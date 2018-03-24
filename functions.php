<?php

function retrieve($a){
    if(isset($a)){
        echo $a;
    }
    
}
function config($key,$secret){
    $myfile = fopen("config.php", "w") or die("Unable to open file!");
    $txt = "<?php\n";
    fwrite($myfile, $txt);

    $txt="return[
        's3' => [
            'key' => '$key',
            'secret' => '$secret'
        ]
    ]\n";
    fwrite($myfile, $txt);

    $txt = " ?>\n";
    fwrite($myfile, $txt);
    fclose($myfile);
}

function setr_object($region){
    $myfile=fopen('client.php','w') or die("Unable to create or open the client.php file!");

    $txt="
        <?php 
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;

    require 'aws/aws-autoloader.php';
    \$config=require('config.php');
    \$path=getcwd();
    \$curr_region='$region';
    ";

    fwrite($myfile,$txt);
    $txt="

    \$s3= new S3Client([
        
        'region'=> '$region',
        'version'=> 'latest',
        'http' =>[
            'verify' => \$path.'/verify/cacert.pem'
        ],
        'credentials' => [
            'key' => \$config['s3']['key'],
            'secret' => \$config['s3']['secret']
        ]

    ]);
    ?>
        ";
    fwrite($myfile,$txt);
    fclose($myfile);

}

function create_new(){
    echo '
    <form action="create_new.php">
    <input type="text" name="n_bucket" id="b_name"><br>
    <label for="web">Enable website hosting?</label> <input type="checkbox"  id="web" name="web"><br>
    <div class="webdet">
    Please give the details for<br> Index file : <br>
    <input type="text" placeholder="e.g. index.html" name="index" id="index"><br>
    Error file : <br>
    <input type="text" name="error" placeholder="e.g. error.html" id="error"><br>
    These files should exist for the bucket to act as a website. Make sure you add these once the bucket is created<br>
    
    </div>
    <input type="submit" id="sbm" value="Create">
    </form>
    ';
    //add basic.js for checkbox toggle

}


?>