<?php

namespace Common\Controller;

use Think\Controller;

class MyController extends Controller {
  function __construct() {
    parent::__construct ();
  }
  
  function _get_key_by_url() {
    $protocol = C('SSL') ? 'https://' : 'http://';
    return md5($protocol . getenv('HTTP_HOST') . getenv('REQUEST_URI') );
  }
  
  function _get_memcache( $key = '' ,$expire = 600 ) {
    if ( empty( $key ) ) {
      $key = $this->_get_key_by_url();
    }
    $memcacht_setting = C('MEMCACHE');
    $memcacht_setting['expire'] = $expire ;
    
    $cache = S( $memcacht_setting );
    return $cache->$key ;
  }
  
  function _set_memcache( $value = '' , $key = '' ) {
    if ( empty( $key ) ) {
      $key = $this->_get_key_by_url();
    }

    $memcacht_setting = C('MEMCACHE');
    $memcacht_setting['expire'] = 600 ;
    
    $cache = S( $memcacht_setting );
    $cache->$key = $value ;
  }
}
