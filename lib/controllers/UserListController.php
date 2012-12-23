<?php
    /*
        including model class of this controller for CRUD
     */

    include_once "lib/models/UserListModel.php";

    $app->post('/user/list/:operation', function ($operation) use ($app){

        //echo json_encode(array('success'=>true, 'op'=>$operation));
        
        $req = $app->request();

        switch ($operation) {
            case 'create':
                # code...
                $newElement = json_decode($req->params('model'), true);

                $res = UserList::create($newElement['name']);

                if($res){
                    echo json_encode(array('success'=>true, 'id'=>$res['id']));
                } else {
                    echo json_encode(array('success'=>false));
                }
                
                break;
            
            case 'read':
                $owner = $_SESSION['username'];

                $res = UserList::readListsOfUser($owner);

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