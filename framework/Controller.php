<?php

abstract class Controller {
  
  function __construct(){
		foreach( Config::AUTOLOAD_MODELS as $model ){
      $res = Loader::parse_path($model);
			require MODELS . $res['path'];
      $cv = $c = $res['class'];
			$this->$cv = new $c();
		}
		foreach( Config::AUTOLOAD_HELPERS as $helper ){
      $res = Loader::parse_path($helper);
			require HELPERS . $res['path'];
      $c = $res['class'];
      $cv = strtolower($res['class']);
			$this->$cv = new $c();
		}
		foreach( Config::AUTOLOAD_LIBRARIES as $library ){
      $res = Loader::parse_path($library);
			require LIBRARIES . $res['path'];
      $c = $res['class'];
      $cv = strtolower($res['class']);
			$this->$cv = new $c();
		}
  }
  
  function _action($action,$params){
    call_user_func_array([$this,$action],$params);
  }
  
}

?>