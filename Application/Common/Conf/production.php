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
  
  'DB_CHARSET' => 'utf8',      // 字符集
  'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => '../../../Public',//'http://files.pchmall.com/Public/mallv1',
    ),
  
		
  'AUTH_URL' =>  'http://la.huaweiyuntian.com/Mp',

  'REMOTE_INTERFACE' => 'http://lc.huaweiyuntian.com',
);
