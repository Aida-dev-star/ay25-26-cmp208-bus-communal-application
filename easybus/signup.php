<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $role = $_POST["role"];

    if (empty($username) || empty($password)) {

        echo "Please fill in all fields.";

    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into commuter table
        if ($role == "commuter") {

            $stmt = $conn->prepare("INSERT INTO commuters (username, password) VALUES (?, ?)");

            $stmt->bind_param("ss", $username, $hashedPassword);

        }

        // Insert into driver table
        else if ($role == "driver") {

            $stmt = $conn->prepare("INSERT INTO drivers (username, password) VALUES (?, ?)");

            $stmt->bind_param("ss", $username, $hashedPassword);

        }

        if ($stmt->execute()) {

            echo "Account created successfully.";

        } else {

            echo "Error creating account.";

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Signup</title>
</head>
<body>

<h2>Signup</h2>

<form method="POST">

    Username:
    <input type="text" name="username" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    Role:
    <select name="role">

        <option value="commuter">Commuter</option>
        <option value="driver">Driver</option>

    </select>

    <br><br>

    <button type="submit">Signup</button>

</form>

<br>

<a href="login.php">Login Here</a>

</body>
</html>