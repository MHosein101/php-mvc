<?php
/*
  @author  Hosein Marzban
  @created 1398/8/21
  @updated 1398/9/25
  @version 1.1
  -------------------------------------------------------------
  @class Open And Parse And Change The Data In Json File
  @json_schema {
    "List One" : {
      "Key One" : {
        "Any" : "Content" ,
        ...
      } ,
      {} , ...
    } ,
    "List Two" : {
      "Key Two" : {
        "Any" : "Content" ,
        ...
      } ,
      {} , ...
    }
    {} , ...
  }
  @initialize require "JsonModel.php";
              $handler = new JsonModel("path/to/data/file.json");
*/
class JsonModel {
  /*
    @var File Handler
  */
  private $file = NULL;
  /*
    @var Array Of JSON Decoded Data
  */
  private $data = NULL;
  /*
    @function Initialize The Class
    @params $file : String , Name or path of json file
    @return Object Self
  */
  public function __construct($file){
    $this->file = $file;
    $f = fopen($file,'r') or die("Could not open the file : $file");
    $this->data = json_decode(fread($f,filesize($file)),TRUE);
    fclose($f);
  }
  /*
    @function Get The List
    @params $list_name : String , Name of list to get the members
    @params $be_json   : Boolean , Function return data be json string or php object
    @return Members Of List Object
  */
  public function get_list($list_name,$be_json = FALSE){
    $newlist = [];
    foreach( $this->data[$list_name] as $k => $v ){
      $v["id"] = (int)$k;
      $newlist[] = $v;
    }
    // echo "<code><pre>" . json_encode($newlist) . "</pre></code>";
    if($be_json) return json_encode($newlist);
    else return $newlist;
  }
  /*
    @function Get The List Item
    @params $list_name : String  , Name of list to get the members
    @params $item_id   : String  , Id of list item to get the content
    @params $be_json   : Boolean , Function return data be json string or php object
    @return Single Member Of List Object
  */
  public function get_item($list_name,$item_id,$be_json = FALSE){
    // echo "<code><pre>" . json_encode($this->data[$list_name][$item_id]) . "</pre></code>";
    if($be_json) return $this->data[$list_name][(String)$item_id];
    else return json_encode($this->data[$list_name][(String)$item_id]);
  }
  /*
    @function Add New Item To List 
    @params $list_name : String , Name of list to add new member
    @params $item_data : String , String Of Json Object
    @return Nothing
  */
  public function add_item($list_name,$item_data){
    $item_data = json_decode($item_data);
    $new_item_id = count($this->data[$list_name]) + 1;
    $this->data[$list_name]["$new_item_id"] = $item_data;
    $this->save_changes();
  }
  /*
    @function Edit Item Content In List
    @params $list_name : String , Name of list to edit the member
    @params $item_id   : String , Id of list item to edit the content
    @params $item_data : String , String Of Json Object
    @return Nothing
  */
  public function edit_item($list_name,$item_id,$item_data){
    $item_data = json_decode($item_data);
    $this->data[$list_name][(String)$item_id] = $item_data;
    $this->save_changes();
  }
  /*
    @function Delete Item From List
    @params $list_name : String , Name of list to delete the member
    @params $item_id   : String , Id of list item to delete
    @return Nothing
  */
  public function delete_item($list_name,$item_id){
    $this->data[$list_name][(String)$item_id] = NULL;
    $new_list = array_filter($this->data[$list_name],function($item){
      if($item !== NULL) return TRUE;
      return FALSE;
    });
    $this->data[$list_name] = $new_list;
    $this->save_changes();
  }
  /*
    @function Save Json Data Changes To File
    @return Nothing
  */
  private function save_changes(){
    $f = fopen($this->file,'w') or die("Could not open the file : $file");
    fwrite($f,json_encode($this->data));
    fclose($f);
  }
}
?>