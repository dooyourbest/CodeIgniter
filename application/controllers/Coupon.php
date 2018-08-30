<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers'.'/Common.php';
 class Coupon extends Common {
	protected $tableName = 'coupon';
	protected $field = array();

	
	protected $condition=array();
	protected $orderBy='';
	protected $groupBy='';
	protected $limit=100;

	public function test(){
	    $returnMsg=array();
	    $returnMsg['data']=$this->getMsg();
	    $returnMsg['conf']=$this->conf();
		echo json_encode($returnMsg);
	}
	public function conf(){
        return array(
            "show"=>['level','name','times','getnum'],
        );
    }
    public function addtablesql(){
        $arr=['id'=>'int12','level'=>'int12', 'privilegeid'=>'int12','goodid'=>'int12','name'=>'int12','detail'=>'varchar64','times'=>'int12','getnum'=>'int12'];
        $mainFiled='id';
        $tableName='coupon';
       echo $this->createTable($mainFiled,$tableName,$arr);
    }

    public function setAddParams($arr)
    {
        return $arr;
        if(!$this->field){
            throw new Exception('please input field');
        }
        $unsetConf = array();

        die;
        $str='"id":"358","time":"","negprecision":"0.5","negrecall":"0.99","negf1score":"0.67","negpsupport":"4931","posprecision":"0.79","posrecall":"0.05","posf1score":"0.1","pospsupport":"5069","allprecision":"0.65","allrecall":"0.51","allf1score":"0.38","allpsupport":"10000","num":"100000","auc":"0.631315","name":"","type":"newpaizifeature.txt.1","zhengPersent":"0.5","note":"","filename":"logistic-regression.model","accuracy":"0.5774","threshold":"0.7"';
        $str=explode(',',$str);

        $returnMsg=array();
        foreach ($this->field as $key=>$row){
            if(in_array($row,$unsetConf)){
                continue;
            }
            $arr=explode(':',$str[$key]);
            $returnMsg[$row]=isset($arr[1])?$this->change($arr[1]):0;
        }
       return $returnMsg;
    }
    function change($num){
	    $num=trim($num,'"');
	    if(is_float($num)){
	        return float($num);
        }
        return $num;
    }
    function index(){
        $this->load->view('model.html');
    }
    function addall(){
        $allstr='';
        $arr=json_decode($allstr,true);
        foreach ($arr as $row){
            unset($row['id']);
            $this->insetMsg($row);
        }
    }

 }
