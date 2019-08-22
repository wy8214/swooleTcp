<?php

if (!function_exists('_get_order_no')) {

  function _get_order_no()
  {
    return  time().substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 6, 13), 1))), 0, 9).rand(10000,20000);
  }
}

/**
 * 扩展array
 */
if (!function_exists('extend')) {

    function extend($config, $default) {
        foreach ($default as $key => $val) {
            if (!isset($config [$key])) {
                $config [$key] = $val;
            } else if (is_array($config [$key])) {
                $config [$key] = extend($config [$key], $val);
            }
        }

        return $config;
    }

}

/**
 * ajax_arr
 */
if (!function_exists('ajax_arr')) {

    function ajax_arr($info, $status = FALSE, $ret = array()) {
        $ret ['info'] = $info;
        $ret ['status'] = $status;
        return $ret;
    }

}

/**
 * 判断str是否用户名
 */
if (!function_exists('is_username')) {

    function is_username($str) {
        $s = trim($str);
        if (strlen($s) < 3 || strlen($s) > 20) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/**
 * 判断str是否网站
 */
if (!function_exists('is_url')) {

    function is_url($str) {
        return filter_var($str, FILTER_VALIDATE_URL);
    }

}

/**
 * 判断str是否email
 */
if (!function_exists('is_email')) {

    function is_email($str) {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

}
if (!function_exists('rmdirs')) {

    function rmdirs($dir) {
        $d = dir($dir);
        while (false !== ($child = $d->read())) {
            if ($child != '.' && $child != '..') {
                if (is_dir($dir . '/' . $child))
                    rmdirs($dir . '/' . $child);
                else
                    unlink($dir . '/' . $child);
            }
        }
        $d->close();
        rmdir($dir);
    }

}
/**
 * 判断str是否phone
 */
if (!function_exists('is_phone')) {

    function is_phone($str) {
        $search = '/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8]))\d{8}$/';
        return preg_match($search, $str);
    }

}

if (!function_exists('site_url')) {

    function site_url($url = '') {
        $base_url = base_url();
        if (strpos($url, "./") == 0) {
            $url = substr($url, 1);
        }
        return str_replace('\\', '', $base_url . $url);
    }

}

if (!function_exists('base_url')) {

    function base_url() {
        return C('BASE_URL');
    }

}

if (!function_exists('delete_file')) {

    function delete_file($filename) {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

}

if (!function_exists('gameover')) {

    function gameover($tips) {
        header('Content-Type:text/html; charset=utf-8');
        exit($tips);
    }

}

if (!function_exists('site_url')) {

    function site_url($url = '') {
        $base_url = C('BASE_URL');

        $ret = str_replace('\\', '', $base_url . $url);
        return str_replace('./', '', $ret);
    }

}

if (!function_exists('base_url')) {

    function base_url() {
        return C('BASE_URL');
    }

}

if (!function_exists('form_options')) {

    function form_options($data, $selected_value = -1) {
        $html = '';
        foreach ($data as $key => $val) {
            $html .= "<option value='$key'>$val</option>";
        }

        if ($selected_value >= 0) {
            $html = str_replace("value='$selected_value'", "value='$selected_value' selected", $html);
        }
        return $html;
    }

}

if (!function_exists('form_options_rows')) {

    function form_options_rows($data, $id = 'id', $text = "name", $selected_value = 0, $dat = array()) {
        $html = '';
        foreach ($data as $row) {
            $value = $row [$id];
            $prefix = '';
            if (isset($row ['level'])) {
                $prefix = $row ['level'] - 1 > 0 ? str_repeat('&nbsp;&nbsp;', $row ['level'] - 1) . '└─ ' : ''; // ┗
            }
            $title = $prefix . $row [$text];
            $d = '';
            foreach ($dat as $p) {
                $d .= sprintf(' data-%s="%s"', $p, $row [$p]);
            }
            $html .= sprintf('<option value="%s"%s>%s</option>', $value, $d, $title);

            if (isset($row ['son'])) {
                $html .= form_options_rows($row ['son'], $id, $text, 0, $row ['level'] + 1);
            }
        }

        if (!empty($selected_value)) {
            $html = str_replace('value="' . $selected_value . '"', 'value="' . $selected_value . '" selected', $html);
        }

        return $html;
    }

}

if (!function_exists('form_options_arr')) {

    function form_options_arr($data) {
        $html = '';
        foreach ($data as $val) {
            $html .= '<option value="' . $val . '">' . $val . '</option>';
        }

        return $html;
    }

}

if (!function_exists('form_radios')) {

    function form_radios($name, $data, $checked_value = 0) {
        $html = '';
        foreach ($data as $key => $val) {
            $html .= '<label class="radio-inline"><input name="' . $name . '" type="radio" value="' . $key . '" >' . $val . '</label>';
        }

        if ($checked_value >= 0) {
            $html = str_replace('value="' . $checked_value . '"', "value='$checked_value' checked", $html);
        }
        return $html;
    }

}

if (!function_exists('form_checkbox')) {

    function form_checkbox($name, $data, $checked_value = 0) {
        $html = '';
        foreach ($data as $key => $val) {
            $html .= '<label class="checkbox-inline"><input name="' . $name . '[]" type="checkbox" value="' . $key . '" >' . $val . '</label>';
        }

        if ($checked_value >= 0) {
            $html = str_replace('value="' . $checked_value . '"', "value='$checked_value' checked", $html);
        }
        return $html;
    }

}

if (!function_exists('form_checkbox_rows')) {

    function form_checkbox_rows($name, $data, $id = 'id', $text = 'name', $checked_value = 0) {
        $html = '';
        foreach ($data as $row) {
            $html .= '<label class="checkbox-inline"><input name="' . $name . '" type="checkbox" value="' . $row [$id] . '" >' . $row [$text] . '</label>';
        }

        if ($checked_value >= 0) {
            $html = str_replace('value="' . $checked_value . '"', "value='$checked_value' checked", $html);
        }
        return $html;
    }

}

if (!function_exists('time_to')) {

    function time_to($time_str) {
        $now = time();
        $time = strtotime($time_str);
        $diff = $now - $time;

        if ($diff < 3600) {
            return floor($diff / 60) . '分钟前';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . '小时前';
        } elseif ($diff >= 86400 && $diff <= 259200) {
            return floor($diff / 86400) . '天前';
        } else {
            return date('m月d日 H:i', strtotime($time_str));
        }
    }

}

if (!function_exists('get_distance')) {

    function get_distance($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 6367000; // approximate radius of earth in meters

        $lat1 = ($lat1 * pi()) / 180;
        $lng1 = ($lng1 * pi()) / 180;

        $lat2 = ($lat2 * pi()) / 180;
        $lng2 = ($lng2 * pi()) / 180;

        /*
         * Using the
         * Haversine formula
         *
         * http://en.wikipedia.org/wiki/Haversine_formula
         *
         * calculate the distance
         */

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;

        return round($calculatedDistance);
    }

}



if (!function_exists('http_post_function')) {
  function http_post_function($url, $data,$http_header=[]) {
    
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_TIMEOUT, 500);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      if($http_header)
      curl_setopt($curl, CURLOPT_HTTPHEADER,$http_header);

      $res = curl_exec($curl);
      curl_close($curl);
      
      return $res;
  }

}

if (!function_exists('http_get_function')) {
  function http_get_function($url,$post='') {

      $header = array(
          'Content-Type: application/json; charset=utf-8',
          "Accept: application/json",
          "Cache-Control: no-cache", 
    　　    );

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_TIMEOUT, 500);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
      curl_setopt($curl, CURLOPT_URL, $url);

      $res = curl_exec($curl);
      curl_close($curl);

      return $res;
  }
}

function validation_filter_id_card($id_card) {
    if (strlen($id_card) == 18) {
        return idcard_checksum18($id_card);
    } elseif ((strlen($id_card) == 15)) {
        $id_card = idcard_15to18($id_card);
        return idcard_checksum18($id_card);
    } else {
        return false;
    }
}

// 计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base) {
    if (strlen($idcard_base) != 17) {
        return false;
    }
    // 加权因子
    $factor = array(
        7,
        9,
        10,
        5,
        8,
        4,
        2,
        1,
        6,
        3,
        7,
        9,
        10,
        5,
        8,
        4,
        2
    );
    // 校验码对应值
    $verify_number_list = array(
        '1',
        '0',
        'X',
        '9',
        '8',
        '7',
        '6',
        '5',
        '4',
        '3',
        '2'
    );
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i ++) {
        $checksum += substr($idcard_base, $i, 1) * $factor [$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list [$mod];
    return $verify_number;
}

// 将15位身份证升级到18位
function idcard_15to18($idcard) {
    if (strlen($idcard) != 15) {
        return false;
    } else {
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array(
                    '996',
                    '997',
                    '998',
                    '999'
                )) !== false) {
            $idcard = substr($idcard, 0, 6) . '18' . substr($idcard, 6, 9);
        } else {
            $idcard = substr($idcard, 0, 6) . '19' . substr($idcard, 6, 9);
        }
    }
    $idcard = $idcard . idcard_verify_number($idcard);
    return $idcard;
}

// 18位身份证校验码有效性检查
function idcard_checksum18($idcard) {
    if (strlen($idcard) != 18) {
        return false;
    }
    $idcard_base = substr($idcard, 0, 17);
    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
        return false;
    } else {
        return true;
    }
}

function del_dir_file($dirName) {
    if (file_exists($dirName)) {
        $handle = opendir("$dirName");
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$dirName/$item")) {
                    del_dir_file("$dirName/$item");
                } else {
                    unlink("$dirName/$item");
                }
            }
        }
        closedir($handle);
        rmdir($dirName);
    }
}

function rand_string($length = 6) {
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i ++) {
        $str .= $strPol [rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }

    return $str;
}

function is_ajax_request() {
    if (isset($_SERVER ['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER ['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    } else {
        return false;
    }
}

if (!function_exists('get_thumb')) {

    function get_thumb($save_path, $size = 220) {
        $path_info = pathinfo($save_path);
        return $path_info ['dirname'] . '/' . $path_info ['filename'] . '.' . $size . '.' . $path_info ['extension'];
    }

}

/**
 * base64当在url中传输时，+和/会有问题，这里替换一下，decode时再替换回来即可
 * 
 * @param type $str          
 * @return type
 */
function safe_base64_encode($str) {
    return str_replace("+", "-", str_replace("/", "_", base64_encode($str)));
}

/**
 * base64当在url中传输时，+和/会有问题，这里替换一下，decode时再替换回来即可
 * 
 * @param type $str          
 * @return type
 */
function safe_base64_decode($str) {
    return base64_decode(str_replace("_", "/", str_replace("-", "+", $str)));
}

function is_assoc_array($array) {
    return array_values($array) === $array;
}

function http_get($url) {
	
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        "Accept: application/json",
        "Cache-Control: no-cache", 
　　    ));
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

function http_post($url, $data) {
	
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
　　    ));

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}


function http_request($url, $data){
	$key='hhxxttxs';
	$timestamp=$time=time();
	 
	$y=date("Y",$time);
	$m=date("m",$time);
	$d=date("d",$time);
	$h=date("H",$time);
	 
	$time=$y.'-'.$m.'-'.$d.'-'.$h;
	$token=md5($key.$time);
	
	if(!empty($data)){
		 
		$data['token_api']=$token;
		$data['timestamp_api']=$timestamp;
	}
	else {
		$url.='/timestamp_api/'.$timestamp;
		$url.='/token_api/'.$token;
	}
	 
	$curl = curl_init();
	
	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if(!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}


//------------wy-----------------
function return_ajax_data($data,$info,$status){


	$re_data['data']=$data;
	$re_data["info"]=$info;
	$re_data["status"]=$status;
	return $re_data;
}
//------------wyend-----------------

 /**
* 查询商品库存
* @param type $goods_id
*/
function _goods_inv_qty($goods_id){
   if(!$goods_id) return false;
   
   $url = C("API_WMS_URL").'index/get_goods_invertory/goods_id/'.$goods_id;
   
   $result = json_decode(http_request($url),TRUE);
   $data = array();
   $storage_type = array(
     '1' => '海外直邮',  
     '2' => '国内发货',  
   );
   if($result['status']=='1')
   {
       foreach($result['data'] as $r){
           $data['storage'][$r['storage_type']]['name'] = $storage_type[$r['storage_type']];
           $data['storage'][$r['storage_type']]['invertory'] += $r['invertory'];
           $data['invertory']  += $r['invertory'];
       }
   }
   return $data;
}

/**
* 虚拟锁定仓库库存
* @param type $goods_id
* @param type $order_id
* @param type $goods_nums
* @return boolean
*/
function _lock_storage_invertory($goods_id,$order_id,$goods_nums,$storage_id,$order_sn){
   $url = C("API_WMS_URL").'Index/lock_storage_invertory/goods_id/'.$goods_id.'/order_id/'.$order_id.'/storage_id/'.$storage_id.'/lock_number/'.$goods_nums.'/status/2/order_sn/'.$order_sn;
   
   
//    dump(return_ajax_data("",$url,0));
   
   $result = json_decode(http_request($url),TRUE);

   if($result['status']==1)
   {
       return true;
   }
   else
   {
       error_log(date('Y-m-d H:i:s').' '.$goods_id .' ' .$order_id. ' '. $goods_nums . ':'.$result['info']."\n",3,'./Public/error_lock_storage_invertory.log');
   }
}



/**
 *
 * @param  $key 缓存键
 * @param  $value 缓存值
 * @param  $act 操作 add新增 get获取 del删除  lock 缓存锁
 * @param  $time 时间（秒）
 */
function memcache_act($key,$value,$act,$time)
{

	if($_SERVER['HTTP_HOST'] == 'localhost'||$_SERVER['HTTP_HOST'] == '127.0.0.1')
	{
		return '';
	}
	//     $memc = new \Think\Cache\Driver\Memcached('ocs');//这里的ocs，就是persistent_id

	//     if (count($memc->getServerList()) == 0) /*建立连接前，先判断*/
	//     {
	//         /*所有option都要放在判断里面，因为有的option会导致重连，让长连接变短连接！*/
	//         $memc->setOption(Memcached::OPT_COMPRESSION, false);
	//         $memc->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
	//         /* addServer 代码必须在判断里面，否则相当于重复建立’ocs’这个连接池，可能会导致客户端php程序异常*/
	//         $memc->addServer('127.0.0.1', 11211);
	//         $memc->setSaslAuthData("", "");
	//     }


	if($act=='add')
	{
		if($time==''||$time==null){
			S($key, $value);
		}else{
			S($key, $value,$time);
		}
	}
	if($act=='lock')
	{
		$key=C("DATA_CACHE_TYPE").$key;
		$redis = new \Think\Cache\Driver\Redis();
		$redis->connect("Redis",'127.0.0.1',array("REDIS_HOST"=>"127.0.0.1","REDIS_PORT"=>6379));
		$ttl=empty($ttl)?10:$ttl;
		$redis->multi();
		$redis->setnx($key, $value);
		$redis->expire($key, $ttl);
		$re_data=$redis->exec();

		return $re_data[0];
	}

	if($act=='get')
	{
		$re_value= S($key);

		return $re_value;
	}

	if($act=='del')
	{
		S($key,null);
	}
}





// //-----------------啦卡拉函数----------------------------


/* * ***
 * 拉卡拉PHP支付公共函数库
* @author chunkuan <urcn@qq.com>
*/


/* * **** DES 加密解密库 Start ******** */
/**
 * des加密用到的临时函数
 */
function des_pkcs5_pad($text, $blocksize){
	$pad = $blocksize - (strlen($text) % $blocksize);
	return $text.str_repeat(chr($pad), $pad);
}

/**
 * des加密字符串
 * @param string $key 加密密钥
 * @param string $data 待加密字符串
 * @return 加密后的十六进制数据
 * @author chunkuan <urcn@qq.com>
 */
function des_encrypt($key, $data){
	$size = mcrypt_get_block_size('des', 'ecb');
	$data = des_pkcs5_pad($data, $size);
	$td = mcrypt_module_open('des', '', 'ecb', '');
	$iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	@mcrypt_generic_init($td, $key, $iv);
	$data = mcrypt_generic($td, $data);
	mcrypt_generic_deinit($td);
	mcrypt_module_close($td);
	return strtoupper(bin2hex($data));
}

/**
 * 解密用到的临时函数
 */
function des_pkcs5_unpad($text){
	$pad = ord($text{strlen($text) - 1});
	if($pad > strlen($text)){
		return false;
	}
	if(strspn($text, chr($pad), strlen($text) - $pad) != $pad){
		return false;
	}
	return substr($text, 0, -1 * $pad);
}

/**
 * des解密字符串
 * @param string $key 加密密钥
 * @param string $data 待解密字符串
 * @return 解密后的数据
 * @author chunkuan <urcn@qq.com>
 */
function des_decrypt($key, $data){
	$data = hex2bin(strtolower($data));
	$td = mcrypt_module_open('des', '', 'ecb', '');
	$iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	$ks = mcrypt_enc_get_key_size($td);
	@mcrypt_generic_init($td, $key, $iv);
	$decrypted = mdecrypt_generic($td, $data);
	mcrypt_generic_deinit($td);
	mcrypt_module_close($td);
	$result = des_pkcs5_unpad($decrypted);
	return $result;
}

/* * **** DES 加密解密库 End ******** */
/**
 * json数据强制转字符串类型
 * @param array $array 待转换的数组
 * @return string 转换后的json字符串
 * @author chunkuan <urcn@qq.com>
 */
function json_encode_s($array){
	foreach($array as &$v){
		$v = (string) $v;
	}
	return json_encode($array);
}

/**
 * RSA 公钥私钥格式化
 * @param string $str 无序公钥、私钥
 * @param string $type public OR private
 * @return string 格式化之后的公钥私钥
 * @author chunkuan <urcn@qq.com>
 */
function rsa_ges($str, $type = 'public'){
	$publicKeyString = "-----BEGIN ".strtoupper($type)." KEY-----\n";
	$publicKeyString .= wordwrap($str, 64, "\n", true);
	$publicKeyString .= "\n-----END ".strtoupper($type)." KEY-----\n";
	return $publicKeyString;
}

function encrypt_format($str){
	return mb_convert_encoding($str, 'gbk', 'utf-8');
	//return $str;
}

/**
 * 支付后同步返回验签结果
 * @param array $data 返回的post数组
 * @param string $pk 公钥
 * @param string $rk 私钥
 * @return array 解密后的支付数据
 * @author chunkuan <urcn@qq.com>
 */
function decryptReqData($data, $pk, $rk){
	$return_data = array('status' => 0, 'data' => array(), 'error' => '');
	$retCode = $data['retCode'];
	$retMsg = $data['retMsg'];
	$merId = $data['merId'];
	$ver = $data['ver'];
	$ts = $data['ts'];
	$reqType = $data['reqType'];
	$reqEncData = $data['encData'];
	$reqMac = $data['mac'];
	$macData = sha1(mb_convert_encoding($retCode.$retMsg.$merId.$ver.$ts.$reqType.$reqEncData, 'gbk', 'utf-8'));
	$reqMacStr = '';
	openssl_public_decrypt(hex2bin(strtolower($reqMac)), $reqMacStr, $pk);
	if($macData != $reqMacStr){
		$return_data['error'] = 'MAC校验失败';
		return $return_data;
	}
	$merKey = md5($merId);
	$reqData = des_decrypt($merKey, $reqEncData);
	if(empty($reqData)){
		$return_data['error'] = '解密业务参数失败';
		return $return_data;
	}
	$return_data['status'] = 1;
	$return_data['data'] = json_decode($reqData, true);
	return $return_data;
}

/**
 * 查询商品库存
 * @param type $goods_id
 */
function _goods_real_inv_qty($goods_id,$storage_id){
	if(!$goods_id) return false;
	$url = C("API_WMS_URL").'index/get_goods_real_invertory/goods_id/'.$goods_id.'/storage_id/'.$storage_id;
	
	$result = json_decode(http_request($url),TRUE);
	
	
	
		
		return $result['data'];
	
}

/**
 * 十六进制转二进制
 * @param string $data 待转换的十六进制数据
 * @return string 返回转换后的二进制数据
 * @author chunkuan <urcn@qq.com>
 */
// function hex2bin($data){
// 		$len = strlen($data);
// 		$newdata = '';
// 		for($i = 0; $i < $len; $i+=2){
// 			$newdata .= pack("C", hexdec(substr($data, $i, 2)));
// 		}
// 		return $newdata;
// }





// //--------------------啦卡拉函数end------------------------

