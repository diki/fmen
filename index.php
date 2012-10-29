<?php 

    echo "hobaaa geliyoır anananan";
    require 'lib/Slim/Slim.php';
    require 'lib/Views/TwigView.php';
    // include_once 'lib/db.php';
    include_once 'lib/init.php';
    
    // include_once 'lib/db.php';
    // include_once 'lib/init.php';
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

    session_start();
    //GET route
    include_once 'lib/controllers/HomeController.php';
    include_once 'lib/controllers/UserController.php';
    include_once 'lib/controllers/CombineController.php';
    include_once 'lib/controllers/ImageController.php';
    include_once 'lib/controllers/CombineElementsController.php';

    /**
     * Step 4: Run the Slim application
     *
     * This method should be called last. This is responsible for executing
     * the Slim application using the settings and routes defined above.
     */
    $app->run();

?>