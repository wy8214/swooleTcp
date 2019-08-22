<?php

/**
 * 区域 Service
 * 
 * @file Apps/Common/Service/AreaService.class.php
 * @author Huwei 
 * @version 1.0 , 2015-06-11
 */

namespace Common\Service;

class AreaService {

  private static $instance;

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new AreaService();
    }
    return self::$instance;
  }

  /**
   * 取默认值
   *
   * @return type
   */
  function get_default($type = 0) {
    $data = array(
      'province' => array(),
      'city' => array(),
      'district' => array(),
      'province_id' => 0,
      'city_id' => 0,
      'district_id' => 0
    );

    $data ['province'] = $this->get_by_pid('', $type);
    if (!empty($data ['province'])) {
      $data ['province_id'] = $data ['province'] [0] ['id'];
      $data ['city'] = $this->get_by_pid($data ['province'] [0] ['id'], $type);
    }

    if (!empty($data ['city'])) {
      $data ['city_id'] = $data ['city'] [0] ['id'];
      $data ['district'] = $this->get_by_pid($data ['city'] [0] ['id'], $type);
    }

    if (!empty($data ['district'])) {
      $data ['district_id'] = $data ['district'] [0] ['id'];
    }

    return $data;
  }

  function get_by_id($id) {
    $Area = M('SysArea');
    $data = $Area->find($id);
    return $data ? $data : array();
  }
  
  
  function get_province() {
    return $this->get_by_pid();
  }

  /**
   * 父ID取数据
   *
   * @param type $pid        	
   * @return type
   */
  function get_by_pid($pid = '', $type = 0) {
    $Area = M('SysArea');
    $where = array();
    if ( empty($pid) ) {
      $where ['pid'] = array('exp',' is null ' );
    } else {
      $where ['pid'] = $pid;
    }
    $where ["type"] = $type;
    $data = $Area->field('id , text , expand')->where($where)->order('id ASC')->select();
    // echo $Area->_sql();
    return $data ? $data : array();
  }

  function get_by_district($district_id, $type = 0) {
    $data = array(
      'province' => $this->get_by_pid("", $type),
      'city' => array(),
      'district' => array(),
      'province_id' => 0,
      'city_id' => 0,
      'district_id' => $district_id
    );

    $district_data = $this->get_by_id($district_id);
    $data['district'] = $this->get_by_pid($district_data ['pid'], $type);
    if (!empty($data ['district'])) {
      $data ['city_id'] = $district_data ['pid'];
      $city_data = $this->get_by_id($district_data ['pid']);
      if (!empty($city_data)) {
        $data ['city'] = $this->get_by_pid($city_data ['pid'], $type);
        $data ['province_id'] = $city_data ['pid'];
      }
    }

    return $data;
  }

}
