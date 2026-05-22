<?php
session_start();

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $role = $_POST["role"];

    // Check commuter table
    if ($role == "commuter") {

        $stmt = $conn->prepare("SELECT * FROM commuters WHERE username = ?");

    }

    // Check driver table
    else if ($role == "driver") {

        $stmt = $conn->prepare("SELECT * FROM drivers WHERE username = ?");

    }

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {

            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $role;

            // Redirect based on role
            if ($role == "commuter") {

                header("Location: commuter.php");

            } else if ($role == "driver") {

                header("Location: driver.php");

            }

        } else {

            echo "Wrong password.";

        }

    } else {

        echo "User not found.";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
 <div class="container">
<h1> Easy Bus</h1>
<h2>Login</h2>

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

    <button type="submit">Login</button>

</form>

<br>

<a href="signup.php">Create Account</a>

</body>
</div>
</html>