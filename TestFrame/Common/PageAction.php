<?php
class PageAction{
	private $Date;//数据
	private $PageSize=20;//单页行数
	private $TotalNum;//总的条数
	private $PageSum;//总得页数
	private $DisplayMark=5;//显示多少个数字标记
	private $Handle=0;//当前页面页数
	private $URL;//URL

	function __construct($URL="/index.php",$TotalNum=20,$Handle=1,$PageSize=20,$DisplayMark=10,&$Date=NULL){
		$this->URL = $URL;//数据
		$this->TotalNum = $TotalNum;//总行数
		$this->Handle = $Handle;//页面页数
		$this->PageSize = $PageSize;//单页行数
		$this->DisplayMark = $DisplayMark;//分页显示的标记
		$this->Date = &$Date;//数据，功能暂时没实现
	}
	//分页计算处理，获得页面的显示范围
	public function PageStrProcess(){
		if ($this->Date){
			$this->PageSum = count($this->Date);
		}
		if ($this->PageSize>=$this->TotalNum){
			//如果页面行数大于总数，则无需翻页
			return array(1=>null);
		}else{
			$this->PageSum = ceil($this->TotalNum/$this->PageSize); //总页数
			if ($this->PageSum<$this->Handle){//显示无数据
				return null;
			}else {
				if ($this->PageSum>$this->DisplayMark){
					if ($this -> Handle <= ceil($this -> DisplayMark/2)){
						return array_fill(1,$this->DisplayMark,'');
					} elseif ($this->Handle>ceil($this->DisplayMark/2)&&$this->Handle<$this->PageSum-(int)floor($this->DisplayMark/2)){
						return array_fill($this->Handle-(int)ceil($this->DisplayMark/2)+1,$this->DisplayMark,'');
					} elseif ($this->Handle>=$this->PageSum-(int)floor($this->DisplayMark/2)) {
						return array_fill($this->PageSum-$this->DisplayMark+1,$this->DisplayMark,'');
					}
				}else {
					return array_fill(1,$this->PageSum,null);
				}
			}
		}
	}
	//返回分页字符串
	public function getPageStr(){
		$_PageArr = $this->PageStrProcess();
		if ($_PageArr){
			$_html = $this->Handle==1?'':('<a href="'.$this->URL.'?pn=1">首页</a><a href="'.$this->URL.'?pn='.(($this->Handle-1)).'">上一页</a>');
			foreach ($_PageArr as $_k=>$_v){
				if ($_k==$this->Handle){
					$_html .= ',<span>'.$_k.'</span>';
				}else {
					$_html .= ',<a href="'.$this->URL.'?pn='.($_k).'">'.$_k.'</a>';
				}
			}
			$_html .= ($this->Handle==$this->PageSum?'':('<a href="'.$this->URL.'?pn='.(($this->Handle+1)).'">下一页</a><a href="'.$this->URL.'?pn='.($this->PageSum).'">尾页</a>'));
		}else {
			$_html='此页无数据';
		}
		return $_html;
	}
	function __destruct(){
		unset($this->Date);
		unset($this->URL);
	}
}
?>