<?php

header('Access-Control-Allow-Origin: *');

session_start();

define('DS' , DIRECTORY_SEPARATOR);
define('FOLDER' , __DIR__ . DS );
define('CORE' , FOLDER . 'framework' . DS );
define('APP' , FOLDER . 'application' . DS );
define('CONTROLLERS' , APP . 'controllers' . DS );
define('MODELS' , APP . 'models' . DS );
define('VIEWS' , APP . 'views' . DS );
define('HELPERS' , APP . 'helpers' . DS );
define('LIBRARIES' , APP . 'libraries' . DS );
define('LOGS' , APP . 'logs' . DS );

define('_Q_S' , $_SERVER['QUERY_STRING'] );
define('_R_M' , $_SERVER['REQUEST_METHOD'] );

spl_autoload_register(function($c){
  require CORE . "$c.php";
});

error_reporting(E_ALL);
set_error_handler('Problem::Error');
set_exception_handler('Problem::Exception');
ini_set( 'error_log' , LOGS . date('Y-m-d H.i.s') . ".txt" );

Hooks::beforeAll();

require CORE . "Functions.php";

Hooks::beforeRouter();
$Routes = new RouteProvider();
require CORE . "RoutesList.php";
$__result = (new RouteParser())->result( $Routes->routes(_R_M) , _Q_S );
Hooks::afterRouter($Routes,$__result);

if( $__result !== NULL ){
  $__file = CONTROLLERS . $__result['file'] . ".php";
  if( file_exists($__file) ){
    Hooks::beforeController($__result);
    require $__file;
    $__obj = new $__result['class']();
    if( method_exists($__obj,$__result['method']) ){
      Hooks::beforeAction($__result,$__obj);
      $__obj->_action($__result['method'],$__result['params']);
      Hooks::afterAll($__result);
    }
    else Hooks::unCallableAction($__result);
  }
  else Hooks::nonExistController($__result);
}
else Hooks::undefinedRoute($__result);


?>