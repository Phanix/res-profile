<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabio Silva</title>
</head>
<body class="container">
    <h1>Please Log In</h1>
    <?php
        session_start();
        require_once "pdo.php";
        require_once "bootstrap.php";  
        $salt = 'XyZzy12*_';
        if(isset($_POST['email'])){
            $check = hash('md5', $salt.$_POST['pass']);
            $stmt = $pdo->prepare('SELECT user_id,
            name FROM users where email=:em AND password=:pw');
            $stmt->execute(array(
                ":em" => $_POST['email'],
                ":pw" => $check
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row != false){
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: index.php");
                return;
            }else{
                $_SESSION["error"] = "Incorrect password";
                header("Location: login.php");
                return;
            }
            
        }
        if(isset($_POST['cancel'])){
            header("Location: index.php");
            return;
        }
        
    ?>
    <?php
        if(isset($_SESSION['error'])){
            echo "<p style='color:red';>" . $_SESSION['error']. "</php>";
            unset($_SESSION['error']);
        }
    ?>
    <form action=""  method="post">
        Email <input type="text" name="email" id="email"><br>
        Password <input type="password" name="pass" id="id_1723"><br>
        <input type="submit" onclick="return doValidate()" value="Log In">
        <input type="submit" value="Cancel" name="cancel">
    </form>

    <script type="text/javascript">
       
       function doValidate(){
           email = document.getElementById("email").value;
           pw = document.getElementById("id_1723").value;
           if(pw == null || pw == "" || pw == " "){
               alert("Both fields must be filled out");
               return false;
           }
           if(email.indexOf('@') == -1){
               alert("Invalid email address");
               return false;
           }
           return true;
       }

    </script>
    
</body>
</html>