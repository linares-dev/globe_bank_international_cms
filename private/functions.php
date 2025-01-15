<?php
  
  function get_url_root($filepath){
    // define the url root dynamically.
    if( $filepath[0] != '/' ){
      $filepath = '/' . $filepath;
    }
    return WWW_ROOT . $filepath;
  }

  function h($string=""){
    return htmlspecialchars($string);
  }

  function ue($string){
    // urlencode string
    if (!$string){
      return -1;
    }
    return urlencode($string);
  }

  function error_404(){
    header( $_SERVER['SERVER_PROTOCOL'] . " 404 Not Found" );
    exit();
  }

  function error_500(){
    header( $_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error" );
    exit();
  }

  function redirect_client($location){
    header( 'Location: ' . $location );
    exit();
  }

  function request_is_post(){
    // check if a form was submitted
    return $_SERVER['REQUEST_METHOD'] === 'POST';
  }

  function request_is_get(){
    // check if a form was submitted
    return $_SERVER['REQUEST_METHOD'] === 'GET';
  }

  function display_errors($errors){
    $output = '';
    if ( !empty($errors)){
      $output .= "<div class='errors'>";
      $output .= "Please fix the following errors";
      $output .= "<ul>";
      foreach($errors as $error){
        $output .= "<li>". h($error) . "</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }



