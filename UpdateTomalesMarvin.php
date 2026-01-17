<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "db_Students";
    include_once   ('temp/HeaderTomalesMarvin.php');
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $record = null;
    $updated = false;


    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
        $id = intval($_POST["studID"]);
        $fname = $conn->real_escape_string($_POST["fname"]);
        $lname = $conn->real_escape_string($_POST["lname"]);
        $email = $conn->real_escape_string($_POST["email"]);

        $sql = "UPDATE tbl_students SET fname='$fname', lname='$lname', email='$email' WHERE studID=$id";
        $updated = $conn->query($sql);
    }


    if (isset($_POST["search_id"])) {
        $id = intval($_POST["search_id"]);
        $result = $conn->query("SELECT * FROM tbl_students WHERE studID=$id");
        $record = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Record</h2>
        <form method="POST">
            User ID: <input type="number" name="search_id" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($record): ?>
            <form method="POST">
                <input type="hidden" name="studID" value="<?= $record['studID'] ?>">

                <p>User ID: <?php echo $record['studID'] ?></p>
                First Name: <input type="text" name="fname" value="<?php echo htmlspecialchars($record['fname']) ?>" required><br>
                Last Name: <input type="text" name="lname" value="<?php echo htmlspecialchars($record['lname']) ?>" required><br>
                Email Address: <input type="email" name="email" value="<?php echo  htmlspecialchars($record['email']) ?>" required><br>
                <button type="submit" name="update">Update</button>
            </form>
        <?php endif; ?>

        <?php if ($updated): ?>
            <div class="message">Record has been updated</div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
include_once ('temp/FooterTomalesMarvin.php');?>