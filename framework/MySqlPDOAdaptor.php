<?php

class MySqlPDOAdaptor extends BaseDB {
  
  private $dbc = NULL;
  public $vtc = NULL;
  
  private $table = "";
  private $columns = "";
  private $statement_name = "";
  private $where = "";
  private $distinct = "";
  private $paginate = "";
  private $order = "";
  private $prepared_params = [];
  
  public function __construct($config){
    parent::__construct($config);
    $this->vtc = Loader::helper("VTC");
  }
  
	public function save($data = NULL){
    $q = "";
    $r = NULL;
    switch( $this->statement_name ){
      case "INSERT":
        $q = "INSERT INTO " . $this->table . " ( ";
        foreach($data as $k => $v) $q .= " $k ,";
        $q = rtrim($q,",") . ") VALUES ( ";
        foreach($data as $k => $v) $q .= " :i_$k ,";
        $q = rtrim($q,",") . " );";
        $r = $this->query($q,$this->prepared_params);
      break;
      case "UPDATE":
        $q = "UPDATE " . $this->table . " SET ";
        foreach($data as $k => $v) $q .= " $k = :u_$k ,";
        $q = rtrim($q,",") . " WHERE " . $this->where . ";";
        $r = $this->query($q,$this->prepared_params);
      break;
      case "DELETE":
        $q = "DELETE FROM " . $this->table;
        $q .= " WHERE " . $this->where . ";";
        $r = $this->query($q,$this->prepared_params);
      break;
      case "SELECT":
        $q = "SELECT " . $this->distinct . $this->columns . " FROM " . $this->table;
        if($this->where != "") $q .= " WHERE " . $this->where;
        if($this->order != "") $q .= " ORDER BY " . $this->order;
        if($this->paginate != "") $q .=  $this->paginate;
        $r = $this->select($q,$this->prepared_params);
      break;
    }
    $this->table = "";
    $this->columns = "";
    $this->statement_name = "";
    $this->where = "";
    $this->paginate = "";
    $this->order = "";
    $this->prepared_params = [];
    return $r;
	}
  
	public function table($t){
    $this->table = $t;
		return $this;
	}
  
	public function distinct(){
    $this->distinct = "DISTINCT ";
		return $this;
	}
  
	public function insert($data){
    $this->statement_name = "INSERT";
    foreach($data as $k => $v) $this->prepared_params[":i_$k"] = $v;
    $this->save($data);
		return $this;
	}
  
	public function update($data){
    $this->statement_name = "UPDATE";
    foreach($data as $k => $v){
      $this->prepared_params[":u_$k"] = $v;
    }
    $this->save($data);
		return $this;
	}
  
	public function delete(){
    $this->statement_name = "DELETE";
    $this->save();
		return $this;
	}
  
	public function get($columns = ""){
    $this->statement_name = "SELECT";
    if($columns != "") $this->columns = "($columns)";
    else $this->columns = "*";
		return $this->save();
	}
  
	public function where($option1,$option2 = NULL){
    if( $this->vtc->stringKeyArray($option1) ){
      foreach($option1 as $k => $v){
        $this->prepared_params[":w_$k"] = $v;
        if( $this->where == "" ){
          $this->where =  $k . "= :w_" . $k;
        }
        else{
          $this->where .= " AND " . $k . "= :w_" . $k;
        }
      }
    }
    elseif( $this->vtc->isStr($option1) ){
      if( $this->vtc->isStr($option2) ){
        $this->prepared_params[":w_$option1"] = $option2;
        if( $this->where == "" ){
          $this->where =  $option1 . "= :w_" . $option1;
        }
        else{
          $this->where .= " AND " . $option1 . "= :w_" . $option1;
        }
      }
    }
    elseif( $this->vtc->isInt($option1) ){
      $this->prepared_params[":w_id"] = $option1;
      if( $this->where == "" ){
        $this->where = " id = :w_id";
      }
      else{
        $this->where .= " AND id = :w_id";
      }
    }
		return $this;
	}
  
	public function orWhere($option1,$option2 = NULL){
    if( $this->vtc->stringKeyArray($option1) ){
      foreach($option1 as $k => $v){
        $this->prepared_params[":w_$k"] = $v;
        if( $this->where == "" ){
          $this->where = " WHERE " . $k . "= :w_" . $k;
        }
        else{
          $this->where .= " OR " . $k . "= :w_" . $k;
        }
      }
    }
    elseif( $this->vtc->isStr($option1) ){
      if( $this->vtc->isStr($option2) ){
        $this->prepared_params[":w_$option1"] = $option2;
        if( $this->where == "" ){
          $this->where =  $option1 . "= :w_" . $option1;
        }
        else{
          $this->where .= " OR " . $option1 . "= :w_" . $option1;
        }
      }
    }
    elseif( $this->vtc->isInt($option1) ){
      $this->prepared_params[":w_id"] = $option1;
      if( $this->where == "" ){
        $this->where = " id = :w_id";
      }
      else{
        $this->where .= " OR id = :w_id";
      }
    }
		return $this;
	}
  
	public function paginate($limit = 5,$offset = 0){
    if( $this->vtc->isInt($limit) && $this->vtc->isInt($offset) ){
      $this->paginate = " LIMIT $limit OFFSET $offset ";
    }
		return $this;
	}
  
	public function order($opt1 = "ASC",$opt2 = "ASC"){
    if( $this->vtc->isStr($opt1) && $this->vtc->isStr($opt2) ){
      if( $opt1 == "DESC" || $opt1 == "ASC" ){
        $this->order .= " id $opt1 ";
      }
      else{
        if( $opt2 == "DESC" || $opt2 == "ASC" ){
          $this->order .= " $opt1 $opt2 ";
        }
      }
    }
		return $this;
	}
  
	public function like($option1,$option2){
    $this->prepared_params[":wl_$option1"] = $option2;
    if( $this->where == "" ){
      $this->where =  " $option1 LIKE :wl_" . $option1;
    }
    else{
      $this->where .= " AND $option1 LIKE :wl_" . $option1;
    }
		return $this;
	}
  
	public function notLike($option1,$option2){
    $this->prepared_params[":wl_$option1"] = $option2;
    if( $this->where == "" ){
      $this->where =  " $option1 NOT LIKE :wl_" . $option1;
    }
    else{
      $this->where .= " AND $option1 NOT LIKE :wl_" . $option1;
    }
		return $this;
	}
  
	public function orLike($option1,$option2){
    $this->prepared_params[":wl_$option1"] = $option2;
    if( $this->where == "" ){
      $this->where =  " $option1 LIKE :wl_" . $option1;
    }
    else{
      $this->where .= " OR $option1 LIKE :wl_" . $option1;
    }
		return $this;
	}
  
	public function orNotLike($option1,$option2){
    $this->prepared_params[":wl_$option1"] = $option2;
    if( $this->where == "" ){
      $this->where =  " $option1 NOT LIKE :wl_" . $option1;
    }
    else{
      $this->where .= " OR $option1 NOT LIKE :wl_" . $option1;
    }
		return $this;
	}
  
	public function one($opt1,$opt2 = NULL){
    if( $this->vtc->isInt($opt1) ){
      return $this->where($opt1)->get();
    }
    elseif( $this->vtc->isStr($opt1) && $this->vtc->isStr($opt2) ){
      return $this->where($opt1,$opt2)->get();
    }
	}
  
	public function first(){
    return $this->order("ASC")->paginate(1)->get()[0];
	}
  
	public function last(){
    return $this->order("DESC")->paginate(1)->get()[0];
	}
  
	public function lastId(){
    return (int)$this->order("DESC")->paginate(1)->get()[0]->id;
	}
  
	public function count(){
    return count($this->get("id"));
	}
  
	public function inc($column,$n = 1){
    if( $this->vtc->isInt($n) && ( $n > 0 && $n < 11 ) ){
      $q = "UPDATE " . $this->table . " SET $column = $column + $n WHERE " .$this->where;
      $this->query($q,$this->prepared_params);
    }
    return $this;
	}
  
	public function dec($column,$n = 1){
    if( $this->vtc->isInt($n) && ( $n > 0 && $n < 11 ) ){
      $q = "UPDATE " . $this->table . " SET $column = $column - $n WHERE " . $this->where;
      $this->query($q,$this->prepared_params);
    }
    return $this;
	}
  
	public function q($sql){
    $this->query($sql,[]);
    return $this;
	}
  
	public function s($sql){
    return $this->select($sql,[]);
	}
  
}

?>