<?php

$base_url = 'http://'.$_SERVER['SERVER_NAME']. str_ireplace('/index.php', '', $_SERVER['PHP_SELF']);

class RedirectHelper {
  public static function redirect($to, $link_name){
    $url = ($to !== NULL) && (strlen($to) > 0) ? str_replace('%27', '', $to) : "index.php";
    $shortcut = ($link_name !== NULL) && (strlen($link_name) > 0) ? link_name : "start page";
    header("301 Moved Permanently");
    header("Location: " .$url);
  }
}
