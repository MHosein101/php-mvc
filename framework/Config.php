<?php

// require "RoutesList.php";

class Config {
  
  /* # GLOBAL SETTINGS ------------------------ */
  
  /*
    Website Base Url
    @var String
  */
  public const BASE_URL = '';
  
  /*
    Show Errors Or Not
    @var Boolean
  */
  public const SHOW_ERRORS = TRUE;
  
  /*
    Use PHP View Custom Template Parser Or Not
    @var Boolean
  */
  public const USE_TEMPLATER = FALSE;
  
  /* # APPLICATION DATA HANDLING ------------------------ */
  
  /*
    Driver constant SQL option
    @var String
  */
  public const DRIVER_SQL = 'SQL';
  /*
    Driver constant SQL option
    @var String
  */
  public const DRIVER_JSON = 'JSON';
    
  /*
    Driver of application data : SQL or JSON
    @var String
  */
  public const DB_DRIVER = self::DRIVER_JSON;
  
  
  /*
    Json file path if DB driver is JSON
    @var String
  */
  public const JSON_FILE = 'public/data.json';
  
  /*
    Sql Admin Username if DB driver is SQL
    @var String
  */
  public const SQL_USERNAME = '';
  
  /*
    Sql Admin Password if DB driver is SQL
    @var String
  */
  public const SQL_PASSWORD = '';
  
  /*
    Sql Database Name if DB driver is SQL
    @var String
  */
  public const SQL_DATABASE = '';
  
  /* # AUTOLOADING FILES ------------------------ */
  
  /*
    List of MODEL files to autoload
    @var String Array
  */
  public const AUTOLOAD_MODELS = [
    'Info'
  ];
  
  /*
    List of HELPER files to autoload
    @var String Array
  */
  public const AUTOLOAD_HELPERS = [
    'Input' , 'Util'
  ];
  
  /*
    List of LIBRARY files to autoload
    @var String Array
  */
  public const AUTOLOAD_LIBRARIES = [
    'Jdf'
  ];
  
  /* # MIXED METHODS ------------------------ */
  
  /*
    Return mix list of all autoload files lists
    @return Key Value Array
  */
  public static function AllAutoloads(){
    return [
      'MODELS' => self::AUTOLOAD_MODELS ,
      'HELPERS' => self::AUTOLOAD_HELPERS ,
      'LIBRARIES' => self::AUTOLOAD_LIBRARIES
    ];
  }
  
  /*
    Return mix list of all SQL db options 
    @return Key Value Array
  */
  public static function SqlOptions(){
    return [
      'username'   => self::SQL_USERNAME ,
      'password'   => self::SQL_PASSWORD ,
      'database'   => self::SQL_DATABASE ,
      'host'       => 'localhost' ,
      'port'       => '3306' ,
      'fetch_mode' => 'Object' // Or Array
    ];
  }
  
}

?>