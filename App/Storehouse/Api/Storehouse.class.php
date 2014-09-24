<?php

/**==============用户本身API中心================**/




namespace Storehouse\Api;
use Storehouse\Api\Api;


class StorehouseApi extends Api{


	//初始化（构造函数的一部分）
	//实例化用户模型
	function _init(){
		$this->model=D('User');	

	}


}



