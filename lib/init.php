<?php 
    
    include_once 'Utils.php';
    include_once 'Console.php';
    include_once 'DBB.php';
    include_once 'SimpleImage.php';
    include_once('S3.php');

    DB::setConnection(getenv('MYSQL_DB_NAME'), getenv('MYSQL_DB_NAME'), 
        getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DB_HOST'));

    DB::useConnection(getenv('MYSQL_DB_NAME'));

    DB::connect();
    //$username="ali";
    //$res = DB::read("SELECT * FROM members WHERE username='ali'", $username);
    // $sql = mysql_query("SELECT username FROM members WHERE username = '".$username."'");
    //var_dump($res);
    // DB::connect();
    //echo "eeeeeee";
    //
    
    define("HTTP_URL", "/ginkatego");
    define ("MAX_SIZE","10000"); 


    //AWS access info
    if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIWSD7RMQONUM6FBQ');
    if (!defined('awsSecretKey')) define('awsSecretKey', '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');
    // //instantiate the class
    $s3 = new S3(awsAccessKey, awsSecretKey);

    //This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
    function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    function resizeImageAndSave($maxWidth, $maxHeight, $makeSquare=false, $imageName, $folderName = "uploaded-images/"){
        $image = false;
        // Create image from file
        switch(strtolower($_FILES['image']['type']))
        {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($_FILES['image']['tmp_name']);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($_FILES['image']['tmp_name']);
                break;
            default:
                exit('Unsupported type: '.$_FILES['image']['type']);
        }
        // Target dimensions
        $max_width = $maxWidth;
        $max_height = $maxHeight;

        // Get current dimensions
        $old_width  = imagesx($image);
        $old_height = imagesy($image);

        // Calculate the scaling we need to do to fit the image inside our frame
        $scale      = min($max_width/$old_width, $max_height/$old_height);

        // Get the new dimensions
        $new_width  = ceil($scale*$old_width);
        $new_height = ceil($scale*$old_height);

        // Create new empty image
        if($makeSquare){
            $new_height = $new_width;
        }
        $new = imagecreatetruecolor($new_width, $new_height);

        // Resize old image into new
        imagecopyresampled($new, $image, 
            0, 0, 0, 0, 
            $new_width, $new_height, $old_width, $old_height);

        $filename = stripslashes($_FILES['image']['name']);
        $extension = getExtension($filename);
        $extension = strtolower($extension);
        $image=$_FILES['image']['name'];

        $image_name=$imageName.'.'.$extension;
        $newname = $folderName.$image_name;

        // Catch the imagedata
        ob_start();
        $copied = imagejpeg($new, $newname);
        $data = ob_get_clean();

        if($copied){
            return $newname;
        } else {
            return false;
        }
    }

    function resizeImageAndSend2S3($maxWidth, $maxHeight, $makeSquare=false, $imageName, $folderName = "uploaded-images/"){
        $image = false;
        // Create image from file
        switch(strtolower($_FILES['image']['type']))
        {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($_FILES['image']['tmp_name']);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($_FILES['image']['tmp_name']);
                break;
            default:
                exit('Unsupported type: '.$_FILES['image']['type']);
        }
        // Target dimensions
        $max_width = $maxWidth;
        $max_height = $maxHeight;

        // Get current dimensions
        $old_width  = imagesx($image);
        $old_height = imagesy($image);

        // Calculate the scaling we need to do to fit the image inside our frame
        $scale      = min($max_width/$old_width, $max_height/$old_height);

        // Get the new dimensions
        $new_width  = ceil($scale*$old_width);
        $new_height = ceil($scale*$old_height);

        // Create new empty image
        if($makeSquare){
            $new_height = $new_width;
        }
        $new = imagecreatetruecolor($new_width, $new_height);

        // Resize old image into new
        imagecopyresampled($new, $image, 
            0, 0, 0, 0, 
            $new_width, $new_height, $old_width, $old_height);

        $filename = stripslashes($_FILES['image']['name']);
        $extension = getExtension($filename);
        $extension = strtolower($extension);
        $image=$_FILES['image']['name'];

        $image_name=$imageName.'.'.$extension;
        $newname = $folderName.$image_name;

        // Catch the imagedata
        ob_start();
        $copied = imagejpeg($new, $newname);
        $data = ob_get_clean();

        $s3 = new S3(awsAccessKey, awsSecretKey);
        // $s3->putBucket("fofgfog", S3::ACL_PUBLIC_READ);
        
        if($s3->putObjectFile($newname, "ginkatego", "uploads/" . $image_name, S3::ACL_PUBLIC_READ)){
            unlink($newname);
            return $image_name;
        } else {
            return "undefined.jpg";
        }

    }

    function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
    }
?>