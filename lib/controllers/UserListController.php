<?php
    /*
        including model class of this controller for CRUD
     */

    require_once("../models/UserListController.php");

    $app->post('/user/list', function () use ($app){
        
        $name = $req->params('name');    
        $res = UserList::create($name);
        echo json_encode(array('success'=>true, 'id'=>));
    });
    
    // $app->map('/images', function () use ($app){
    //     echo "hohohohohoh";
    // })->via('GET', 'POST');
    
    // $app->get('/images', function () use ($app){
    //     echo "hohohohohoh";
    // });
?>