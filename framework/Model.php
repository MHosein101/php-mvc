<?php

abstract class Model {
  
  protected $db = NULL;
  
  function __construct(){
    if( strtoupper(Config::DB_DRIVER) == Config::DRIVER_SQL ){
      $this->db = new MySqlPDOAdaptor(Config::SqlOptions());
    }
    elseif( strtoupper(Config::DB_DRIVER) == Config::DRIVER_JSON ){
      $this->db = new JsonModel(Config::JSON_FILE);
    }
  }
  
}

?>