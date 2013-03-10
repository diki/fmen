<?php 

    // echo "hobaaa geliyoır anananan iyiyi vay vay vay ";
    require 'lib/Slim/Slim.php';
    require 'lib/Views/TwigView.php';
    // include_once 'lib/db.php';
    // include_once 'lib/init.php';
    
    // include_once 'lib/db.php';
    include_once 'lib/init.php';

    require 'lib/facebook/facebook.php';
    /**
     * Step 2: Instantiate the Slim application
     *
     * Here we instantiate the Slim application with its default settings.
     * However, we could also pass a key-value array of settings.
     * Refer to the online documentation for available settings.
     */


    $app = new Slim(array(
        'debug' => true,
        'templates.path' => 'lib/templates',
        'view' => 'TwigView',
        'cookies.lifetime' => '2 days', //parsed with `strtotime` internally
        //'cookies.secret_key' => 'foo',
        'cookies.httponly' => false,
        'cookies.secret_key'  => 'MY_SALTY_PEPPER',
        'cookies.lifetime' => time() + (1 * 24 * 60 * 60), // = 1 day
        'cookies.cipher' => MCRYPT_RIJNDAEL_256,
        'cookies.cipher_mode' => MCRYPT_MODE_CBC
    ));

    $facebook = new Facebook(array(
            'appId' => '546067615425845',
            'secret' => 'c002269023db410abdf731b0a62ef164'
        ));

    $user = $facebook->getUser();

    if($user){
        try{
            $user_profile = $facebook->api('/me');

            // var_dump($user_profile);
            // die();

            $_SESSION['username'] = $user_profile['name'];
            $_SESSION['name'] =  $user_profile['first_name'];
            $_SESSION['surname'] = $user_profile['last_name'];
            $_SESSION['profiled'] = false;
            $_SESSION['id'] = $user_profile['id'];

        }catch(FacebookApiException $e){
            $user = null;
        }
    }
    // session_start();



    /*
        include models 
     */
    // include_once 'lib/models/UserListModel.php';
    // include_once 'lib/controllers/HomeController.php';

    //GET route
    include_once 'lib/controllers/HomeController.php';
    include_once 'lib/controllers/UserController.php';
    include_once 'lib/controllers/CombineController.php';
    include_once 'lib/controllers/ImageController.php';
    
    include_once 'lib/controllers/CombineElementsController.php';

    include_once 'lib/controllers/UserRecordController.php';
    include_once 'lib/controllers/UserListController.php';
    

    /**
     * Step 4: Run the Slim application
     *
     * This method should be called last. This is responsible for executing
     * the Slim application using the settings and routes defined above.
     */
    $app->run();


?>