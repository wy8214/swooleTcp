<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/OrderService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class OrderService {
  
  private static $instance;
  var $status = array(
    0=>'取消',
    10=>'未支付',
    20=>'已支付',
    30=>'已发货',
    40=>'已收货',
    50=>'已完成',
    60=>'退款中',
    70=>'已退款',
    99=>'异常');

  var $type = array(
    1 => '挂号',
    2 => '处方缴费',
    3 => '就诊卡充值',
    4 => '住院预交',
    5 => '预约住院',
    6 => '邮寄病历押金',
    7 => '邮寄病历',
    8 => '在线问诊',
    9 => '扫码就诊卡充值',
    10 => '预约挂号',
    11 => '扫码住院预缴',
    12 => '微信阅读任务',
   );

  var $pay_method = array(
    // 1=>'现金',
    2=>'支付宝',
    3=>'微信',
   );

  var $refund_status = array(
    0=>'未退款',
    1=>'已退款',
    2=>'退款失败',
    3=>'退款中',
    4=>'拒绝退款',
   );

   var $his_mutual_status= array(
    1 =>  '待支付',
    2 =>  '已支付',
    3 =>  '提交his支付信息',
    4 =>  '接收到his正常返回',
    41=>  'his返回数据异常'
   );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new OrderService();
    }

    return self::$instance;
  }
  
  function get_default_row() {
    return array(
        'id' => '' ,  
        'ac_id' => '0' ,  
        'Order_url' => '' ,  
        'Order_show' => '1' ,  
        'Order_sort' => '99' ,  
        'Order_title' => '' ,  
        'Order_content' => '' ,  
        'Order_time' => '0' , 
        'count' => 0

    );
  }

  function find( $where ) {
    $Order = M('hwyt_order');
    $data = $Order->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $Order = M('hwyt_order');
    $data = $Order->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'DESC' ,
        'sort' => 'o.created_at',
    );

    $config = extend($config, $default);

    $Order = M('hwyt_order');
    
    $where = array();
    
    if($config['keyword']){
      $k = $config['keyword'];
      $where['_string'] = " o.order_name like '%$k%'  or o.order_sn like '%$k%' ";
    }

    if ( $config['status'] ) {
      $where['o.status'] = $config['status'] ;
    }

    if ( $config['terminal'] ) {
      $where['o.terminal'] = $config['terminal'] ;
    }

    if ( $config['pay_method'] ) {
      $where['o.pay_method'] = $config['pay_method'] ;
    }

    if ( $config['refund_status'] ) {
      $where['o.refund_status'] = $config['refund_status'] ;
    }

    if ( $config['start_time']) {
        $where['o.created_at'] = array('gt',$config['start_time']);
    }
    if ( $config['end_time']) {
        $where['o.created_at'] = array('lt',$config['end_time']);
    }

    if($config['start_time'] && $config['end_time'])
    {
      $where['o.created_at'] = array('between',[$config['start_time'],$config['end_time']],'and');
    }

    if ( $config['status'] == 20 ){
      $where['o.refund_status'] = 0 ;
    }

    if ( !empty($config['user_id']) ) {
      $where['o.user_id'] = $config['user_id'] ;
    }

    if ($config['count']) {
      return $Order->alias('o')
              ->field($config['field'])
              ->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      if (!$config['nopage'])
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $Order->alias('o')
              ->field($config['field'])
              ->where($where)
              ->limit($limit)->order( $order )->select();
      // echo $Order->_sql();
      return $data ? $data : array();
    }
  }

  function order_read_stat($config)
  {

    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'DESC' ,
        'sort' => 'o.created_at',
    );

    $config = extend($config, $default);

    $Order = M('hwyt_order');
    
    $where = array();
    
    if($config['keyword']){
      $k = $config['keyword'];
      $where['_string'] = " o.order_name like '%$k%'  or o.order_sn like '%$k%' ";
    }
    if ( $config['status'] ) {
      $where['o.status'] = $config['status'] ;
    }

    if ( $config['terminal'] ) {
      $where['o.terminal'] = $config['terminal'] ;
    }

    if ( $config['pay_method'] ) {
      $where['o.pay_method'] = $config['pay_method'] ;
    }

    if ( $config['refund_status'] ) {
      $where['o.refund_status'] = $config['refund_status'] ;
    }

    if ( $config['start_time']) {
        $where['o.created_at'] = array('gt',$config['start_time']);
    }
    if ( $config['end_time']) {
        $where['o.created_at'] = array('lt',$config['end_time']);
    }

    if($config['start_time'] && $config['end_time'])
    {
      $where['o.created_at'] = array('between',[$config['start_time'],$config['end_time']],'and');
    }

    if ( !empty($config['h_id']) ) {
      $where['o.h_id'] = $config['h_id'] ;
    }

    if ( $config['status'] == 20 ){
      $where['o.refund_status'] = 0 ;
    }

    $data['order_count']  = $Order->alias('o')->where($where)->count('id') ;
    $data['order_amount'] = $Order->alias('o')->where($where)->sum('order_amount') ;
    $data['pay_amount']   = $Order->alias('o')->where($where)->sum('pay_amount') ;
    return $data;
    
  }


  function get_order_details($order)
  {
    $order_details = [];

    if($order['order_type']==12)
    {
      $ret = M('hwyt_task_wxread')->where(['order_id'=>$order['id']])->find();

      $order_details['wx_article_url']  = $ret['wx_article_url'];
      $order_details['article_title']   = $ret['article_title'];
      $order_details['init_read_num']   = $ret['init_read_num'];
      $order_details['target_read_num']   = $ret['target_read_num'];
      $order_details['order_read_num']  = $ret['order_read_num'];
    }
    

    return $order_details;

  }

  
  
  function create($data, $is_ajax = true) {
    $Order = M('hwyt_order');
    $ret = $Order->add($data);
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

  /**
   * 统计每个状态下的订单数量
   * @return type
   */  
  function order_nums($mer_id){
      $SysOrder = M('hwyt_order');

      if($mer_id)
      {

          $sql=" SELECT a.status,count(a.id) as nums from  ";
          $sql.="  hwyt_order as a  where a.h_id=".$mer_id;
          $sql.=" and a.deleted_at is  null and refund_status = 0  GROUP BY a.status ";


          $data =M()->query($sql);

          $order_nums = array();
          foreach ($data as $info){
              $order_nums[$info['status']] = $info['nums'];
          }


          $sql=" SELECT count(a.id) as nums from  ";
          $sql.="  hwyt_order as a  where a.h_id=".$mer_id;

          $data =M()->query($sql);
          
          $order_nums['all'] = $data[0]['nums'];


          $sql=" SELECT a.refund_status,count(a.id) as nums from  ";
          $sql.="  hwyt_order as a  where a.h_id=".$mer_id;
          $sql.=" and a.deleted_at is  null and refund_status>0  GROUP BY a.refund_status ";


          $data =M()->query($sql);
          
          foreach ($data as $info){
              $order_nums[$info['refund_status']] = $info['nums'];
          }
         
      }
    
      return $order_nums;
  }



  //创建微信阅读任务订单
  function create_wxread_order($filter)
  {
      
      //创建订单
      $order_data['order_sn']     = _get_order_no();
      $order_data['order_type']   = 12; //预约挂号
      $order_data['order_amount'] = $filter['pay_amount'];
      $order_data['pay_amount']   = 0;
      $order_data['refund_amount']= 0;
      $order_data['ali_pay_no']   = '';
      $order_data['status']       = 10;
      $order_data['mer_id']       = $filter['mer_id'];
      $order_data['user_id']      = $filter['user_id'];
      $order_data['member_id']    = $filter['member_id']?:0;
      $order_data['context']      = $filter['context'];
      $order_data['terminal']     = $filter['terminal'];

      $order_data['order_name']   = '微信阅读任务';
      $order_data['pay_user_id']  = $filter['member_id'];
      $order_data['created_at']   = date('Y-m-d H:i:s');
      $order_data['updated_at']   = date('Y-m-d H:i:s');
      
      M()->startTrans(); 
      $OrderService = \Common\Service\OrderService::instance();   

      $ret = $OrderService->create($order_data); 

      if(!$ret['status']){
        return ajax_arr('创建订单失败', FALSE);
      }

      $order_id = $ret['id'];

      $filter['order_id'] = $order_id;
      $filter['status'] = 1;
      $WxReadService = WxReadService::instance();
      $ret = $WxReadService->create($filter);

      if(!$ret['status']){
        M()->rollback();
        return ajax_arr('创建任务失败', FALSE);
      }

      $task_id = $ret['id'];

      $url = C("REMOTE_INTERFACE")."/Center/Recharge/consumeUserRecharge";
      $post_data['mer_id']        = $filter['mer_id'];
      $post_data['user_id']       = $filter['user_id'];
      $post_data['consume_money'] = $filter['price'];

      $ret = http_post_function($url,$post_data);
      $ret = json_decode($ret,true);

      if($ret['code']!="0"){
        M()->rollback();
        return ajax_arr('创建订单支付失败', FALSE);
      }

      $OrderService->update($order_id,['pay_order_sn'=>$ret['list']['order_sn'],'status'=>20]);

      M()->commit();


      return ajax_arr('创建订单成功', true,['order_id'=>$ret['id'],'task_id'=>$task_id,'order_sn'=>$order_data['order_sn']]);
  }


  
  
  function update( $id , $data ) {
    $Order = M('hwyt_order');
    
    $ret = $Order->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $Order = M('hwyt_order');
    //$ret = $Order->delete($ids);

    $ret = $Order->where("id = %d", $id)->save(['deleted_at'=>date('Y-m-d H:i:s')]);

    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }

  function unicode_decode($name){
 
      $json = '{"str":"'.$name.'"}';
      $arr = json_decode($json,true);
      if(empty($arr)) return '';
      return $arr['str'];
  }
    
}
