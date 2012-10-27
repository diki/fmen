<?php

//user operations
$app->get('/user/register', function () use ($app){
        
    if(isset($_SESSION['username'])){
        $app->redirect('/glim');
    } else {
        $title = "SexualPinner register";
        $bodyTitle = "User registration";
        
        $view = $app -> view();
        $view -> setData(array('title' => $title));
        
        $app->render('register.php');
    }

});

$app->post('/user/register', function () use ($app){
    
    #session_start();
    
    if(isset($_SESSION['username'])){
        $app->redirect(HTTP_URL);
    } else {
        $req = $app->request();
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        
        //server side validation here
        $email = $req->params('email');
        $password = $req->params('password');
        $type = $req->params('type');
        $name = $req->params('name');
        $surname = $req->params('surname');

        if($email==null){
            //echo "foremail-Email field cannot be empty";
            
            return;
        }

        if($password==null){
            echo "forpassword-Password field cannot be empty";
            return;   
        }

        if($type == null || $type=="default"){
            echo "fortype-Type cannot be empty";
            return;
        }

        if($name == null){
            echo "forname-Name cannot be empty";
            return;
        }

        if($surname == null){
            echo "fosurrname-Surname cannot be empty";
            return;
        }

        $email = mysql_real_escape_string($req->params('email'));
        $password = mysql_real_escape_string($req->params('password'));
        $type = mysql_real_escape_string($req->params('type'));
        $name = mysql_real_escape_string($req->params('name'));
        $surname = mysql_real_escape_string($req->params('surname'));
        $username = "";

        $userRows = DB::read("SELECT * FROM members WHERE email=':email'", $email);
        $rows = $userRows->result;

        //construct username from other names
        $userNames = DB::read("SELECT * FROM members WHERE name=':name' AND surname=':surname'", $name, $surname);
        $userNamesRes = $userNames->result;

        if(empty($userNamesRes)){
            $username = $name. "_" . $surname;
        } else {
            $username = $name. "_" . $surname . (count($userNamesRes)-1);
        }
        //if email is not registered
        if(!empty($rows)){
            echo json_encode(array('success'=>false, 'status'=>'This email is already registered'));
            die(); 
        } else {
            $user = array(
                "email" => $email,
                "password" => $password,
                "type" => $type,
                "name" => $name,
                "surname" => $surname,
                "username" => $username
            );

            $newUser = DB::insert("members", $user, true);

            if($newUser->success){
                $_SESSION['username'] = $username;
                $_SESSION['name'] =  $name;
                $_SESSION['profiled'] = 0;
                
                echo json_encode(array('success'=>true, 'redirect_url'=>'/glim'));
                die();
            }
        }      
    }

});

$app->get('/user/login', function () use ($app){

    
    if(isset($_SESSION['username'])){
        $app->redirect(HTTP_URL);
    } else {
        $title = "Login";
        $body = "User login";
        
        $view = $app -> view();
        $view -> setData(array('title' => $title));
        $app->render('login.php');
    }
});

$app->post('/user/login', function () use ($app){
   
    if(isset($_SESSION['username'])){
        $app->redirect(HTTP_URL);
    } else {
        $req = $app->request();
        $response = $app->response();
        //$response['Content-Type'] = 'application/json';
        
        $email = $req->params('email');
        $password = $req->params('password');
        $type = $req->params('type');

        //server side validation here
        if($email==null){
            echo "foremail-Email field cannot be empty";
            return;
        }

        if($password==null){
            echo "forpassword-Password field cannot be empty";
            return;   
        }

        if($type == null || $type=="default"){
            echo "fortype-Type cannot be empty";
            return;
        }

        $email = mysql_real_escape_string($req->params('email'));
        $password = mysql_real_escape_string($req->params('password'));
        $type = mysql_real_escape_string($req->params('type'));
        //$sql = mysql_query("SELECT * FROM members WHERE username = '".$username."' and password = '".$password."'");
        
        $rows = DB::read("SELECT * FROM members WHERE email=':email' AND password=':password' AND type=':type'", $email, $password, $type);
        if (!empty($rows->result)) 
        {

            $result = $rows->result;
            $user = $result[0];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] =  $user['name'];
            $_SESSION['surname'] = $user['surname'];
            $_SESSION['profiled'] = $user['profiled'];
            //set cookie
            //$app->setCookie('_gstun', $user['username']);
           // setcookie('gstun', $user['username']);
            $app->setEncryptedCookie('_gstun', $user['username']);
            //echo json_encode(array('success'=>true, 'redirect_url'=>'/glim'));
            $app->redirect(HTTP_URL);
            die();
        } else {
            //return json response success false;
            echo json_encode(array('success'=>false, 'status'=>'Username or password incorrect'));
            die();
        }
    }
});

$app->post('/user/logout', function () use ($app){

    session_destroy();
    $app->redirect(HTTP_URL);

});

?>