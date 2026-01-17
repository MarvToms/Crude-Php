<?php

include_once ('temp/HeaderTomalesMarvin.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_Students";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['password']);

    $check = "SELECT * FROM tbl_students WHERE email = '$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $message = "Email is already registered.";
    } else {
        $sql = "INSERT INTO tbl_students (fname, lname, email, password) 
                VALUES ('$fname', '$lname', '$email', '$pass')";
        if ($conn->query($sql) === TRUE) {
            $message = "Your account has been created. <a href='LoginTomalesMarvin.php'>Click here to login</a>.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
    input[type="password"] {
    width: 95%;
    padding: 8px;
    margin: 6px 0;
    border: 1px solid #aaa;
    border-radius: 4px;
    box-sizing: border-box;
    }
    </style>
</head>
<body>

<div class="form-container">
        <h2>Register</h2>

        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php else: ?>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="fname" required>

            <label>Last Name:</label>
            <input type="text" name="lname" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Register</button>
        </form>
        <a href="LoginTomalesMarvin.php">Already have an account? Login</a>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
include_once ('temp/FooterTomalesMarvin.php');?>