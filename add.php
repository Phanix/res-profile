
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
        require_once "bootstrap.php";
        require_once "pdo.php";
        session_start();
        echo "<h1>Adding Profile for " . $_SESSION['name'] . "</h1>";
   
        //check form fields
        if(isset($_POST['cancel'])){
            header("Location: index.php");
            return;
        }
        if(isset($_POST['add'])){
            $fi = $_POST['first_name'];
            $la = $_POST['last_name'];
            $em = $_POST['email'];
            $he = $_POST['headline'];
            $su = $_POST['summary'];
            if(strlen($fi) < 1 || strlen($la) < 1 || 
                strlen($em) < 1 || strlen($he) < 1 || strlen($su) < 1){
                $_SESSION['error'] = "All fields are required";
                header("Location: add.php");
                return;
            }
            if(!str_contains($em, '@')){
                $_SESSION['error'] = "Email address must contain @";
                header("Location: add.php");
                return;
            }
            //add to database
            $stmt = $pdo->prepare("insert into profile (user_id, first_name, last_name, email,
                headline, summary) values (:user_id, :first_name, :last_name, :email, :headline,
                    :summary)");
            $stmt->execute(array(":user_id" => $_SESSION['user_id'],
                ":first_name" => $fi, ":last_name" => $la, ":email" => $em,
                ":headline" => $he, ":summary" => $su));
            $_SESSION['success'] = "Profile added";
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
        First Name: <input type="text" size="40" name="first_name"><br><br>
        Last Name: <input type="text" size="40" name="last_name"><br><br>
        Email: <input type="text" size="40" name="email"><br><br>
        Headline: <input type="text" size="40" name="headline"><br><br>
        <p>Summary:<p> <textarea   rows="10" cols="50" name="summary"></textarea><br><br>
        <input type="submit" value="Add" name="add">
        <input type="submit" value="Cancel" name="cancel">
     </form>
    
</body>
</html>