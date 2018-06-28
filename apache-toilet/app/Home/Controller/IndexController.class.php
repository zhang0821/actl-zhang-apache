<?php
namespace Home\Controller;
use Think\Controller;
session_start();
class IndexController extends Controller {	
    public function index(){
        $this->display();
    }
	public function check(){
		 $User= M('user');
		 $condition['username'] = $_POST['username'];
		 $condition['password'] = $_POST['password'];
		 $list=$User->where($condition)->find();		 
		 if($list){
			// $User->where($condition)->save($data); // 根据条件保存修改的数据
			$this->success("欢迎你，".$_POST['username']."!<br/>".date("Y-m-d H:i:s",time()),U('Monitor/TemperatureAndHumidity'),1);
			// $this->success(U('Monitor/TemperatureAndHumidity'));
			// echo '已进入';
			// $this->display('Monitor:TemperatureAndHumidity');			
		 }
		 else
			$this->error('用户名或密码错误',"",1);
		$_SESSION["username"]=$condition['username'];
    }
}