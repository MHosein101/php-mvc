<?php
class Input {
  
  public static function get($key = ''){
    if($key == '') return $_GET;
    else{
      if( isset($_GET[$key]) !== NULL ) return $_GET[$key];
      else NULL;
    }
  }
  
  public static function post($key = ''){
    if($key == '') return $_POST;
    else{
      if( isset($_POST[$key]) !== NULL ) return $_POST[$key];
      else NULL;
    }
  }
  
  public static function put($key = ''){
    if( strtoupper($_SERVER['REQUEST_METHOD']) == 'PUT' ){
      parse_str( file_get_contents( 'php://input' ) , $_R );
      if($key == '') return $_R;
      else{
        if( isset($_R[$key]) !== NULL ) return $_R[$key];
        else NULL;
      }
    }
  }
  
  public static function patch($key = ''){
    if( strtoupper($_SERVER['REQUEST_METHOD']) == 'PATCH' ){
      parse_str( file_get_contents( 'php://input' ) , $_R );
      if($key == '') return $_R;
      else{
        if( isset($_R[$key]) !== NULL ) return $_R[$key];
        else NULL;
      }
    }
  }
  
  public static function delete($key = ''){
    if( strtoupper($_SERVER['REQUEST_METHOD']) == 'DELETE' ){
      parse_str( file_get_contents( 'php://input' ) , $_R );
      if($key == '') return $_R;
      else{
        if( isset($_R[$key]) !== NULL ) return $_R[$key];
        else NULL;
      }
    }
  }
  
  public static function file($key = ''){
    if($key == '') return $_FILES;
    else{
      if( isset($_FILES[$key]) !== NULL ) return $_FILES[$key];
      else NULL;
    }
  }
  
}
?>