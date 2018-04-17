<?php
    /*  
    *   
    *   Replace the following database credentials with your own
    *   DB_SERVER:  Insert your aws ENDPOINT URL
    *   DB_USER:    Your database username   
    *   DB_PASS:    Your database password
    *   DB_NAME:    Your database name
    *
    */
    if(!(defined("DB_SERVER") && defined("DB_USER") && defined("DB_PASS") && defined("DB_NAME"))) {
        define("DB_SERVER", "");
        define("DB_USER", "");
        define("DB_PASS", "");
        define("DB_NAME", "");
    }

    /*  
    *   
    *   Replace the following S3 credentials with your own
    *   S3_BUCKETNAME:    Your bucketname   
    *   S3_KEY:    Your AWS authentication key
    *   S3_SECRET:    Your AWS SECRET keyword
    *
    */

    if(!(defined("S3_BUCKETNAME") && defined("S3_KEY") && defined("S3_SECRET"))) {
        define("S3_BUCKETNAME", 'cainam-app-bucket');
        define("S3_KEY", 'AKIAJSBEPFZOWJJDEDAQ');
        define("S3_SECRET", 'j8Tl+bephxJ4J+rHpZg27Qa9bkmrqqt+zfA8BQ7');
    }

?>