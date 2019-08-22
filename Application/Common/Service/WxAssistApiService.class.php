<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class WxAssistApiService {
  
  private static $instance;
  var $status = array(
    1 => '启用',
    0 => '禁用',
  );

  var $api_url = "http://weixin.3f2mt.cn/weixin/tj";
  var $key = "160ef6fc0b154fea8f1266e2010ebf50";

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new WxAssistApiService();
    }

    return self::$instance;
  }


  function wx_assist_submit($account_id)
  {
    $AccountService = \Common\Service\AccountService::instance();
    $account = $AccountService->get_by_id($account_id);

    if(!$account['qrurl'])
      return ajax_arr('微信辅助二维码不能为空');

    

    $param_data['my'] = $this->key;
    $param_data['lianjie'] = $account['qrurl'];
    $param_data['tupian'] = "1";
    $param_data['sjh'] = $account['name'];
    
    $url = $this->api_url;
    $url_param = "";
    foreach ($param_data as $key => $value) {
      if($url_param!="")
        $url_param.="&";
      $url_param.=$key.'='.$value;
    }
    $url .="?".$url_param;
    
    $res = http_get_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);


    if($res['sts']!=1)
      return ajax_arr('提交辅助验证失败');


    $assist_id = $res['d']['id'];

    $assist_data['account_id']  = $account_id;
    $assist_data['assist_id']   = $assist_id;
    $assist_data['updated_at']  = date('Y-m-d H:i:s');
    $assist_data['created_at']  = date('Y-m-d H:i:s');

    $ret = M('hwyt_assist_log')->add($assist_data);

    if($ret)
      return ajax_arr('本地更新辅助验证数据失败');

    return ajax_arr('提交成功',true,['id'=>$ret]);


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
    $TaskClass = M('hwyt_task_class');
    $data = $TaskClass->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $TaskClass = M('hwyt_task_class');
    $data = $TaskClass->find( $id ) ;
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

    $TaskClass = M('hwyt_task_class');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" class_name like '%$k%' ";
    }

    if ( !empty($config['mer_id']) ) {
      $where['mer_id'] = $config['mer_id'] ;
    }

    if ( !empty($config['status']) ) {
      $where['status'] = $config['status'] ;
    }
    
    if ( $config['ac_parent_id'] >= 0 ) {
      $where['ac_parent_id'] = $config['ac_parent_id'];
    }
        
    if ($config['count']) {
      return $TaskClass->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $TaskClass
              ->where($where)
              ->limit($limit)->order( $order )->select();
//      echo $ArticleClass->_sql();
      return $data ? $data : array();
    }
  }
  
  
  
  function create($data, $is_ajax = true) {
    $TaskClass = M('hwyt_task_class');
    $ret = $TaskClass->add($data);
    
    if ($ret) {
      return ajax_arr('添加成功', TRUE, array(
        'id' => $ret
      ));
    } else {
      return ajax_arr('添加失败', FALSE);
    }
    
  }

  function update( $id , $data ) {
    $TaskClass = M('hwyt_task_class');
    
    $ret = $TaskClass->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $TaskClass = M('hwyt_task_class');
    $ret = $TaskClass->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }
  
   
  
}
