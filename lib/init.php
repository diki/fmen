<?php 
    
    include_once 'Utils.php';
    include_once 'Console.php';
    include_once 'DBB.php';
    include_once 'SimpleImage.php';
    include_once 'S3.php';

    include_once 'lib/facebook/facebook.php';

    include_once 'lib/twitter/OAuth.php';
    include_once 'lib/twitter/twitteroauth.php';
    
    include_once 'CommonFunctions.php';

    
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

    define("FB_APP_ID", "572794652744127");
    define("FB_APP_SECRET", "cbf87f1f0492521626c3ee7501da6ea4");

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