<?php
session_start();
?>


<?php
if(isset($_REQUEST['a_bucket'])){
    $_SESSION['bucket']=$_REQUEST['a_bucket'];
    header('Refresh: 0; URL=alr_bucket.php');




    ?>
    
    
    
    
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{
            background-color:#172025;
        }
    </style>
</head>
<body>
    





<div style="position:absolute; right:80px; top:30%; text-align:center;padding:0px; font-family:gotham; font-size:45px; color:#fff;">
Connection<br> in progress<br>
<span style="font-size:20px; text-align:center;">
Source Name: 
<?php  echo $_REQUEST['a_bucket']; ?>
</span>

</div>


</body>
</html>
    
    
    
    
    
    
    
    
      <?php
}

else{
echo "404, thats an error!";

}
?>
