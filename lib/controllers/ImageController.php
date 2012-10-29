<?php

    require_once("../sdk-1.5.15/sdk.class.php");
    //define a maxim size for the uploaded images in Kb
    $app->post('/images', function () use ($app){
        
        $s3 = new AmazonS3();
        if (!$s3->if_bucket_exists($bucket_name)) {
            $response = $s3->create_bucket($bucket_name, AmazonS3::REGION_US_E1, AmazonS3::ACL_PUBLIC);
        }
        
        $req = $app->request();
        // $height = intval($req->params("height"));
        // $width = intval($req->params("width"));

        // $image_name=time();
        // if($req->params("element")){
        //     resizeImageAndSave(160, 160, true, $image_name, "uploaded-images/thumbs/");
        //     resizeImageAndSave(32, 32, true, $image_name,"uploaded-images/markers/");
        // }

        // $copied = resizeImageAndSave($height, $width, true, $image_name);

        // if($copied){
        //      echo json_encode(array('success'=>true, 'id'=>$copied));
        //      die();   
        // }

    });

?>