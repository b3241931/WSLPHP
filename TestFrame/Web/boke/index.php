<?php
define("PATH_BASE",dirname(__FILE__));
define("CORE_FILEPATHSTR",PATH_BASE.'/filepaths.dat');//�����ļ�·��
define('RUN_MODE', 1);//1Ϊ������ģʽ��0Ϊ����ģʽ��������ģʽ��ͣ��һ�л���
define('CACHETIME', 24*3600);//ϵͳ����ʱ�䣬����Ϊ��λ
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