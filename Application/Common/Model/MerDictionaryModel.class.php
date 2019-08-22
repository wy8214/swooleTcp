<?php

/**
 * 自动生成 MerDictionaryModel
 * 
 * Apps/Common/Model/MerDictionaryModel.class.php
 * Huwei @ 2015-06-15
 */

namespace Common\Model;

use Think\Model;

class MerDictionaryModel extends Model {

  protected $trueTableName = 'mer_dictionary';

  public function get_by_pid($pid, $field = 'id,text', $last_time = '') {
    $where = array(
      'pid' => $pid
    );
    if (empty($last_time)) {
      $where['is_del'] = 0;
    } else {
      $where['update_date'] = array('gt', $last_time);
      if ($field != '*') {
        $field = explode(',', $field);
        if (!in_array('is_del', $field)) {
          $field[] = 'is_del';
        }
      }
    }
    $data = $this->field($field)
      ->where($where)
      ->select();
    return $data ? $data : array();
  }

}
