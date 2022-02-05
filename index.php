<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabio Silva</title>
</head>
<body class="container">
<h1>Resume Registry</h1>
<?php
    require_once "bootstrap.php";
    require_once "pdo.php";
    session_start();
    
    if(!isset($_SESSION['name'])){
        echo '<a href="login.php">Please log in</a>';
        return;
    }else{
        if(isset($_SESSION['success'])){
            echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['error'])){
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        echo '<a href="logout.php">Logout</a>';
        $stmt = $pdo->prepare("select * from profile where user_id = :id");
        $stmt->execute(array(":id" => $_SESSION['user_id']));
        echo "<table border='1'>";
        echo "<th>Name</th>";
        echo "<th>Headline</th>";
        echo "<th>Action</th>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
            echo "<td>" . $row['first_name']. " " . $row['last_name'] .  "</td>";
            echo "<td>" . $row['headline'] . "</td>";
            echo "<td><a href=edit.php?profile_id=".$row['profile_id'] . ">Edit </a>";
            echo "<a href=delete.php?profile_id=".$row['profile_id'] . ">Delete</a></td>";
            
            echo "</tr>";
        }
        echo "</table>";
        
    }
?>
    <a href="add.php">Add New Entry</a>

   
    
</body>
</html>