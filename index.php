<?php
/**
 * Step 1: Require the Slim PHP 5 Framework
 *
 * If using the default file layout, the `Slim/` directory
 * will already be on your include path. If you move the `Slim/`
 * directory elsewhere, ensure that it is added to your include path
 * or update this file path as needed.
 */
require 'lib/Slim/Slim.php';
require 'lib/Views/TwigView.php';

include_once 'lib/db.php';
include_once 'lib/init.php';
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



/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function. If you are using PHP < 5.3, the
 * second argument should be any variable that returns `true` for
 * `is_callable()`. An example GET route for PHP < 5.3 is:
 *
 * $app = new Slim();
 * $app->get('/hello/:name', 'myFunction');
 * function myFunction($name) { echo "Hello, $name"; }
 *
 * The routes below work with PHP >= 5.3.
 */

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

