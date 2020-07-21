<?php
class Util {
	
	public function enable_cookie(){
		if( count($_COOKIE) > 0 ) return TRUE;
		else FALSE;
	}
  
	public function set_cookie($cookie){
		setcookie( $cookie['name'] , $cookie['value'] , time() + ( 3600 * $cookie['expire_hour'] ) );
	}
  
	public function cookie($name){
		if( isset($_COOKIE[$name]) ) return $_COOKIE[$name];
		else NULL;
	}
  
	public function unset_cookie($name){
		if( isset($_COOKIE[$name]) ) setcookie( $name , '' , time() - 3600 );
	}
	
	public function sset($key,$val){
		$_SESSION[$key] = $val;
	}
  
	public function session($key){
    if( isset($_SESSION[$key]) !== NULL ) return $_SESSION[$key];
		else return NULL;
	}
  
	public function sunset($key){
		if( isset($_SESSION[$key]) !== NULL ) unset($_SESSION[$key]); 
	}
  
	public function sclear(){
		session_destroy(); 
	}
	
	public function to_json($var){
		return json_encode($var); 
	}
  
	public function parse_json($var,$to_array = TRUE){
		return json_decode($var,$to_array); 
	}
	
	public function array_order($array , $status){
    switch($status){
      case 'ASC':        return sort($array);   break;
      case 'DESC':       return asort($array);  break;
      case 'KEY_ASC':    return ksort($array);  break;
      case 'VALUE_ASC':  return rsort($array);  break;
      case 'KEY_DESC':   return krsort($array); break;
      case 'VALUE_DESC': return arsort($array); break;
      default:           return NULL;           break;
    }
	}
	
	public function server($key){
    switch($key){
      case 'SELF':     return $_SERVER['PHP_SELF'];             break;
      case 'R_METHOD': return $_SERVER['REQUEST_METHOD'];       break;
      case 'Q_S':      return $_SERVER['QUERY_STRING'];         break;
      case 'CHARSET':  return $_SERVER['HTTP_ACCEPT_CHARSET'];  break;
      case 'HTTPS':    return $_SERVER['HTTPS'];                break;
      case 'IP':       return $_SERVER['REMOTE_ADDR'];          break;
      case 'URI':      return $_SERVER['SCRIPT_URI'];           break;
      case 'PATH':      return $_SERVER['SCRIPT_NAME'];          break;
      default:         return NULL;                             break;
    }
	}
	
	public function filter($val , $type){
    switch($type){
      case 'INT':     return ( filter_var( $val, FILTER_VALIDATE_INT )     == true ); break;
      case 'FLOAT':   return ( filter_var( $val, FILTER_VALIDATE_FLOAT )   == true ); break;
      case 'BOOLEAN': return ( filter_var( $val, FILTER_VALIDATE_BOOLEAN ) == true ); break;
      case 'EMAIL':   return ( filter_var( $val, FILTER_VALIDATE_EMAIL )   == true ); break;
      case 'URL':     return ( filter_var( $val, FILTER_VALIDATE_URL )     == true ); break;
      case 'REGEX':   return ( filter_var( $val, FILTER_VALIDATE_REGEXP )  == true ); break;
      case 'IP':      return ( filter_var( $val, FILTER_VALIDATE_IP )      == true ); break;
      default:        return NULL;                                                    break;
    }
	}
	
	public function vd($var){
		echo '<pre style="display:block;"><code>';
		var_dump($var);
		echo '</code></pre>';
	}
	
}
?>