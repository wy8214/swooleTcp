<?php

/**
 * 压价阶梯 Model
 * 
 * @filepath  Apps/Common/Model/MerEventPriceDownModel.class.php
 * @author  Huwei 
 * @version 1.0 , 2015-09-17
 */
namespace Common\Model;

use Think\Model;

class MerEventPriceDownModel extends Model {
  protected $trueTableName = 'mer_event_price_down';
  public function get_by_event_id($event_id) {
    $data = $this->where([
      'event_id'=>$event_id
    ])
      ->select();
    return $data;
  }
}
