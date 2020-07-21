<?php

class Templater {
  
  public static function parse($viewfile){
    
    $output = file_get_contents($viewfile);
    
    $output = str_replace("{%","<?php",$output);
    $output = str_replace("%}","?>",$output);
    
    $output = str_replace("{{","<?=",$output);
    $output = str_replace("}}","?>",$output);
    
    $output = str_replace("{?",'<?php echo "<pre><code>"; var_dump(',$output);
    $output = str_replace("?}",'); echo "</code></pre>" ?>',$output);
    
    $output = str_replace("@if","<?php if",$output);
    $output = str_replace("@elseif","<?php elseif",$output);
    $output = str_replace("@else","<?php else: ?>",$output);
    $output = str_replace("@endif","<?php endif; ?>",$output);
    
    $output = str_replace("@each","<?php foreach",$output);
    $output = str_replace("@endeach","<?php endforeach; ?>",$output);
    
    $output = str_replace(")::","): ?>",$output);
    
    return $output;
  }
  
}

?>