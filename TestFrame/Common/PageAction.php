<?php
class PageAction{
	private $Date;//����
	private $PageSize=20;//��ҳ����
	private $TotalNum;//�ܵ�����
	private $PageSum;//�ܵ�ҳ��
	private $DisplayMark=5;//��ʾ���ٸ����ֱ��
	private $Handle=0;//��ǰҳ��ҳ��
	private $URL;//URL

	function __construct($URL="/index.php",$TotalNum=20,$Handle=1,$PageSize=20,$DisplayMark=10,&$Date=NULL){
		$this->URL = $URL;//����
		$this->TotalNum = $TotalNum;//������
		$this->Handle = $Handle;//ҳ��ҳ��
		$this->PageSize = $PageSize;//��ҳ����
		$this->DisplayMark = $DisplayMark;//��ҳ��ʾ�ı��
		$this->Date = &$Date;//���ݣ�������ʱûʵ��
	}
	//��ҳ���㴦�����ҳ�����ʾ��Χ
	public function PageStrProcess(){
		if ($this->Date){
			$this->PageSum = count($this->Date);
		}
		if ($this->PageSize>=$this->TotalNum){
			//���ҳ���������������������跭ҳ
			return array(1=>null);
		}else{
			$this->PageSum = ceil($this->TotalNum/$this->PageSize); //��ҳ��
			if ($this->PageSum<$this->Handle){//��ʾ������
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
	//���ط�ҳ�ַ���
	public function getPageStr(){
		$_PageArr = $this->PageStrProcess();
		if ($_PageArr){
			$_html = $this->Handle==1?'':('<a href="'.$this->URL.'?pn=1">��ҳ</a><a href="'.$this->URL.'?pn='.(($this->Handle-1)).'">��һҳ</a>');
			foreach ($_PageArr as $_k=>$_v){
				if ($_k==$this->Handle){
					$_html .= ',<span>'.$_k.'</span>';
				}else {
					$_html .= ',<a href="'.$this->URL.'?pn='.($_k).'">'.$_k.'</a>';
				}
			}
			$_html .= ($this->Handle==$this->PageSum?'':('<a href="'.$this->URL.'?pn='.(($this->Handle+1)).'">��һҳ</a><a href="'.$this->URL.'?pn='.($this->PageSum).'">βҳ</a>'));
		}else {
			$_html='��ҳ������';
		}
		return $_html;
	}
	function __destruct(){
		unset($this->Date);
		unset($this->URL);
	}
}
?>