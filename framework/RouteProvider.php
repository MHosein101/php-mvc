<?php

class RouteProvider {
  
  private $_routes = [];
  private $group = "";
  
  private function set($m,$r,$t){
    $r = trim($r,"/");
    $this->_routes[$m][ $this->toRegex($this->group . $r) ] = $t;
  }
  
  public function routes($m = ''){
    if($m == '') return $this->_routes;
    else return $this->_routes[$m];
  }
  
  public function get($r,$t = ''){
    $this->set("GET",$r,$t);
    return $this;
  }
  
  public function post($r,$t = ''){
    $this->set("POST",$r,$t);
    return $this;
  }
  
  public function put($r,$t = ''){
    $this->set("PUT",$r,$t);
    return $this;
  }
  
  public function patch($r,$t = ''){
    $this->set("PATCH",$r,$t);
    return $this;
  }
  
  public function delete($r,$t = ''){
    $this->set("DELETE",$r,$t);
    return $this;
  }
  
  public function group($g){
   $this->group .= $g . "/";
   return $this;
  }
  
  public function end($g = ""){
    if($g == ""){
      $this->group = "";
    }
    else{
      $this->group = str_replace($g.'/',"",$this->group);
    }
    return $this;
  }
  
  private function toRegex($route){
    $route = trim($route,"/");
    $route = str_replace('/','\/',$route);
    $param_regex = "/\{\w+:?([^\/]*)\}/i";
    $route = preg_replace_callback( $param_regex , function($matches){
      $pattern = strtoupper($matches[1]);
      switch($pattern){
        case "INT":
          return "(\d+)";
        break;
        case "WORD":
          return "([a-zA-Z]+)";
        break;
        case "STRING":
          return "(\w+)";
        break;
        case "ANY":
        case "":
          return "(.+)";
        break;
        default:
          return "(" . $matches[1] . ")";
        break;
      }
    } , $route );
    return "/^".$route."$/i";
  }
  
}

?>