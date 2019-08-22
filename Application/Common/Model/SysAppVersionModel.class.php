<?php

/**
 * 自动生成 SysAppVersionModel
 * 
 * Apps/Common/Model/SysAppVersionModel.class.php
 * ryadmin @ 2015-09-11
 */

namespace Common\Model;

use Think\Model;

class SysAppVersionModel extends Model {

  protected $trueTableName = 'sys_app_version';

  function get_by_type($type, $environment = 1) {
    $data = $this->where(array(
        'type' => $type,
        'environment' => $environment ,
        'status' => 1 ,
      ))
      ->order('id DESC')
      ->find();
    return $data ? $data : array();
  }

}
