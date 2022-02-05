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
        if(isset($_SESSION['name'])){
            echo "<h1>Editing Profile for " . $_SESSION['name'] . "</h1>";
        }else{
            die("error");
        }
        if(isset($_POST['cancel'])){
            header("Location: index.php");
            return;
        }
        $stmt = $pdo->prepare("select * from profile where profile_id = :id");
        $stmt->execute(array(":id" => $_GET['profile_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row == false){
            $_SESSION['error'] = 'Could not load profile';
            header("Location: index.php");
            return;
        }
        if(isset($_POST['save'])){
            $fi = $_POST['first_name'];
            $la = $_POST['last_name'];
            $em = $_POST['email'];
            $he = $_POST['headline'];
            $su = $_POST['summary'];
            $id = $_POST['profile_id'];
            if(strlen($fi) < 1 || strlen($la) < 1 || 
                strlen($em) < 1 || strlen($he) < 1 || strlen($su) < 1){
                $_SESSION['error'] = "All fields are required";
                header("Location: edit.php?profile_id=" . $id );
                return;
            }
            if(!str_contains($em, '@')){
                $_SESSION['error'] = "Email address must contain @";
                header("Location: edit.php?profile_id=" .$id );
                return;
            }
          
          
          
            $stmt = $pdo->prepare("update profile set first_name = :fi, last_name = :la,
            email = :em, headline = :he, summary = :su where profile_id = :id");
            $stmt->execute(array(
                ":fi" => $fi,
                ":la" => $la,
                ":em" => $em,
                ":he" => $he,
                ":su" => $su,
                ":id" => $id
            ));
          
             $_SESSION['success'] = "Profile update";
             header("Location: index.php");
             return;

        }


    ?>
     <?php
    if(isset($_SESSION['error'])){
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>"; 
        unset($_SESSION['error']);
    }
  ?>
     <form  method='post'>
        First Name: <input type="text" size="40" value="<?=htmlentities($row['first_name'])?>" name="first_name"><br><br>
        Last Name: <input type="text" size="40" value="<?=htmlentities($row['last_name'])?>" name="last_name"><br><br>
        Email: <input type="text" size="40" value="<?=htmlentities($row['email'])?>" name="email"><br><br>
        Headline: <input type="text" size="40" value="<?=htmlentities($row['headline'])?>" name="headline"><br><br>
        <p>Summary:<p> <textarea   rows="10" cols="50"  name="summary"><?=htmlentities($row['summary'])?></textarea><br><br>
        <input type="hidden" name="profile_id" value="<?=htmlentities($row['profile_id'])?>">
        <input type="submit" value="Save" name="save">
        <input type="submit" value="Cancel" name="cancel">
     </form>
</body>
</html>