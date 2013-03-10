<?php

require_once "lib/models/UserListModel.php";



//user operations
$app->get('/user/register', function () use ($app){
        
    if(isset($_SESSION['username'])){
        $app->redirect('/');
    } else {
        $title = "ginkatego kullanıcı kaydı";
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
                
                echo json_encode(array('success'=>true, 'redirect_url'=>'/'));
                die();
            }
        }      
    }

});

$app->get('/user/login', function () use ($app){

    /**
     * if user came from facebook register it and redirect to main page
     */
    if(isset($_SESSION['username'])){
        $app->redirect(HTTP_URL);
    } else {

        $title = "Login";
        $body = "User login";
        
        $view = $app -> view();

        $facebook = new Facebook(array(
            'appId' => FB_APP_ID,
            'secret' => FB_APP_SECRET
        ));
        $view -> setData(array('title' => $title, 'fbLoginUrl'=>$facebook->getLoginUrl(array( 'scope' => 'email'))));
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
            $_SESSION['id'] = $user['id'];
            
            //set user name cookie
            $app->setEncryptedCookie('_gstun', $user['username']);
            //set user_id cookie
            $app->setEncryptedCookie('_gstuk', $user['id']);
            //set user is authanticated
            // $app->setEncryptedCookie('_gstauth', )
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


$app->get('/user/twitter-login', function() use ($app){

    $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);

    // Requesting authentication tokens, the parameter is the URL we will be redirected to
    $request_token = $twitteroauth->getRequestToken(HTTP_URL . 'user/twlogin');

    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    // If everything goes well..
    if ($twitteroauth->http_code == 200) {
        // Let's generate the URL and redirect
        $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);

        echo $url;
        $app->redirect($url);
    } else {
        // It's a bad idea to kill the script, but we've got to know when there's an error.
        die('Something wrong happened.');
    }
});

$app->get('/user/fb-login', function() use ($app){
    $facebook = new Facebook(array(
        'appId' => FB_APP_ID,
        'secret' => FB_APP_SECRET
    ));
    $user = $facebook->getUser();
    if($user){
        try{
            // $app->redirect("/");
            $app->render('fbLoggedIn.php');
        }catch(FacebookApiException $e){
            $user = null;
        }
    } else {
        $url = $facebook->getLoginUrl(array( 'redirect_uri' => HTTP_URL . 'user/fb-login', 'scope' => 'email'));
        $app->redirect($url);
    }
});

$app->get('/user/twlogin', function () use ($app){

    $req = $app->request();

    if($req->params('oauth_verifier') && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
        $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        // Let's request the access token
        $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
        
        // Save it in a session var
        $_SESSION['access_token'] = $access_token;
        
        // Let's get the user's info
        $user_info = $twitteroauth->get('account/verify_credentials');
        
        
        // Print user's info
        if (isset($user_info->error)) {
            // Something's wrong, go back to square 1  
            header('Location: login-twitter.php');
        } else {
            // var_dump($user_info);
            $twitter_otoken=$_SESSION['oauth_token'];
            $twitter_otoken_secret=$_SESSION['oauth_token_secret'];
            $email='';
            $uid = $user_info->id;
            $username = $user_info->name;
            $_SESSION['id'] = $uid;
            $_SESSION['username'] = $username;

            $app->setEncryptedCookie('_gstuk', $uid);
            
            $app->render('twitterLoggedIn.php');
            //TODO: save outh token and secret
        }
    }
});


$app->post('/user/logout', function () use ($app){

    $app->deleteCookie('_gstun');
    $app->deleteCookie('_gstuk');
    $app->deleteCookie('_gstfb');
    session_destroy();

    $app->redirect(HTTP_URL);

});


$app->get('/user/profile/:name', function($name) use ($app){


    $view = $app -> view();
        
    $title = "Profile"; 

    $listsOfUser = UserList::readListsOfUser($name);

    
    $view -> setData(array('title' => $title, ''));
    if($_SESSION['username']==$name){
        $app->render('private_profile.php');
        exit;
    } else {
        $app->render('public_profile.php');
        exit;
    }

    
});



?>