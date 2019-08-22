<?php

return array(
  'APP_STATUS' => '开发环境',
  'LOG_RECORD' => FALSE, // 开启日志记录
  'LOG_EXCEPTION_RECORD' => FALSE,
  //'LOG_LEVEL'             => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',
  'LOG_LEVEL' => '',
		
  //数据库信息
  'DB_TYPE' => 'mysql',         // 数据库类型
  'DB_HOST' => '47.96.23.135', // 服务器地址
  'DB_NAME' => 'fclt',      // 数据库名
  'DB_USER' => 'root',          // 用户名
  'DB_PWD'  => 'hwyt@xtyp', // 密码  
  'DB_PORT' => 3306,           // 端口

  'DATA_CACHE_PREFIX' => 'Redis_',//缓存前缀
  'DATA_CACHE_TYPE'=>'Redis',//默认动态缓存为Redis
  'REDIS_HOST'=>'127.0.0.1', 
  'REDIS_PORT'=>'6379',//端口号
  'REDIS_TIMEOUT'=>'300',//超时时间
  'REDIS_PERSISTENT'=>false,//是否长连接 false=短连接
  // 'REDIS_AUTH'=>'redis_docsay',//AUTH认证密码

		//上传FTP设置
// 		'File_SAVE_TYPE'=>'ftp',	
		  'UPLOAD_SAVE_FTP' => false ,
		  'UPLOAD_FTP_CONFIG' => array(
		    'host'     => '115.159.115.108', //服务器        
		    'port'     => 21, //端口        
		    'timeout'  => 30, //超时时间      
		    'username' => 'ftpadmin', //用户名        
		    'password' => 'zg12345678990', //密码 
		    'pasv'     => TRUE ,
		    'root_dir' => '/tfiles.pchmall.com',
		  ),
		'TMPL_PARSE_STRING' => array(
				'__UPLOAD__' => 'http://localhost/mall',
		),

  'DB_CHARSET' => 'utf8',      // 字符集
  

  'AUTH_URL' =>  'http://la.huaweiyuntian.com/Mp',

  'REMOTE_INTERFACE' => 'http://lc.huaweiyuntian.com',
	
);
