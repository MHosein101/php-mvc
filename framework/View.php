<?php

class View {
  
  static function render($file,$vars = []){
    $vf = VIEWS . $file . ".php";
    if( file_exists($vf) ){
      extract($vars);
      if( Config::USE_TEMPLATER ){
        $output = Templater::parse($vf);
        eval("?> $output <?php");
      }
      else{
        require $vf;
      }
    }
    else{
      echo "404 , View File <b>$file</b> Does Not Exists";
    }
  }
      
  
}

?>