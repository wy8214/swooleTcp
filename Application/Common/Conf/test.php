<?php

return array(
  'APP_STATUS' => '测试环境',
  'LOG_RECORD' => FALSE, // 开启日志记录
  'LOG_EXCEPTION_RECORD' => FALSE,
  //'LOG_LEVEL'             => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',
  'LOG_LEVEL' => '',
  /*
    // 开启子域名或者IP配置
    'APP_SUB_DOMAIN_DEPLOY'   =>    1,
    'APP_SUB_DOMAIN_RULES'    =>    array(
    'mgrtt.dongqil.com.cn'      => 'Mgr',
    'mptt.dongqil.com.cn'       => 'Mp',
    'apitt.dongqil.com.cn'      => 'Api',
    'downloadtt.dongqil.com.cn' => 'Download',
    ),
   * 
   */


  //数据库信息
  'DB_TYPE' => 'mysql',         // 数据库类型
  'DB_HOST' => '47.96.23.135', // 服务器地址
  'DB_NAME' => 'hwytmall',      // 数据库名
  'DB_USER' => 'root',          // 用户名
  'DB_PWD'  => '123456', // 密码  

  // 'DB_HOST' => 'localhost', // 服务器地址
  // 'DB_NAME' => 'pashim',      // 数据库名
  // 'DB_USER' => 'root',          // 用户名
  // 'DB_PWD'  => '123456', // 密码
  
	'DB_CHARSET'=> 'utf8mb4', 
  // 'DB_HOST' => '115.159.115.108',
  // 'DB_USER' => 'root',
  // 'DB_PWD'  => 'zg7782414', // 密码
  // 'DB_NAME' => 'tpashim',      // 数据库名
		
  'DB_PORT' => 3306,           // 端口
  
  'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => '../../../Public',//'http://files.pchmall.com/Public/mallv1',
    ),
  'WX_SITE' => 'http://wx.huaweiyuntian.com/kl',
  //'UPLOAD_BASE_URL' => 'http://files.pchmall.com/',
  //'API_WMS_URL'=>'http://twms.pchmall.com/index.php?s=Api/',
  //上传FTP设置
  'UPLOAD_SAVE_FTP' => FALSE ,
  'UPLOAD_FTP_CONFIG' => array(
    'host'     => '115.159.161.210', //服务器        
    'port'     => 21, //端口        
    'timeout'  => 30, //超时时间      
    'username' => 'webftp', //用户名        
    'password' => 'zg1234567899', //密码 
    'pasv'     => TRUE ,
    'root_dir' => '/data/wwwroot/www.wuyi.com',
  ),
  //通联支付参数配置
  'allinpay_gateway' => 'http://ceshi.allinpay.com/gateway/index.do',
  'allinpay_version' => 'v1.0',
  'allinpay_singType' => '1',
  'allinpay_merchantId' => '100020091218001',
  'allinpay_key' => '1234567890',
  'allinpay_method' => 'post',
  //支付宝支付参数配置
  'alipay_gateway' => 'https://mapi.alipay.com/gateway.do?_input_charset=utf-8',
  'alipay_service' => 'create_direct_pay_by_user',
  'alipay_partner' => '2088711185713024',
  'alipay_seller_email' => 'pay@pchmall.com',
  'alipay_payment_type' => '1',
  'alipay_input_charset' => 'utf-8',
  'alipay_method' => 'post',
  'alipay_sign_type' => 'MD5',
		
		'merchant_host'   =>    array(
				'mer.pchmall.com' => 2,
				'test.pchmall.com' => 3,
		),
		//网关购汇支付配置
  'ehking_merchantId'=>'400000047',
  'ehkingpay_key'=>'3ae00b9e51c9a1ae6d30de9e7c3e73f3',
  'ehkingpay_gateway'=>'https://api.ehking.com/foreignExchange/order',
  'ehkingpay_method' => 'post',
);
