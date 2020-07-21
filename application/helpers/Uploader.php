<?php

class Uploader {
  
  /*
    Path To Upload The File In
    @var String
  */
  private const PATH = './';
  
  /*
    New Name Of File If We Want To Renamethe File
    Empty String Means We Do Not Want To Rename The file
    @var String
  */
  private const NAME = '';
  
  /*
    Replace Uploaded File If Exists Before
    @var Boolean
  */
  private const REPLACE = FALSE;
  
  /*
    [ Not Working Yet ]
    Make The Path Folder If Not Exists
    @var Boolean
  */
  private const MAKE_PATH = FALSE;
  
  /*
    List Of Allowed File Extensions
    Splited By | Character
    Note : You Can Use * Character To
    allow All Extensions
    @var String
  */
  private const EXTENSIONS = '*';
  
  /*
    Max Value Of File size In KB
    @var Integer
  */
  private const MAX_SIZE  = 500;
  
  /*
    Images Width And Height Values
    Note : If You Set Width Or Height Or Both They Have
    More Priority The The Max And Min Sizes
    @var Integer
  */
  private const MAX_WIDTH  = 100000;
  private const MAX_HEIGHT = 100000;
  private const MIN_WIDTH  = 0;
  private const MIN_HEIGHT = 0;
  
  /*
    @function  Upload File With Given Configurations
    @param $file String , File Name That Sent With Post Method
    @param $config Array , Configuration Of What To Do With File
    @return True , Upload OK
    @return -1   , No Input File With Given Key
    @return 1    , Size Error
    @return 2    , Extension Error
    @return 3    , Image Resulotion Error
    @return 4    , Path Not Exists
    @return 5    , File Exists
  */
  public function do($file,$config = []){
    $config = $this->set_config($config);
    if( isset($_FILES[$file]) ){
      $f = $_FILES[$file];
      if( (int)($f['size'] / 1000) > $config['maxsize'] ) return 1;
      if( $config['extensions'] != '*' ){
        $exts = explode('|',$config['extensions']);
        $i = 0;
        $fe = pathinfo($f['name'],PATHINFO_EXTENSION);
        foreach($exts as $e) if($e == $fe) $i = 1;
        if($i == 0) return 2;
      }
      $img = getimagesize($f["tmp_name"]);
      if($img != FALSE){
        if( $config['max_width']  < $img[0] ||
            $config['max_height'] < $img[1] ||
            $config['min_width']  > $img[0] ||
            $config['min_height'] > $img[1] ) return 3;
        if( isset($config['width']) && $config['width'] != $img[0] ) return 3;
        if( isset($config['height']) && $config['height'] != $img[1] ) return 3;
      }
      if( file_exists($config['path']) ){
        $config['path'] = rtrim($config['path'],'/');
        $config['path'] = rtrim($config['path'],'\\');
        $config['path'] = str_replace('/',DIRECTORY_SEPARATOR,$config['path']);
        $filename = $f['name'];
        if( $config['name'] != '' ){
          $filename = $config['name'] . '.' . pathinfo($f['name'],PATHINFO_EXTENSION);
        }
        $finishupload = $config['path'] . '/' . $filename;
        if( file_exists($finishupload) ){
          if( $config['replace'] == TRUE ) unlink($finishupload);
          else return 5;
        }
        move_uploaded_file($f["tmp_name"],$finishupload);
        return TRUE;
      }
      else return 4;
    }
    else return -1;
  }

  
  /*
    @function Set Defaults And Remake The Configurations
    @param $c Array , Configuration Of What To Do With File
    @access private
    @return Array
  */
  private function set_config($c){
    $newconfig = [
        'maxsize'    => ( isset($c['maxsize']) )    ? $c['maxsize']    : self::MAX_SIZE ,
        'extensions' => ( isset($c['extensions']) ) ? $c['extensions'] : self::EXTENSIONS ,
        'path'       => ( isset($c['path']) )       ? $c['path']       : self::PATH ,
        'makepath'   => ( isset($c['makepath']) )   ? $c['makepath']   : self::MAKE_PATH ,
        'name'       => ( isset($c['name']) )       ? $c['name']       : self::NAME ,
        'replace'    => ( isset($c['replace']) )    ? $c['replace']    : self::REPLACE ,
        'max_width'  => ( isset($c['max_width']) )  ? $c['max_width']  : self::MAX_WIDTH ,
        'max_height' => ( isset($c['max_height']) ) ? $c['max_height'] : self::MAX_HEIGHT ,
        'min_width'  => ( isset($c['min_width']) )  ? $c['min_width']  : self::MIN_WIDTH ,
        'min_height' => ( isset($c['min_height']) ) ? $c['min_height'] : self::MIN_HEIGHT ,
    ];
    if( isset($c['width'])  ) $newconfig['width']  = $c['width'];
    if( isset($c['height']) ) $newconfig['height'] = $c['height'];
    return $newconfig;
  }
  
}

?>