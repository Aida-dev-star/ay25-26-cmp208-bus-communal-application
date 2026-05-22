<?php
session_start();
include "db.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];






   //CHECK DRIVER AVAILABILITY

$driverCheck = $conn->query("SELECT COUNT(*) AS total FROM drivers WHERE available = 'yes'");
$driverRow = $driverCheck->fetch_assoc();
$availableDrivers = $driverRow["total"];


   //DRIVER MESSAGE

$result = $conn->query("
SELECT accepted_requests.message, drivers.username
FROM accepted_requests
JOIN drivers ON accepted_requests.driver_id = drivers.id
WHERE accepted_requests.status='active'
ORDER BY accepted_requests.id DESC
LIMIT 1
");
?>

<!DOCTYPE html>
<html>
<head>

     <link rel="stylesheet" href="style.css">
    <title>Commuter Dashboard</title>
</head>
<body>
<div class="container">

<h2>🚍 Commuter Dashboard</h2>

<!-- GREETING -->
<p>Hello, <?php echo $username; ?> Welcome to the Easy Bus Communal WebPage.
   This Webpage was built to ease the process of commuting and create a seamless and stress free Communal Experience.</p>

<hr>


<h3>🚦 Bus Availability Status</h3>

<?php
if ($availableDrivers > 0) {

    echo "<h3 style='color:green;'>🟢 Buses Available Now</h3>";
   
    echo" Next Bus Comes Within 20 Minutes.";

} else {

    echo "<h3 style='color:red;'>🔴 No Buses Available</h3>";
   

    echo "Next Bus Comes Within 40 Minutes." ;
    
}
?>

<hr>

<!--  REQUEST BUS BUTTON -->
<h3>Request a Bus</h3>

<form method="POST">
    <button type="submit" name="request">Request Bus</button>
</form>
<?php
if (isset($_POST["request"])) {

    $stmt = $conn->prepare("INSERT INTO requests (commuter_name) VALUES (?)");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    echo "<p style='color:green;'>Bus request sent!</p>";}
?>

<hr>

<!--  DRIVER MESSAGE -->
<h3>Latest Bus Update</h3>

<?php
if ($result && $result->num_rows > 0) {

    $row = $result->fetch_assoc();

    echo "<h3 style='color:green;'>" . $row["message"] . "</h3>";
    echo "<p>Driver: " . $row["username"] . "</p>";

} else {

    echo "<p>No driver assigned yet.</p>";

}
?>

<a href="HeatMap.php">
    <button>Open HeatMap</button>
</a>

<hr>

<a href="logout.php">Logout</a>

</div>

</body>
</html>