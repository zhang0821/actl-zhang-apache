<?php
namespace Home\Controller;
use Think\Controller;
session_start();
class IndexController extends Controller {	
    public function index(){
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
//			phpinfo();

			$this->display();
	 	}
    }


public function apache_test(){
			$UserTable=M('contact','','DB_Local');
			

			$UserInfo=$UserTable->select();
			$data['info']=0;
//$infoReturn=array();
			if($UserInfo){
				//for($i=0;$i<count($UserInfo);$i++){
					//$infoReturn[$i]['name']
				//}
				
				echo json_encode($UserInfo,JSON_UNESCAPED_UNICODE);
			}

			else{
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			}

}


    //定时执行的方法  
    public function crons()  
    {  
        // $time['data'] =12;
        // M('ticker','','DB_Local')->add($time);
    }  

	public function hisDataCheck(){
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$historyday_count=$_POST['historyday_count'];
			$condition['room_id']=$_POST['room_id'];
			//温湿度的查询
			$myDataTable= M('tem_hum_para','','DB_Local');
			$history_day=date("Y-m-d",strtotime("-".$historyday_count." day"));
			$dataParaArray=array();
			for($i=0;$i<24;$i++){
				$start_time=date("Y-m-d H:i:s",strtotime($history_day,time()));
				$mystart_time=date("Y-m-d H:i:s", strtotime ("+".($i)." hour", strtotime($start_time)));
				$end_time=date("Y-m-d H:i:s", strtotime ("+".($i+1)." hour", strtotime($start_time)));
				$condition['datetime']=array(between,array($mystart_time,$end_time));
				$dataTable=$myDataTable->where($condition)->order('ID desc')->limit(1)->find();	
				if($dataTable){	
					$dataParaArray[$i]['temp_value']=$dataTable['temp_value'];
					$dataParaArray[$i]['humi_value']=$dataTable['humi_value'];
				}
				else{
					$dataParaArray[$i]['temp_value']=0;
					$dataParaArray[$i]['humi_value']=0;
				}
				$dataParaArray[$i]['date']=$history_day;
				$dataParaArray[$i]['door_status']=0;
			}
			//烟雾和水浸报警记录
			$dataParaArray[24]=array();
			$dataParaArray[25]=array();

			$smokeTable= M('smoke_para','','DB_Local');	
			$condition2['room_id']=$_POST['room_id'];
			$condition2['smoke_status']=1;
			$condition2['datetime']=array(between,array(date("Y-m-d H:i:s",strtotime($history_day,time())),date("Y-m-d H:i:s", strtotime ("+24 hour", strtotime(date("Y-m-d H:i:s",strtotime($history_day,time())))))));
			$smokeInfo=$smokeTable->where($condition2)->field('datetime')->select();
			if($smokeInfo){
				for($j=0;$j<count($smokeInfo);$j++){
					$dataParaArray[24][$j]['datetime']=$smokeInfo[$j]['datetime'];
				}
			}

			$waterTable= M('water_para','','DB_Local');	
			$condition3['room_id']=$_POST['room_id'];
			$condition3['water_status']=1;
			$condition3['datetime']=array(between,array(date("Y-m-d H:i:s",strtotime($history_day,time())),date("Y-m-d H:i:s", strtotime ("+24 hour", strtotime(date("Y-m-d H:i:s",strtotime($history_day,time())))))));
			$waterInfo=$waterTable->where($condition3)->field('datetime')->select();

			if($waterInfo){
				for($j=0;$j<count($waterInfo);$j++){
					$dataParaArray[25][$j]['datetime']=$waterInfo[$j]['datetime'];
				}
			}	
			echo json_encode($dataParaArray);
		}
	}

}

?>
