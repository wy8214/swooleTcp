<?php

return array(
		
  'DEFAULT_MODULE' =>    'Backend',	
  'APP_STATUS' => '开发环境',
  'LOG_RECORD' => FALSE, // 开启日志记录
  'LOG_EXCEPTION_RECORD' => FALSE,
  //'LOG_LEVEL'             => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC,INFO,DEBUG,SQL',
  'LOG_LEVEL' => '',
  //'API_WMS_URL'=>'http://wms.pchmall.com/index.php?s=Api/',
		
		'TMPL_PARSE_STRING' => array(
			//	'__PUBLIC__' => 'http://files.pchmall.com/Public/mallv1',
			'__PUBLIC__' => 'Public',
		),
		
		//数据库信息
		  // 'DB_TYPE' => 'mysql',         // 数据库类型
		  // 'DB_HOST' => 'liubinghua.cn', // 服务器地址
		  // 'DB_NAME' => 'letong',      // 数据库名
		  // 'DB_USER' => 'root',          // 用户名
		  // 'DB_PWD'  => 'Yjuiwxf1', // 密码
		  // 'DB_PORT' => 3306,           // 端口
		  // 'DB_CHARSET' => 'utf8',      // 字符集
		

		'DB_HOST' => 'localhost', // 服务器地址
		  'DB_NAME' => 'pashim',      // 数据库名
		  'DB_USER' => 'root',          // 用户名
		  'DB_PWD'  => '123456', // 密码
		  'DB_PORT' => 3306,
		  'DB_CHARSET' => 'utf8',      // 字符集
		
		'COPYRIGHT' => '©2015-2016 北京林德电子商务有限公司',
);
