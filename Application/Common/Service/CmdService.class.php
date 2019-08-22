<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class CmdService {
  
  private static $instance;

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new CmdService();
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
    $Cmd = M('hwyt_cmd');
    $data = $Cmd->where($where)->find();
    $cmd_count = M("hwyt_cmd_moblie_rel")->where($where)->count();
    $data['cmd_count'] = $cmd_count;
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $Cmd = M('hwyt_cmd');
    $data = $Cmd->find( $id ) ;
    $cmd_count = M("hwyt_cmd_moblie_rel")->where(['id'=>$id])->count();
    $data['cmd_count'] = $cmd_count;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 600,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'created_at',
    );

    $config = extend($config, $default);

    $Cmd = M('hwyt_cmd');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" task_id like '%$k%'  or serial like '%$k%' ";
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

   

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }

    
        
    if ($config['count']) {
      return $Cmd->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $Cmd->where($where)->limit($limit)->order( $order )->select();
     // echo $TaskLog->_sql();
              foreach ($data as $key => $value) {
                $cmd_count = M("hwyt_cmd_moblie_rel")->where(['id'=>$value['id']])->count();
                $data[$key]['cmd_count'] = $cmd_count;
              }
      return $data ? $data : array();
    }
  }
  

  function create($data, $is_ajax = true) {
    $Cmd = M('hwyt_cmd');
    $ret = $Cmd->add($data);

    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
   
  }

  function update( $id , $data ) {
    $Cmd = M('hwyt_cmd');
    
    $ret = $Cmd->where(['id'=>$id])->save($data);

    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }

  function delete_cmd_rel($cmd_id,$moblie_serial)
  {
    $ret = M("hwyt_cmd_moblie_rel")->where(['cmd_id'=>$cmd_id,'moblie_serial'=>$data['moblie_serial']])->delete();
    if ($ret === false ) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除成功', TRUE);
    }
  }

  function create_cmd_rel($cmd_id,$moblie_serial)
  {
    $ret = M("hwyt_cmd_moblie_rel")->add(['cmd_id'=>$cmd_id,'moblie_serial'=>$data['moblie_serial']]);
    if ($ret === false ) {
      return ajax_arr('创建失败', FALSE);
    } else {
      return ajax_arr('创建成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $Cmd = M('hwyt_cmd');
    $ret = $Cmd->delete($ids);

    M("hwyt_cmd_moblie_rel")->where(['cmd_id'=>$ids])->delete();
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }


}
