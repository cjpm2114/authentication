<?php 

session_start(); 

if(!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true){
    header("location: login.php");
    exit;
}
 
require_once "config.php";


$code_err = "";
$_SESSION["code_access"] = true;



if(isset($_POST['login']))
{ 
    if(empty(trim($_POST["code"]))){
        echo "<script>alert('PLEASE ENTER CODE');</script>";
    } else{ 

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        

        $id_code = mysqli_query($link,"SELECT * FROM code WHERE code='$code' AND id_code=id_code") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($id_code);


        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'test';

        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT expiration FROM code where code='$code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<div style='display: none;'>"."Expiration: " . $row["expiration"]. "<br>";
                echo $currentDate."<br></div>";
                if(($row["expiration"]) >($currentDate)){

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;                            
                    header("location: welcome.php");

                }
                else{
                    echo "<script>alert('EXPIRED CODE ERROR');</script>";
                }
            }
          } else {
            echo "<script>alert('WRONG CODE ERROR');</script>";
          }

          $conn->close();
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
    <title>Verification</title>
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
        .wrapper{
            position: relative;
            top: 320px;
            height: 400px;
            width: 350px;
            left: 780px;
        }
        h2{
            color: #adb5bd;
            margin-left: 110px;
            font-family: 'Quantico', sans-serif;
            font-weight: bold;
        }
        .form-group{
            position: relative;
            color: #fff;
            top: 30px;
            padding: 10px;
        }
        .form-control{
            position: relative;
            padding: 8px;
            font-weight: bold;
            width: 230px;
            border-radius: 5px;
            float: left;
            left: 130px;
            bottom: 30px;
        }
        .form-control input{
            font-size: 30px;
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
            left: 170px;
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
        a{
            position: relative;
            color: #fff;
            text-decoration: none;
            font-family: 'Quantico', sans-serif;
            bottom: 5px;
        }
        a:hover{
            color: #00b4d8;
        }
        .text{
            position:relative;
            color: #adb5bd;
            top: 350px;
            left: 620px;
            width: 850px;
        }
    </style>
</head>  
<body>
    
    <div class="wrapper">
        <h2>Verification</h2>
        
        
        <form role="form" method="post">

                <div class="form-group">
                    <label>Restricted Code</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter your Code Agent">
                   
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="login">LOGIN</button><br>
                    <a href="random.php" target="_blank">GET CODE</a>
                </div>

                
        </form>
    </div>
    
</body>
</html>


