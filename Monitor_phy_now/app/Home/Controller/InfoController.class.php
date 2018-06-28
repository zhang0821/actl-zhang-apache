<?php
namespace Home\Controller;
use Think\Controller;
// session_start();
// //*******控制台的名字命名必须首字母大写！！！
class InfoController extends Controller 
{	

public function sensor_type_search(){
		$Types =M('room_sensor','','DB_Local')->distinct(true)->field('type')->select();
    	echo json_encode($Types);
	}
public function get_send_ssInfo_DB()
	{
		$RSInfo['dev_eui']=$_POST['dev_eui'];
		$RSInfo['room_id']=strval($_POST['room_id']);
		$RSInfo['posx']=$_POST['posX'];
		$RSInfo['posy']=$_POST['posY'];
		$RSInfo['type']=$_POST['typeSs'];
		$RSInfo['floor_id']=strval($_POST['floor_id']);

		$ifDevExist['dev_eui']=$_POST['dev_eui'];

		if (M('room_sensor','','DB_Local')->where($ifDevExist)->find()) {
			echo 1;//该设备已存在
		}
		else{
			if(M('room_sensor','','DB_Local')->add($RSInfo)){

				$RIInfo['room_id']=strval($_POST['room_id']);
				$RIInfo['floor_id']=strval($_POST['floor_id']);
				$RIInfo['tem_high_threshold']=$_POST['tempMax'];
				$RIInfo['tem_low_threshold']=$_POST['tempMin'];
				$RIInfo['hum_high_threshold']=$_POST['humiMax'];
				$RIInfo['hum_low_threshold']=$_POST['humiMin'];

				$ifRomExist['room_id']=strval($_POST['room_id']);
				$ifRomExist['floor_id']=strval($_POST['floor_id']);

				if($RMinfoFind=M('room_info','','DB_Local')->where($ifRomExist)->find()){
					// $RIInfo['tem_alarm_datetime']=$RMinfoFind['tem_alarm_datetime'];
					// $RIInfo['hum_alarm_datetime']=$RMinfoFind['hum_alarm_datetime'];
					// $RIInfo['water_alarm_datetime']=$RMinfoFind['water_alarm_datetime'];
					// $RIInfo['door_alarm_datetime']=$RMinfoFind['door_alarm_datetime'];
					// $RIInfo['smoke_alarm_datetime']=$RMinfoFind['smoke_alarm_datetime'];
					// $RIInfo['alarm_time']=$RMinfoFind['alarm_time'];
					M('room_info','','DB_Local')->where($ifRomExist)->save($RIInfo);

				}
				else{
					$RIInfo['tem_alarm_datetime']=null;
					$RIInfo['hum_alarm_datetime']=null;
					$RIInfo['water_alarm_datetime']=null;
					$RIInfo['door_alarm_datetime']=null;
					$RIInfo['smoke_alarm_datetime']=null;
					$RIInfo['alarm_time']=null;
					M('room_info','','DB_Local')->where($ifRomExist)->add($RIInfo);
				}
				echo 2;
			}
			else{
				echo 3;//插入失败
			}
		}
	}

/******将所有节点的信息返回到页面********/
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
		$floor_name_list=['创业学院一楼','创业学院二楼','创业学院三楼','创业学院四楼','创业学院五楼','创业学院六楼','华大驿站 ','物理学院二楼','九楼','十楼'];
		$ifSendEmail=0;
		$warnSendContext='';
		$return_SsInfo=array();
		$condition_floor_cy['floor_id'] = '7';
		$rooms_info=M('room_info','','DB_Local')->where($condition_floor_cy)->select();//找出共有多少个房间
		
		
		$last_warn_time=M('room_info','','DB_Local')->where($condition_floor_cy)->order('alarm_time desc')->limit(1)->find();//先找出最近报警时间，避免本次更新影响

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
			$warn_inser_condition['room_id']='9228';
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
		//如果有报警，报警标志位置为1，然后依次发送所有楼层报警信息，三十分钟内只发一次
		if($ifSendEmail==1){					
			if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$last_warn_time['alarm_time'],10)){
				$sendEmail=D('Mail');
				$sendMsg=D('Message');
				$contactList=M('contact','','DB_Local')->select();//获取联系人信息
				if($contactList){
					for($ki=0;$ki<count($contactList);$ki++){
						$toAddress=$contactList[$ki]['email'];
						$mobile=$contactList[$ki]['tel'];
						$sendContext='尊敬的图书馆管理员'.$contactList[$ki]['name'].',您好！<br>环境监控系统报警信息如下:<br>'
						.$warnSendContext.'<br>报警时间:'.date('Y-m-d H:i:s');
						//self::sendMsg($mobile,$sendContext);
						//$sendMsg->SendMessage($mobile, '环境监测系统报警信息通知', $sendContext);	
						$sendEmail->SendMail($toAddress,$sendContext);
												
					}
					//$updateInfo['alarm_time']=date("Y-m-d H:i:s");
					//M('room_info','','DB_Local')->where($warn_inser_condition)->save($updateInfo);

				}
			}
		}
		echo json_encode($return_SsInfo);
	}


public function phy_send_SsInfo_web()
	{
		//$floor_name_list=['创业学院一楼','创业学院二楼','创业学院三楼','创业学院四楼','创业学院五楼','创业学院六楼','华大驿站 ','物理学院二楼','九楼','十楼'];
		$ifSendEmail=0;
		$warnSendContext='';
		$return_SsInfo=array();
		$condition_floor['floor_id']='0';
		$rooms_info=M('room_info','','DB_Local')->where($condition_floor)->select();//找出共有多少个房间
		
		$last_warn_time=M('room_info','','DB_Local')->where($condition_floor)->order('alarm_time desc')->limit(1)->find();//先找出最近报警时间，避免本次更新影响

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
					//$SsInfo[$i]['floor_name']=$floor_name_list[$rooms_info[$r_id]['floor_id']];
					$SsInfo[$i]['floor_name']='物理学院二楼';
					$SsInfo[$i]['time']=date("H:i");
					
				}
				array_push($return_SsInfo,$SsInfo);
			}
			if($warnSendContext_floor!=' '){
				$warnSendContext=$warnSendContext.' 物理学院二楼,'.self::roomName_map($condition_room['room_id']).$warnSendContext_floor.'<br>';
				$warnSendContext_floor=' ';
				if($ifUpdate_alarm==1 && $ifSendEmail==1)
				{
					$ifUpdate_alarm=0;
					$updateInfo_type['alarm_time']=date("Y-m-d H:i:s");
					M('room_info','','DB_Local')->where($condition_room)->save($updateInfo_type);//并更新报警记录表里面该楼层的报警时间
				}
				
			}
		}
		//如果有报警，报警标志位置为1，然后依次发送所有楼层报警信息，三十分钟内只发一次
		if($ifSendEmail==1){					
			if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$last_warn_time['alarm_time'],10)){
				$sendEmail=D('Mail');
				$sendMsg=D('Message');
				$contactList=M('contact','','DB_Local')->select();//获取联系人信息
				if($contactList){
					for($ki=0;$ki<count($contactList);$ki++){
						$toAddress=$contactList[$ki]['email'];
						$mobile=$contactList[$ki]['tel'];
						$sendContext='尊敬的图书馆管理员'.$contactList[$ki]['name'].',您好！<br>环境监控系统报警信息如下:<br>'
						.$warnSendContext.'<br>报警时间:'.date('Y-m-d H:i:s');
						self::sendMsg($mobile,$sendContext);
						//$sendMsg->SendMessage($mobile, '环境监测系统报警信息通知', $sendContext);	
						$sendEmail->SendMail($toAddress,$sendContext);
												
					}
					//$updateInfo['alarm_time']=date("Y-m-d H:i:s");
					//M('room_info','','DB_Local')->where($warn_inser_condition)->save($updateInfo);

				}
			}
		}
		echo json_encode($return_SsInfo);
	}

public function sendMsg($address,$context){
	$sendMsg=D('Message');
	$sendMsg->SendMessage($address, '环境监测系统报警信息通知', $context);	
		
}
//判断元素是否在数组中
 public function ele_not_in_array($ele,$array){
 	for($i=0;$i<count($array);$i++){
 		if($ele==$array[$i]){
 			return 0;
 		}
 	}
 	return 1;
 }
 public function test_room_return(){
	 $condition['floor_id']="2";
		$room_sensor_Table=M('room_sensor','','DB_Local');
		$findSS=$room_sensor_Table->where($condition)->select();
		$rooms_name=array();
		if($findSS)
		{
			$room_id=[];
			for($i=0;$i<count($findSS);$i++){
				if((self::ele_not_in_array($findSS[$i]['room_id'],$room_id))){
					array_push($rooms_name,$findSS[$i]['room_id']);
					array_push($room_id,$findSS[$i]['room_id']);
				}
			}
		}
		echo json_encode($rooms_name);
 }
//每层楼层各有哪些房间编号
	public function rooms_name($floor_id){
		$condition['floor_id']=strval($floor_id);
		$room_sensor_Table=M('room_sensor','','DB_Local');
		$findSS=$room_sensor_Table->where($condition)->select();
		$rooms_name=array();
		if($findSS)
		{
			$room_id=[];
			for($i=0;$i<count($findSS);$i++){
				if((self::ele_not_in_array($findSS[$i]['room_id'],$room_id))){
					array_push($rooms_name,$findSS[$i]['room_id']);
					array_push($room_id,$findSS[$i]['room_id']);
				}
			}
		}
		return $rooms_name;
	}
	public function floor_average_tem_hum($floor_id){
		$tem_hum_Table=M('tem_hum_para','','DB_Local');
		
		// $name_rooms=array();

		$return_tem_hum=array();

		$temp=0.0;$humi=0.0;//中间不能用逗号分开
		
		$name_rooms=self::rooms_name($floor_id);//每个楼层共有哪些房间

		$condition['floor_id']=strval($floor_id);
		$room_online=0;

		for($i=0;$i<count($name_rooms);$i++){
			$condition['room_id']=$name_rooms[$i];
			$start_time=date("Y-m-d").' '.'00:00:00';
			$end_time=date("Y-m-d").' '.'23:59:59';
			$condition['datetime']=array(between,array($start_time,$end_time));

			$findInfo=$tem_hum_Table->where($condition)->order('datetime desc')->find();
			if($findInfo){
				$temp+=$findInfo['temp_value'];
				$humi+=$findInfo['humi_value'];
				$room_online++;
			}
			else{
				$temp+=0;
				$humi+=0;
			}
		}
		if($room_online==0){
			$room_online=1;//防止做除法的时候报错
		}
		array_push($return_tem_hum,sprintf("%.1f",round(($temp/$room_online),2)));
		array_push($return_tem_hum,sprintf("%.1f",round(($humi/$room_online),2)));
		return $return_tem_hum;
	}
/********将所有楼层的均值温湿度信息返回界面***************/
 	public function send_average_tem_hum()
 	{
 		$_POST['floorCount']=8;
 		$floor_online=0;
 		$tem_hum_return['temp_average']=0;$tem_hum_return['humi_average']=0;

 		for($i=0;$i<$_POST['floorCount'];$i++){
 			$floor_average_tem_hum=self::floor_average_tem_hum($i);
 			if($floor_average_tem_hum[0]!=0 || $floor_average_tem_hum[1]!=0){
 				$tem_hum_return['temp_average']+=$floor_average_tem_hum[0];
 				$tem_hum_return['humi_average']+=$floor_average_tem_hum[1];
 				$floor_online++;
 			}
 		}
 		if($floor_online!=0){
 			$tem_hum_return['temp_average']=round($tem_hum_return['temp_average']/$floor_online,2);
 			$tem_hum_return['humi_average']=round($tem_hum_return['humi_average']/$floor_online,2);
 		}
 		$tem_hum_return['time']=date("H:i");
 		echo json_encode($tem_hum_return);
 	}
/***********返回整栋楼的平均值的初始信息***************/
public function send_init_info()
	{
		// if($_POST['floor_id']==-1){ //返回整个楼栋平均值
			$k=0;
			// $now_hour=23;
			$now_hour=date("H");//当前时刻//往前取10个小时的时刻点
			$data_return=array();//每个小时一个温度，一个湿度
			for($i=0;$i<=$now_hour;$i++){//取出来11条消息
				$date=date("Y-m-d");
				$start_time=$date.' '.$i.":00:00";
				$end_time=$date.' '.$i.":59:59";
				$condition['datetime']=array(between,array($start_time,$end_time));
				$info_array=M('room_para','','DB_Local')->where($condition)->select();
				//$info_array=M('room_para','','DB_Local')->select();
				if($info_array){
					$online_count=0;
					$average_hour_temp=0.0;$average_hour_humi=0.0;
					for($j=0;$j<count($info_array);$j++){
						if($info_array[$j]['temp_average']!=0){
							$average_hour_temp+=$info_array[$j]['temp_average'];
							$average_hour_humi+=$info_array[$j]['humi_average'];
							$online_count++;
						}
					}
					if($online_count==0){
						$online_count=1;
					}
					$average_hour_temp=round($average_hour_temp/$online_count,2);
					$average_hour_humi=round($average_hour_humi/$online_count,2);
				}
				else{
					$average_hour_temp=0;$average_hour_humi=0;
				}
				$time_i=$i;
				$time_i=($time_i<10?"0".$time_i:$time_i);
				$data_return[$k]['time']=$time_i.":00";
				$data_return[$k]['temp']=$average_hour_temp;
				$data_return[$k]['humi']=$average_hour_humi;
				$k++;
			}
			echo json_encode($data_return);
	}
	
	public function send_init_info_test()
	{
		// if($_POST['floor_id']==-1){ //返回整个楼栋平均值
			$k=0;
			// $now_hour=23;
			$now_hour=date("H");//当前时刻//往前取10个小时的时刻点
			$data_return=array();//每个小时一个温度，一个湿度
			for($i=0;$i<=$now_hour;$i++){//取出来11条消息
				$date=date("Y-m-d");
				$start_time=$date.' '.$i.":00:00";
				$end_time=$date.' '.$i.":59:59";
				$condition['datetime']=array(between,array($start_time,$end_time));
				$info_array=M('room_para','','DB_Local')->where($condition)->field('temp_average','humi_average')->select();
				$data_return[$i]['info']=$info_array;
				
			}
			echo json_encode($data_return);
	}
/***********返回报警信息到界面*************/
	public function send_Ss_warn(){
	 	$typeName=$_POST['type'].'_alarm_datetime';
	 	$date=date("Y-m-d");
	 	$start_time=date("Y-m-d H:i:s", strtotime ("+0hour",strtotime($date)));
		$end_time=date("Y-m-d H:i:s", strtotime ("+24hour",strtotime($date)));
		$condition[$typeName]=array(between,array($start_time,$end_time));

	 	$warnFind=M('room_info','','DB_Local')->where($condition)->select();
	 	if ($warnFind) {
	 		for($i=0;$i<count($warnFind);$i++)
	 			$warnFind[$i]['datetime']=$warnFind[$i][$typeName];
	 		echo json_encode($warnFind);
	 	}
	 	else{
	 		echo 0;
	 	}
    }
/////***********查询楼层一天内的平均温湿度信息************///////
 	public function day_floor_average_tem_hum_hour($floor_id,$date){
		$tem_hum_Table=M('room_para','','DB_Local');
		$return_tem_hum_24hour_floor=array();
		$condition['floor_id']=strval($floor_id);
		for($i=0;$i<24;$i++){
			$return['temp']=0.0;$return['humi']=0.0;//中间不能用逗号分开
			$time_i=$i<9?"0".$i:$i;
			$condition['datetime']=$date.' '.$time_i.":00:00";
			$find_info=$tem_hum_Table->where($condition)->select();
			if($find_info){
				for($j=0;$j<count($find_info);$j++){
					$return['temp']+=$find_info[$j]['temp_average'];
					$return['humi']+=$find_info[$j]['humi_average'];
				}
				$return['temp']=round($return['temp']/count($find_info),2);
				$return['humi']=round($return['humi']/count($find_info),2);
				$return['time']=$time_i.":00";
				array_push($return_tem_hum_24hour_floor,$return);
			}
		}
		return $return_tem_hum_24hour_floor;
	}
/**************返回历史信息到界面***返回每层楼的****************/
	public function send_history_web()//返回每层楼的24个数据点，每个数据点包含温度，湿度，时间
	{
		$floors_info=array();$floor_count=8;

		// $_POST['his_date']=56;
		$date=date("Y-m-d",strtotime("-".$_POST['his_date']." day"));
		//$date="2017-09-25";
		for($i=0;$i<$floor_count;$i++){
			$one_info=self::day_floor_average_tem_hum_hour($i,$date);
			if($one_info)////如果为空，则不往回传
				array_push($floors_info,$one_info);
		}
		if(count($floors_info)!=0)
			echo json_encode($floors_info);

	}
/****************存储配置信息到数据库**************/
	public function get_SetInfo_DB()
	{
		$roomInfoTable=M('room_info','','DB_Local');
		$condition['room_id']=strval($_POST['room_id']);
		$condition['floor_id']=strval($_POST['floor_id']);

		$toRMIFbase['tem_high_threshold']=$_POST['tempMax'];
		$toRMIFbase['tem_low_threshold']=$_POST['tempMin'];
		$toRMIFbase['hum_high_threshold']=$_POST['humiMax'];
		$toRMIFbase['hum_low_threshold']=$_POST['humiMin'];

		if ($_POST['room_id']=='all') {
			$allRooms=$roomInfoTable->select();
			for($i=0;$i<count($allRooms);$i++){
				$condition['room_id']=$allRooms[$i]['room_id'];
				$ifSuccess=$roomInfoTable->where($condition)->save($toRMIFbase);
			}
		}
		if ($_POST['room_id']!='all') {
			$ifSuccess=$roomInfoTable->where($condition)->save($toRMIFbase);
		}
		if($ifSuccess){
			echo "1";
		}	
	}
	public function adminInfoToWeb()
	{
		$adminTable=M('contact','','DB_Local');
		$adminInfo=$adminTable->select();
		if($adminInfo){
			echo json_encode($adminInfo);
		}
		else{
			echo 0;
		}
	}
	public function postAdminInfo()
	{
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
	public function delAdminInfo()
	{
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
