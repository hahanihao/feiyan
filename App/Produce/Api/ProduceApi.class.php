<?php

/**==============生产跟踪API中心================**/




namespace Produce\Api;
use Produce\Api\Api;


class ProduceApi extends Api{


	//初始化（构造函数的一部分）
	//实例化用户模型
	function _init(){
		$this->model=D('User');	

	}




}



