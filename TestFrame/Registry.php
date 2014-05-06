<?php
class Registry extends ArrayObject{
	private static $_instance;

	public function  __construct($array=array(),$flags=parent::ARRAY_AS_PROPS){
		parent::__construct($array,$flags);
	}
	public function  getInstance(){
		if (!(self::$_instance instanceof  self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function set($index,&$value){
		$instance = self::$_instance;
		$instance->offsetSet($index, $value);
	}
	public function get($index){
		$instance = self::$_instance;
		if (!$instance->offsetExists($index)){
			return null;
		}else {
			return $instance->offsetGet($index);
		}
	}
}