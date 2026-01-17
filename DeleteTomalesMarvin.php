<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_Students";
include_once('temp/HeaderTomalesMarvin.php');

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$record = null;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM tbl_students WHERE studID = $delete_id";
    if ($conn->query($sql) === TRUE) {
        $message = "Record with ID $delete_id has been deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userid'])) {
    $id = intval($_POST['userid']);
    $sql = "SELECT * FROM tbl_students WHERE studID = $id";
    $result = $conn->query($sql);
    $record = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search and Delete</title>
    <style>
        .container {
            width: 350px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
        }

        input[type="text"], input[type="email"], input[type="number"] {
            width: 95%;
            padding: 8px;
            margin: 4px 0;
        }

        button {
            padding: 6px 14px;
            align-self: center
        }

        h2 {
            text-align: center;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            color: green;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Search & Delete</h2>
    
    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        User ID: <input type="number" name="userid" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($record): ?>
        <p>User ID: <?php echo $record['studID'] ?></p>
        <p>Name: <?php echo htmlspecialchars($record['fname'] . " " . $record['lname']) ?></p>
        <p>Email Address: <?php echo htmlspecialchars($record['email']) ?></p>
        <p>Date registered: <?php echo htmlspecialchars($record['bday']) ?></p>

        
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            <input type="hidden" name="delete_id" value="<?php echo $record['studID']; ?>">
            <button type="submit" style="background-color: red; color: white;">Delete This Record</button>
        </form>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userid'])): ?>
        <p class="message" style="color: red;">No record found.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php include_once('temp/FooterTomalesMarvin.php'); ?>
