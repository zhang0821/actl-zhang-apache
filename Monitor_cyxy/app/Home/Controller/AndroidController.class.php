<?php
namespace Home\Controller;
use Think\Controller;
session_start();
class AndroidController extends Controller {

 public function AndroidLoginJudge_test(){
			$UserTable=M('contact','','DB_Local');
			$condition['name'] = $_GET['username'];

			$UserInfo=$UserTable->where($condition)->find();

			if($UserInfo){
				if($UserInfo['password']==$_GET['password']){
					$data['login']=2;//登录成功
				}
				else{
					$data['login']=1;//用户名与密码不匹配
				}
			}

			else{
				$data['login']=0;    //用户名不存在
			}
$return['name']=$_GET['username'];
$return['password']=$_GET['password'];
echo json_encode($return,JSON_UNESCAPED_UNICODE);
			//echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }





	//用户登录
    public function AndroidLoginJudge(){
		//if($_SERVER['REQUEST_METHOD']=="POST"){
			$UserTable=M('contact','','DB_Local');
			$condition['name'] = $_POST['username'];

			$UserInfo=$UserTable->where($condition)->find();

			if($UserInfo){
				if($UserInfo['password']==$_POST['password']){
					$data['login']=2;//登录成功
				}
				else{
					$data['login']=1;//用户名与密码不匹配
				}
			}

			else{
				$data['login']=0;    //用户名不存在
			}
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		//}
    }
	//先查看该系统涵盖了哪些楼层
    public function all_floor_count(){
    	//select floor_id from product where name in (select name from product group by name having COUNT(*)>1
	$condition_floor_cy['floor_id'] = array('LT','7');
    	$floor_names =M('room_info','','DB_Local')->distinct(true)->where($condition_floor_cy)->field('floor_id')->select();
    	$data_return['data']=$floor_names;
    	echo json_encode($data_return);//返回有哪些楼层的数据
    }

	//房间名字映射
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
		return '驿站-1';
	}
	else if($room_id=='yz6'){
		return '驿站-2';
	}
	else if($room_id=='dating'){
		return '一楼大厅';
	}
	else{
		return strtoupper($room_id);
	}
}



//按类型
public function new_info_type(){
		$floor_name_list=['F1','F2','F3','F4','F5','F6','YZ ','phy'];
		$return_SsInfo=array();
		$if_ask_all=$_POST['askALL'];
		if($if_ask_all=="all"){
			$condition_floor_cy['floor_id'] = array('LT','7');
			$rooms_info=M('room_info','','DB_Local')->where($condition_floor_cy)->order('floor_id asc')->select();
		}else{
			$condition_f['floor_id']=$_POST['askALL'];
			$rooms_info=M('room_info','','DB_Local')->where($condition_f)->select();
		}
		if($rooms_info){
			for($i=0;$i<count($rooms_info);$i++){
				$return_SsInfo[$i]['floor_id']=$floor_name_list[$rooms_info[$i]['floor_id']];
				$return_SsInfo[$i]['room_id']=self::roomName_map($rooms_info[$i]['room_id']);
				$return_SsInfo[$i]['temp_value']=0;
				$return_SsInfo[$i]['humi_value']=0;
				$return_SsInfo[$i]['door']="--";
				$return_SsInfo[$i]['smoke']="--";
				
				$condition_1['floor_id']=$rooms_info[$i]['floor_id'];
				$condition_1['room_id']=$rooms_info[$i]['room_id'];
				$condition_1['type']=$_POST['type'];
				$SsInfo=M('room_sensor','','DB_Local')->where($condition_1)->select();//找出该楼该房间的所有节点
				$tem_hum_count=0;
				for ($j=0; $j <count($SsInfo); $j++) {
						$condition['dev_eui']=$SsInfo[$j]['dev_eui'];//eui是唯一标识
						if($SsInfo[$j]['type']=='tem_hum'){
							$result_find=M('tem_hum_para','','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
							$return_SsInfo[$i]['temp_value']+=$result_find['temp_value'];
							$return_SsInfo[$i]['humi_value']+=$result_find['humi_value'];
							$tem_hum_count++;
						}
						if($SsInfo[$j]['type']=='smoke'){
							$result_find=M('smoke_para','','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
							if($result_find){	
								if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$result_find['datetime'],20))
								{
									$return_SsInfo[$i]['smoke']="离线";
								}
								else{
									if($result_find['smoke_status']==1)
									{
										$return_SsInfo[$i]['smoke']="正常";
									}
									else{
										$return_SsInfo[$i]['smoke']="报警";
									}
								}
							}
							
						}
						if($SsInfo[$j]['type']=='door'){
							$result_find=M('door_para','','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
							if($result_find){
								if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$result_find['datetime'],20))
								{
									$return_SsInfo[$i]['door']="离线";
								}
								else{
									if($result_find['door_status']==1)
									{
										$return_SsInfo[$i]['door']="关";
									}
									else{
										$return_SsInfo[$i]['door']="开";
									}
								}
							}
						}							
				}
				if($tem_hum_count==0)
				{
					$return_SsInfo[$i]['temp_value']="--";
					$return_SsInfo[$i]['humi_value']="--";
				}
				else{
					$return_SsInfo[$i]['temp_value']=strval(round($return_SsInfo[$i]['temp_value']/$tem_hum_count,2));
					$return_SsInfo[$i]['humi_value']=strval(round($return_SsInfo[$i]['humi_value']/$tem_hum_count,2));
				}
				
			}
			
			$all_info['data']=$return_SsInfo;
		}
		else{
			$all_info['data']=0;
		}
		
		echo json_encode($all_info,JSON_UNESCAPED_UNICODE);
	}


	
	//用户请求最新各房间节点信息
	public function all_newest_info(){
		$floor_name_list=['F1','F2','F3','F4','F5','F6','YZ ','phy'];
		$return_SsInfo=array();
		$if_ask_all=$_POST['askALL'];
		if($if_ask_all=="all"){
$condition_floor_cy['floor_id'] = array('LT','7');
		//$rooms_info=M('room_info','','DB_Local')->where($condition_floor_cy)->select();

			$rooms_info=M('room_info','','DB_Local')->where($condition_floor_cy)->order('floor_id asc')->select();
		}else{
			$condition_f['floor_id']=$_POST['askALL'];
			$rooms_info=M('room_info','','DB_Local')->where($condition_f)->select();
		}
		if($rooms_info){
			for($i=0;$i<count($rooms_info);$i++){
				$return_SsInfo[$i]['floor_id']=$floor_name_list[$rooms_info[$i]['floor_id']];
				$return_SsInfo[$i]['room_id']=self::roomName_map($rooms_info[$i]['room_id']);
				$return_SsInfo[$i]['temp_value']=0;
				$return_SsInfo[$i]['humi_value']=0;
				$return_SsInfo[$i]['door']="--";
				$return_SsInfo[$i]['smoke']="--";
				
				$condition_1['floor_id']=$rooms_info[$i]['floor_id'];
				$condition_1['room_id']=$rooms_info[$i]['room_id'];
				$SsInfo=M('room_sensor','','DB_Local')->where($condition_1)->select();//找出该楼该房间的所有节点
				$tem_hum_count=0;
				for ($j=0; $j <count($SsInfo); $j++) {
						$condition['dev_eui']=$SsInfo[$j]['dev_eui'];//eui是唯一标识
						if($SsInfo[$j]['type']=='tem_hum'){
							$result_find=M('tem_hum_para','','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
							$return_SsInfo[$i]['temp_value']+=$result_find['temp_value'];
							$return_SsInfo[$i]['humi_value']+=$result_find['humi_value'];
							$tem_hum_count++;
						}
						if($SsInfo[$j]['type']=='smoke'){
							$result_find=M('smoke_para','','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
							if($result_find){	
								if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$result_find['datetime'],20))
								{
									$return_SsInfo[$i]['smoke']="离线";
								}
								else{
									if($result_find['smoke_status']==1)
									{
										$return_SsInfo[$i]['smoke']="正常";
									}
									else{
										$return_SsInfo[$i]['smoke']="报警";
									}
								}
							}
							
						}
						if($SsInfo[$j]['type']=='door'){
							$result_find=M('door_para','','DB_Local')->where($condition)->order('datetime desc')->limit(1)->find();
							if($result_find){
								if(D('Alarm')->DifferentDateTime(date("Y-m-d H:i:s"),$result_find['datetime'],20))
								{
									$return_SsInfo[$i]['door']="离线";
								}
								else{
									if($result_find['door_status']==1)
									{
										$return_SsInfo[$i]['door']="关";
									}
									else{
										$return_SsInfo[$i]['door']="开";
									}
								}
							}
						}							
				}
				if($tem_hum_count==0)
				{
					$return_SsInfo[$i]['temp_value']="--";
					$return_SsInfo[$i]['humi_value']="--";
				}
				else{
					$return_SsInfo[$i]['temp_value']=strval(round($return_SsInfo[$i]['temp_value']/$tem_hum_count,2));
					$return_SsInfo[$i]['humi_value']=strval(round($return_SsInfo[$i]['humi_value']/$tem_hum_count,2));
				}
				
			}
			
			$all_info['data']=$return_SsInfo;
		}
		else{
			$all_info['data']=0;
		}
		
		echo json_encode($all_info,JSON_UNESCAPED_UNICODE);
	}
    
	//用户发布消息
	public function notifyInfo(){
    	$file_address="/home/actl/actl/zhangl/HTTP/notifyFile.txt";
    	$notifyText;
    	$allNotifyText;
    	if ($fp=fopen($file_address,'r')) {
			$startTime = microtime ();
			do {
				$canRead = flock ($fp, LOCK_EX );
				if (! $canRead)
					usleep ( round ( rand ( 0, 100 ) * 1000 ) );
			} 
			while ( (! $canRead) && ((microtime () - $startTime) < 1000) );
			if ($canRead) {
				$fp=fopen($file_address,'r');//要清除之前的内容，用w+
				$allNotifyText=fread($fp,filesize($file_address));
			
				$notifyText=explode('#&',$allNotifyText,-1);//按分号分离字符串到数组中
				// echo count($notifyText);
				fclose($fp);
			}
		}
		$j=count($notifyText);
		$k=$j-1;// array_push($notifyText,"12");
     	for($i=0;$i<($j-1);$i++){
     		$note['data'][$i]['note']=$notifyText[$k];
     		$k--;
     	}
     	echo json_encode($note,JSON_UNESCAPED_UNICODE);
    }
	public function notifyInfoSec(){
		$file_address="/home/actl/actl/zhangl/HTTP/notifyFile.txt";
		// $recieve=$_POST['noteInfo'];
		$recieve=$_POST['noteInfo'];
	    $info['data']=0;
	    if ($fp=fopen($file_address,'a+')) {
			$startTime = microtime ();
			do {
				$canWrite = flock ( $fp, LOCK_EX );
				if (! $canWrite)
					usleep ( round ( rand ( 0, 100 ) * 1000 ) );
			} 
			while ( (! $canWrite) && ((microtime () - $startTime) < 1000) );
			if ($canWrite) {
				$out_put_string=$recieve."/发布时间:".date("Y-m-d H:i")."#&";
				$fp=fopen($file_address,'a+');//要清除之前的内容，用w+
				fwrite($fp,$out_put_string,strlen($out_put_string)); 
				flock($fp,LOCK_UN);   
				fclose($fp);
			    $info['data']=1;
			}
		}
	   echo json_encode($info);
	}
       

	 //用户修改信息
     public function AndroidModifyUserInfo(){
	     	$condition['name']=$_POST['username'];		
			
			$newInfo['tel']=$_POST['telephone'];
			$newInfo['email']=$_POST['email'];
			$newInfo['password']=$_POST['newPassword'];
			if(M('contact','','DB_Local')->where($condition)->save($newInfo))
			{
				$returnInfo['data']=1;
			}
			else{
				$returnInfo['data']=0;
			}
		echo json_encode($returnInfo,JSON_UNESCAPED_UNICODE);
     }
	
	
	//用户配置阈值,判断输入是否为空，以及用户权限，再存入数组
	public function app_set_threshold()
	 {
		 $condition['name']=$_POST['username'];

		 $condition_room['room_id']=$_POST['room_id'];
		 $setInfo['tem_high_threshold']=floatval($_POST['tempMax']);
		 $setInfo['tem_low_threshold']=floatval($_POST['tempMin']);
		 $setInfo['hum_high_threshold']=floatval($_POST['humiMax']);
		 $setInfo['hum_low_threshold']=floatval($_POST['humiMin']);
		 $ifSetALL=$_POST['ifALL'];
		 // $setInfo['ifSetALL']=$_POST['ifALL'];

		if($ifSetALL=="1")//配置到所有房间
		{
			 if(M('room_info','','DB_Local')->save($setInfo))
			 {
				 $returnData['data']=1;
			 }
			 else{
				 $returnData['data']=2;
			 }
				 
		}else{
			if(M('room_info','','DB_Local')->where($condition_room)->limit(1)->find())
			 {
				 if(M('room_info','','DB_Local')->where($condition_room)->save($setInfo))
				 {
					 $returnData['data']=1;//配置成功
				 }
				 else{
					 $returnData['data']=2;//配置失败
				 }
			 }else{
				 $returnData['data']=0;//该房间不存在
			 }
		}

		 echo json_encode($returnData,JSON_UNESCAPED_UNICODE);
	 }

	 //新增用户
	public function add_new_user(){
		$condition['name']=$_POST['name'];
		if(M('contact','','DB_Local')->where($condition)->limit(1)->find())
		{
			$returnData['data']=0;//用户已存在
		}else{
		$setInfo['name']=$_POST['name'];
		$setInfo['tel']=$_POST['tel'];
		$setInfo['email']=$_POST['email'];
		$setInfo['password']=$_POST['password'];		
		if(M('contact','','DB_Local')->add($setInfo))
		{
			$returnInfo['data']=2;//新增成功
		}
		else{
			$returnInfo['data']=1;//新增失败
		}}
		echo json_encode($returnInfo,JSON_UNESCAPED_UNICODE);
	}
}

?>