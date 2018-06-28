<?php 

function connect_db()
{
	$handle=mysql_connect("localhost",'root','zhang');
	mysql_query("set names 'utf8'");
	mysql_select_db("lora_monitor");
	return $handle;
}
/**
* 数据库各相关操作函数
*/
class dataBase 
{
	
	function __construct()
	{
		$this->handle=connect_database();
	}
	function __destruct()
	{
		mysql_close($this->handle);
	}
	function abnorInfo($type)
	{
		$table="smoke_para";
		$status="smoke_status";
		 $sql="select datatime from smoke_para where status=0 order by id desc limit 1";
		// $sql="select datatime from ".$type."_para where ".$type."_status=0 order by id desc limit 1";
		 // $sql="select datatime from {$table} where {$status}=0 order by id desc limit 1";
		 return mysql_query($sql,$this->handle);

	}
}

 ?>