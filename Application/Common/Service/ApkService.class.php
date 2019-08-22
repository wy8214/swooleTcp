<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class ApkService {
  
  private static $instance;

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new ApkService();
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
    $Apk = M('hwyt_apk');
    $data = $Apk->where($where)->find();

    $apk_installed_count = M("hwyt_apk_installed_rel")->where($where)->count();
    $data['installed_count'] = $apk_installed_count;
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $Apk = M('hwyt_apk');
    $data = $Apk->find( $id ) ;
    $apk_installed_count = M("hwyt_apk_installed_rel")->where(['apk_id'=> $id])->count();
    $data['installed_count'] = $apk_installed_count;
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

    $Apk = M('hwyt_apk');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" task_id like '%$k%'  or serial like '%$k%' ";
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

    if ($config['id'])  {
      $where['id'] = $config['id'] ;
    }
    
   
    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }

        
    if ($config['count']) {
      return $Apk->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $Apk->where($where)->limit($limit)->order( $order )->select();

      }
    foreach ($data as $key => $value) {
      $apk_installed_count = M("hwyt_apk_installed_rel")->where(['apk_id'=>$value['id']])->count();
      $data[$key]['installed_count'] = $apk_installed_count;
      $installed_moblie_serial = M("hwyt_apk_installed_rel")->where(['apk_id'=>$value['id']])->select();
      $data[$key]['installed'] = "0";
      foreach ($installed_moblie_serial as $k => $v) {
        $data[$key]['installed_moblie_serial'][$v['moblie_serial']] = $v;
      }
    }

    return $data ? $data : array(); 
  }

  function create_apk_install_rel($apk_id,$moblie_serial)
  {
    $ret = M("hwyt_apk_installed_rel")->where(['apk_id'=>$apk_id,'moblie_serial'=>$moblie_serial])->find();

    if(!$ret)
      $ret = M("hwyt_apk_installed_rel")->add(['apk_id'=>$apk_id,'moblie_serial'=>$moblie_serial]);


    if ($ret) {
      return ajax_arr('添加成功', TRUE);
    } else {
      return ajax_arr('添加失败', FALSE);
    }

  }

  function delete_apk_install_rel($apk_id,$moblie_serial)
  {
    $ret = M("hwyt_apk_installed_rel")->where(['apk_id'=>$apk_id,'moblie_serial'=>$moblie_serial])->delete();

    if ($ret) {
      return ajax_arr('删除成功', TRUE);
    } else {
      return ajax_arr('删除失败', FALSE);
    }

  }  

  function create($data, $is_ajax = true) {
    $Apk = M('hwyt_apk');
    $ret = $Apk->add($data);
    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
   
  }

  function update( $id , $data ) {
    $Apk = M('hwyt_apk');
    
    $ret = $Apk->where(['id'=>$id])->save($data);

    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }

 
  
  function delete( $ids ) {
    $Apk = M('hwyt_apk');
    $ret = M("hwyt_apk_installed_rel")->where(['apk_id'=>$ids])->delete();

    $ret = $Apk->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }


}
