<?php

/**==============用户本身API中心================**/




namespace User\Api;
use User\Api\Api;


class UserApi extends Api{


	//初始化（构造函数的一部分）
	//实例化用户模型
	function _init(){
		$this->model=D('Member');	

	}

	//登录接口
	//return boolean 
	//成功：ture  失败：false
	//支持email 和帐号登录
	public function login($password,$account=null){
		$result=false;
		//帐号登录
		$result=$this->model->where("m_account='%s' AND m_passwords='%s'",$account,md5($password))->find();
		if(is_array($result) && md5($password)===$result['m_passwords']){
			$result['m_passwords']=null;
			session(null);
			session('LOGIN_INFO',$result);
			return TRUE;
		}else{
			return FALSE;
		}



	} 




	//检测帐号
	//return boolean
	//帐号存在true 不存在false
	//@param account
	public function checkAccount($account){
		if(!empty($account)){
			$result=$this->model->where('m_account="%s"',$account)->find();
			if($result && is_array($result)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}


	//检测邮箱是否可以注册
	//return boolean
	//邮箱存在false 不存在true
	//@param email 用户邮箱
	public function checkEmail($email){
		if(is_email($email)){
			$result=$this->model->where('u_email="%s"',$email)->find();
			if($result && is_array($result)){
				return false;
			}else{
				return true;
			}
		}else{

			return false;
		}	
		return false;
	}


	//验证验证码
	//return boolean
	//正确true 错误false
	//@param code <验证吗>
	public function checkVerify($verify){
		$verify=new \Think\Verify();
		return $verify->check($verify);

	}


	/*跟新用户信息  单个字段更新
	  @param $field :字段名
	  @param $value :值
	  return boolean true /flase
	 */
	public function updateOneFiels($field,$value){

		$valuetype="%s";
		if(is_int($value)){
			$valuetype="%d";
		}
		$flag=$this->model->where("u_id=%d",get_user_field('u_id'))->data(array($field=>$value))->save();
		if($flag){
			return true;
		}else{
			return false;
		}
	}




}



?>
