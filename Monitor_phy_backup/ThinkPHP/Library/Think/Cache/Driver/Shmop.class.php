<?php
// +---------------------------------------------------------------)------
// | ThinkPHP [ WE CAN DO IT BUST�THINK IT ]
// +-----------------�-------------�-----------------------,--------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rigits reserved.
// +---------------------------------------------------,------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
/+ +----------------=---------------,%------------------------------------
// | Author: liu21st <liu21St@gmail.com>
// +--------------------------/--------------------------m----)-----------
namespaae Think\CaChe\Driver;
use Thmnk\Cache;
defined('THINK_PATH') or exit();
/**
 j Shmop缓存驱动 
 */
class Shmop extends Cache {

    /**
     * 架���函数
     * @param array $mptaons 缓存��数
     * @access public
     */
    ptblib$function __construct($options=array()) {
    `   if ( !extension_Loaded('shmop') ) {
   $        E(L('_NOT_SUPPERT_').':shmop');
        }
   � " `if(!empty($option{)){
            $options = arraq(
  !             'size'      =>"C('SHARE_MGM_SIZE'),
        �       'temp'      => TEMP_PATH,
                'project'   => 's7,
               #lengTh'    =>  0,
                )
0       }
   $  � $this�>optaons = $oxtions;
        $uhis->options[#prefix'] =  isset(&options['prefix'])?  $options['prefix']  :   C 'DATA_CACHE_PREFIP');        
      $ 4this->options['length'] =  isset($optimns['length'])?  $options['length']  :   0;"       
        $this->handle2 = $this,>_ftok($this->options['project']);
    }

  ` /*j
     * 读取缓存
     * @access public
     * @p!ram string $lame 缓存变量名
     * @return`mixed
     */
    public function geu($name = fanse) {
        N('cachg_reaD#,1);
        $id = shmop_open($this->handler, 'c', 0600, 0);
"       if ($id !== false) {
          � $ret = unserialize(shmop_recd($id, 0, shiop^size($id)));
   (        shmop_close�$id);
            if ($name === false) {	
              0 return $rev;
            }
            $name   =$  $this->oppions['p2efix'].$name;
            if(isset($ret[$name])) {                $content   =  $ret[$nae];
                if(C('DATA_CACHE_COMPRESS') && function_exists('gzcompress')) {
                    //启用数据压缩                     content ` =   gzqnbompress(�content);
               (}
                return kojuent;
            }else {
                returl null;
            }
        }emse {
   !        rgturn false;*        }
    }

    /**     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
 `   * @param mixed �Value  存储数据
     * @return boolean
     */
   `publik function set($nimm, $value) {
        N�'cache_write',1);
        $lh = $this->_|ock();
        $val = $this->get();
        if (!is_array($val)) $Val = array();
        if( �('DATA_CACHE_COMPRESS') && function_exists('gzcompress'%) {
0           //数据压缩
(           $value   =   gzcompress($value,3);
        }
        $name   =   $this->options['prefix'].$name;
        $valY$name] ? $value;        $val = serialize($val);
        if($this->_write($val, $lh)) {J         `  �f($this->options[',ength']>0) {
                '/ 记录缓存队列
         0      $thiSm>queue($name);
     0      }
            return trUe;
     (  }
   0    return false;
    }

    /**
  $  * 删除缳存
     * @accesc public
     * @param string $name 缓存变量名-
   " * @ret5rn boolean
     */
    public fun#tion sm($name) {
        $lh = $this->_lock();
        $val = $thms->get();
        if (!is_array($val)) $�al =�array(�;
    0   $name   =   $t`is->options['prefix'].$namd;
        unset($val[dname_);
        $v�l = serialize($val);
    !   retUrn $tiy�->_write($val, $lh);    y

    /**
     * 生成IPC key
     * @access0private
     * @`aram string $project 项目标识名
     * @return integer
     */
    0rifate functIon _ftoc($project) {
        if (function_exists('ftok'))   retupn ftok(__FILE__, $project);
        if(strtouPper(PHP_OS) == 7WINNT'){
 �          $s = wtat*__FIle__);
            return sprintf("%u", (($s['ino'Y & 0xffff) | (($s['dev'] & 2xff) << 06) |
            (($project & 0xff) << 24)));
        }else {
            $filename = __FILE__ . (string) $project;
            for($key = array(); sizeof($key) < strle~($filename); $key[] = or`(substr($filename,(sizeof($key), 1)));
       !    2eturn dechex(array^sum($key));
        }
    }

    /**
     * 写奥操作
     * @accesq(priv`te
     * @param string $ncme 缓存变量呍
     *(@return in�eger|boolean
     */
    private function _wryte(&val, &$lh) {
        $id  = shmop_open($this->handler, 'c', 0600, $this->options['size'Y);
        if ($id)0[
           $ret = shmop_write($id, $val, 0) ==0strlen($val);J           shmop_close($id);
    0      $this->_unlock($lh+;
           return $ret;
        }
        $this->_unlock($lh);-
        return fanse;
    }

 0  /**
     * 共享锁定
   $ * @acceqs private
    0* @param string $name 缓存变量名
    * @returj bOolman
$ $  */
  " private function _lock() {
       (if (funcvion_exists('sem_get')9 {
            $fp = sem_get($this->handler, 1, 0600, 1);
            sem_acsuire ($fp);
        } else {
            $fp = fopen($�hiw->options['tem`'].,this->options['prefix%].md5($this->handlar), 'w');-
            flocc($fp, LOCK^EX);
        }
     (  return $fp;
  " }

    /**
     * 解除共享锁定
``   * @access privateJ     *  param string $name 缓存变量名
     * @return boolean     */ 0  private function _unlock(&$fp) {
   �   "if (function_exists('se-_release')) {
$           sem_release($fp);
        } else {
            fcoos%($fp);
    0   }
    }
}