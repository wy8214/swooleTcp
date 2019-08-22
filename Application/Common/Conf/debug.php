<?php

return array(
  'APP_STATUS' => '开发环境',
  'LOG_RECORD' => FALSE, // 开启日志记录
  'LOG_EXCEPTION_RECORD' => FALSE,
  //'LOG_LEVEL'             => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',
  'LOG_LEVEL' => '',
		
  //数据库信息
  'DB_TYPE' => 'mysql',         // 数据库类型
//   'DB_HOST' => '5680e0fa3207f.sh.cdb.myqcloud.com', // 服务器地址
//   'DB_NAME' => 'pashim',      // 数据库名
//   'DB_USER' => 'cdb_outerroot',          // 用户名
//   'DB_PWD'  => 'zg7782414', // 密码
//   'DB_PORT' => 4448,          // 端口

   
  // 'DB_HOST' => '120.26.221.76', // 服务器地址
  // 'DB_NAME' => 'letong',      // 数据库名
  // 'DB_USER' => 'root',          // 用户名
  // 'DB_PWD'  => 'Yjuiwxf1', // 密码  

  'DB_HOST' => 'localhost', // 服务器地址
  'DB_NAME' => 'hwytlt',      // 数据库名
  'DB_USER' => 'root',          // 用户名
  'DB_PWD'  => '123456', // 密码  
		
  // 'DB_HOST' => 'localhost', // 服务器地址
  // 'DB_NAME' => 'pashim',      // 数据库名
  // 'DB_USER' => 'root',          // 用户名
  // 'DB_PWD'  => '123456', // 密码
  'DB_PORT' => 3306,

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
  

  'AUTH_URL' =>  'http://la.hwyt.com/Mp',

  'REMOTE_INTERFACE' => 'http://lc.hwyt.com',
	
);
