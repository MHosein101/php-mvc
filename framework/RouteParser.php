<?php

class RouteParser {

  public function result($routes,$url){
    foreach($routes as $pattern => $target){
      $params = $this->check($url,$pattern);
      if( $params != NULL ){
        array_shift($params);
        $result = $this->parse($target,$params);
        return $result;
      }
    }
    return NULL;
  }
  
  private function check($url,$regex){
    if( preg_match($regex,$url,$matches) == 1 ){
      return $matches;
    }
    else return NULL;
  }

  private function parse($target,$params){
    $m = "";
    $t = explode( "@" ,$target[0]);
    $f = str_replace("\\", "/" ,$t[0]);
    $c = explode( "/" , $f);
    $c = $c[count($c)-1];
    if( count($t) > 1 ){
      $m = $t[1];
    }
    else{
      $m = "index";
    }
    $p = [];
    if( count($target) > 1 ){
      $p = $target[1];
      for($i = 0 ; $i < count($params) ; $i++){
        $k = $i+1;
        $p = str_replace( '{' . $k . '}' , $params[$i] , $p );
      }
      $p = explode(',',$p);
      for($i = 0 ; $i < count($p) ; $i++){
        $p[$i] = $this->toReal($p[$i]);
      }
    }
    return [
      'file' => $f ,
      'class' => $c ,
      'method' => $m ,
      'params' => $p
    ];
  }
  
  private function toReal($val){
    if( strtoupper($val) == 'TRUE' ) return TRUE;
    elseif( strtoupper($val) == 'FALSE' ) return FALSE;
    elseif( strtoupper($val) == 'NULL' ) return NULL;
    elseif( is_numeric($val) ){
      if( strpos($val,'.') !== FALSE ) return floatval($val);
      else return intval($val);
    }
    else return $val;
  }
  
}

?>