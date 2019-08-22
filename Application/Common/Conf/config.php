<?php

/**
 * é»˜è®¤é…ç½®
 */
$base_url = "http://" . getenv('HTTP_HOST');
$base_url .= preg_replace('@/+$@', '', dirname(getenv('SCRIPT_NAME')));

return array(
  'LICENSE_METHOD' => 'SERVER', //SERVER , TIME 
  //'SESSION_AUTO_START' => true, //是否开启session

  'BASE_URL' => $base_url,
  'LOG_RECORD' => true,
  // é»˜è®¤æ¨¡å—
  'DEFAULT_MODULE' =>    'Home',  
  //è·¯ç”±çŠ¶æ€?
  'URL_ROUTER_ON' => TRUE, //å¼€å¯URLè·¯ç”±
  'URL_MODEL' => 2, //REWRITE  æ¨¡å¼
  'URL_CASE_INSENSITIVE' => true, //ä¸åŒºåˆ†å¤§å°å†™
  'URL_PARAMS_BIND_TYPE' => 1, //æŒ‰å˜é‡é¡ºåºç»‘å®?
  'URL_HTML_SUFFIX' => '', //ä¼ªé™æ€åŽç¼€.
  //ç¿»é¡µå°ºå¯¸
  'PAGE_SIZE' => 10,
  //æ•°æ®åº“å­—æ®µåŒºåˆ†å¤§å°å†™
  'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),
  
  //ç‰ˆæƒåŠé¡¹ç›®åç§?
  'COPYRIGHT' => '©2017-2018 任务管理系统',
  
  'SSL'      => FALSE ,
  
  'SAVE_TYPE'=>'cos',

  'SAVE_PATH'=>array(
    'cos'   => '',
    'local' => $base_url,

  ),

  'SERVER_PHONE' => '18163531460',
);
