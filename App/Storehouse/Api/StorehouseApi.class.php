<?php

/**==============库存API中心================**/




namespace Storehouse\Api;
use Storehouse\Api\Api;


class StorehouseApi extends Api{


	//初始化（构造函数的一部分）
	//实例化用户模型
	function _init(){
		$this->model=D('Goodslist');	
	}


	/**
	 * 获取仓库列表
	 * @param   $data  搜索条件
	 * return array 二维数组
	 */ 
	//获取仓库数据列表
	public function getGoodList(){
		$count = $this->model->count();// 查询满足要求的总记录数
	    $Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	    $result['page'] = $Page->show();// 分页显示输出
	    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	    $result['datalist'] = $this->model->limit($Page->firstRow.','.$Page->listRows)->select();
		return $result;
	}


	/**
	 * 修改仓库数据信息
	 * @param   $gl_id  搜索条件
	 * return array 一维数组
	 */ 
	//修改仓库数据信息
	public function editGoodLIstUi($gl_id){
		$result=$this->model->where("gl_id='%d'",$gl_id)->find();
		return $result;
	}

	/**
	 * 修改仓库信息
	 * @param   $data 搜索条件
	 * return TRUE(success) or FALSE
	 */ 
	//修改仓库信息
	public function modifyGoodSingle($data){
		$gl_id=$data['gl_id'];
		$result=$this->model->where("gl_id=%d",intval($gl_id))->data($data)->save();
		if($result){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * 修改仓库信息
	 * return array 二维数组
	 */ 
	//获取货物类型
	public function getGoodType(){
		$this->model=null;
		$this->model1=D('Goodskind');
		$result=$this->model1->select();
		return $result;
	}

	/**
	*修改货物类型类型
	*查询条件$gk_id
	*return array 一维数组
	*/
	//修改货物类型类型
	public function modifyGoodType($gk_id){
		$this->model=null;
		$this->model1=D('Goodskind');
		$result=$this->model1->where("gk_id='%d'",$gk_id)->find();
		return $result;
	}

	/**
	*添加货物类型名称
	*查询条件$data
	*return 1,2,3
	*1表示该类型已有，2表示添加成功，3表示添加失败
	*/
	//添加货物类型名称
	public function addGoodKind($data){
		$result=0;
		$this->model=null;
		$this->model1=D('Goodskind');
		$find=$this->model1->where("gk_name='%s'",$data)->find();
		if(!empty($find)){
			$result=1;
		}else{
			$gk_id='';
			$result=$this->model1->where("gk_id=%d",intval($gk_id))->data($data)->add();
			if($result){
				$result=2;
			}else{
				$result=3;
			}
		}
		return $result;
	}

	/***
	*货物货物类型名称，用在添加库存上
	*return array 二维数组
	*/
	//货物货物类型名称，用在添加库存上
	public function getGoodTypeBy(){
		$this->model=null;
		$this->model1=D("Goodskind");
		$result=$this->model1->select();
		return $result;
	}
	/***
	*修改货物类型名称
	*$data 查询条件
	*return true or false
	*/
	//修改货物类型名称
	public function GoodKindSingleEdit($data){
		$this->model=null;
		$this->model1=D("Goodskind");
		$gk_id=$data['gk_id'];
		$result=$this->model1->where("gk_id=%d ",intval($gk_id))->data($data)->save();
		return $result;
	}

	/***
	*修改货物类型名称
	*$data 查询条件
	*return true or false
	*/
	//添加库存
	public function addGoodSingle($data){
		$gl_id='';
		$result=$this->model->where("gl_id=%d",intval($gl_id))->data($data)->add();
		return $result;
	}

























}



