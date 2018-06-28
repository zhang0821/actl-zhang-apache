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
public function search(){
    	$list=M('mag_sensor','','DB_Local')->select();
    	$lot=array();
    	for($i=0;$i<count($list);$i++){
    		$considtion['dev_ui']=$list[$i]['dev_ui'];
    		/*$considtion['longtitude']=$list[$i]['longtitude'];
    		$considtion['latitude']=$list[$i]['latitude'];*/
    		$gps=M('gps','','DB_Local')->where($considtion)->limit(1)->find();/*order('datetime desc')时间排序->*/
    		array_push($lot, $gps['dev_ui']);//,$gps['longtitude'],$gps['latitude']
    	}
    	echo json_decode($lot);
    }	


}
