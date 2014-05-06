<?php
class init{
	private static $_instance;
	public function __construct(){
	}
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function  run(){
		$this->registerSubject();
		list($controller,$action,$arg)=UrlExplain::explain($_SERVER['REQUEST_URI']);
		return  (new $controler())->$action();
	}
	public function registerSubject(){
		return spl_autoload_register(array($this,'loader'));
	}

	public function loader($class){
		$filepathstrs = $this->getFileName();
		foreach ($filepathstrs as $filepathstr){
			if (is_file($filepathstr)){
				require_once($filepathstr);
			}
		}
	}
	private function getFileName(){
		if (file_exists(CORE_FILEPATHSTR)&&(time()-fileatime(CORE_FILEPATHSTR)<CACHETIME)&&RUN_MODE===0) {//������ģʽ��ֹͣ���û���
			if(!$handle = fopen(CORE_FILEPATHSTR,'r')){
				trigger_error('��Ŀ¼ȱ�ٶ�дȨ�ޣ�\n�ļ���ַ��'.CORE_FILEPATHSTR,E_USER_ERROR);
			}
			$str = fgets($handle);
			fclose($handle);
			return unserialize($str);
		}
		$arr = $this->getPhpFilePath();
		if (RUN_MODE===0) {//����ģʽ�¿���Ŀ¼�ļ�����
			if(!$handle = fopen(CORE_FILEPATHSTR, 'w')){trigger_error('��Ŀ¼ȱ�ٶ�дȨ�ޣ�\n�ļ���ַ��'.CORE_FILEPATHSTR,E_USER_ERROR);};
			if(!fwrite($handle,serialize($arr))){trigger_error('��Ŀ¼ȱ�ٶ�дȨ�ޣ�\n�ļ���ַ��'.CORE_FILEPATHSTR,E_USER_ERROR);}else{fclose($handle);};;
		}
		return $arr;
	}
	private function getPhpFilePath($dirstr=PATH_BASE){
		$arr= array();
		$handles = dir($dirstr);
		while ($file=$handles->read()){
			if ($file!=='.'&&$file!=='..'&&preg_match_all('/^.*\.php$/i', $file)) {
				$arr[]=$dirstr.'/'.$file;
			}elseif ($file!=='.'&&$file!=='..'&&is_dir($dirstr.'/'.$file)){
				$_tmp=getPhpFilePath($dirstr.'/'.$file);
				$arr = array_merge($arr,$_tmp);
			}
		}
		$handles->close();
		return $arr;
	}
	public function __clone(){
		trigger_error('�����ܸ���',E_USER_ERROR);
	}
}
?>