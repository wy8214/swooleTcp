<?php

/**
 * {module_name} Model
 * 
 * @filepath  Apps/Common/Model/MerUserAttributeModel.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-10-12
 */
namespace Common\Model;

use Think\Model;

class MerUserAttributeModel extends Model {
  protected $trueTableName = 'mer_user_attribute';
  public function find_by_user_id($user_id) {
    $data = $this -> field('id,user_id', true) 
      -> where([
      'user_id' => $user_id
    ]) 
      -> find();
    return $data;
  }
}
