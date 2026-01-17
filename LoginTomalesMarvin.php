<?php
session_start();


include_once ('temp/HeaderTomalesMarvin.php');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_Students";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$greeting = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM tbl_students WHERE email = '$email' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['fname'] . " " . $row['lname'];
        $_SESSION['name'] = $name;

        $greeting = "Welcome, <strong>$name</strong>!<br><a href='ViewTomalesMarvin.php'>Continue</a>";
    } else {
        $greeting = "Invalid email or password.";
    }

    
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
    <h2>Login</h2>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p><?php echo $greeting; ?></p>
    <a href="RegisterTomalesMarvin.php">Don't have an account? Register</a>
</div>

</body>
</html>


<?php
include_once ('temp/FooterTomalesMarvin.php');?>
