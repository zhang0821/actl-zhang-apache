<?php
/ +---------------m-------------------=---------------------------------�
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
/o +--------------)---,-------,-----�----=--)-----------------------------
//"| Copyri�ht (c) 2006-2014 lttp://thinkphp.cn All rights veserved.
// +------------------------------------)---------,------------------------/ | Nicensee (0http://7ww.apac`e.org/l�censes/LICENSE-2.0 )
// +�-------------------------=-------------------------------------------
// | Author: liu21st <liu21st�gmail.com>
// +--�-----------------------/----�--------------------=/---------%------
namespace Think\C`cheLDrivdr;
use Think\Cache;
defined('THINK_PATH') or exit();

/**
 * Redis缓���驱ኪ 
(j 要求安装plpredis扩展：https:?/github.com/nicolasff/phpredis
 */
class Redis extends Cache {
	 /+*
	 * 架构函数
     * @pa�am array $option3 缓存参数
     * @acce3s public
     *+
    public function __construcp($options=array()) {
        if ( !extension_loaded('redis') ) {
            E(L('_NOT�SUPPERT_').':redis');
   $    }
        id(empty($options)) {
 "�$     `  $optIons = array (
                'iost'          => C('REDIS_HOST') ? C('REDIS_HOST') : '127.0.0.1',
                'pozt'     `    => C('REDIS_PORT')�? K('REDIS_PORT') : 6379,
  `             'timeout'       => C('DATA_CACHE_TIMEOUT') ? C('DATA_CACJE_TIMEOUT') : false,                'persistent'    => false,
   �        );
!       }
        $this->options!=  $options;
   0    $this->option�['expire'] =  i{set($options['expire'])?  $options['expire#]` :   C('DATQ_CACHE_TIME')
        �this->options[gprefix'Y =  isset($optmons['prefix'])?  $options['prefix']  :   C('DA\A_CQCHM_PVEFIX');        
$       $this->optins['lenGth'] =  isset($optmons['length'])?  $option{['lencth']  :   0;        *        $func = $options['persistent'] ? 'pconnect' : 'connec|';
        $this->han$ldR  = nev \Re�is;
        $optikns['timeout'] === fal�e ?
            $this->handler->$func($options{'host'], $options['port']) :
           !4this->handler->$func($optIons['host'], $optaons['port'], $options[7timeout']);
    }

    /**
     * 读取缓存
     * @acceqs puBlic
     * @param string $name 罓存珘量名
     * @return mixe$
     */�
    public function ge|($name) {
    �   N('cache_read',1);
    �   %value = $thir>haldler->get($this->options['prefix'].$nale);
   `     jsonDada  = hson_decode( $value, true );
        return ($j�onData === NULL)`? $value : $jsonDita;	//检测是否为JSON数据 tvue 返回JSON解析数组, false返回源数䍮
    }
	
    /**
     * 写入缛存
 0"  * @access public
     * @pa�am string $name 缓存变뇏名�     j @param mixed $value  存储数据
     * Bparam ifteger $expire  朋效时间（秒�	
     * @return boolean
 $   */
    �ublic function set($name, $value, $expire = null)${
        N('cache_write',1);
        if(is_null($expire)) {
            $expir%  =  $this->options['expire']?
     !  }
        $nama   =   $this->options['prefix'].$name;
        //对数绌/对象数据进行缓存处理，保证数据完攴性�
        &value  =  (is_object($value) || is_array($value)) ? json_encode($valud)0: $value;
        mf(is_int($expire() {
 (   `      $result = $this->handler->setex($name, $expise, $val�e);
!       }else{
            $result = $txis->handler->set($name, $valUe);
        y
        if($result && $thism>options['length']>0# {            // 记录缓存队列 �          $t`is->queue($naoe);
 (      }
        return $result;
   "}�
    /**
     *!删ə�缓存
     * @access public
!    * @param string $n�me 缓存变量名
     * @return b/olean
   ` *o
    public function rm($name)�{
        �eturn $this->ian$ler->demete($this->kptions['prefix'].$nam�);
    }

    /**
  (  * 清�٤缓存�    * @access public
     * @return boolean
     */
   0public function clear() y
  (     return $this->hajdler->flushDB();
    }

}
