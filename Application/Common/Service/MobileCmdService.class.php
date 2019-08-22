<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class MobileCmdService {
  
  private static $instance;
  var $status = array(
    1 => '启用',
    0 => '禁用',
  );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new MobileCmdService();
    }

    return self::$instance;
  }
  
  function get_default_row() {
    return array(
        'id' => '' ,  
        'ac_code' => '' ,  
        'ac_name' => '' ,  
        'ac_parent_id' => '0' ,  
        'ac_sort' => '99' ,  
        'status' => 1

    );
  }

  function find( $where ) {
    $MobileCmd = M('hwyt_mobile_cmd');
    $data = $MobileCmd->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $MobileCmd = M('hwyt_mobile_cmd');
    $data = $MobileCmd->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'field' => '*',
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'ac_sort',
    );

    $config = extend($config, $default);

    $MobileCmd = M('hwyt_mobile_cmd');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" cmd_name like '%$k%' ";
    }

    if ( !empty($config['id']) ) {
      $where['id'] = $config['id'] ;
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }
    
   
        
    if ($config['count']) {
      return $MobileCmd->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $MobileCmd->field($config['field'])
              ->where($where)
              ->limit($limit)->order( $order )->select();
//      echo $ArticleClass->_sql();
      return $data ? $data : array();
    }
  }
  
  
  
  function create($data, $is_ajax = true) {
    $MobileCmd = M('hwyt_mobile_cmd');
    $ret = $MobileCmd->add($data);
    
    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
    
  }

  function update( $id , $data ) {
    $MobileCmd = M('hwyt_mobile_cmd');
    
    $ret = $MobileCmd->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $MobileCmd = M('hwyt_mobile_cmd');
    $ret = $MobileCmd->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }
  
   
  
}
