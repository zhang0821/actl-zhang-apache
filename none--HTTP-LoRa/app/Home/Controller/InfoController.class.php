<?php
namespace Home\Controller;
use Think\Controller;
// session_start();
// //*******控制台的名字命名必须首字母大写！！！
class InfoController extends Controller {
/*****************************获取每个房间的平均温湿度水浸门禁烟雾等信息************/
	public function averageData(){
			$condition['room_id']=1;

			$smokeTable=M('smoke_para','','DB_Local');
			$tem_humTable=M('tem_hum_para','','DB_Local');
			$doorTable=M('door_para','','DB_Local');
			$waterTable=M('water_para','','DB_Local');

			$smokeInfo=$smokeTable->where($condition)->order('id desc')->limit(1)->find();
			$tem_humInfo=$tem_humTable->where($condition)->order('id desc')->limit(1)->find();
			$doorInfo=$doorTable->where($condition)->order('id desc')->limit(1)->find();
			$waterInfo=$waterTable->where($condition)->order('id desc')->limit(1)->find();

			if($tem_humInfo){
				$informationValue['temp_average']=$tem_humInfo['temp_value'];
				$informationValue['humi_average']=$tem_humInfo['humi_value'];
				$informationValue['datetime']=$tem_humInfo['datetime'];
				$informationValue['door_status']=$doorInfo['door_status'];
				$informationValue['water_status']=$waterInfo['water_status'];
				$informationValue['smoke_status']=$smokeInfo['smoke_status'];
			}				
			echo json_encode($informationValue);
		}

	public function askRommCount(){
		$Table=M('room_sensor','','DB_Local');
		$roomCount=1;
		//$condition['room_id']=$roomCount;
		while(1){
			$condition['room_id']=$roomCount;
			if($Table->where($condition)->limit(1)->find()){
				$roomCount++;
			}
			else{
				break;
			}
		}
		$roomCount=$roomCount-1;
		echo json_encode($roomCount);
	}


	public function loadSetInfo(){
		$roomInfoTable=M('room_info','','DB_Local');
		$roomSensorTable=M('room_sensor','','DB_Local');
	//把配置信息存入room_info数据表
		$toRMIFbase['room_id']=$_POST['room_id'];
		$toRMIFbase['tem_high_threshold']=$_POST['Threshold_array'][0];
		$toRMIFbase['tem_low_threshold']=$_POST['Threshold_array'][1];
		$toRMIFbase['hum_high_threshold']=$_POST['Threshold_array'][2];
		$toRMIFbase['hum_low_threshold']=$_POST['Threshold_array'][3];
		$condition1['room_id']=$_POST['room_id'];
		if($roomInfoTable->where($condition1)->limit(1)->find()){
			$success1=$roomInfoTable->where($condition1)->save($toRMIFbase);
		}
		else{
			$success1=$roomInfoTable->add($toRMIFbase);
		}
	//把节点与房间号对应信息存入room_sensor数据表
		$devEuiArray['dev_eui_array']=$_POST['dev_eui_array'];
		// $toRMSSbase['room_id']=$_POST['room_id'];
		$condition2['room_id']=$_POST['room_id'];
		for($i=0; $i <count($devEuiArray['dev_eui_array']); $i++) { 
			$condition2['dev_eui']=$devEuiArray['dev_eui_array'][$i];
			if(!($roomSensorTable->where($condition2)->limit(1)->find())){
				$success2=$roomSensorTable->add($condition2);
			}
		}
		if(($success2 && $success1)){
			echo "1";
		}	
	}
	public function adminInfoToWeb(){
		$adminTable=M('contact','','DB_Local');
		$adminInfo=$adminTable->select();
		if($adminInfo){
			echo json_encode($adminInfo);
		}
		else{
			echo 0;
		}
	}
	public function postAdminInfo(){
		$adminTable=M('contact','','DB_Local');
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$condition['name']=$_POST['name'];
			if($adminTable->where($condition)->limit(1)->find()){
				echo "1";
			}
			else{
				$insertInfo['name']=$_POST['name'];
				$insertInfo['tel']=$_POST['tel'];
				$insertInfo['email']=$_POST['email'];
				$isSuccess=$adminTable->add($insertInfo);
				if($isSuccess)
					echo "2";
				else
					echo "0";
			}
		}
		else{
			echo "0";
		}
	}
	public function delAdminInfo(){
		$adminTable=M('contact','','DB_Local');
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$condition['name']=$_POST['name'];
			if($adminTable->where($condition)->limit(1)->find()){
				//删除
				$isDel=$adminTable->where($condition)->delete();
				if($isDel){
					echo "2";
				}
				else{
					echo "0";
				}

			}
			else{
				echo "1";//用户本就不存在
			}
		}
		else{
			echo "0";
		}
	}
}

?>