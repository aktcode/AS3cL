
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Configure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <style>
       
        input:focus,
        select:focus,
        textarea:focus,
        button:focus {
            outline: none;
            border-bottom:3px solid #0E7411;
        }
        input{
            padding:2px;
            border:0px;
            border-bottom:1px solid #e3e3e3;
            font-size:20px;
        }
    </style>
</head>
<body>
    
    <div class="mid">
    Hi!,<br>
    You have to configure your account first<br>
    That's quite easy, you just need to get the access keys and you will be done<br>
    <br>
    Please note that this data is local to your machine and is not shared whatsoever<br>
    <br>
    <form action="#" method="post">
    <input type="text" name="access_key" placeholder="Your Access Key here" 
    <?php if(isset($_REQUEST['access_key'])){
        echo "value='".$_REQUEST['access_key']."'";
    }
        
        ?>><br>
    <br>
    <input type="text" name="secret_key" placeholder="You secret here"
    <?php if(isset($_REQUEST['secret_key'])){
        echo "value='".$_REQUEST['secret_key']."'";
    }
        
        ?>
    ><br>
    Region:<?php include('region.php'); ?>

    <br>
    <input type="submit" value="Submit" style="padding:10px 20px; border-radius:4px; ">
    </form>
    <?php
        if(isset($_REQUEST['access_key']) && isset($_REQUEST['secret_key']) && isset($_REQUEST['region']) )
        {
            $acc_key=$_REQUEST['access_key'];
            $sec_key=$_REQUEST['secret_key'];
            $region=$_REQUEST['region'];
            config($acc_key,$sec_key);
            setr_object($region);
            header('Refresh: 1; URL=index.php');
        }
    ?>

    
        
            </div>


            
</body>
</html>