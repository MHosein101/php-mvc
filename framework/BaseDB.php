<?php

class BaseDB {
  
  private $connection = NULL;
  private $fetchMode  = "";
  
  public function __construct($config){
    try{
      $this->connection = new PDO("mysql:host={$config["host"]};dbname={$config["database"]};charset=utf8" ,
                        $config["username"] , $config["password"] );
      $this->fetchMode = isset($config["fetch_mode"]) ? strtoupper($config["fetch_mode"]) : "OBJECT" ;
      $this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      // Connected To Database
    }
    catch(PDOException $e){
      $this->exception($e);
    }
  }
  
  protected function query($sql,$inputs = []){
    $prepared = $this->connection->prepare($sql);
    $prepared->execute($inputs);
    return $prepared;
  }
  
  protected function select($sql,$options = []){
    $select = $this->connection->prepare($sql);
    $select->execute($options);
    if($this->fetchMode == "ARRAY"){
      $select->setFetchMode(PDO::FETCH_ASSOC);
    }
    elseif($this->fetchMode == "OBJECT"){
      $select->setFetchMode(PDO::FETCH_OBJ);
    }
    return $select->fetchAll();
  }
  
  protected function execute($sql){
    $safeSql = $this->connection->quote($sql);
    $this->connection->exec($safeSql);
    return $this->connection->rowCount();
  }
  
  private function exception($e){
    echo "<h3><code><pre>PDO Exception :\n";
    echo "  Message : {$e->getMessage()}\n";
    echo "  File : {$e->getFile()}\n";
    echo "  Line : {$e->getLine()}";
    echo "</pre></code></h3>";
  }
  
}

?>