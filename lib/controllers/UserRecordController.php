<?php
    /*
        including model class of this controller for CRUD
     */

    require_once "lib/models/UserRecordModel.php";

    $app->get('/user/record/upload', function () use ($app){
        
        $req = $app->request();

        $imageUrl = urldecode($req->params('image_url'));
        $sourceUrl = urldecode($req->params('source_url'));

        if(isset($_SESSION['username'])){
            //app->redirect('/');image_url
            //echo "logged";
            $view = $app -> view();
        
            $title = "Upload Record"; 
            
            $view -> setData(array('title' => $title, 'imgUrl'=>$imageUrl, 'srcUrl'=>$sourceUrl));
            $app->render('upload_record.php');
            exit;
        } else {
            //echo "out";
            $app->redirect("/user/login");
            exit;
        }

    });

    $app->post('/user/record/manage/:operation', function ($operation) use ($app){

        //echo json_encode(array('success'=>true, 'op'=>$operation));
        
        $req = $app->request();

        switch ($operation) {
            case 'create':
                # code...
                $newElement = json_decode($req->params('model'), true);

                $res = UserRecord::create($newElement);

                if($res){
                    echo json_encode(array('success'=>true, 'id'=>$res));
                } else {
                    echo json_encode(array('success'=>false));
                }
                
                break;
            
            case 'read':
                $owner = $_SESSION['username'];

                $res = UserRecord::readRecordsOfUser($owner, $req->params("limit"), $req->params("offset"), $req->params("list"));

                echo json_encode(array('success'=>true, 'data'=>$res));

                break;
            default:
                # code...
                break;
        }

    });
    
    // $app->map('/images', function () use ($app){
    //     echo "hohohohohoh";
    // })->via('GET', 'POST');
    
    // $app->get('/images', function () use ($app){
    //     echo "hohohohohoh";
    // });
?>