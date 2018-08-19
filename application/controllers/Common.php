<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class Common extends CI_Controller {
	protected $tableName = '';
	protected $field =array();

	
	protected $condition=array();
	protected $orderBy=' order by name desc';
	protected $groupBy='';
	protected $limt=100;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function set($key ,$val=null){
		if(isset($val)){
			return false;
		}
		$this->$key = $val;
	}	
	public function get($key){
		if(!isset($val)){
			return false;
		}
		return $this->$key;
	}
	public function createTable($mainFiled,$tableName,$arr){
		$this->set('mainFiled',$mainFiled);
		$sql="CREATE TABLE `$tableName` (";
		foreach($arr as $key=>$val){
			$sql.=$this->returnType($key,$val).',';
		}
		$sql.="PRIMARY KEY (`{$mainFiled}`)";
		$sql.=") ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8 COMMENT='TP表'";
		echo $sql;
	}
	
	public function returnType($filedName,$type,$isAutoIncrease=false,$comment=false,$deafault=true){
		try{
			$mainFiled=$this->get('mainFiled');
		}catch(Exception $e){
			throw new Exception('no set main key');
		}
		$conf=array(
			'int12'=> "`$filedName`"." int(12) NOT NULL DEFAULT '0'",
			'int64'=> "`$filedName`"." bigint(21) NOT NULL DEFAULT '0'",
			'float'=> "`$filedName`"." float(10) NOT NULL DEFAULT '0'",
			'vachar32'=> "`$filedName`"." int(32) NOT NULL DEFAULT ''",
			'vachar64'=> "`$filedName`"." int(64) NOT NULL DEFAULT ''",
			'vachar128'=> "`$filedName`"." int(128) NOT NULL DEFAULT ''",
			'vachar256'=> "`$filedName`"." int(256) NOT NULL DEFAULT ''",
			'decimal10'=> "`$filedName`"." decimal(10) NOT NULL DEFAULT '0'",
		);
		$msg=$conf[$type];
		echo $mainFiled;
		echo 1;
		echo $filedName;
		if($mainFiled==$filedName){
			$msg.=' AUTO_INCREMENT';
		}
		if($comment){
			$msg=$msg+' COMMENT'+"'{$comment}'";
		}
		return $msg;
			
	}
	
	public function index(){
		echo 123;
		$res=$this->getMsg(array('id','name'),array('id'=>'>10','name'=>'>1'));
		print_r($res);
	}
	public function select(){
		
		$sql='SELECT ';
		if(!empty($this->field)){
			foreach($this->field as $row){
				$sql.=$row.',';
			}
		}else{
			$sql.='*,';//注意下面的-1兼容
		}

		$sql=substr($sql,0,-1);

		$tableName=$this->tableName;
		if($tableName){
			$sql.=' FROM '.$tableName.' ';
		}else{
			throw new Exception('please set table name');
		}
		if($this->condition){
			$sql.=' WHERE ';
			foreach($this->condition as $key =>$val){
				$sql.="(".$key.' '.$val.') AND';
			}
			$sql = substr($sql,0,-3);

		}
        $sql.=$this->orderBy?$this->orderBy:' ';
        $sql.=$this->groupBy?$this->groupBy:' ';
		$sql.=$this->limit?' LIMIT '.$this->limit:' ';
		return $sql.';';
	}
	public function query($sql){                   
		$this->db->query($sql);
	}
	protected function getMsg($field=null,$condition=null){
		$this->set('tableName','model');
		if(isset($field)){$this->field=$field;}
		if(isset($condition)){$this->field=$field;}
		$sql=$this->select($field,$condition);
		$resArr=$this->db->query($sql);
		return $resArr->result_array();
	}
	//利用框架写插入
     function insetMsg($data=null){
    if(!$data){
        $msg=$this->setAddParams();
    }else{
        $msg=$data;
    }
     if(!$msg){
         throw new Exception('please input your data');
     }
	    $res=$this->db->insert($this->tableName,$msg);
     }

}
