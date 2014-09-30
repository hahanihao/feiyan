<?php

/**==============用户本身API中心================**/




namespace Sample\Api;
use Sample\Api\Api;


class SampleApi extends Api{


	//初始化（构造函数的一部分）
	//实例化用户模型
	function _init(){
		$this->model=D('User');	

	}




}



