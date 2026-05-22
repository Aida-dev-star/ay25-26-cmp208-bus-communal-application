<?php
session_start();
include "db.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$driver_name = $_SESSION["username"];


   //GET DRIVER INFO SAFELY

$stmt = $conn->prepare("SELECT id, available FROM drivers WHERE username = ?");
$stmt->bind_param("s", $driver_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $driver_id = $row["id"];
    $available = $row["available"];

} else {
    die("Driver not found in database.");
}


  // COUNT REQUESTS

$countResult = $conn->query("SELECT COUNT(*) AS total FROM requests");
$countRow = $countResult->fetch_assoc();
$totalRequests = $countRow["total"];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Driver Page</title>
</head>
<body>
   <div class="container">

<h2>Welcome Driver</h2>
<p>Hello, <?php echo $driver_name; ?></p>

<h3>Driver Dashboard</h3>

<?php
if ($totalRequests >= 5) {
    echo "<h3 style='color:red;'>⚠️ ALERT: $totalRequests commuters are waiting for a bus!</h3>";
} else {
    echo "<p>Not enough requests yet ($totalRequests / 5)</p>";
}
?>

<!-- ACCEPT REQUESTS -->
<form method="POST">
    <button type="submit" name="accept">Accept Bus Requests</button>
</form>

<!-- FINISH TRIP -->
<form method="POST">
    <button type="submit" name="finish">Finish Trip</button>
</form>

<?php

   //ACCEPT REQUESTS

if (isset($_POST["accept"])) {

    // Count how many requests exist
    $result = $conn->query("SELECT COUNT(*) AS total FROM requests");
    $row = $result->fetch_assoc();
    $totalRequests = $row['total'];

    if ($totalRequests < 5) {

        echo "<p style='color:red;'>You need at least 5 requests before accepting a trip.</p>";

    } else {

        if ($available == "no") {
            echo "<p style='color:red;'>You are already on a trip.</p>";
        } else {

            $message = "Driver $driver_name is coming to pick up passengers.";

            $stmt = $conn->prepare("INSERT INTO accepted_requests (driver_id, message) VALUES (?, ?)");
            $stmt->bind_param("is", $driver_id, $message);
            $stmt->execute();

            $conn->query("DELETE FROM requests");

            $update = $conn->prepare("UPDATE drivers SET available = 'no' WHERE id = ?");
            $update->bind_param("i", $driver_id);
            $update->execute();

            echo "<p style='color:green;'>Requests accepted!</p>";
        }
    }
}


   //FINISH TRIP

if (isset($_POST["finish"])) {

    // Driver available again
    $update = $conn->prepare("
    UPDATE drivers 
    SET available = 'yes' 
    WHERE id = ?
    ");

    $update->bind_param("i", $driver_id);
    $update->execute();


    // Complete trip
    $trip = $conn->prepare("
    UPDATE accepted_requests
    SET status='completed'
    WHERE driver_id = ?
    ");

    $trip->bind_param("i", $driver_id);
    $trip->execute();

    echo "<p style='color:blue;'>You are now available again.</p>";
}
?>

<br>
<a href="logout.php">Logout</a>

</div>

</body>
</html>