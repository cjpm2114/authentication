<?php 
session_start();
require_once "config.php";
    if(!isset($_SESSION["code_access"]) || $_SESSION["code_access"] !== true){
        header("location: login.php");
        exit;
    }else{

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        $duration = floor(time()/(30));
        srand($duration);
        $_SESSION["codee"] = substr(str_shuffle($permitted_chars), 0, 6);
                
        date_default_timezone_set('Asia/Manila');

        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $endDate_months = strtotime("+30 seconds", $currentDate_timestamp);
        $packageEndDate = date('Y-m-d H:i:s', $endDate_months);
            
        $_SESSION["current"] = $currentDate;
        $_SESSION["expired"] = $packageEndDate;

        $user_id = $_SESSION["id"];
        $codee = $_SESSION["codee"];
        

        $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$codee', '$currentDate', '$packageEndDate')";
        
        $result = mysqli_query($link,"select * from code where code='$codee'") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($result);
        if($count == 0)
        {
            if(mysqli_query($link, $sql)){
               
            } else{
            echo "ERROR: $sql. " . mysqli_error($link);
            }
        }else{
       
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-image: url(code.jpg);
            background-repeat: no-repeat;
            background-size: 1920px 1000px;
        }
        .sauce{
            position: relative;
            top: 300px;
            height: 400px;
            width: 350px;
            left: 350px;
            font-weight: bold;
            font-size: 300px;
            font-family: 'Orbitron', sans-serif;
            color: #2ec4b6;
        }
    </style>
</head>

<body>
        <div class="sauce">
            <?php echo $_SESSION["codee"]; ?> 
        </div>
 
</body>
</html>  