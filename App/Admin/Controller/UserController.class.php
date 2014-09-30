<?php
/**
 * 员工管理控制器
 * 处理基本的员工操作
 */


namespace Admin\Controller;
use Think\Controller;
use User\Api\UserApi;

class UserController extends AdminController{

	private $userapi=null;
	public function _initialize(){
		parent::_initialize();
		$this->userapi=new UserApi();
	}
	public function index(){

	}
	//获取所有员工
	public function userList(){
		$result=$this->userapi->getUserList();
		if(empty($result)){
			$this->error("没有相关记录！");
		}else{
			$this->assign('list',$result);
			$this->display('userlist');
		}

	}
	//获取某个员工详细信息
	public function userDetail(){
		$uid=I('get.uid');
		if(empty($uid)){
			$this->error("没有相关记录");
		}else{
			$result=$this->userapi->getUserDetail($uid);
			$this->assign('result',$result);
			$this->display('userdetail');
		}

	}
	//修改员工信息，信息显示在员工页面
	public function userEdit(){
		$uid=I('get.uid');
		if(empty($uid)){
			$this->error("没有相关记录！");
		}else{
		$result=$this->userapi->getUserEdit($uid);
		$this->assign('result',$result);
		$this->display('useredit');
		}
	}
	//修改员工信息
	public function userModify(){

		$m_id=I('post.m_id');
		$m_name=I('post.m_name');
		$m_gender=I('post.m_gender');
		$m_price=I('post.m_price');
		$m_phone=I('post.m_phone');
		$m_idcard=I('post.m_idcard');
		$m_address=I('post.m_address');
		$m_remark=I('post.m_remark');
		if(empty($m_id)||empty($m_name)||empty($m_price)){
			$this->error("员工姓名或员工薪酬不能为空！");
		}else{
			$result=$this->userapi->userModify($m_id,$m_name,$m_price,$m_gender,$m_phone,$m_idcard,$m_address,$m_remark);
			if($result==true){
				$this->error("修改成功！修改失败!请检查相关原因！");
			}else{
				$this->error("修改失败!请检查相关原因！");
			}
		}
	}
	//删除员工信息
	public function userDelete(){
		$m_id=I('get.uid');
		if(empty($m_id)){
			$this->error("没有相关记录！");
		}else{
			$result=$this->userapi->userDelete($m_id);
			if($result==true){
				$this->error("删除成功");
			}else{
				$this->error("删除失败!请检查相关原因！!");
			}
		}
	}
	//添加员工信息
	//获取员工类型
	public function userType(){
		$result=$this->userapi->getUserType();
		$this->assign("list",$result);
		$this->display('useradd');
	}

	//删除工种类型
	public function deleteUserKind(){
		$uid=I('get.uid');
		if (empty($uid)) {
			$this->error("删除失败!");
		}else{
			$result=$this->userapi->deleteUserType($uid);
			if($result==true){
				$this->error("删除成功!");
			}else{
				$this->error("删除成功!删除失败");
			}
		}
	}
	//将要修改的员工单价添加到页面中
	public function modifyUserKind(){
		$uid=I('get.uid');
		if(empty($uid)){
			$this->error("查询失败!");
		}else{
			$result=$this->userapi->modifyUserKind($uid);
			$this->assign('result',$result);
			$this->display("modifyuserkind");
		}
	}
	//修改员工的单价
	public function userModifyKind(){
		$uid=I('post.mk_id');
		$mi_price=I('post.mk_price');
		if(empty($mi_price)){
			$this->error("员工单价不能为空!");
		}else{
			if($mi_price>0){
				$result=$this->userapi->userModifyKind($uid,$mi_price);
				if($result==true){
					$this->error("修改成功");
				}else{
					$this->error("修改失败");
				}
			}else{
				$this->error("员工单价不能为负！");
			}
		}
	}
	//添加工种类型
	public function addUserKind(){
		$mk_name=I('post.mk_name');
		$mk_price=I('post.mk_price');
		if(empty($mk_name)||empty($mk_price)){
			$this->error("工种名称或工种单价不能为空");
		}else{
			$this->model1=D("Memberkind");

			$data['mk_name']=$mk_name;
            $data['mk_price']=$mk_price;
            $result=$this->model1->add($data);
			//$result=$this->userapi->addUserKindd($mk_name,$mk_price);
			if($result){
				$this->error("添加成功!");
			}else{
				$this->error("添加失败!");
			}
		}
	}


	//添加一个员工信息，获取员工信息
	public function addUserDetail(){
		$userdetail=M('Memberkind');
        $casetype=$userdetail->select();
        $this->assign('casetype',$casetype);
        if(is_array($casetype)){
            $this->display('adduserdetail');
        }else{
            $this->error("请先添加员工类型！！！");
        }
	}
	//添加一个员工信息
	public function addUserSingle(){
		//var_dump(I('post.'));
		$m_name=I('post.m_name');
		$m_gender=I('post.m_gender');
		$m_price=I('post.m_price');
		$mk_id=I('post.mk_id');
		$m_phone=I('post.m_phone');
		$m_idcard=I('post.m_idcard');
		$m_address=I('post.m_address');
		$m_remark=I('post.m_remark');
		if(empty($m_name)||empty($m_price)||empty($m_phone)){
			$this->error("员工姓名或员工薪酬不能为空或号码不能为空！");
		}else{
			$adduser=M('Member');
			$data['m_name']=$m_name;
			$data['m_gender']=$m_gender;
			$data['m_price']=$m_price;
			$data['mk_id']=$mk_id;
			$data['m_phone']=$m_phone;
			$data['m_idcard']=$m_idcard;
			$data['m_address']=$m_address;
			$data['m_remark']=$m_remark;
			$result=$adduser->add($data);
			if($result){
				$this->error("添加成功");
			}else{
				$this->error("添加失败！");
			}
		}
	}

















}
