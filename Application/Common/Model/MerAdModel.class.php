<?php

/**
 * 自动生成 MerAdModel
 * 
 * @filepath  Apps/Common/Model/MerAdModel.class.php
 * @author  cmcc_admin 
 * @version 1.0 , 2015-09-25
 */
namespace Common\Model;

use Think\Model;

class MerAdModel extends Model {
  protected $trueTableName = 'mer_ad';
  public function get_ad($catalog, $count = 3) {
    $now = date('Y-m-d H:i:s');
    $where = array(
      // @formatter:off 取消eclipse格式化
      'start_time'=>[
        ['exp','is null'],
        ['elt', $now],
        'or'
      ],
      'end_time'=>[
        ['exp','is null'],
        ['egt', $now],
        'or'
      ],
      // @formatter:on
      'status'=>1,
      'catalog'=>$catalog
    );
    $data = $this->where($where)
      ->limit($count)
      ->order('sort')
      ->select();
    return $data;
  }
}
