<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/MobileTaskService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class MobileTaskService {
  
  private static $instance;
  var $status = array(
    1 => '执行中',
    2 => '已完成',
  );

  var $task_type = array(
    'download'  => '下载',
    'install'   => '安装',
    'command'   => '模拟点击',
    'wx_register' => '微信注册',
    'account' => '账号导入',
  );

  var $task_plat = array(
    'va'    => 'VA',
    'wx'    => '微信',
    'qtt'   => '趣头条',
    'ali'   => '支付宝',
    'dftt'  => '东方头条',
    'qktx'  => '趣看天下',
    'ktt'   => '快头条',
    'wx_assist'   => '辅助平台',

  );

  var $task_va = array(
    '趣头条1'    => '趣头条1',
    '趣头条2'    => '趣头条2',
    '趣头条3'    => '趣头条3',
    '趣头条4'    => '趣头条4',
    '趣头条5'    => '趣头条5',
    '趣头条6'    => '趣头条6',
    '东方头条1'  => '东方头条1',
    '东方头条2'  => '东方头条2',
    '东方头条3'  => '东方头条3',
    '东方头条4'  => '东方头条4',
    '东方头条5'  => '东方头条5',
    '东方头条6'  => '东方头条6',
    '快头条1'   => '快头条1',
    '快头条2'   => '快头条2',
    '快头条3'   => '快头条3',
    '快头条4'   => '快头条4',
    '快头条5'   => '快头条5',
    '快头条6'   => '快头条6',
    '趣看天下1'  => '趣看天下1',
    '趣看天下2'  => '趣看天下2',
    '趣看天下3'  => '趣看天下3',
    '趣看天下4'  => '趣看天下4',
    '趣看天下5'  => '趣看天下5',
    '趣看天下6'  => '趣看天下6',
    '支付宝1'  => '支付宝1',
    '支付宝2'  => '支付宝2',
    '支付宝3'  => '支付宝3',
    '支付宝4'  => '支付宝4',
    '支付宝5'  => '支付宝5',
    '支付宝6'  => '支付宝6',
  );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new MobileTaskService();
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
    $MobileTask = M('hwyt_task_mobile');
    $data = $MobileTask->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $MobileTask = M('hwyt_task_mobile');
    $data = $MobileTask->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'ac_sort',
    );

    $config = extend($config, $default);

    $MobileTask = M('hwyt_task_mobile');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" task_title like '%$k%' ";
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }
 
        
    if ($config['count']) {
      return $MobileTask->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $MobileTask
              ->where($where)
              ->limit($limit)->order( $order )->select();
//      echo $MobileTask->_sql();
      return $data ? $data : array();
    }
  }


  
  
 
  
  function create($data, $is_ajax = true) {
    $MobileTask = M('hwyt_task_mobile');
    $ret = $MobileTask->add($data);
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
    $MobileTask = M('hwyt_task_mobile');
    
    $ret = $MobileTask->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $MobileTask = M('hwyt_task_mobile');
    $ret = $MobileTask->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }


}
