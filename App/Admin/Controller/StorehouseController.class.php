<?php 

namespace Admin\Controller;
use Think\Controller;
use Storehouse\Api\StorehouseApi;
/**
* 
*/
class StorehouseController extends AdminController
{
	private $storehouseapi=null;
	public function _initialize(){
		parent::_initialize();
		$this->storehouseapi=new StorehouseApi();
	}
	public function index(){

	}
	//仓库列表
	public function goodList(){
		$result=$this->storehouseapi->getGoodList();
		if(empty($result)){
			$this->error("没有相关记录");
		}else{
			$this->assign('show',$result['page']);
			$this->assign('list',$result['datalist']);
			$this->display('goodlist');
		}
	}
	//仓库信息修改
	public function editGoodListUi(){
		$gl_id=I('get.gl_id');
		if(empty($gl_id)){
			$this->error("操作错误");
		}else{
			$result=$this->storehouseapi->editGoodLIstUi($gl_id);
			if(empty($result)){
				$this->error("没有相关记录!");
			}else{
				$this->assign('result',$result);
				$this->display('editgoodlistUi');
			}
		}
	}
	//修改仓库信息
	public function modifyGood(){
		$data=I('post.');
		if(empty($data['gl_name'])||empty($data['gl_supplier'])||empty($data['gl_price'])){
			$this->error("货物名或供应商或单价不能为空!");
		}else{
			$result=$this->storehouseapi->modifyGoodSingle($data);
			if($result){
				$this->success("修改成功!");
			}else{
				$this->error("修改失败!");
			}
		}
	}
	//获取货物类型
	public function addGoodUi(){
		$result=$this->storehouseapi->getGoodType();
		$this->assign('list',$result);
		$this->display("addgoodUi");
	}
	//添加货物类型名称
	public function addGoodKind(){
		$data=I('post.');
		if(empty($data['gk_name'])){
			$this->error("请输入货物类型名称");
		}else{
			$result=$this->storehouseapi->addGoodKind($data);
			if($result==1){
				$this->error("该类型已存在");
			}
			if($result==2){
				$this->success("添加成功");
			}
			if($result==3){
				$this->error("添加失败");
			}
		}
	}
	//修改货物类型
	public function modifyGoodKindUi($gk_id){
		$gk_id=I('get.gk_id');
		if(empty($gk_id)){
			$this->error("查询出错!");
		}else{
			$result=$this->storehouseapi->modifyGoodType($gk_id);
			$this->assign('result',$result);
			$this->display();
		}
	}



	//修改货物名称
	public function modifyGoodKind(){
		$data=I('post.');
		if(!empty($data['gk_name'])){
			$result=$this->storehouseapi->GoodKindSingleEdit($data);
			if($result){
				$this->success("修改成功!");
			}else{
				$this->error("修改失败!");
			}
		}else{
			$this->error("请填写货物类型名称");
		}
	}




	//添加一个库存时，提前获取一些信息
	public function addGoodDetailUi(){
        $casetype=$this->storehouseapi->getGoodTypeBy();
        $this->assign('casetype',$casetype);
        if(is_array($casetype)){
            $this->display('addGoodDetailUi');
        }else{
            $this->error("请先添加货物类型名称！！！");
        }
	}


	//添加库存
	public function addGoodSingle(){
		$data=I('post.');
		if(empty($data['gl_name'])||empty($data['gl_models'])||empty($data['gl_number'])||empty($data['gl_price'])){
			$this->error("请填写必填信息!");
		}else{
			$result=$this->storehouseapi->addGoodSingle($data);
			if($result){
				$this->success("添加成功!");
			}else{
				$this->error("添加失败！");
			}
		}
	}


























}
?>