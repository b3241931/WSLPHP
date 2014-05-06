<?php
class UrlExplain{
	private $request_url;
	private $controller;
	private $action;
	private $args;
	public function __construct($request_url){
		$this->request_url=$request_url;
	}
	public static  function explain(){

		if (isset($_SERVER['PATH_INFO'])&&!empty($_SERVER['PATH_INFO'])) {
			/*****
			url 格式/Controllor/action
			***/
		 	$pathinfo = explode('/', $_SERVER['PATH_INFO']);
		 	$controller = $pathinfo[1];
		 	$action = $pathinfo[2];
		 	if (count($pathinfo)>3) {
		 		$count =count($pathinfo);
				for ($c=3;$c<=$count;$c++){
					if ($c%2===0) {
						$arg[$pathinfo[$c]]=(isset($pathinfo[$c+1])?$pathinfo[$c+1]:'');
					}
				}
		 	}
		 	$this->controller = (isset($controller)?$controller:'index');
		 	$this->action = (isset($action)&&!empty($action)?$action:'index');
		}else {
			if (!empty($_GET(CONTROLLER))&&!empty($_GET(ACTION))) {
				$this->controller = $_GET(CONTROLLER);
				$this->action = $_GET(ACTION);
			}else {
				trigger_error('没有此控制器',E_USER_ERROR);
			}
		}
		if (class_exists($this->getcontroller())){
			return array('controller'=>$this->getcontroller(),'action'=>$this->action,$arg);
		}else {
			trigger_error('没有此控制器',E_USER_ERROR);
		}
	}
	private function getcontroller(){
       return $this->controller.'Controller';
	}
	private function getaction(){
		return $this->action.'Action';
	}
}