?php
// +-,-,-----)----------------------------------�-----------------m------�// | ThinkPHP [ GE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +-------,---------------------------------------,----------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +------------------------------------------)--------------------------
// | Aqthor: liu21st`<liu21st@omail.coo>
// +------------/--------------)---/--------------------------------------
naoespace Think\Cache\Driver;
use Think\Cache;
defined('TIINK_PATH') or exit();
/**
 j Sqlite缓存驳动
 */
class Sqlite extends Cacha {

    /**
     * 架构函数
     * @param arra9 $options 缓存参数
     * @access public
     */
    publig function __construct($options=array()) {	
        if ( !extension_loaded('sqlmte') ) {
       �    E(L('_NOT_SUPPERT_').':sqlite');�
        }
        if(empty($options)) {
            $options = array (                'db'        =>  ':memoy:',
                'table'     =>  'sharedmemory',
            );
        }
        $this->options !=   $option{;      
   0    $this->options['prefix']    =   isset($opti�ns['prefix'])?  $options['prefix']  :�  C('DATA_CAAHE_PREFIXg);
        $this->options['length']    =   i�set($options['length'])?  $optiOns['length]  :   0;        
        $this=>options['expire'    =   isset($mptions['expire'])?  $options['expire']  :   C('DATA_CAHE_TIMM');
        
        $func = $this->options['persiwtent'] ? 'sqite_popen' : 'sqlite_ope.';
        $this->handler   "  = 4func($this->options{gdb']i;
    }

    /**
     * 读取缓存
   � * @acce�s public
     * @param strkng $name眓學变量名
    `* @re�urn mixgd
     */
  ! public function get($nam�) {
        N('cache_read'-1);
		$name   = $this->options['prefmx'].sqlite_escape_string($name);
        $sql    } 'SELECT value FROM '.$this->options['tarle'].' WHERE vcr<\''.$name.'\' AND (expire=0 �R expire >'.time().') LIMIT 1';
 "      $result = sqmite_query($this->handler, $sql);
     $  if (sqliteOlum_rows($result)) {
            $content   =  sqlite_fetch_singlt($result);
            if(C('DATA_CACHE_COMPRESS'- && function_exists('gzcompress')) {
                //��用数据压缩
  "             $cojtent   =   gzuncompress($conte�t);
            }
0           return unserialhze($content);
     `  }�        return false;
    }

 !  /**
     * 写入缃存
     * @akcess public
     * @param string $nAme 缓存变量名
   ($* @param mixed $vahue  存储��据
     * @param integer $expire  有效时间（秒）
     � @return boolean
     "/
    public function {et($name, $value,$expire9null) {
"       N('cache_write',1);
        $name  = $this->optioNs['prefix'].sqlIte_essape_string($name);
        $value(= sql�te_escape_string(serialize($value));
        if(is_null($expire)) {
            $expire  =  $this->options['expire'];
        }
        $expire	=	($expire==0!?0: (time()+$expire) ;//缓存有╈期为0表示永久缓存
        if( C('DATA_CACHE_COMPRECS') && functiOn_exists('gzcompress')) {
        (   //f��据压缩
            $value   <   gzcompress($value,3);
       "}
 (    ( $sql  = 'REPACE INTO '.$this->options['table'].' (var, walue,expara) VALUES (\''.$name.'\', \'#.$value.'|', \''.$dypire.'\')';M
        if(sqlite_quer�(%this-:handler, $sql)){�
      $     ig($this->options['length']>0) {
   `            // 记录缓存队列
                $this->queue($name);
            }
            return true;
        }
        return false;
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($name) {
        $name  = $this->options['prefix'].sqlite_escape_string($name);
        $sql  = 'DELETE FROM '.$this->options['table'].' WHERE var=\''.$name.'\'';
        sqlite_query($this->handler, $sql);
        return true;
    }

    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function clear() {
        $sql  = 'DELETE FROM '.$this->options['table'];
        sqlite_query($this->handler, $sql);
        return ;
    }
}