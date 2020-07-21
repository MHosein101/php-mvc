<?php
class Info extends Model {
  
	public function get(){
		return $this->db->get_list('Info');
	}
  
}
?>