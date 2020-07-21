<?php

class Problem {
  
  public static function Error($level, $message, $file, $line){
    if (error_reporting() !== 0) {  // to keep the @ operator working
      if( Config::SHOW_ERRORS ){
        // throw new \ErrorException($message, 0, $level, $file, $line);
        echo "
        <code style='display:block;border:1px solid black;margin:10px;padding:10px;font-size:1.2em;'>
          <div style=''><b> Error Happened : </b></div>
          <div style=''>Message : <b> $message </b></div>
          <div style=''>Thrown In File <b> $file </b></div>
          <div style=''>Line : <b> $line </b></div>
        </code>
        ";
      }
      else{
        $msg = PHP_EOL . PHP_EOL . " Error Happened : " . PHP_EOL . PHP_EOL;
        $msg .= "Message = $message " . PHP_EOL . PHP_EOL;
        $msg .= "File = [ $file ] " . PHP_EOL . PHP_EOL;
        $msg .= "Line = [ $line ] " . PHP_EOL . PHP_EOL;
        error_log($msg);
        View::render("errors/error.php");
      }
    }
  }
  
  public static function Exception($exception){
    $code = $exception->getCode();
    if ($code != 404) {
      $code = 500;
    }
    http_response_code($code);
    if( Config::SHOW_ERRORS ){
      echo "
      <code style='display:block;border:1px solid black;margin:10px;padding:10px;font-size:1.2em;'>
        <div style=''><b>" . get_class($exception) . "</b> Exception</div>
        <div style=''>Message : <b>" . $exception->getMessage() . "</b></div>
        <div style=''>Thrown In File <b>" . $exception->getFile() . "</b></div>
        <div style=''>Line : <b>" . $exception->getLine() . "</b></div>
      </code>
      ";
    }
    else{
      $msg = PHP_EOL . PHP_EOL . "'" . get_class($exception) . "' Exception " . PHP_EOL . PHP_EOL;
      $msg .= "Message = " . $exception->getMessage() . " " . PHP_EOL . PHP_EOL;
      $msg .= "File [ " . $exception->getFile() . " ] " . PHP_EOL . PHP_EOL;
      $msg .= "Line [ " . $exception->getLine() . " ] " . PHP_EOL . PHP_EOL;
      error_log($msg);
      View::render("errors/$code.php");
    }
  }
  
}

?>