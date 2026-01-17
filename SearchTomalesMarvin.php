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
    <title>Search</title>
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
        <h2>Search</h2>
        <form method="POST">
            User ID: <input type="number" name="userid" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($record): ?>
            <p>User ID: <?php echo $record['studID'] ?></p>
            <p>Name: <?php echo htmlspecialchars($record['fname'] . " " . $record['lname']) ?></p>
            <p>Email Address: <?php echo htmlspecialchars($record['email']) ?></p>
            <p>Date registered: <?php echo htmlspecialchars($record['bday']) ?></p>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p class="message" style="color: red;">No record found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
include_once ('temp/FooterTomalesMarvin.php');
?>
