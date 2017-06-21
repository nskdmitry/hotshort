<?php

class LinkStorage {
  public static function loadAll() {
    self::$data = json_decode(file_get_contents("shorts.json"), TRUE);
  }

  public static function updateAll() {
    file_put_contents("shorts.json", json_encode(self::$data));
  }
  
  public static function getHash($url){
    return array_search($url, self::$data);
  }
  
  public static function getURL($hash) {
    return isset(self::$data[$hash]) ? self::$data[$hash] : FALSE;
  }

  public static function add($url) {
    if ( ($key = array_search($url, self::$data)) !== FALSE ) {
      return $key;
    }
    
    $digest = self::hash($url);
    $variability = str_split($digest, 5);
    
    //print_r(self::$data);
    $signed = $digest;
    foreach ($variability as $hash) {
      $found = array_key_exists($hash, self::$data);
      if ($found) {
        break;
      }
      $signed = $hash;
    }
    
    self::$data[$signed] = $url;
    return $digest;
  }

  public static function info() {
    print_r(self::$data);
  }
  
  protected static function hash($url) {
    return sha1($url);
  }
  
  private static $data;
}
