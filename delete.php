<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabio Silva</title>
</head>
<body class="container">
    <?php
        session_start();
        require_once "pdo.php";
        require_once "bootstrap.php";
        if(!isset($_SESSION['name'])){
            die("ACCESS DENIED");
        }
        $stmt = $pdo->prepare("select * from profile where profile_id = :id");
        $stmt->execute(array(":id" => $_GET['profile_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row == false){
            $_SESSION['error'] = 'Could not load profile';
            header("Location: index.php");
            return;
        }
        echo "<h1>Deleting Profile</h1>";
        echo "First Name: " . $row['first_name'];
        echo "<br><br>";
        echo "Last Name: " . $row['last_name'];

        if(isset($_POST['cancel'])){
            header("Location: index.php");
            return;
        }
        if(isset($_POST['delete'])){
        $stmt = $pdo->prepare("delete from profile where profile_id = :id");
        $stmt->execute(array(":id" => $_POST['profile_id']));
        $_SESSION['success'] = "Profile deleted";
        header("Location: index.php");
        return;        
        }


    ?>
    <br>
    <br>
        <form method="post">
        <input type="submit" name="delete" value="Delete">
        <input type="hidden" name="profile_id" value=<?= htmlentities($row['profile_id']) ?>>
        <input type="submit" value="Cancel" name="cancel">
    </form>
</body>
</html>