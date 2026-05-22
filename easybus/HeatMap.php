<?php
session_start();
include "db.php";

// must be logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "user";

//  get total bus requests
$result = $conn->query("SELECT COUNT(*) AS total FROM requests");
$row = $result->fetch_assoc();
$totalRequests = $row["total"];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Bus Heatmap</title>
</head>
<body>
<div class="container">

<h2>🚍 Bus Heatmap Dashboard</h2>

<p><strong>User:</strong> <?php echo $username; ?></p>
<p><strong>Role:</strong> <?php echo $role; ?></p>

<hr>

 
<img src="Heatmap.png" width="600">

<hr>

<h3>Legend</h3>

<p style="color:red;">🔴 RED = This area usually has the most people so it is best to avoid (avoid)</p>
<p style="color:orange;">🟠 ORANGE = These areas sometimes has crowds but it depends on the time of day(Medium crowd)</p>
<p style="color:green;">🟢 GREEN =  These areas usually has the least amount of people all day round(best place to wait)</p>

<hr>

<h3>Live Bus Demand Status</h3>



<hr>

<p>Total bus requests in system: <?php echo $totalRequests; ?></p>

<hr>

<hr>

<h3>Offline Heatmap</h3>

<hr>

<hr>

<a href="Offline Heatmap.png" download>
    <button>Download</button>
</a>

<hr>


<a href="commuter.php">Commuter Dashboard</a> |
<a href="logout.php">Logout</a>

</div>

</body>
</html>