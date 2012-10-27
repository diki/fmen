<?php
    //define a maxim size for the uploaded images in Kb
    $app->post('/images', function () use ($app){
        
        $req = $app->request();
        $height = intval($req->params("height"));
        $width = intval($req->params("width"));

        $image_name=time();
        if($req->params("element")){
            resizeImageAndSave(160, 160, true, $image_name, "uploaded-images/thumbs/");
            resizeImageAndSave(32, 32, true, $image_name,"uploaded-images/markers/");
        }

        $copied = resizeImageAndSave($height, $width, true, $image_name);

        if($copied){
             echo json_encode(array('success'=>true, 'id'=>$copied));
             die();   
        }

    });

?>