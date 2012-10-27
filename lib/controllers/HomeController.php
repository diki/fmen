<?php 

    $app->get('/', function () use ($app){
        
        //if there is a session when coming here
        
        if(isset($_SESSION['username']) && $_SESSION['username']){
            //echo "npooooooooooooooooooooooooooo";
            
        }
        $title = "Home Title";
        $body = "Home body";

        $view = $app -> view();
        
        $s = false;
        $username = false;
        if(isset($_SESSION['username'])){
            $s = true;
            $username = $_SESSION['username'];
        } 
        $view -> setData(array('title' => $title));

        $app->render('home.php');

    });
    
?>