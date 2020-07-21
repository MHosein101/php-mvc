<?php

function redirect($url,$code = 302){
  $url = trim($url,'/');
  if( substr($url,0,4) == 'http' || substr($url,0,4) == 'www.' ){
    header("Location:http://$url",true,$code);
  }
  elseif( !strpos($url,'/') && strpos($url,'.') ){
    header("Location:http://$url",true,$code);
  }
  else{
    if($url == '') header("Location:" . baseUrl(),true,$code);
    else {
      $url = baseUrl() . '/?' . $url;
      header("Location:$url",true,$code);
    }
  }
  die();
}


function httpCode($code = 0){
  if($code == 0){
    return http_response_code();
  }
  else{
    http_response_code($code);
    return http_response_code();
  } 
}

function httpHeaders(){
  return headers_list();
}

function view($file,$vars = []){
  View::render($file,$vars);
}

function model($file){
  Loader::model($file);
}

function helper($file,$args = []){
  Loader::helper($file,$args);
}

function library($file,$args = []){
  Loader::library($file,$args);
}

function download($file,$type){
  $file = baseurl() . '/' . trim($file,'/');
  header("Content-Type: $type");
  header("Content-Disposition: attachment; filename=$file");
  readfile("$file");
  exit();
}

function url($url = ''){
  $url = trim($url,'/');
  return baseurl() . '/' . $url ;
}

function baseUrl(){
  if( Config::BASE_URL != '' ){
    return protocol() . '://' . Config::BASE_URL;
  }
  else{
    return protocol() . '://' . $_SERVER['HTTP_HOST'];
  }
}

function protocol(){
  if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ){
    return 'https';
  }
  return 'http';
}

?>