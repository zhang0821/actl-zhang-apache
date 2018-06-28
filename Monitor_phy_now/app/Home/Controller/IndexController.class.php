<?php
namespace Home\Controller;
use Think\Controller;
session_start();
class IndexController extends Controller {	
    public function index(){
		$Dao = M('User','','DB_Local');
    	$user_list = $Dao->select();
    	$this->display();
    }
	
/***********用来测试数据库操作是否正确的程序**********/
	public function test_alarm()
	{
$time1='2017-12-11 00:00:00';
$time2='2017-12-10 00:00:00';
if($time1>$time2){
	echo  1;
}
/*
		$sendEmail=D('Mail');$sendMsg=D('Message');
		$contactList=M('contact','','DB_Local')->select();//获取联系人信息
		if($contactList){
			for($ki=0;$ki<count($contactList);$ki++){
						$toAddress=$contactList[$ki]['email'];$mobile=$contactList[$ki]['tel'];
						$sendContext='hello';
						$sendEmail->SendMail($toAddress,$sendContext);
						$sendMsg->SendMessage($mobile, '环境监测系统报警信息通知', $sendContext);	
			}
					
		}*/

	}
	
	
	
	
    public function transfer_test($a){
    	echo json_encode($a);
    }
   
    /******定时执行计算各个房间温湿度平均值并保存，再删除历史数据，只保留近一个小时的*********/
    //每天都计算每一天的
	public function averageTemHumStore()
	{
		$roomS=M('room_info','','DB_Local')->select();
		$hum_tem_table=M('tem_hum_para','','DB_Local');
		$room_para_table=M('room_para','','DB_Local');
		$timeBasic=date("Y-m-d H:i:s",strtotime(date("Y-m-d"),time()));
		for($k=0;$k<count($roomS);$k++){
			$condition['room_id']=$roomS[$k]['room_id'];
			for($i=0;$i<24;$i++){
				$start_time=date("Y-m-d H:i:s", strtotime ("+".($i)." hour", strtotime($timeBasic)));
				$end_time=date("Y-m-d H:i:s", strtotime ("+".($i+1)." hour", strtotime($timeBasic)));
				$condition['datetime']=array(between,array($start_time,$end_time));
				$dataTable=$hum_tem_table->where($condition)->order('ID desc')->limit(1)->find();	
				if($dataTable){	
					$infoInserRP['temp_average']=$dataTable['temp_value'];
					$infoInserRP['humi_average']=$dataTable['humi_value'];
				}
				else{
					$infoInserRP['temp_average']=0;
					$infoInserRP['humi_average']=0;
				}
				$infoInserRP['room_id']=$roomS[$k]['room_id'];
				$infoInserRP['datetime']=$start_time;
				$room_para_table->add($infoInserRP);
			}
		}
	}
	
/***********测试结束**********/
	public function store_value_interval(){
		$floor_count=7;
		$target_table=M('room_para','','DB_Local');
		$tick_table=M('tem_hum_para','','DB_Local');
		$time_hour=date("H");
		$start_time_hour=date("Y-m-d").' '.$time_hour.":00:00";
		$end_time_hour=date("Y-m-d").' '.$time_hour.":59:59";
		$condition['datetime']=array(between,array($start_time_hour,$end_time_hour));
		$info=array();
$total_watch=array();
		for($i=0;$i<$floor_count;$i++){
			$rooms_name=A("Info")->rooms_name($i);
if($rooms_name){
			for($j=0;$j<count($rooms_name);$j++){
				$condition['floor_id']=strval($i);
				$condition['room_id']=$rooms_name[$j];
				$every_room_info_hour=$tick_table->where($condition)->field('temp_value,humi_value')->select();
				$info_insert['floor_id']=strval($i);
				$info_insert['room_id']=$rooms_name[$j];
				$info_insert['temp_average']=0;
				$info_insert['humi_average']=0;
				$info_insert['datetime']=$start_time_hour;
				if($every_room_info_hour){
					$temp_total=0;$humi_total=0;$count=0;
					for($k=0;$k<count($every_room_info_hour);$k++){
						$temp_total+=$every_room_info_hour[$k]['temp_value'];
						$humi_total+=$every_room_info_hour[$k]['humi_value'];
						if($every_room_info_hour[$k]['temp_value']!=null){
							$count++;
						}
					}
					$info_insert['temp_average']=round($temp_total/$count,2);
					$info_insert['humi_average']=round($humi_total/$count,2);
				}
				if($target_table->where($condition)->limit(1)->find()){
					$target_table->where($condition)->save($info_insert);//插入新数据

					$condition_delete['floor_id']=$condition['floor_id'];//删除表两张表中七天前的消息
					$condition_delete['room_id']=$condition['room_id'];
					$delete_day=7;
					$date=date("Y-m-d",strtotime("-".$delete_day." day"));
					$delete_start_time=$date.' '."00:00:00";
					$delete_end_tim=$date.' '."23:59:59";
					$condition_delete['datetime']=array(between,array($delete_start_time,$delete_end_tim));
					$target_table->where($condition_delete)->delete();
					$tick_table->where($condition_delete)->delete();

				}
				else{
					$target_table->add($info_insert);
				}
$watch=array();
$watch[$j]['condition']=$condition;
$watch[$j]['compte_temp']=$temp_total;$watch['compte_humi']=$humi_total;

			}
$total_watch[$i]['every_floor'.$i]=$watch;
}

		}
//echo json_encode($total_watch);
	}
}

?>