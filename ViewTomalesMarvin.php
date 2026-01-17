<?php
include_once ('temp/HeaderTomalesMarvin.php');
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_Students";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT studID, fname, lname, email, bday FROM tbl_students";

$sql = "SELECT studID, fname, lname, email, bday FROM tbl_students WHERE 1";


if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " AND (fname LIKE '%$search%' OR lname LIKE '%$search%' OR email LIKE '%$search%')";
}


if (!empty($_GET['domain'])) {
    $domain = $conn->real_escape_string($_GET['domain']);
    $sql .= " AND email LIKE '%@$domain'";
}



$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP with HTML</title>
    <link rel="stylesheet" href="Styles/style.css">
    <style>
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 50%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
    </style>
</head>
<body>




<div class="table-container">
    
    <h2>Student List</h2>
    <form method="GET" style="text-align: center; margin-bottom: 20px;">
    
    
        <select name="domain">
            <option value="">All Emails</option>
            <option value="gmail.com" <?php if (isset($_GET['domain']) && $_GET['domain'] == 'gmail.com') echo 'selected'; ?>>Gmail</option>
            <option value="yahoo.com" <?php if (isset($_GET['domain']) && $_GET['domain'] == 'yahoo.com') echo 'selected'; ?>>Yahoo</option>
        </select>



        <button type="submit">Go</button>


        <label>Search Here
        <input type="text" name="search"  value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </label>
    </form>
    <table>
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Date</th>
        </tr>
    
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["studID"]); ?></td>
                    <td><?php echo htmlspecialchars($row["fname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["lname"]); ?></td>
                    <td><?php echo htmlspecialchars($row["email"]); ?></td>
                    <td><?php echo htmlspecialchars($row["bday"]); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No records found.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>


<?php
include_once ('temp/FooterTomalesMarvin.php');  
?>