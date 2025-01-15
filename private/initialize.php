<?php
ob_start();

/**
 * CONSTANT VARIABLES
 */

 define("PRIVATE_PATH", dirname(__FILE__));
 define("PROJECT_PATH", dirname(PRIVATE_PATH));
 define("PUBLIC_PATH", PROJECT_PATH . '/public');
 define("SHARED_PATH", PRIVATE_PATH . '/shared');

 // Define root url
 $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
 $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
 define("WWW_ROOT", $doc_root);


 /**
 * Initialize Application and include, or require libraries third party or local.
 */

 require_once('functions.php');
 require_once('database.php');
 require_once('query_functions.php');
 
 /** 
  * create db connection so that every page loaded has a // db_connection already to use.
  * you can load it on a case by case basis. 
  */ 

  $db = db_connect();
  
  // for error form messages
  $errors = [];
