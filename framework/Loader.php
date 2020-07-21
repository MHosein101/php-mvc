<?php

class Loader {
  
  public static function model($file){
    $res = Loader::parse_path($file);
    require MODELS . $res['path'];
    return new $res['class']();
  }
  
  public static function library($file,$args = NULL){
    $res = Loader::parse_path($file);
    require LIBRARIES . $res['path'];
    return new $res['class']($args);
  }
  
  public static function helper($file,$args = NULL){
    $res = Loader::parse_path($file);
    require HELPERS . $res['path'];
    return new $res['class']($args);
  }
  
  public static function parse_path($file){
    $DS = DIRECTORY_SEPARATOR;
    $file = str_replace('/', $DS ,$file);
    $path = $class = $file;
    if(strpos($file,'@') !== FALSE){
      $path = explode('@',$file)[0];
      $class = explode('@',$file)[1];
    }
    else{
      if(strpos($file,$DS) !== FALSE){
        $class = explode($DS,$file);
        $class = $class[count($class)-1];
      }
    }
    return [
      'path' => "$path.php" ,
      'class' => $class
    ];
  }
  
}

?>