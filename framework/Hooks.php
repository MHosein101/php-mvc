<?php

class Hooks {
  
  public static function beforeAll(){
    // This Hook Will Run Before Doing Any Thing
  }
  
  public static function beforeRouter(){
    // This Hook Will Run Before Routing
  }
  
  public static function afterRouter($routeProvider,$result){
    // This Hook Will Run After Routing
    // var_dump($result);
    // var_dump($routeProvider);
  }
  
  public static function beforeController($result){
    // This Hook Will Run Before Creating Controller Object
  }
  
  public static function beforeAction($result,$controllerObj){
    // This Hook Will Run Before Calling Action
    // var_dump($result);
  }
  
  public static function afterAll($result){
    // This Hook Will Run After Doing All Things
    // var_dump($result);
  }
  
  public static function unCallableAction($result){
    // This Hook Will Run If Called Action Not Exists Or Is Not Public
    // var_dump($result);
    echo "404 , Can't Call {$result['method']} Method In {$result['class']} Controller";
  }
  
  public static function nonExistController($result){
    // This Hook Will Run If Controller File Not Exists
    // var_dump($result);
    echo "404 , {$result['class']} Controller File Not Found";
  }
  
  public static function undefinedRoute($result){
    // This Hook Will Run If Route Is Not Defined And Is Wrong
    // var_dump($result);
    echo "404 , Route Not Found";
  }
  
}

?>