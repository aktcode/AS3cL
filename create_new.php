<?php
session_start();
use Aws\S3\Exception\S3Exception;
require('functions.php');
if(isset($_REQUEST['n_bucket'])){
    require('client.php');
    $buck_name=$_REQUEST['n_bucket'];
    ?>

    <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>New Bucket</title>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="style.css">

    <style>
    


    </style>


        </head>
        <body>
            
            <?php
          
    try
    {
        $result = $s3->createBucket([
            'Bucket' => $buck_name
        ]);
            ?>
            <div class="mid">
            <?php
        echo "New Bucket <b> $buck_name</b> created successfully!<br>";
        
        if(isset($_REQUEST['web'])){
            $index=$_REQUEST['index'];
            $error=$_REQUEST['error'];
            
            $params = [
                'Bucket' => $buck_name,
                'WebsiteConfiguration' => [
                    'ErrorDocument' => [
                        'Key' => $error,
                    ],
                    'IndexDocument' => [
                        'Suffix' => $index,
                    ],
                ]
            ];
            try {
                $resp = $s3->putBucketWebsite($params);?>
                Website Configuration also Added
                <?php
               
            } catch (AwsException $e) {
                // Display error message
                echo $e->getMessage();
                echo "\n";
            }
       
        }
        
        ?>
<br>

        <a href="redirect.php?a_bucket=<?php echo $buck_name; ?>" style="font-size:25px; text-decoration:none;">Visit Bucket</a>


            </div>

        </body>
        </html>
        
        

        <?php
    }
    catch(S3Exception $e)
    {
        ?>
         <body>
            <div class="mid">
            <span style="font-size:30px;">Oops,<br></span><br>
            Bucket <?php echo "<b>".$buck_name."</b>"; ?> already exists!<br>
            <br>Try Again with another name<br><br>
            <?php create_new() ?>
            
            <br>
            <a href="index.php"><-Go Home</a>
            </div>
            <script src="basic.js"></script>
        </body>
        </html>
        
        
        <?php
    }

}


?>