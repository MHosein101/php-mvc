<?php

/* Variable Type Checker */
class VTC {
  
  public function type($var){
    return strtoupper(gettype($var));
  }
  
  public function isStr($var){
    return ($this->type($var) == "STRING");
  }
  
  public function isChar($var){
    return ($this->type($var) == "STRING" && strlen($var) == 1);
  }
  
  public function isInt($var){
    return ($this->type($var) == "INTEGER");
  }
  
  public function isFloat($var){
    return ($this->type($var) == "DOUBLE");
  }
  
  public function isDouble($var){
    return ($this->type($var) == "DOUBLE");
  }
  
  public function isArray($var){
    return ($this->type($var) == "ARRAY");
  }
  
  public function isObject($var){
    return ($this->type($var) == "OBJECT");
  }
  
  public function arrayType($var){
    $s = json_encode($var);
    if    ( substr($s,0,1) == '{' ) return 'STRING';
    elseif( substr($s,0,1) == '[' ) return 'INT';
  }
  
  public function intKeyArray($var){
    return ($this->arrayType($var) == "INT");
  }
  
  public function stringKeyArray($var){
    return ($this->arrayType($var) == "STRING");
  }
  
}

?>