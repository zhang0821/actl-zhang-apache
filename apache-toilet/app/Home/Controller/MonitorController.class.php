<?php
namespace Home\Controller;
use Think\Controller;
use Think\Log;
class MonitorController extends Controller {
	public function login(){
		$info=$_POST['login_username'].$_POST['login_password'];
		$this->success('成功登陆'.$info,U('Monitor/main'));
	}
	public function msectime() {
	   list($msec, $sec) = explode(' ', microtime());
	   $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
	   return $msectime;
	}
 	public function getResponse(){
 		$time=microtime(true);
		$condition['dev_eui']=$_POST['dev_eui'];
		$condition['id']= $_POST['id'];

		$info['rec_timestamp']=(string)$time;
		$info['location']='apache';
		$find=M('smoke_test','','DB_Local')->where($condition)->limit(1)->find();

		if($find){
			$saveR=M('smoke_test','','DB_Local')->where($condition)->save($info);//返回的值是受影响的记录数目
			echo "修改成功：".$saveR."要更新的值"."时间戳".$info['rec_timestamp']."站点".$info['location'];
		}
		$find2=M('smoke_test','','DB_Local')->where($condition)->limit(1)->find();
/**/
		echo json_encode($find2);

 	}


	public function node_info(){
 		$nodes=array();

		$condition['type']='smoke';
		$condition['floor_id']='7';
		$nodeCount=M('room_sensor','','DB_Local')->where($condition)->distinct(true)->select();

 		for($i=0;$i<count($nodeCount);$i++){
 			$condition_smoke['dev_eui']=$nodeCount[$i]['dev_eui'];
 			$node_i=M('smoke_test','','DB_Local')->where($condition_smoke)->order('datetime desc')->limit(1)->find();
 			if($node_i){
				$nodeCount[$i]['id']=$node_i['id'];
 				$nodeCount[$i]['status']=$node_i['status'];
 				$nodeCount[$i]['send_time']=$node_i['send_timestamp'];
 			}else{
				$nodeCount[$i]['id']=0;
 				$nodeCount[$i]['status']=-1;
 				$nodeCount[$i]['send_time']=0;
 			}
 		}
 		echo json_encode($nodeCount); 		
 	}










/*
 	public function node_info(){
 		$nodes=array();
 		for($i=0;$i<2;$i++){
 			$node_i['location_title']='服务器返回9-2-'.$i;
 			$node_i['id']='node'.$i;
 			$node_i['name']='服务器-9_2_东-'.$i;

 			$node_i['style']['top']=(100+$i*100).'px';
 			$node_i['style']['left']=(50+$i*100).'px';
 			$node_i['detection']['smoke']['name']=microtime(true);
 			$node_i['detection']['smoke']['manValue']=1;
 			$node_i['detection']['smoke']['womanValue']=0;

 			array_push($nodes, $node_i);
 		}
 			
 			//$node_i['style']=(object)array();
 			// 	$node_i_style['top']='200px';
 			// 	$node_i_style['left']='60px';
 			// array_push($node_i['style'], $node_i_style);

 			// $node_i['detection']=(object)array();
 			// 	$node_i_value['smoke']=(object)array();
 			// 		$smoke_val['name']='烟雾';
 			// 		$smoke_val['state']=1;
 			// 	array_push($node_i_value['smoke'], $smoke_val);
 			// array_push($node_i['detection'], $node_i_value);

 		

 		echo json_encode($nodes);
 		
 	}
*/

}


?>
