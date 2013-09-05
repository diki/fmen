<?php 
    
    include 'Utils.php';
    include 'Console.php';
    include 'DBB.php';
    include 'SimpleImage.php';
    include 'S3.php';

    include 'lib/facebook/facebook.php';

    include 'lib/twitter/OAuth.php';
    include 'lib/twitter/twitteroauth.php';
    
    include 'CommonFunctions.php';

    /**
     * initialize DB connection
     */
    DB::setConnection("kiks", "kiks", 
        "root", "root", "localhost");
    DB::useConnection("kiks");

    /**
     * constants
     */
    define("HTTP_URL", "http://www.pindistan.com/");
    define ("MAX_SIZE","10000"); 

    define("FB_APP_ID", "382443528535064");
    define("FB_APP_SECRET", "f416ed9bde6ac89ef693f22fcee482fc");

    define("TWITTER_CONSUMER_KEY", "XcSQ6LQDr4guFm1enTOdA");
    define("TWITTER_CONSUMER_SECRET", "bvdtJwVUCqKdO6Bl3sXabdhQ1pVA3vzCQGN8xuqotI");

    /**
     * AWS access info
     *
     * and objects
     */
    if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJAT6CHH46OIKAOGA');
    if (!defined('awsSecretKey')) define('awsSecretKey', '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');
    // //instantiate the class
    $s3 = new S3(awsAccessKey, awsSecretKey);

?>