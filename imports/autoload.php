<?php

    if(!(defined("DS") && defined("SITE_ROOT") && defined("LIB_PATH"))) {
        define("DS", DIRECTORY_SEPARATOR);

        //Replace the following document root with your custom root depending on the environment you are running
        define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'photoapp'.DS.'aws');   
           
        define('LIB_PATH', SITE_ROOT.DS.'imports');   
    }
    require_once(LIB_PATH.DS."configuration.php");
    require_once(LIB_PATH.DS."miscellaneous.php");
    require_once(LIB_PATH.DS."dboperation.php");
    require_once(LIB_PATH.DS."dbdml.php");
    require_once(LIB_PATH.DS."session.php");
    require_once(LIB_PATH.DS."photograph.php");
    require_once(LIB_PATH.DS."..".DS."vendor".DS."autoload.php");

?>