<?php 
session_start();
  
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: welcome.php");
    exit;
}
  
require_once "config.php";

$_SESSION["verify"] = false;
$_SESSION["code_access"] = false;
  
 
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    if(empty(trim($_POST["username"]))){
        echo "<script>alert('ENTER USERNAME');</script>";
    } else{
        $username = trim($_POST["username"]);
    }
     
    if(empty(trim($_POST["password"]))){
        echo "<script>alert('ENTER PASSWORD');</script>";
    } else{
        $password = trim($_POST["password"]);
    }
     
    if(empty($username_err) && empty($password_err)){ 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){ 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
             
            $param_username = $username;
             
            if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);
                 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            $_SESSION["verify"] = true;
                            $_SESSION["code_access"] = true;
                            
                            $_SESSION["id"] = $id;
                            header("location: verification.php");
                            

                        } else{ 
                             
                            echo "<script>alert('PASSWORD ERROR');</script>";
                        }
                    }
                } else{ 
                    echo "<script>alert('USERNAME IS NOT EXIST');</script>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quantico&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-image: url(cia.jpg);
            height: 100%;
            width: 100%;
            background-repeat: no-repeat;
        }
        .next{
            position: relative;
            top: 290px;
            height: 400px;
            width: 350px;
            left: 780px;

        }
        .form-group{
            position: relative;
            color: #fff;
            top: 30px;
            padding: 10px;
        }
        .form-control{
            position: relative;
            font-size: 20px;
            padding: 3px;
            width: 200px;
            border-radius: 5px;
            float: left;
            left: 130px;
            bottom: 5px;
        }
        input{
            font-size: 15px;
        }
        label{
            position: relative;
            float: right;
            font-size: 20px;
            right: 220px;
            font-family: 'Quantico', sans-serif;
        }
        .login{
            color: #fff;
            background: transparent;
            position: relative;
            top: 20px;
            left: 80px;
            width: 150px;
            height: 30px;
            border-radius: 15px;
            font-family: sans-serif;
        }
        .login:hover{
            color: #fff;
            background: #212529;
            font-weight: bold;
            transition: 0.2s;
        }
        .text{
            position:relative;
            color: #adb5bd;
            top: 350px;
            left: 640px;
            width: 850px;
        }
    </style>
</head>  
<body>
       
    <div class="wrapper">
        <h2>Login</h2>
      
        
        <form action="" method="post">
            <div class="next">
                <div class="form-group">
                <label>AGENT ID</label>
                    <input type="text" name="username" class="form-control" >
                
                </div> <br>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" class="form-control" >
               
                </div>
            <div class="form-group">
                <input type="submit" class="login" value="Login">  
            </div>
            
        
            </div>
            <div class="text">
                 <label style="font-size: 15px;"><center>You are entering in a secured United States Government system, which may be used only <br>for authorized purposes. Modification of any information on this system is subject <br>to a criminal prosecution. The agency monitors all usage of this system. <br>All persons are hereby notified that use of this system constitutes consent to such<br> monitoring and audition.</center></label>
            </div>
        </form>
   
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>