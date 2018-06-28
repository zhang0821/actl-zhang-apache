<?php

$GLOBALS['type']=['tem_hum','电压','电流','water','door','smoke','电池电压'];
$GLOBALS['typeChose']='10121314151617';
$GLOBALS['u16temp'];
$GLOBALS['u16hum'];


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
  function abnorInfo()
  {
    $table="smoke_para";
    $status="smoke_status";
     $sql="select datatime from smoke_para where status=0 order by id desc limit 1";
    // $sql="select datatime from ".$type."_para where ".$type."_status=0 order by id desc limit 1";
     // $sql="select datatime from {$table} where {$status}=0 order by id desc limit 1";
     return mysql_query($sql,$this->handle);

  }
}



function SHT2x_CalcTemperatureC($u16sT)
{
  $u16sT &=~0x0003; // clear bits [1..0] (status bits)
  $GLOBALS['u16temp']=$u16sT;
  $temperatureC= -46.85 + 175.72/65536 *($u16sT); //T= -46.85 + 175.72 * ST/2^16
  $temperatureC=floor($temperatureC*100)/100;
  return $temperatureC;
}

/*湿度换算 %RH*/
function SHT2x_CalcRH($u16sRH)
{
  $u16sRH &= ~0x0003; // clear bits [1..0] (status bits) 
  $GLOBALS['u16hum']=$u16sRH;
  $humidityRH = -6.0 + 125.0/65536 * ($u16sRH); // RH= -6 + 125 * SRH/2^16
  $humidityRH=floor($humidityRH*100)/100;
  return $humidityRH;
}

function strToHex($string)//字符串转十六进制
{ 
  $hex="";
  for($i=0;$i<strlen($string);$i++)
    $hex.=bin2hex(ord($string[$i]));
  $hex=strtoupper($hex);
  return $hex;
} 

function connect_postgre()
{
 $conn_str="host=10.149.65.205 port=5432 dbname=loraserver user=loraserver password=dbpassword";
 $handle=pg_connect($conn_str);
 return $handle;
}

class DB_postgres
{
  var $handle;

   function __construct()
   {
     $this->handle=connect_postgre();
   }

   function __destruct()
   {
   	pg_close($this->handle);
   }

//取出所有在线用户信息
   function query_online_users()
   {
    return pg_query('select * from onlineuser',$this->handle);
   }
//在在历史表中获取所有用户历史信息
   function query_users_hisInfo($date)
   {
     $sql='select * from user where user.time='.$date;
     return pg_query($sql,$this->handle);
   }
//在用户信息表中根据用户名取出用户信息
   function query_user_by_name($name)
   {
     $sql="select * from user where user.name='".$name."' limit 1";
     return pg_query($sql,$this->handle); //使用mysql_query()函数执行SQL语句
   }


}


 ?>