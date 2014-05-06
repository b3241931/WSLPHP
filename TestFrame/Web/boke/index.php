<?php
define("PATH_BASE",dirname(__FILE__));
define("CORE_FILEPATHSTR",PATH_BASE.'/filepaths.dat');//核心文件路径
define('RUN_MODE', 1);//1为开发者模式，0为服务模式，开发者模式下停用一切缓存
define('CACHETIME', 24*3600);//系统缓存时间，以秒为单位
define('CONTROLLER','_c');
define('ACTION','_a');
error_reporting(E_ALL);
require_once("../../init.php");
$i = init::getInstance();
try {
	$i->run();
}catch (Exception $e){
	$e->getMessage();
}
echo $i->getBody();
?>