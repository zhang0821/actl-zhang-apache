<?php
namespace Home\Controller;
use Think\Controller;

header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type'); 

session_start();
class IndexController extends Controller {	
    public function index(){
		$Dao = M('User','','DB_Local');
    	$user_list = $Dao->select();
    	$this->display();
    }
	
/***********用来测试数据库操作是否正确的程序**********/
public function angular_test(){
	$data['userName']='zhangli';
	$data['password']='123';
	echo json_encode($data);
}
public function roomName_map($room_id)
{
	if($room_id=='zxs'){
		return '自习室';
	}
	else if($room_id=='pl'){
		return '漂流吧';
	}
	else if($room_id=='lpd'){
		return '礼品店';
	}
	else if($room_id=='yz9'){
		return '驿站-九号楼';
	}
	else if($room_id=='yz6'){
		return '驿站-东六';
	}
	else if($room_id=='dating'){
		return '一楼大厅';
	}
	else{
		return strtoupper($room_id);
	}
}

public function send_SsInfo_web()
	{
		$floor_name_list=['创业学院一楼','创业学院二楼','创业学院三楼','创业学院四楼','创业学院五楼','创业学院六楼','华大驿站 ','八楼','九楼','十楼'];
		$ifSendEmail=0;
		$warnSendContext='';
		$return_SsInfo=array();
		$rooms_info=M('room_info','','DB_Local')->select();//找出共有多少个房间
		
		$condition_lib['floor_id']=array('ELT','6');
		$last_warn_time=M('room_info','','DB_Local')->where($condition_lib)->order('alarm_time desc')->limit(1)->find();//先找出最近报警时间，避免本次更新影响

		if($last_warn_time){
			$warn_inser_condition['floor_id']=$last_warn_time['floor_id'];
			$warn_inser_condition['room_id']=$last_warn_time['room_id'];
		
			if($last_warn_time['alarm_time']==null){
				$last_warn_time['alarm_time']=="2016-10-10 00:00:00";
			}
			
		}
		else{
			$last_warn_time['alarm_time']=="2016-10-10 00:00:00";
			$warn_inser_condition['floor_id']=7;
			$warn_inser_condition['room_id']='yz6';
		}
		
		for($r_id=0;$r_id<count($rooms_info);$r_id++){
			$condition_room['floor_id']=$rooms_info[$r_id]['floor_id'];
			$condition_room['room_id']=$rooms_info[$r_id]['room_id'];
			$SsInfo=M('room_sensor','','DB_Local')->where($condition_room)->select();
			$warnSendContext_floor=' ';
			$ifUpdate_alarm=0;
			if($SsInfo){
				for ($i=0; $i <count($SsInfo); $i++) {
					$condition['dev_eui']=$SsInfo[$i]['dev_eui'];//eui是唯一标识
					$serchTable=$SsInfo[$i]['type'].'_para';
					$name=$SsInfo[$i]['type'].'_status';

					$result_find=M($serchTable,'','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
					if($result_find){
						//如果离线
						if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$result_find['datetime'],20)){
							$SsInfo[$i]['online']=0;
							$warnSendContext_floor=$warnSendContext_floor.'节点已离线;';
						}
						//查询每类节点的对应值
						else{
						if($SsInfo[$i]['type']=='tem_hum'){
							$SsInfo[$i]['temp_value']=round($result_find['temp_value'],2);
							$SsInfo[$i]['humi_value']=round($result_find['humi_value'],2);
							//查看是否超过阈值
							
							$SsInfo[$i]['status']=1;//未超过阈值
							if($SsInfo[$i]['temp_value']>$rooms_info[$r_id]['tem_high_threshold'] || $SsInfo[$i]['temp_value']<$rooms_info[$r_id]['tem_low_threshold'] || $SsInfo[$i]['humi_value']>$rooms_info[$r_id]['hum_high_threshold'] ||$SsInfo[$i]['humi_value']<$rooms_info[$r_id]['hum_low_threshold'])
							{
								
								//$ifSendEmail=1;//有异常，报警仅仅温湿度有异常，不报警
								$SsInfo[$i]['status']=0;//不在正常范围内时，为0
								
								if($SsInfo[$i]['temp_value']>$rooms_info[$r_id]['tem_high_threshold'] || $SsInfo[$i]['temp_value']<$rooms_info[$r_id]['tem_low_threshold'])
								{
									$updateInfo_type['tem_alarm_datetime']=date("Y-m-d H:i:s");
									$ifUpdate_alarm=1;
									$warnSendContext_floor=$warnSendContext_floor.'温度超过阈值;';

								}
								if($SsInfo[$i]['humi_value']>$rooms_info[$r_id]['hum_high_threshold'] ||$SsInfo[$i]['humi_value']<$rooms_info[$r_id]['hum_low_threshold'])
								{
									$updateInfo_type['hum_alarm_datetime']=date("Y-m-d H:i:s");
									$warnSendContext_floor=$warnSendContext_floor.'湿度超过阈值;';
									$ifUpdate_alarm=1;
								}
								
							}
							
						}
						else{
							$SsInfo[$i]['status']=$result_find[$name];//如果是门禁为0，也不用报警，只是表示men得状态开关

							if($SsInfo[$i]['status']==0){
								if($name!='door_status'){
									$ifSendEmail=1;
								}
								if($name=='water_status'){
									$ifSendEmail=1;//状态为0，报警
									$warnSendContext_floor=$warnSendContext_floor.'水浸传感器报警;';
									$ifUpdate_alarm=1;
									$updateInfo_type['water_alarm_datetime']=date("Y-m-d H:i:s");
								}
								if($name=='smoke_status'){
									$ifSendEmail=1;//状态为0，报警
									$warnSendContext_floor=$warnSendContext_floor.'烟雾传感器报警;';
									$updateInfo_type['smoke_alarm_datetime']=date("Y-m-d H:i:s");
									$ifUpdate_alarm=1;
									//如果是烟雾传感器报警，此时先去查看该房间对应的厌恶传感的报警时间，如果时间超过10分钟，也报警
									$smoke_alarm=M('room_info','','DB_Local')->where($condition_room)->limit(1)->find();
									if($smoke_alarm['alarm_time']<$last_warn_time['alarm_time']){
										$last_warn_time['alarm_time']=$smoke_alarm['alarm_time'];
									}
									//$updateInfo_type['alarm_time']=date("Y-m-d H:i:s");

								}
							}
							$SsInfo[$i]['temp_value']=NULL;
							$SsInfo[$i]['humi_value']=NULL;
							
						}
						}
					}
					else{
						$SsInfo[$i]['online']=0;
						$warnSendContext_floor=$warnSendContext_floor.'节点已离线;';
						}
					$SsInfo[$i]['floor_name']=$floor_name_list[$rooms_info[$r_id]['floor_id']];
					$SsInfo[$i]['time']=date("H:i");
					
				}
				array_push($return_SsInfo,$SsInfo);
			}
			if($warnSendContext_floor!=' '){
				$warnSendContext=$warnSendContext.' '.$floor_name_list[$condition_room['floor_id']].','.self::roomName_map($condition_room['room_id']).$warnSendContext_floor.'<br>';
				$warnSendContext_floor=' ';
				if($ifUpdate_alarm==1 && $ifSendEmail==1)
				{
					$ifUpdate_alarm=0;
					$updateInfo_type['alarm_time']=date("Y-m-d H:i:s");
					M('room_info','','DB_Local')->where($condition_room)->save($updateInfo_type);//并更新报警记录表里面该楼层的报警时间
				}
				
			}
		}
echo json_encode($last_warn_time['alarm_time']);
		//如果有报警，报警标志位置为1，然后依次发送所有楼层报警信息，三十分钟内只发一次
$ifSendEmail=1;
		if($ifSendEmail==1){					
			if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$last_warn_time['alarm_time'],20)){

				$sendEmail=D('Mail');
				$sendMsg=D('Message');
				$contactList=M('contact','','DB_Local')->select();//获取联系人信息
				if($contactList){
echo json_encode($contactList);
					for($ki=0;$ki<count($contactList);$ki++){
						$toAddress=$contactList[$ki]['email'];
						$mobile=$contactList[$ki]['tel'];
						$sendContext='尊敬的图书馆管理员'.$contactList[$ki]['name'].',您好！<br>环境监控系统报警信息如下:<br>'
						.$warnSendContext.'<br>报警时间:'.date('Y-m-d H:i:s');
						$sendMsg->SendMessage($mobile, '环境监测系统报警信息通知', $sendContext);	
						$sendEmail->SendMail($toAddress,$sendContext);
												
					}
					//$updateInfo['alarm_time']=date("Y-m-d H:i:s");
					//M('room_info','','DB_Local')->where($warn_inser_condition)->save($updateInfo);

				}
			}
		}
	}

	public function test_alarm()
	{
$sendMsg=D('Message');
$sendEmail=D('Mail');
$sendEmail->SendMail('670954789@qq.com','哈哈哈哈哈哈哈');
//$sendMsg->SendMessage('15882312250', '环境监测系统报警信息通知33', '33333333333333');
/*
$time1='2017-12-11 00:00:00';
$time2='2017-12-11 00:19:00';
	if(D('Alarm')->DifferentDateTime($time2,$time1,20)){
				$sendEmail=D('Mail');
				$sendMsg=D('Message');
				$contactList=M('contact','','DB_Local')->select();//获取联系人信息
				if($contactList){
					for($ki=0;$ki<count($contactList);$ki++){
						$toAddress=$contactList[$ki]['email'];
						$mobile=$contactList[$ki]['tel'];
						$sendContext='尊敬的图书馆管理员,您好！<br>环境监控系统报警信息如下:<br>报警时间:'.date('Y-m-d H:i:s');
						$sendMsg->SendMessage($mobile, '环境监测系统报警信息通知', $sendContext);	
						$sendEmail->SendMail($toAddress,$sendContext);
												
					}
					//$updateInfo['alarm_time']=date("Y-m-d H:i:s");
					//M('room_info','','DB_Local')->where($warn_inser_condition)->save($updateInfo);

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