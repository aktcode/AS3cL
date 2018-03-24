<?php
session_start();
if(isset($_SESSION['bucket']))
{
    require('client.php');

$bck=$_SESSION['bucket'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inside Bucket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <style>
   table tr td:nth-child(1){
       padding:10px;
       border:1px solid #172025;
       background-color:#172025;
       color:#fff;
   }
   table tr td:nth-child(2){
       padding:10px;
       border:1px solid #172025;
       background-color:#172025;
       color:#fff;
   }
   table tr td:nth-child(3){
       padding:10px;
       border:1px solid #EF6C00;
       background-color:#EF6C00;
       color:#fff;
   }
   table tr td:hover{
       opacity:0.8;
   }
    </style>
</head>
<body>


    <div class="mid">
        Current : <span style="font-size:25px;"><b><?php echo $bck; 
        
        
        ?>
    </b></span><?php $url="http://".$bck.".s3-website.$curr_region.amazonaws.com";
        echo "<a href='$url' target='blank'>Visit Website</a>"; ?>
        <br><br>
        <span style="font-size:30px;">
       <b> Files inside this Bucket:</b></span>
        <br>

<table>
<tr>
<td>Name</td>
<td>Size</td>
<td>Delete</td>

</tr>

<?php
try {
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => $bck
    ));

    foreach ($objects as $object) {
        $k=$object['Key'];
        
            echo "<tr><td>".$object['Key']."</td>";
            echo "<td>".$object['Size']."</td>";
            echo "<td><a style='text-decoration:none; color:#fff;' href='?del=$k'>Yes</a></td></tr>";


        
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

if(isset($_REQUEST['del'])){

    $result = $s3->deleteObject(array(
        'Bucket' => $bck,
        'Key'    => $_REQUEST['del']
    ));
    header("Location: alr_bucket.php");

}
?>
</table><br><br>
<span style="font-size:35px;">
       <b>Upload a file</b></span> straight to server<br>
       <span style="font-size:27px;">
       <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="upload">
    <input type="submit" value="Upload">
    </form>
</span>



<?php

       if(isset($_FILES['upload'])){
    $target_file ="upl/". basename($_FILES["upload"]["name"]);
    $name=$_FILES["upload"]["name"];
    move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file);
    


    try{
        $result = $s3->putObject([
            'Bucket' => $bck,
            'Key' => $name,
            'Body' => fopen($target_file,'rb'),
            'ACL' => 'public-read'
        ]);
        
        header('Location: '.$_SERVER['REQUEST_URI']);

    }catch(S3Exception $e){
        echo $e->getMessage();
    }

    fclose(fopen($target_file,'rb'));

 

}


try{
   
$result = $s3->getBucketWebsite(array(
    'Bucket' => $bck,
));

echo "<br><br>Make sure your index document is the same as below<br>Index File : ";
echo $result->getPath('IndexDocument/Suffix');
}catch(S3Exception $e){
    echo $e->getMessage();
}






echo "<br><br><a href='?delbuck=$bck'>Delete this Website</a>";

if(isset($_REQUEST['delbuck'])){
$del_buck=$_REQUEST['delbuck'];




try {
    $objects = $s3->getIterator('ListObjects', array(
        'Bucket' => $bck
    ));

    foreach ($objects as $object) {
        $k=$object['Key'];
        $result = $s3->deleteObject(array(
            'Bucket' => $bck,
            'Key'    => $k
        ));
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}

 



try
{
    $result = $s3->deleteBucket([
        'Bucket' => $del_buck
    ]);
    header('Refresh: 1; URL=index.php');
    echo "<br><b><div style='font-size:30px; text-align:center;'>Bucket Deleted!</div></b>";

}catch(S3Exception $e){
    echo $e->getMessage();
}
}
?>


<br><br>


<br>
<a href="index.php"><---Go Back to home</a> 
    </div>
</body>
</html>

<?php 
}
else{
    echo "Error connecting to bucket";
}
?>