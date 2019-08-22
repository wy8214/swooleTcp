<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class AccountPlatService {
  
  private static $instance;
  var $status = array(
    1 => '启用',
    0 => '禁用',
  );

  var $type = array(
    1 => '微信',
    2 => '微博',
    3 => '趣头条',
  );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new AccountPlatService();
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
    $AccountPlat = M('hwyt_account_plat');
    $data = $AccountPlat->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $AccountPlat = M('hwyt_account_plat');
    $data = $AccountPlat->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'id',
    );

    $config = extend($config, $default);

    $AccountPlat = M('hwyt_account_plat');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" ac.name like '%$k%' or m.mobile_serila like '%$k%' or m.location like '%$k%'";
    }

    if ( !empty($config['plat_name']) ) {
      $where['plat_name'] = $config['plat_name'] ;
    }

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }

    if ( !empty($config['account_id']) ) {
      $where['account_id'] = $config['account_id'] ;
    }
    
        
    if ($config['count']) {
      return $AccountPlat->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $AccountPlat->alias('ap')
              ->where($where)
              ->limit($limit)->order( $order )->select();
     // echo  $AccountPlat->_sql();
      return $data ? $data : array();
    }
  }
  
  
  
  function create($data, $is_ajax = true) {
    $AccountPlat = M('hwyt_account_plat');
    $ret = $AccountPlat->add($data);
    
    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
    
  }

  function update( $id , $data ) {
    $AccountPlat = M('hwyt_account_plat');
    
    $ret = $AccountPlat->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $AccountPlat = M('hwyt_account_plat');
    $ret = $AccountPlat->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }
  
}
