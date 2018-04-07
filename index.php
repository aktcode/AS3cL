<?php
use Aws\S3\Exception\S3Exception;
require('functions.php');
if(file_exists('config.php')){
    require('client.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>S3 Client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="style.css">
<style>
    select{
        padding:5px;
        margin-top:10px;
        margin-bottom:10px;
        font-size:20px;
        border:1px solid #e3e3e3;
        background-color:#e3e3e3;
    }
    *:focus {
    outline: 0;
    }

</style>    
</head>
<body>

<span style="color:#202020;">
<?php
    if(isset($_REQUEST['sources']))
    {
        echo $_REQUEST['sources'];
    }
?>  
</span>
<div class="mid">
Your current region :<b> 
        <?php echo $curr_region; ?></b> <button id="change">change?</button> <br>
        <span style="font-size:12px;color:#7F2F2F; ">When entering into a bucket, make sure you are in the same region when you created the bucket. We don't recommend changing the region too much. 
</span>
        <div class="reg_change">
    <form action="">
    <?php include('region.php'); ?>
    <input type="submit" id="sbm_r"  value="Change">
    </form>
    </div>

    <script>
        $(document).ready(function(){
            $('.reg_change').hide();
    
            $('#change').click(function(){
                $('.reg_change').toggle(200);
            });
                });
        </script>
        <?php
            if(isset($_REQUEST['region'])){
                setr_object($_REQUEST['region']);
                header('Refresh: 0; URL=index.php');
            }
        ?>

</div>
<div class="mid">You are logged into your account,<br>
<span style="font-size:12px;color:#393BC7;">Just choose the bucket where you want to work</span><br>

<form action="redirect.php">

  <select name="a_bucket" id="sources"  placeholder="Choose Bucket">
      
  <?php
    $buckets = $s3->listBuckets();
    foreach ($buckets['Buckets'] as $bucket){
        $bname=$bucket['Name'];
            echo "<option value='$bname'><a href='?bname=$bname'>".$bucket['Name']."</a></option>";
        
    }
?>  

  </select>

  <br>

  <input type="submit" id="sbm" value="Enter">
  </form>

</div>

<div class="mid" style="margin-top:20px;">
    Or create a whole new bucket<br>
    <?php
    create_new();
    ?>
    <button id="del_this_account">Delete this account</button>
    <div class="show_del">
        Are you sure you want to unlink your account? You will have provide the access key and secret again next time you want to enter.
        <br>
    <a href="?unlink_account=1">Unlink account</a><br><br>
    <button id="close" href="">Close</button>
    </div>
    
    <?php
        if(isset($_REQUEST['unlink_account'])){
            unlink_config();
        }
    ?>
</div>


<script src="basic.js">  </script>


</body>
</html>

<?php  
}   
else{
    include('config_body.php');
}?>