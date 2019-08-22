<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class QueueTaskItemService {
  
  private static $instance;
  var $m_type = array(
    1=>'任务机',
    2=>'主控机'
  );

  var $status = array(
    1=>'在线',
    2=>'离线'
  );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new QueueTaskItemService();
    }

    return self::$instance;
  }
  
  function get_default_row() {
    return array(
        'id' => '' ,  
        'ac_id' => '0' ,  
        'mobile_url' => '' ,  
        'mobile_show' => '1' ,  
        'mobile_sort' => '99' ,  
        'mobile_title' => '' ,  
        'mobile_content' => '' ,  
        'mobile_time' => '0' , 
        'count' => 0

    );
  }

  function find( $where ) {
    try
    {
      $mobile = M('hwyt_queue_task_item');
      $data = $mobile->where($where)->find();
      return $data ? $data : array();
    }catch(Exception $e)
    {
      echo $e->getMessage();
    }
    
    
  }

  function get_by_id( $id ){
    $mobile = M('hwyt_queue_task_item');
    $data = $mobile->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'field' => 'a.*',
        'status' => '' ,
        'count' => FALSE,
        'order' => 'DESC' ,
        'sort' => 'a.id',
    );

    $config = extend($config, $default);

    $mobile = M('hwyt_queue_task_item');
    
    $where = array();
    
    if($config['keyword']){
      $k = $config['keyword'];
      $where['_string'] = " a.mobile_serila like '%$k%' or a.location like '%$k%' ";
    }

    if ( !empty($config['status']) ) {
      $where['a.status'] = $config['status'] ;
    }

    if ( !empty($config['mer_id']) ) {
      $where['a.mer_id'] = $config['mer_id'] ;
    }

    if ( !empty($config['queue_task_id']) ) {
      $where['a.queue_task_id'] = $config['queue_task_id'] ;
    }

    if ( !empty($config['notice_time']) ) {
      $where['a.notice_time'] = $config['notice_time'] ;
    }
    if ($config['count']) {
      return $mobile->alias('a')
              ->field($config['field'])
              ->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      if($config['page'])
        $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $mobile->alias('a')
              ->field($config['field'])
              ->where($where)
              ->limit($limit)->order( $order )->select();
      // echo $mobile->_sql();
      return $data ? $data : array();
    }
  }

  
  
  function create($data, $is_ajax = true) {
    $mobile = M('hwyt_queue_task_item');
    $ret = $mobile->add($data);
    if($is_ajax){
      if ($ret) {
        return ajax_arr('添加成功', TRUE, array(
          'id' => $ret
        ));
      } else {
        return ajax_arr('添加失败', FALSE);
      }
    }else{
      if ($ret) {
        return $ret;
      } else {
        return 0;
      }
    }
  }
  
  function update( $id , $data ) {
    $mobile = M('hwyt_queue_task_item');
    
    $ret = $mobile->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $mobile = M('hwyt_queue_task_item');
    $ret = $mobile->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }
}
