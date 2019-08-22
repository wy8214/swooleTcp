<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class QueueTaskService {
  
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
      self::$instance = new QueueTaskService();
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
      $mobile = M('hwyt_queue_task');
      $data = $mobile->where($where)->find();
      return $data ? $data : array();
    }catch(Exception $e)
    {
      echo $e->getMessage();
    }
    
    
  }

  function get_by_id( $id ){
    $mobile = M('hwyt_queue_task');
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

    $mobile = M('hwyt_queue_task');
    
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

    if ( !empty($config['m_type']) ) {
      $where['a.m_type'] = $config['m_type'] ;
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
    $mobile = M('hwyt_queue_task');
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

  function fd_init()
  {
    $mobile = M('hwyt_queue_task');
    $mobile->where("1=1")->save(['fd'=>0,'m_status'=>0,'updated_at'=>date('Y-m-d H:i:s')]);
  }

  function update_inc( $id ) {
    $mobile = M('hwyt_queue_task');
  
    $ret =  $mobile->where("id = %d", $id)->setInc("count");
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function update( $id , $data ) {
    $mobile = M('hwyt_queue_task');
    
    $ret = $mobile->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $mobile = M('hwyt_queue_task');

    M('hwyt_queue_task_item')->where(['queue_task_id'=>$ids])->delete();
    M('hwyt_queue_moblie_rel')->where(['queue_task_id'=>$ids])->delete();
    $ret = $mobile->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }

  function update_queue_task($task_id)
  {
    $queue_task = $this->get_by_id($task_id); 

    $QueueTaskItemService = \Common\Service\QueueTaskItemService::instance();

    $queue_task_items =   $QueueTaskItemService->get_by_cond(['queue_task_id'=>$task_id,'page'=>false]);

    $task_num   = 0;
    $task_time  = 0;

    foreach ($queue_task_items as $key => $value) {
      $task_num++;

      $task_time += $value['exec_time'];
    }

    return $this->update($task_id,['task_num'=>$task_num,'task_time'=>$task_time]);


  }

  function add_queue_task_device($queue_task_id,$mobile_serila)
  {

    $ret = M('hwyt_queue_moblie_rel')->where(['queue_task_id'=>$queue_task_id,'moblie_serial'=>$mobile_serila])->find();

    if($ret)
      return ajax_arr('设备已经存在', FALSE);


    M('hwyt_queue_moblie_rel')->add(['queue_task_id'=>$queue_task_id,'moblie_serial'=>$mobile_serila]);

    $count = M('hwyt_queue_moblie_rel')->where(['queue_task_id'=>$queue_task_id])->count();

    return $this->update($queue_task_id,['mobile_count'=>$count]);

  }


  function delete_queue_task_device($queue_task_id)
  {

    $ret = M('hwyt_queue_moblie_rel')->where(['queue_task_id'=>$queue_task_id])->delete();

    if ($ret === false ) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除成功', TRUE);
    }

  }

  function get_queue_task_device($queue_task_id)
  {
    $ret = M('hwyt_queue_moblie_rel')->alias('a')
          ->join("hwyt_mobile as m on a.moblie_serial = m.mobile_serila","left")
          ->where(["a.queue_task_id"=>$queue_task_id])
          ->select();

    return $ret;
  }
}
