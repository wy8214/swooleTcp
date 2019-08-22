<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class AccountService {
  
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
      self::$instance = new AccountService();
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
    $Account = M('hwyt_account');
    $data = $Account->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $Account = M('hwyt_account');
    $data = $Account->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'sort',
    );

    $config = extend($config, $default);

    $Account = M('hwyt_account');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" ac.name like '%$k%' or m.mobile_serila like '%$k%' or m.location like '%$k%'";
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }
    if ( !empty($config['notice_time']) ) {
      $where['m.notice_time'] = $config['notice_time'] ;
    }
    
        
    if ($config['count']) {
      return $Account->alias('ac')->field("ac.*,m.mobile_serila,m.mobile_brand,m.location")
              ->join('hwyt_mobile m on m.id=ac.mobile_id','left')->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $Account->alias('ac')
              ->field("ac.*,m.mobile_serila,m.mobile_brand,m.location,m.mobile_class,m.notice_time,al.assist_id,al.created_at as al_created_at,al.updated_at as al_updated_at")
              ->join('hwyt_mobile m on m.id=ac.mobile_id','left')
              ->join('hwyt_assist_log al on al.account_id=ac.id','left')
              ->where($where)
              ->limit($limit)->order( $order )->select();
//      echo $Account->_sql();
      return $data ? $data : array();
    }
  }
  
  
  
  function create($data, $is_ajax = true) {
    $Account = M('hwyt_account');
    $ret = $Account->add($data);
    
    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
    
  }

  function update( $id , $data ) {
    $Account = M('hwyt_account');
    
    $ret = $Account->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $Account = M('hwyt_account');
    $ret = $Account->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }

  function get_wx_account_pos($sort)
  {

    $int_x = $sort<4?$sort:$sort%3;

    $int_y = $sort<4?1:floor($sort/3)+1;

    $pos_x = ($int_x*2-1)*130;

    $pos_y = ($int_y*2-1)*165+166;

    return ['pos_x'=>$pos_x,'pos_y'=>$pos_y,];

  }
  
   
  
}
