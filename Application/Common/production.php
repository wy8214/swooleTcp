<?php

return array(
  'APP_STATUS' => '生产环境',
  // 开启子域名或者IP配置
  /*
    'APP_SUB_DOMAIN_DEPLOY' =>    1,
    'APP_SUB_DOMAIN_RULES'  =>    array(
    'backend' => 'Backend',
    'mp'      => 'Mp',
    ),
   * 
   */
    
  //数据库信息
  'DB_TYPE' => 'mysql',         // 数据库类型

  'DB_HOST' => '10.66.139.116', // 服务器地址
  'DB_NAME' => 'pashim',      // 数据库名
  'DB_USER' => 'dbuser01',          // 用户名
  'DB_PWD'  => 'zg12345678990', // 密码
  'API_WMS_URL'=>'http://wms.pchmall.com/index.php?s=Api/',
	 
// 		'DB_HOST' => '115.159.115.108',
// 		'DB_USER' => 'root',
// 		'DB_PWD'  => 'zg7782414', // 密码
// 		'DB_NAME' => 'tpashim',      // 数据库名
// 		'API_WMS_URL'=>'http://twms.pchmall.com/index.php?s=Api/',		
		
		
  'DB_PORT' => 3306,           // 端口
  'DB_CHARSET' => 'utf8',      // 字符集
  'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => 'http://files.pchmall.com/Public/mallv1',
  		'__UPLOAD__' => 'http://www.pchmall.com',
    ),
  'UPLOAD_BASE_URL' => 'http://files.pchmall.com/mallv1',
		
		
		
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
		
 
  
//   'core_seek_ip'=>'115.159.126.144',
  'core_seek_ip'=>'127.0.0.1',
  'core_seek_port'=>'9312',
  //网关购汇支付配置
  'ehking_merchantId'=>'400000047',
  'ehkingpay_key'=>'3ae00b9e51c9a1ae6d30de9e7c3e73f3',
  'ehkingpay_gateway'=>'https://api.ehking.com/foreignExchange/order',
  'ehkingpay_method' => 'post',
	//通联支付参数配置
  'allinpay_gateway' => 'https://service.allinpay.com/gateway/index.do',
  'allinpay_version' => 'v1.0',
  'allinpay_singType' => '0',
  'allinpay_merchantId' => '109233791407004',
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
		
		
		'lakalapay_gateway' =>'https://intl.lakala.com:7777/ppayGate/CrossBorderWebPay.do',
		'Plat_Public_Key'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDPg0O4rPQJL1O+jqJ4rBjFVNRAuDmBSoii9pYfPQBaescCVY0irkWWoLyfTT65TjvnPpOx+IfNzBTlB13qCEFm7algREoeUHjFgFNHiXJ2LK/R0+VWgXe5+EDFfbrFCPnmLKG3OcKDGQszP0VOf6VVTM1t56CpgaRMm1/+Tzd2TQIDAQAB',
		'Rsa_Pri_Key'=>'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAKImc2pdn1cFDvlaicYLVXWtMBE69LILc/Q9DX5b1E7R0S/bCwtKKeXEPUJK3Y7LMkZpaRWJkpMbB8eRQY7xpWL1DKPoGi37Idd/FN/Iv7poBvjPuKEWQmT9gLQqNBdArY7VRPr9S3NwaWlnPc9uJPCCMGVzlsQKTEKVOGhxlCGPAgMBAAECgYBvhCI8NMcxAbmapDm8im7rz4APWYyQJnBIuPRewqjwzDwhvXOLACZwbtXykapuWjDpW/V5anPz19Mx3SRJOseSfVzjLlDN3NwugOj6RApNBmUB9hDkC/KwBp6hIU9Vz7V1lti2SltSygbxKBiYA9dnPgEGxJwSntNRrRspBFSWAQJBAOHD9OKjq4gYWZBQ3WnQcgIPdonZH1wisohvI/V3MxMQ87wiJ9K9Bnkz+X3lGuJsRFEUmvL7rSt4VT6r4Bfd2d8CQQC33Yls8vEPScSmv6yw4TDbdYHv+nCRvHuDzFyt379g5KQdsIShmId4pybC2aipQnhFPHrFeWyBX2uQRhF8iA5RAkEAr/d1QsVBKFWaUYLF4PjIM9Trlqv15nFg6DiANY3P8FdxMj0I/xe4GPYqyzasSrkKUowV7be+lLg48R00EEYpzwJBAI2/uHwLC7dKmtYnPV6cLctzWzqErBZe5iZk/ip6LhPoEXJmLMpcSkzFKMfdf/8FpK1UBB6MDw/qXYW7zy1fwxECQCtdLnhBDSIt7pQ1FB2hEGBeggop/BGJKJNQ42luHgxb34Y5z516RXcVOhKbBdEzgt2R7QYHulQxIP8Ps01FjIU=',
		'lakalapay_merchantId' => 'DOPCHN000069',
		// 		'lakalapay_gateway' =>'https://intl.lakala.com:7777/ppayGate/CrossBorderHtml5Pay.do',
		// 		'Plat_Public_Key'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDPg0O4rPQJL1O+jqJ4rBjFVNRAuDmBSoii9pYfPQBaescCVY0irkWWoLyfTT65TjvnPpOx+IfNzBTlB13qCEFm7algREoeUHjFgFNHiXJ2LK/R0+VWgXe5+EDFfbrFCPnmLKG3OcKDGQszP0VOf6VVTM1t56CpgaRMm1/+Tzd2TQIDAQAB',
		// 		'Rsa_Pri_Key'=>'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALUssKEex+3XSN3oiMrtC4yDS923E7G34oKI4Ien9Bv3/uNokNAV+oGnKXAXPoD+bRwsAQ+UD8r3Mwzk8KcQdTK5j6qppg6Km9R7UUNre6H+iExPBx2OrR4T4e+4UcKjCYwnSTzGqGGVqaVxMdHgNgwI137iYPy3fzTJPlYS0hIFAgMBAAECgYEAnMaCRbpEGX0s8dHR5X/AeaP4F3DgGu5blMdrPBhLNZShPRn0DgymzGDhi7yherAvrKwrctaV3/WPeH33/SlRr85G2ZzJW/UqU14uSvCwj2ktvGyGu0ZCS76fjpaorxOW6Tms4PiKrVpRlEjzLaBbTmGH4+kSCjYchYVhhgaR1WECQQD1w8g2bYKEEimA5WDpQf3fAsFVbf2XDx/5dcqARKVWPedsgs81URrIWhYT8sELZ7w77NgM1J4igDzmolEaqg25AkEAvLhHv5vfSTk4LEW3qAGMWlzLtfLrqYivmmVw41oFyzMmAbbGTw/PQAvePdN1zht1igjEk+5tpkJX15ltLWMsrQJAbzyZP0FbxKlvzZ6Eua8b2DeoCCHLmPbIkyGkcWAgsaM9PxkJ7mjyRWK5AXhrtdzTDxCJTW1i0dzXM9CeAwKbSQJBAK0QQZvRkZ5Qvta6yIVlhhSH7LhaoQrDsmXgiPm1YILL0RrZRlrSoLiXKaOA/BOa0ttW1w7iI+PIC05IAPsSa7ECQHQ16BDYXqgQFdz86GV85iA5/mVE+Y1VTu9A/9w/CZFRlBGqX4EJx2BVQ6e98CFnLnCMz88fQK3NwOlaLJJ4cbo=',
		// 		'lakalapay_merchantId' => 'DOPCHN000070',
		'lakalapay_version' => '1.0.0',
		'lakalapay_reqType' => 'B0002',
		
		'lakalapay_bizCode'=> '121010',
		'lakalapay_method' => 'post',
);
