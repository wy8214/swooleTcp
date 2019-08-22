<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class SerilaService {
  
  private static $instance;

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new SerilaService();
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
    $Serila = M('hwyt_serila');
    $data = $Serila->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $Serila = M('hwyt_serila');
    $data = $Serila->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'created_at',
    );

    $config = extend($config, $default);

    $Serila = M('hwyt_serila');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" task_id like '%$k%'  or serial like '%$k%' ";
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

    if ($config['task_id'])  {
      $where['task_id'] = $config['task_id'] ;
    }
    
    if ($config['task_class'])  {
      $where['task_class'] = $config['task_class'] ;
    }

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }

    if ($config['exec_time'])  {
      $where['exec_time'] = $config['exec_time'] ;
    }
    
    
        
    if ($config['count']) {
      return $Serila->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $Serila
              ->where($where)
              ->limit($limit)->order( $order )->select();
     // echo $TaskLog->_sql();
      return $data ? $data : array();
    }
  }
  

  function create($data, $is_ajax = true) {
    $Serila = M('hwyt_serila');
    $ret = $Serila->add($data);
    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
   
  }

  function update( $id , $data ) {
    $Serila = M('hwyt_serila');
    
    $ret = $Serila->where(['id'=>$id])->save($data);

    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }

 
  
  function delete( $ids ) {
    $Serila = M('hwyt_serila');
    $ret = $Serila->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }


}
