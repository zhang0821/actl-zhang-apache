<?php 
namespace Home\Controller;
use Think\Controller;
class PgsqlController extends Controller {

	public function pgDataToMysql(){
		$table=M('got_data','','DB_LoRaWan');		
		//按类型去取数据，每种类型依次取出一个日期最近的
		$handle=$table->order('datanum desc')->limit(4)->select();
		if($handle){
			$RoomSensorTable=M('room_sensor','','DB_Local');

			for($i=0;$i<count($handle);$i++){
				$data=substr($handle[$i]['data'],2);
				$EUI=substr($handle[$i]['dev_eui'],2);
				$dataPre=substr($data,0,2);
				
				if($dataPre=='a5'){
					$conditionFindRoom['dev_eui']=$EUI;
					$RoomSensorInfo=$RoomSensorTable->where($conditionFindRoom)->limit(1)->find();//找出节点的房间号
					$infoToSensor['room_id']=$RoomSensorInfo['room_id'];
					$infoToSensor['datetime']=$handle[$i]['time'];

					//对应到表
					$type=substr($data,2,2);
					$pos=strpos($GLOBALS['typeChose'],$type)/2;
					$typeTable=$GLOBALS['type'][$pos];
					//计算数据值
					$len=substr($data,5,1);
					if($len==1){//门禁水浸烟雾状态
						$infoToSensor[$typeTable.'_status']=substr($data,7,1);
					}
					if($len==5){//温湿度值
						$symbol=substr($data,7,1);

						$tempint=substr($data,8,2);
						$tempfloat=substr($data,10,2);
						$humiint=substr($data,12,2);
						$humifloat=substr($data,14,2);

						$tempValue=hexdec($tempint)+hexdec($tempfloat)*0.01;
						$humiValue=hexdec($humiint)+hexdec($humifloat)*0.01;
						if($symbol=="0"){
							$tempValue=-$tempValue;
						}
						$infoToSensor['temp_value']=$tempValue;
						$infoToSensor['humi_value']=$humiValue;		
					}
					M($typeTable.'_para','','DB_Local')->add($infoToSensor);
					unset($infoToSensor);	
				}	
			}
		}
	}



}


// function pgDataToMysql(){
// 		$table=M('got_data','','DB_LoRaWan');		
// 		$handle=$table->order('datanum desc')->limit(4)->select();
// 		if($handle){
// 			$RoomSensorTable=M('room_sensor','','DB_Local');	
// 			for($i=0;$i<count($handle);$i++){
// 				$data=substr($handle[$i]['data'],2);
// 				$EUI=substr($handle[$i]['dev_eui'],2);
// 				$dataPre=substr($data,0,2);
// 				if($dataPre=='a5'){
// 					$conditionFindRoom['dev_eui']=$EUI;
// 					$RoomSensorInfo=$RoomSensorTable->where($conditionFindRoom)->limit(1)->find();//找出节点的房间号

// // $nickname = $User->where('id=3')->getField('nickname');// 获取ID为3的用户的昵称
// 					$infoToSensor['room_id']=$RoomSensorInfo['room_id'];
// 					// $infoToSensor['rssi']=$handle[$i]['rssi'];
// 					$infoToSensor['datetime']=$handle[$i]['time'];

// 					// $return[$i]['time']=$handle[$i]['time'];
// 					// $return[$i]['data']=$data;
// 					// $return[$i]['room']=$infoToSensor['room_id'];
// 					//对应到表
// 					$type=substr($data,2,2);
// 					$pos=strpos($GLOBALS['typeChose'],$type)/2;
// 					$typeTable=$GLOBALS['type'][$pos];
// 					//计算数据值
// 					$len=substr($data,5,1);
// 					if($len==1){//门禁水浸烟雾状态
// 						$infoToSensor[$typeTable.'_status']=substr($data,7,1);
// 						// $return[$i]['pos']=$typeTable.'_status';
// 					}
// 					if($len==5){//温湿度值
// 						$symbol=substr($data,7,1);

// 						$tempint=substr($data,8,2);
// 						$tempfloat=substr($data,10,2);
// 						$humiint=substr($data,12,2);
// 						$humifloat=substr($data,14,2);

// 						$tempValue=hexdec($tempint)+hexdec($tempfloat)*0.01;
// 						$humiValue=hexdec($humiint)+hexdec($humifloat)*0.01;
// 						if($symbol=="0"){
// 							$tempValue=-$tempValue;
// 						}
// 						$infoToSensor['temp_value']=$tempValue;
// 						$infoToSensor['humi_value']=$humiValue;
							
// 					}
// 					M($typeTable.'_para','','DB_Local')->add($infoToSensor);
// 					unset($infoToSensor);	
// 				}	
				
// 			}
// 			echo json_encode($return);
// 		}
// 		else{
// 			echo "0";
// 		}
// 	}

?>


