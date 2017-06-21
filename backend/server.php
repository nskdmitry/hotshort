<?php

include_once 'RedirectHelper.php';
include_once 'LinkStorage.php';

LinkStorage::loadAll();
  
$params = ["full" => strip_tags($_REQUEST["full"]),
           "shortcut" => strip_tags($_REQUEST["url"]),
           "link" => FALSE];

$base_url = 'http://'.$_SERVER['SERVER_NAME']. str_ireplace(['/index.php', '/backend/server.php'], '', $_SERVER['PHP_SELF']);
  
if ($params["shortcut"] != ''){
  $params["link"] = TRUE;
  $params["full"] = LinkStorage::getURL($params['shortcut']);
  RedirectHelper::redirect($params["full"], $params["shotcut"]);
} else if ($params["full"] != NULL){
  $params["shortcut"] = $base_url.'/'.LinkStorage::add($params["full"]);
}
LinkStorage::updateAll();

header('Content-type: application/json; charset=utf-8');
echo json_encode($params);