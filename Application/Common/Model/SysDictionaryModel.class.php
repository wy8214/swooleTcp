<?php

namespace Common\Model;

use Think\Model;

class SysDictionaryModel extends Model {
  protected $trueTableName = 'sys_dictionary';
  public function get_by_text($text) {
    return $this -> where(array(
      'text' => $text
    )) 
      -> select();
  }
  public function get_by_pid($pid, $field = 'id,text', $last_time = '') {
    $where['pid'] = $pid;
    
    if(empty($last_time)) {
      $where['is_del'] = 0;
    } else {
      $where['update_date'] = $last_time;
      if($field != '*') {
        $field = explode(',', $field);
        if( ! in_array('is_del', $field)) {
          $field[] = 'is_del';
        }
      }
    }
    $order = 'sort ASC ';
    $data = $this -> field($field) 
      -> where($where) 
      -> order($order) 
      -> select();
    return $data?$data :array();
  }
}
