<?php

/**
 * 自动生成 MerUserDeviceModel
 * 
 * Apps/Common/Model/MerUserDeviceModel.class.php
 * ryadmin @ 2015-08-28
 */
namespace Common\Model;

use Think\Model;

class MerUserDeviceModel extends Model {
  protected $trueTableName = 'mer_user_device';
  function get_user_id($token) {
    $data = $this -> field("user_id") 
      -> where(array(
      'token' => $token
    )) 
      -> find();
    if(empty($data)) {
      return NULL;
    } else {
      return $data['user_id'];
    }
  }
}
