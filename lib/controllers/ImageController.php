<?php
    //define a maxim size for the uploaded images in Kb
    $app->post('/images', function () use ($app){
        
        $req = $app->request();
        $height = intval($req->params("height"));
        $width = intval($req->params("width"));

        $image_name=time() . "_" . $req->params("width") . "x" . $req->params("height");
        // if($req->params("element")){
        //     resizeImageAndSend2S3(160, 160, true, $image_name, "uploaded-images/thumbs/");
        //     resizeImageAndSend2S3(32, 32, true, $image_name, "uploaded-images/thumbs/");
        //     // resizeImageAndSave(160, 160, true, $image_name, "uploaded-images/thumbs/");
        //     // resizeImageAndSave(32, 32, true, $image_name,"uploaded-images/markers/");
        // }

        $copied = resizeImageAndSend2S3($height, $width, false, $image_name);

        if($copied){
             echo json_encode(array('success'=>true, 'id'=>$copied));
             die();   
        }

    });
    
    // $app->map('/images', function () use ($app){
    //     echo "hohohohohoh";
    // })->via('GET', 'POST');
    
    // $app->get('/images', function () use ($app){
    //     echo "hohohohohoh";
    // });
?>