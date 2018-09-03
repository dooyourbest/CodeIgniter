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
    //展示设置
	public function conf(){
        return array(
            "show"=>array(
                'level'=>array('data','int'),
                'name'=>array('label','string'),
                'times'=>array('data','int'),
                'getnum'=>array('data','int')
            ),
            "x_line"=>'level',
        );   
    }
    //增加新表
    public function addtablesql(){
        $arr=['level'=>'int12', 'privilegeid'=>'int12','goodid'=>'int12','name'=>'int12','detail'=>'varchar64','times'=>'int12','getnum'=>'int12'];
        $mainFiled='id';
        $tableName='coupon';
        echo $this->createTable($mainFiled,$tableName,$arr);
    }
    //增加数据
    function addall(){
        $allstr='';
        $arr=json_decode($allstr,true);
        foreach ($arr as $row){
            unset($row['id']);
            $this->insetMsg($row);
        }
    }
    public function test(){
	    $returnMsg=array();
	    $returnMsg['data']=$this->getMsg();
	    $returnMsg['conf']=$this->conf();
		echo json_encode($returnMsg);
	}
 }
