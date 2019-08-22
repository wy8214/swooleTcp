<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;
use Common\Vendor\Validate;


class ClientService {
  
  private static $instance;
  var $status = array(
    1 => '待执行',
    2 => '正在执行',
    3 => '已完成',
    4 => '异常',
    5 => '暂停'
  );

  

  public static function instance() {

    if (self::$instance == null) {
      self::$instance = new ClientService();
    }

    return self::$instance;
  }

  function client_construct($serv,$data)
  {

    // error_log(date('Y-m-d H:i:s').' | client_construct:'. json_encode($data)."\n",3,SWOOLE_PATH . DIRECTORY_SEPARATOR .'Public/client_distribute.log');

    if(!$data)
      return ajax_arr('数据不能为空', FALSE);

    $ret = [];

    switch ($data['cmd']) {

        case 'client_pulse':  //心跳操作
            $ret = $this->client_pulse($serv,$data);
            break;

        case 'server_start':  //初始化
            $ret = $this->server_start($serv,$data);
            break;
        case 'init':  //初始化

            $ret = $this->client_init($serv,$data);
            break;
        case 'close':  //客户端断开
            $ret = $this->client_close($serv,$data);
            break;
        case 'distribute':  //分发操控指令
            $ret = $this->client_distribute($serv,$data);
            break;
        case 'input_phone_num':  //获取手机号码
            $ret = $this->input_phone_num($serv,$data);
          break;
        case 'input_read_article':  //阅读文章
            $ret = $this->input_read_article($serv,$data);
          break;
        case 'send_ver_code':  //分发操控指令
            $ret = $this->send_ver_code($serv,$data);
          break;
        case 'client_update':  //更新手机信息
            $ret = $this->client_update($serv,$data);
            break;
        case 'recover_mobile':  //恢复手机出厂设置
            $ret = $this->recover_mobile($serv,$data);
            break;
        case 'get_phone_list':  //获取手机列表
            $ret = $this->client_mobilelist($serv,$data);
            break;
        case 'update_mobile':  //更新手机设备信息
            $ret = $this->update_mobile($serv,$data);
            break;
        case 'update_mobile_phonenum':  //更新手机号信息
            $ret = $this->update_mobile_phonenum($serv,$data);
            break;

        case 'client_register':  //注册手机
            $ret = $this->client_register($serv,$data);
            break;
        case 'phone_ver_code':  //获取手机验证码
            $ret = $this->client_varcode($serv,$data);
            break;
        case 'cmd_recorde':  //保存录制脚本记录
            $ret = $this->cmd_recorde($serv,$data);
            break;
        case 'update_cmd':  //更新录制脚本记录
            $ret = $this->update_cmd($serv,$data);
            break;
        case 'delete_cmd':  //删除录制脚本记录
            $ret = $this->delete_cmd($serv,$data);
            break;
        case 'delete_cmd_rel':  //删除录制脚本关系
            $ret = $this->delete_cmd_rel($serv,$data);
            break;
        case 'run_cmd_script':  //执行录制脚本
            $ret = $this->run_cmd_script($serv,$data);
            break;
        case 'stop_cmd_script':  //执行录制脚本
            $ret = $this->stop_cmd_script($serv,$data);
            break;
        case 'apk_list':  //保存apk数据记录
            $ret = $this->apk_list($serv,$data);
            break;
        case 'upload_apk':  //上传apk
            $ret = $this->upload_apk($serv,$data);
            break;
        case 'apk_upload_complete':  //上传apk完成，通知任务机进行下载
            $ret = $this->apk_upload_complete($serv,$data);
            break;
        case 'delete_apk':  //删除apk
            $ret = $this->delete_apk($serv,$data);
            break;
        case 're_install_apk':  //重新安装apk
            $ret = $this->re_install_apk($serv,$data);
            break;

        case 'uninstall_apk':  //删除并卸载apk
            $ret = $this->uninstall_apk($serv,$data);
            break;
        case 'open_apk':  //打开apk
            $ret = $this->open_apk($serv,$data);
            break;
        case 'auto_read_apk':  //自动阅读apk
            $ret = $this->auto_read_apk($serv,$data);
            break;
        case 'client_apk_install':  //客户机APK安装
            $ret = $this->client_apk_install($serv,$data);
            break;
        case 'delete_apk_install_rel':  //删除任务机apk关系
            $ret = $this->delete_apk_install_rel($serv,$data);
            break;

        case 'add_mobile_group':  //添加分组
            $ret = $this->add_mobile_group($serv,$data);
            break;
        case 'delete_mobile_group':  //删除分组
            $ret = $this->delete_mobile_group($serv,$data);
            break;
        case 'update_mobile_group':  //更新分组
            $ret = $this->update_mobile_group($serv,$data);
            break;
        case 'edit_queue_task':  //编辑队列任务
            $ret = $this->edit_queue_task($serv,$data);
            break;
        case 'delete_queue_task':  //删除队列任务
            $ret = $this->delete_queue_task($serv,$data);
            break;
        case 'queue_task_list':
            $ret = $this->queue_task_list($serv,$data);
            break;
        case 'edit_queue_task_item':
            $ret = $this->edit_queue_task_item($serv,$data);
            break;
        case 'queue_task_item_list':
            $ret = $this->queue_task_item_list($serv,$data);
            break;
        case 'delete_queue_task_item':
            $ret = $this->delete_queue_task_item($serv,$data);
            break;
        case 'add_queue_task_device':
            $ret = $this->add_queue_task_device($serv,$data);
            break;
        case 'delete_queue_task_device':
            $ret = $this->delete_queue_task_device($serv,$data);
            break;
        case 'exec_queue_task':
            $ret = $this->exec_queue_task($serv,$data);
            break;

        case 'stop_queue_task':
            $ret = $this->stop_queue_task($serv,$data);
            break;
        case 'update_running_task_item':
            $ret = $this->update_running_task_item($serv,$data);
            break;
        case 'remove_running_task_item':
            $ret = $this->remove_running_task_item($serv,$data);
            break;

        case 'pulse_queue_task':
            $ret = $this->pulse_queue_task($serv,$data);
            break;
        default:             
            break;
    }

    return $ret;

  }

  function send_message($serv,$fd,$send_message)
  {
    echo "fd:++++  ".$fd."\n";
    echo preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return iconv("UCS-2BE","UTF-8",pack("H*", $matches[1]));'), $send_message)."\n";
    $length = 4 + strlen($send_message);
    $serv->send($fd, pack("N", $length));
    $serv->send($fd, $send_message);
  }


  function client_pulse($serv,$filter)
  {
  
    $this->send_message($serv,$filter['fd'],"pulse");
  }

  function server_start($serv,$filter)
  {
    
    $MobileService = \Common\Service\MobileService::instance();
    $MobileService->fd_init();
  }


  function client_close($serv,$filter)
  {
    $filter['rec_fd'] = $fd = $filter['fd'];
    $MobileService = \Common\Service\MobileService::instance();
    $mobile = $MobileService->find(['fd'=>$fd]);

    if(!$mobile)
      return;

    $m_data['fd']                 = "0";
    $m_data['m_status']           = 2;
    $m_data['updated_at']         = date('Y-m-d H:i:s');

    $ret = $MobileService->update($mobile['id'],$m_data);

    if(!$ret['status'])
      echo "客户端断开，更新数据失败";

    if($mobile['m_type']==1)
    {
      $master_mobile = $MobileService->find(['m_type'=>2,'m_status'=>1,'mer_id'=>$mobile['mer_id']]);

      if(!$master_mobile)
      {
        $b_mess['code'] = -1;
        $b_mess['cmd']  = "notice";
        $b_mess['info'] = "主控手机未登陆";
        $send_message = json_encode($b_mess);
        $this->send_message($serv,$filter['rec_fd'],$send_message);
      }

      $mobile['fd']                 = "0";
      $mobile['m_status']           = 2;
      $mobile['updated_at']         = date('Y-m-d H:i:s');
      $ret_data['cmd'] = "get_phone_list";
      $ret_data['phone_list'][] = $mobile;
      $this->send_message($serv,$master_mobile['fd'],json_encode($ret_data));
    }

  }

  function client_init($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];
    
    if(!$filter['Serial']){
      
      $b_mess['code'] = -1;
      $b_mess['cmd']  = "notice";
      $b_mess['info'] = '手机没有注册，Serial为空';
      $serv->send($filter['rec_fd'], json_encode($b_mess));
      return;
    }
    $MobileService = \Common\Service\MobileService::instance();
    $mobile = $MobileService->find(['mobile_serila'=>$filter["Serial"]]);

    //如果手机没有做判断
    if(!$mobile)
    {
      //查询IMEI号库，如果有，返回调起二维码页面，主控机进行扫码进行注册
      $SerilaService = \Common\Service\SerilaService::instance();
      $serila = $SerilaService->find(['serila'=>$filter['Serial']]);
     

      if(!$serila){
        $b_mess['code'] = -1;
        $b_mess['cmd']  = "close";
        $b_mess['info'] = '手机非法手机';
        $send_message = json_encode($b_mess);
        $this->send_message($serv,$filter['rec_fd'],$send_message);
        $serv->close($filter['fd'],true);
        return;
      }

      $b_mess['code']         = 0;
      $b_mess['cmd']          = "init";
      $b_mess['fd']           = $filter['fd'];
      $b_mess['is_master']    = "3";
      $b_mess['mer_phone']    = "";
      $b_mess['mer_id']       = "";
      $b_mess['server_phone'] = C('SERVER_PHONE');
      $b_mess['info'] = '手机未注册，待扫码注册';
      $send_message = json_encode($b_mess);
      $this->send_message($serv,$filter['rec_fd'],$send_message);
      return;
    }
        
    $m_data['mobile_brand']       = $filter["BRAND"];
    $m_data['mobile_device_id']   = $filter["Device_ID"];
    $m_data['hardware']           = $filter["HARDWARE"];
    $m_data['model']              = $filter["MODEL"];
    $m_data['batterycap']         = $filter["BatteryCap"];
    $m_data['version']            = $filter["Version"];
    $m_data['fd']                 = $filter["fd"];
    $m_data['m_status']           = 1;
    $m_data['updated_at']         = date('Y-m-d H:i:s');
    
    $ret = $MobileService->update($mobile['id'],$m_data);

    if(!$ret['status'])
    {
        $b_mess['code'] = -1;
        $b_mess['info'] = $ret['msg'];
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
    }

    if(!S("merchant_data_".$mobile['mer_id']))
    {
      $RemoteLoginService = \Common\Service\RemoteLoginService::instance();
      $ret = $RemoteLoginService->get_merchant_byid($mobile['mer_id']);

      if(!$ret['status']){

        $b_mess['code'] = -1;
        $b_mess['info'] = $ret['msg'];
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }
      $merchant = $ret['data'];
      S("merchant_data_".$mobile['mer_id'],$merchant,5);
    }

    $merchant = S("merchant_data_".$mobile['mer_id']);


    $b_mess['is_master'] = $mobile['m_type'];//手机类型，是否主控机
    $b_mess['serial']    = $mobile['mobile_serila'];
    $b_mess['mer_id']    = $mobile['mer_id'];
    $b_mess['mer_phone'] = $merchant['phone'];
    $b_mess['server_phone'] = C('SERVER_PHONE');
    $b_mess['fd']        = $filter['fd'];
    $b_mess['cmd']       = "init";
    $b_mess['code']      = 0;

    $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));


    //如果是主控机
    if($mobile['m_type']==2)
    {
      $filter['mer_id'] = $mobile['mer_id'];
      $this->client_mobilelist($serv,$filter);

      //下发命令脚本数据
      $this->init_cmd_list($serv,$filter);

      //下发apk列表数据
      $this->init_apk_list($serv,$filter);

      //获取设备分组信息
      $this->client_get_group_list($serv,$filter);

      //获取任务列表
      $this->queue_task_list($serv,$filter);

      //获取任务队列列表
      $this->queue_task_item_list($serv,$filter);


    }
    //如果是客户机
    if($mobile['m_type']==1)
    {

      $master_mobile = $MobileService->find(['m_type'=>2,'m_status'=>1,'mer_id'=>$mobile['mer_id']]);

      if(!$master_mobile)
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "主控手机未登陆";
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      }

      //通知本机
      $mobile = $MobileService->find(['mobile_serila'=>$filter["Serial"]]);
      $ret_data['cmd'] = "get_phone_list";
      $ret_data['phone_list'][] = $mobile;
      $this->send_message($serv,$mobile['fd'],json_encode($ret_data));

      //更新主控手机列表
      $ret_data = [];
      $ret_data['cmd'] = "get_phone_list";
      $ret_data['phone_list'][] = $mobile;
      $this->send_message($serv,$master_mobile['fd'],json_encode($ret_data));

      //下发命令脚本数据
      $filter['mer_id'] = $mobile['mer_id'];
      $this->init_cmd_list($serv,$filter);

      //下发apk列表数据
      $this->init_apk_list($serv,$filter);

      //获取设备分组信息
      $this->client_get_group_list($serv,$filter);

      //获取任务队列列表
      $this->get_client_task_item_list($serv,$filter);

    }
   
  }


  function update_mobile_phonenum($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    
    $validate = new Validate([
      'mobile_serila'     => 'require',
      'phone'             => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }
   

    $MobileService = \Common\Service\MobileService::instance();

    $moblie = $MobileService->find(['mobile_serila'=>$filter['mobile_serila']]);

    if($moblie&&!$moblie['phone'])
    {
      $ret = $MobileService->update($moblie['id'],['phone'=>$filter['phone']]);

      if($ret['status'])
      {
        $moblie = $MobileService->get_by_id($moblie['id']);

        $master_mobile = $MobileService->find(['m_type'=>2,'m_status'=>1,'mer_id'=>$moblie['mer_id']]);

        if($master_mobile)
        {
          $ret_data['cmd'] = "get_phone_list";
          $ret_data['phone_list'][] = $moblie;
          $this->send_message($serv,$master_mobile['fd'],json_encode($ret_data));
          $this->send_message($serv,$moblie['fd'],json_encode($ret_data));
        }

        
      }
      
    }

  }

  function client_update($serv,$filter)
  {


    $where = json_decode($filter['where'],true);

    $data = json_decode($filter['data'],true);

    $MobileService = \Common\Service\MobileService::instance();

    $moblie = $MobileService->find($where);

    if($moblie)
    {
      $ret = $MobileService->update($moblie['id'],$data);

      if($ret['status'])
      {
        $moblie = $MobileService->find($where);

        $master_mobile = $MobileService->find(['m_type'=>2,'m_status'=>1,'mer_id'=>$moblie['mer_id']]);

        if($master_mobile)
        {
          $ret_data['cmd'] = "get_phone_list";
          $ret_data['phone_list'][] = $moblie;
          $this->send_message($serv,$master_mobile['fd'],json_encode($ret_data));
          $this->send_message($serv,$moblie['fd'],json_encode($ret_data));
        }

        
      }
      
    }

  }


  function cmd_recorde($serv,$filter)
  {


    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }


    $cmd_data['mer_id']           = $filter['mer_id'];
    $cmd_data['name']             = $filter['name'];
    $cmd_data['file_name']        = $filter['file_name'];
    $cmd_data['apk_package_name'] = $filter['apk_package_name'];
    $cmd_data['oss_file_path']    = $filter['oss_file_path'];
    $cmd_data['local_path']       = $filter['local_path'];
    $cmd_data['file_size']        = $filter['file_size']?:0;
    $cmd_data['status']           = $filter['status']?:1;
    $cmd_data['created_at']       = date('Y-m-d H:i:s');
    $cmd_data['updated_at']       = date('Y-m-d H:i:s');

    $CmdService = \Common\Service\CmdService::instance();

    $ret = $CmdService->create($cmd_data);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "保存录制脚本记录失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $cmd = $CmdService->get_by_id($ret['id']);


    //通知客户机
    $MobileService = \Common\Service\MobileService::instance();

    $config = [
                'mer_id'               => $filter['mer_id'],
                'm_status'             => 1,
                'page_size'            => false,
              ];

    $mobile_list = $MobileService->get_by_cond($config);


    $cmd['cmd_phone_id'] = "";
    foreach ($mobile_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd'] = "cmd_list";
      $ret_data['cmd_list'][] = $cmd;
      $this->send_message($serv,$value['fd'],json_encode($ret_data));
    }
    
  }



  function update_mobile($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
      'mobile_id'     => 'require',
      'data'       => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    $data = json_decode($filter['data'],true);

    $MobileService = \Common\Service\MobileService::instance();

    $ret = $MobileService->update($filter['mobile_id'],$data);


    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "更新录制脚本记录失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }


    $config = [
                'mer_id'               => $filter['mer_id'],
                'm_status'             => 1,
                'm_type'               => 2,
                'page_size'            => false,
              ];

    $mobile_list = $MobileService->get_by_cond($config);

    $mobile = $MobileService->get_by_id($filter['mobile_id']);

    $ret_data = [];
    $ret_data['cmd'] = "phone_list";
    $ret_data['phone_list'][] = $mobile;

    foreach ($mobile_list as $key => $value) {
      
      $this->send_message($serv,$value['fd'],json_encode($ret_data));
    }
    $this->send_message($serv,$mobile['fd'],json_encode($ret_data));
  }



  function update_cmd($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
      'cmd_id'     => 'require',
      'data'       => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    

    $data = json_decode($filter['data'],true);

    S("cmd_phone_id_".$filter['cmd_id'],$data['cmd_phone_id']);

    $CmdService = \Common\Service\CmdService::instance();

    $ret = $CmdService->update($filter['cmd_id'],$data);


    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "更新录制脚本记录失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }


    //通知客户机
    // $MobileService = \Common\Service\MobileService::instance();

    // $config = [
    //             'mer_id'               => $filter['mer_id'],
    //             'm_status'             => 1,
    //             'page_size'            => false,
    //           ];

    // $mobile_list = $MobileService->get_by_cond($config);

    $cmd = $CmdService->get_by_id($filter['cmd_id']);

    $ret_data['cmd'] = "cmd_update";
    $cmd['cmd_phone_id'] = "";
    if($data['cmd_phone_id'])
      $cmd['cmd_phone_id'] = $data['cmd_phone_id'];
    $ret_data['cmd_list'][] = $cmd;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

    // foreach ($mobile_list as $key => $value) {
    //   $ret_data = [];
    //   $ret_data['cmd'] = "cmd_update";
    //   $ret_data['cmd_list'][] = $cmd;
    //   $this->send_message($serv,$value['fd'],json_encode($ret_data));
    // }

  }


  function delete_cmd($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
      'cmd_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }


    $CmdService = \Common\Service\CmdService::instance();

    $ret = $CmdService->update($filter['cmd_id'],['deleted_at'=>date('Y-m-d H:i:s')]);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "删除录制脚本记录失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $cmd = $CmdService->get_by_id($filter['cmd_id']);

    //通知客户机
    $MobileService = \Common\Service\MobileService::instance();

    $config = [
                'mer_id'               => $filter['mer_id'],
                'm_status'             => 1,
                'page_size'            => false,
              ];

    $mobile_list = $MobileService->get_by_cond($config);

    foreach ($mobile_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd'] = "cmd_update";
      $ret_data['cmd_list'][] = $cmd;
      $this->send_message($serv,$value['fd'],json_encode($ret_data));
    }

  }

  function delete_cmd_rel($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
      'cmd_id'     => 'require',
      'moblie_serial'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    $CmdService = \Common\Service\CmdService::instance();
    $ret = $CmdService->delete_cmd_rel($filter['cmd_id'],$filter['moblie_serial']);


    $cmd = $CmdService->get_by_id($filter['cmd_id']);

    if($cmd['cmd_count']==0)
    {
      $CmdService->delete($filter['cmd_id']);
    }

  }

  function upload_apk($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    $apk_data['mer_id']           = $filter['mer_id'];
    $apk_data['apk_name']         = $filter['apk_name'];
    $apk_data['file_name']        = $filter['file_name'];
    $apk_data['apk_package_name'] = $filter['apk_package_name'];
    $apk_data['apk_oss_file_url'] = $filter['apk_oss_file_url'];
    $apk_data['apk_local_path']   = $filter['apk_local_path'];
    $apk_data['file_name']        = $filter['file_name'];
    $apk_data['apk_version']      = $filter['apk_version'];
    $apk_data['apk_file_size']    = $filter['apk_file_size']?:0;
    $apk_data['status']           = $filter['status']?:1;
    $apk_data['created_at']       = date('Y-m-d H:i:s');
    $apk_data['updated_at']       = date('Y-m-d H:i:s');

    $ApkService = \Common\Service\ApkService::instance();

    $ret = $ApkService->find(['mer_id'=>$filter['mer_id'],'apk_package_name'=>$filter['apk_package_name']]);
    if($ret['id'])
    {
      $ApkService->delete($ret['id']);
    }

    $ret = $ApkService->create($apk_data);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "apk数据记录保存失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $apk = $ApkService->get_by_id($ret['id']);

    $ret_data['cmd'] = "update_apk_status";
    $ret_data['apk_list'][] = $apk;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

  }


  function apk_list($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }
   
    $ApkService = \Common\Service\ApkService::instance();

    $apk = $ApkService->get_by_id($filter['apk_id']);

    //通知客户机
    $MobileService = \Common\Service\MobileService::instance();

    $config = [
                'mer_id'               => $filter['mer_id'],
                'm_status'             => 1,
                'page_size'            => false,
              ];

    $mobile_list = $MobileService->get_by_cond($config);

    foreach ($mobile_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd'] = "apk_list";
      $ret_data['apk_list'][] = $apk;
      $this->send_message($serv,$value['fd'],json_encode($ret_data));
    }
    
  }


  function client_apk_install($serv,$filter)
  {

    $config = ['mer_id'=>$filter['mer_id']];

    $ApkService = \Common\Service\ApkService::instance();

    $ret = $ApkService->create_apk_install_rel($filter['apk_id'],$filter['moblie_serial']);

    if($ret['status'])
    {
      $apk = $ApkService->get_by_id($filter['apk_id']);
      $b_mess['cmd'] = "update_apk_status";
      $b_mess['apk_list'][] = $apk;

      $MobileService = \Common\Service\MobileService::instance();

      $master_mobile = $MobileService->find(['m_type'=>2,'mer_id'=>$filter['mer_id']]);

      $this->send_message($serv,$master_mobile['fd'],json_encode($b_mess));
    }

  }

  function apk_upload_complete($serv,$filter)
  {

    $ApkService = \Common\Service\ApkService::instance();

    $ret = $ApkService->update($filter['apk_id'],['status'=>2]);

    if($ret['status'])
    {
      $apk = $ApkService->get_by_id($filter['apk_id']);

      $b_mess['cmd'] = "apk_list";
      $b_mess['apk_list'][] = $apk;

      $MobileService = \Common\Service\MobileService::instance();
      $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

      foreach ($mobiles as $key => $value) {
        $this->send_message($serv,$value['fd'],json_encode($b_mess));
      }

    }


  }


  function delete_apk($serv,$filter)
  {

    $config = ['mer_id'=>$filter['mer_id']];

    $ApkService = \Common\Service\ApkService::instance();

    $apk = $ApkService->get_by_id($filter['apk_id']);

    $ret = $ApkService->delete($filter['apk_id']);

    if($ret['status'])
    {

      $b_mess['cmd'] = "delete_apk_file";
      $b_mess['apk'] = $apk;

      $MobileService = \Common\Service\MobileService::instance();
      $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

      foreach ($mobiles as $key => $value) {
        $this->send_message($serv,$value['fd'],json_encode($b_mess));
      }

    }

  }


  function re_install_apk($serv,$filter)
  {

    $config = ['mer_id'=>$filter['mer_id']];

    $ApkService = \Common\Service\ApkService::instance();

    $apk = $ApkService->get_by_id($filter['apk_id']);

    if($apk)
    {

      $b_mess['cmd'] = "re_install_apk";
      $b_mess['apk'] = $apk;

      $MobileService = \Common\Service\MobileService::instance();
      $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

      foreach ($mobiles as $key => $value) {
        $this->send_message($serv,$value['fd'],json_encode($b_mess));
      }

    }

  }

  function uninstall_apk($serv,$filter)
  {

    $config = ['mer_id'=>$filter['mer_id']];

    $ApkService = \Common\Service\ApkService::instance();

    $apk = $ApkService->get_by_id($filter['apk_id']);

    $ret = $ApkService->update($filter['apk_id'],['deleted_at'=>date('Y-m-d H:i:s')]);

    if($ret['status'])
    {
      $apk = $ApkService->get_by_id($filter['apk_id']);

      $b_mess['cmd'] = "apk_list";
      $b_mess['apk_list'][] = $apk;

      $MobileService = \Common\Service\MobileService::instance();
      $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

      foreach ($mobiles as $key => $value) {
        $this->send_message($serv,$value['fd'],json_encode($b_mess));
      }

    }
    
  }


  function open_apk($serv,$filter)
  {

    $b_mess['cmd'] = "open_apk";
    $b_mess['package_name'] = $filter['apk_package_name'];

    $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
    
  }

  function auto_read_apk($serv,$filter)
  {

    $b_mess['cmd'] = "auto_read_apk";
    $b_mess['package_name'] = $filter['apk_package_name'];

    $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
    
  }

  
  function run_cmd_script($serv,$filter)
  {
    $b_mess = $filter;
    $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
  }
  
  function stop_cmd_script($serv,$filter)
  {

    $b_mess = $filter;

    $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
  }
  
  function delete_apk_install_rel($serv,$filter)
  {

    $config = ['mer_id'=>$filter['mer_id']];

    $ApkService = \Common\Service\ApkService::instance();

    $ret = $ApkService->delete_apk_install_rel($filter['apk_id'],$filter["moblie_serial"]);

    if($ret['status'])
    {
      $apk = $ApkService->get_by_id($filter['apk_id']);

      if($apk['installed_count']==0)
      {
        $ret = $ApkService->delete($filter['apk_id']);
      }
      
    }

  }

  // function client_apk_delete($serv,$filter)
  // {

  //   $ApkService = \Common\Service\ApkService::instance();

  //   $ret = $ApkService->delete($filter['apk_id']);

  //   if($ret['status'])
  //   {

  //     $MobileService = \Common\Service\MobileService::instance();

  //     $mobile = $MobileService->find(['mer_id'=>$filter['mer_id']]);

  //     foreach ($mobile as $key => $value) {
  //       $b_mess['cmd'] = "delete_apk";
  //       $b_mess['apk_id'] = $filter['apk_id'];
  //       $this->send_message($serv,$value['fd'],json_encode($b_mess));
  //     }
      
  //   }

  // }

  


  function init_apk_list($serv,$filter)
  {
    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    $filter['rec_fd'] = $filter['fd'];

    $config = ['mer_id'=>$filter['mer_id']];

    $redis_key = "init_apk_list".$filter['mer_id'];

    if(!S($redis_key))
    {

      $ApkService = \Common\Service\ApkService::instance();

      $apk_list = $ApkService->get_by_cond($config);

      S($redis_key,$apk_list,5);

    }

    $apk_list = S($redis_key);

    foreach ($apk_list as $key => $value) {
      $b_mess['apk_list'] = [];
      $b_mess['cmd'] = "apk_list";
      
      $value['installed'] = 0;
      if($value['installed_moblie_serial'][$filter['Serial']])
        $value['installed'] = 1;

      unset($value['installed_moblie_serial']);

      $b_mess['apk_list'][] = $value;
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
    }

  }


  function init_cmd_list($serv,$filter)
  {
    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    $filter['rec_fd'] = $filter['fd'];

    $redis_key = "init_cmd_list_".$filter['mer_id'];
    if(!S($redis_key))
    {
       $config = ['mer_id'=>$filter['mer_id']];

      $CmdService = \Common\Service\CmdService::instance();

      $cmd_list = $CmdService->get_by_cond($config);

      S($redis_key,$cmd_list,5);
    }

    $cmd_list = S($redis_key);

    foreach ($cmd_list as $key => $value) {
      $b_mess['cmd_list'] = [];
      $b_mess['cmd'] = "cmd_list";

      $value['cmd_phone_id'] = "";
      if(S("cmd_phone_id_".$value['id']))
         $value['cmd_phone_id'] = S("cmd_phone_id_".$value['id']);
      $b_mess['cmd_list'][] = $value;
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
    }

   

  }

  function client_varcode($serv,$filter)
  {
    $body = $filter['body'];

    $VerCodeService = \Common\Service\VerCodeService::instance();
    $code = $VerCodeService->get_ver_code($body);
    $ret_data['code'] = $code;
    $ret_data['cmd'] = "clip_code";

    $this->send_message($serv,$filter['fd'],json_encode($ret_data));
  }

  function client_distribute($serv,$filter)
  {
    try
    {
      $this->send_message($serv,$filter['rec_fd'],json_encode($filter));
    }catch(Exception $e){
      error_log(date('Y-m-d H:i:s').' | client_construct:'. $e->getMessage()."\n",3,SWOOLE_PATH . DIRECTORY_SEPARATOR .'Public/client_distribute.log');
    }

  }

  function input_phone_num($serv,$filter)
  {
    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }
    $MobileService = \Common\Service\MobileService::instance();
    $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

    foreach ($mobiles as $key => $value) {

      $b_mess['cmd'] = "input_phone_num";
      $this->send_message($serv,$value['fd'],json_encode($b_mess));
    }
  }

  function input_read_article($serv,$filter)
  {
    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }
    $MobileService = \Common\Service\MobileService::instance();
    $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

    $b_mess = $filter;
    $b_mess['cmd'] = "xpread_article";
    foreach ($mobiles as $key => $value) {
      $this->send_message($serv,$value['fd'],json_encode($b_mess));
    }
  }

  

  function send_ver_code($serv,$filter)
  {

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }
    $MobileService = \Common\Service\MobileService::instance();
    $mobiles = $MobileService->get_by_cond(['m_status'=>1,'mer_id'=>$filter['mer_id']]);

    foreach ($mobiles as $key => $value) {
      
      $b_mess['cmd'] = "send_ver_code";
      $this->send_message($serv,$value['fd'],json_encode($b_mess));
    }

  }


  //注册手机信息，手机位置信息等
  function client_register($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];
    $validate = new Validate([
      'Serial'     => 'require',
      //'mer_id'     => 'require',
      'm_type'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }

    $MobileService = \Common\Service\MobileService::instance();

    $mobile = $MobileService->find(['mobile_serila'=>$filter["Serial"]]);

    if($mobile){

        $b_mess['code'] = -1;
        $b_mess['info'] = "手机已经录入";
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }
    
    //主控手机注册
    if($filter['m_type']==2)
    {
      $validate = new Validate([
        'phone'     => 'require',
        'code'      => 'require',
      ]);

      if (!$validate->check($filter)) {
        $b_mess['code'] = -1;
        $b_mess['info'] = $validate->getError();
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      S($filter['Serial'].'code',123456);

      if(S($filter['Serial'].'code')!=$filter['code'])
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "手机验证码不正确";
        $b_mess['cmd'] = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      //获取mer_id
      $RemoteLoginService = \Common\Service\RemoteLoginService::instance();
      $ret = $RemoteLoginService->get_merchant_byphone($filter['phone']);

      if(!$ret['status']){

        $b_mess['code'] = -1;
        $b_mess['info'] = $ret['msg'];
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      $merchant = $ret['data'];

      $filter["mer_id"] = $merchant['id'];

      //如果主控手机存在，恢复原主控手机出厂设置
      $master_mobile = $MobileService->find(['m_type'=>2,'mer_id'=>$filter['mer_id']]);

      if($master_mobile)
      {
        $MobileService->delete($master_mobile['id']);

        $b_mess['info'] = "重新初始化";
        $b_mess['cmd']  = "retry_init";
        $this->send_message($serv,$master_mobile['fd'],json_encode($b_mess));
      }

      $filter["client_fd"] = $filter['fd'];
    }

    $filter['rec_fd'] = $filter['fd'];

    $m_data['mobile_serila']      = $filter["Serial"];
    $m_data['mobile_brand']       = $filter["BRAND"];
    $m_data['mer_id']             = $filter["mer_id"]?:0;
    $m_data['mobile_device_id']   = $filter["Device_ID"];
    $m_data['hardware']           = $filter["HARDWARE"];
    $m_data['model']              = $filter["MODEL"];
    $m_data['batterycap']         = $filter["BatteryCap"];
    $m_data['version']            = $filter["Version"];
    $m_data['group']              = $filter["group"];
    $m_data['mobile_code']        = $filter["mobile_code"];
    $m_data['location_x']         = $filter["location_x"];
    $m_data['location_y']         = $filter["location_y"];
    $m_data['fd']                 = $filter["client_fd"];
    $m_data['m_type']             = $filter["m_type"];
    $m_data['m_status']           = 1;
    $m_data['updated_at']         = date('Y-m-d H:i:s');
    $m_data['created_at']         = date('Y-m-d H:i:s');
    
    $ret = $MobileService->create($m_data);

    $b_mess = $ret;
    $b_mess['code'] = 0;

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "注册手机数据失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
    }

    $master_mobile = $MobileService->find(['m_type'=>2,'m_status'=>1,'mer_id'=>$filter['mer_id']]);

    if(!$master_mobile)
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "主控手机未登陆";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
    }

    //任务机注册成功，通知主控机更新数据
    $mobile = $MobileService->find(['mobile_serila'=>$filter["Serial"]]);
    $ret_data['cmd'] = "get_phone_list";
    $ret_data['phone_list'][] = $mobile;
    $this->send_message($serv,$master_mobile['fd'],json_encode($ret_data));

    $this->send_message($serv,$mobile['fd'],json_encode($ret_data));
  }



  function client_mobilelist($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $MobileService = \Common\Service\MobileService::instance();

    $config = [
                'mer_id'               => $filter['mer_id'],
                // 'm_status'             => 1,
                'page_size'            => false,
              ];

    $mobile_list = $MobileService->get_by_cond($config);

    foreach ($mobile_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd'] = "get_phone_list";
      $ret_data['phone_list'][] = $value;
      $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
    }
    
  }


  function client_get_group_list($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $redis_key = "client_get_group_list_".$filter['mer_id'];

    if(!S($redis_key))
    {
      $MobileGroupService = \Common\Service\MobileGroupService::instance();

      $config = ['mer_id'=>$filter['mer_id']];

      $group_list = $MobileGroupService->get_by_cond($config);

      S($redis_key,$group_list,5);
    }

    $group_list = S($redis_key);

    foreach ($group_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd'] = "get_group_list";
      $ret_data['group_list'][] = $value;
      $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
    }
    
  }

  function add_mobile_group($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];
    $validate = new Validate([
      'mer_id'      => 'require',
      'group_name'  => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $m_data['mer_id']             = $filter['mer_id'];
    $m_data['group_name']         = $filter['group_name'];
    $m_data['code']               = $filter['code'];
    $m_data['updated_at']         = date('Y-m-d H:i:s');
    $m_data['created_at']         = date('Y-m-d H:i:s');

    $MobileGroupService = \Common\Service\MobileGroupService::instance();
    $ret = $MobileGroupService->create($m_data);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "创建设备组失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }
    $MobileGroup = $MobileGroupService->get_by_id($ret['id']);

    $ret_data['cmd'] = "get_group_list";
    $ret_data['group_list'][] = $MobileGroup;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
  }



  function delete_mobile_group($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];
    $validate = new Validate([
      'group_id'  => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $MobileGroupService = \Common\Service\MobileGroupService::instance();
    $ret = $MobileGroupService->delete($filter['group_id']);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "删除设备组失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $this->client_get_group_list($serv,$filter);
  }

  function update_mobile_group($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'group_id'  => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $MobileGroupService = \Common\Service\MobileGroupService::instance();

    if($filter['mer_id'])
    {
      $m_data['mer_id'] = $filter['mer_id'];
    }

    if($filter['group_name'])
    {
      $m_data['group_name'] = $filter['group_name'];
    }

    if($filter['code'])
    {
      $m_data['code'] = $filter['code'];
    }

    $m_data['updated_at']         = date('Y-m-d H:i:s');

    $ret = $MobileGroupService->update($filter['group_id'],$m_data);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "更新设备组失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }
    $MobileGroup = $MobileGroupService->get_by_id($filter['group_id']);

    $ret_data['cmd'] = "get_group_list";
    $ret_data['group_list'][] = $MobileGroup;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

  }

  function recover_mobile($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];
    $validate = new Validate([
      'Serial'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
     
      return;
    }
    $MobileService = \Common\Service\MobileService::instance();
    $mobile = $MobileService->find(['mobile_serila'=>$filter["Serial"]]);

    $ret = $MobileService->delete($mobile['id']);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "恢复手机出厂设置失败";
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $master_mobile = $MobileService->find(['m_type'=>2,'m_status'=>1,'mer_id'=>$mobile['mer_id']]);

    $ret_data['cmd'] = "recover_mobile";
    $ret_data['serial'] = $filter["Serial"];

    $this->send_message($serv,$mobile['rec_fd'],json_encode($ret_data));

    $this->send_message($serv,$master_mobile['fd'],json_encode($ret_data));

  }

  function queue_task_list($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }


    $config = [
                'mer_id'               => $filter['mer_id'],
                'page_size'            => false,
              ];

    $QueueTaskService = \Common\Service\QueueTaskService::instance();

    $queue_task_list = $QueueTaskService->get_by_cond($config);

    foreach ($queue_task_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd']        = "queue_task_list";
      $ret_data['queue_task'][] = $value;

      $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
    }
   

  }

  function edit_queue_task($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $task_id = $filter["task_id"];

    $QueueTaskService = \Common\Service\QueueTaskService::instance();

    if($filter['task_id'])
    {
      $queue_task = $QueueTaskService->get_by_id($filter["task_id"]);

      if(!$queue_task)
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "没有对应的任务";
        $b_mess['cmd'] = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      $queue_task['task_name']  = $filter["task_name"];
      $queue_task['updated_at'] = date('Y-m-d H:i:s');

      $ret = $QueueTaskService->update($filter["task_id"],$queue_task);

      if(!$ret['status'])
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "任务更新失败";
        $b_mess['cmd'] = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

    }else{

      $queue_task['task_name']  = $filter["task_name"];
      $queue_task['mer_id']     = $filter["mer_id"];
      $queue_task['task_num']   = 0;
      $queue_task['task_time']  = 0;
      $queue_task['mobile_count']  = 0;
      $queue_task['updated_at'] = date('Y-m-d H:i:s');
      $queue_task['created_at'] = date('Y-m-d H:i:s');

      $ret = $QueueTaskService->create($queue_task);

      if(!$ret['status'])
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "任务创建失败";
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      $task_id = $ret['id'];

    }

    $queue_task = $QueueTaskService->get_by_id($task_id);

    $ret_data['cmd']        = "queue_task_list";
    $ret_data['queue_task'][] = $queue_task;

    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
  }

  function delete_queue_task($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'task_id'     => 'require',
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $QueueTaskService = \Common\Service\QueueTaskService::instance();

    $ret = $QueueTaskService->delete($filter["task_id"]);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "任务删除失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    
    $ret_data = [];
    $ret_data['cmd']        = "delete_queue_task";
    $ret_data['task_id']    = $filter["task_id"];
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
  }


  function edit_queue_task_item($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $task_id = $filter["id"];

    $QueueTaskItemService = \Common\Service\QueueTaskItemService::instance();

    if($filter['id'])
    {
      $queue_task_item = $QueueTaskItemService->get_by_id($filter["id"]);

      if(!$queue_task_item)
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "没有对应的队列";
        $b_mess['cmd'] = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      $queue_task_item['apk_name']      = $filter["apk_name"];
      $queue_task_item['package_name']  = $filter["package_name"];
      $queue_task_item['exec_time']     = $filter["exec_time"];
      $queue_task_item['queue_task_id'] = $filter["queue_task_id"];
      $queue_task_item['updated_at']    = date('Y-m-d H:i:s');

      $ret = $QueueTaskItemService->update($filter["id"],$queue_task_item);

      if(!$ret['status'])
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "任务更新失败";
        $b_mess['cmd'] = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

    }else{

      $queue_task_item['apk_name']      = $filter["apk_name"];
      $queue_task_item['package_name']  = $filter["package_name"];
      $queue_task_item['exec_time']     = $filter["exec_time"];
      $queue_task_item['queue_task_id'] = $filter["queue_task_id"];

      $queue_task_item['mer_id']        = $filter["mer_id"];
      $queue_task_item['updated_at']    = date('Y-m-d H:i:s');
      $queue_task_item['created_at']    = date('Y-m-d H:i:s');

      $ret = $QueueTaskItemService->create($queue_task_item);

      if(!$ret['status'])
      {
        $b_mess['code'] = -1;
        $b_mess['info'] = "任务创建失败";
        $b_mess['cmd']  = "notice";
        $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
        return;
      }

      $task_id = $ret['id'];

    }


    $QueueTaskService = \Common\Service\QueueTaskService::instance();
    $ret = $QueueTaskService->update_queue_task($filter["queue_task_id"]);

    $queue_task = $QueueTaskService->get_by_id($filter["queue_task_id"]);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "更新任务信息失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $queue_task_item = $QueueTaskItemService->get_by_id($task_id);

    $ret_data = [];
    $ret_data['cmd']        = "queue_task_item_list";
    $ret_data['queue_task_item'][] = $queue_task_item;

    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

    $ret_data = [];
    $ret_data['cmd']        = "queue_task_list";
    $ret_data['queue_task'][] = $queue_task;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

  }


  function queue_task_item_list($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'mer_id'     => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd'] = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $config = [
                'mer_id'               => $filter['mer_id'],
                'page_size'            => false,
              ];

    $QueueTaskItemService = \Common\Service\QueueTaskItemService::instance();

    $queue_task_item_list = $QueueTaskItemService->get_by_cond($config);

    foreach ($queue_task_item_list as $key => $value) {
      $ret_data = [];
      $ret_data['cmd']        = "queue_task_item_list";
      $ret_data['queue_task_item'][] = $value;

      $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
    }
   

  }


  function delete_queue_task_item($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'id'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $QueueTaskItemService = \Common\Service\QueueTaskItemService::instance();
    $QueueTaskService = \Common\Service\QueueTaskService::instance();

    $queue_task_item = $QueueTaskItemService->get_by_id($filter["id"]);

    $ret = $QueueTaskItemService->delete($filter["id"]);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "任务删除失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }


    $ret = $QueueTaskService->update_queue_task($queue_task_item['queue_task_id']);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "删除任务队列，更新信息失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $queue_task = $QueueTaskService->get_by_id($queue_task_item['queue_task_id']);


    $ret_data = [];
    $ret_data['cmd']        = "delete_queue_task_item";
    $ret_data['task_item_id']    = $filter["id"];
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

    $ret_data = [];
    $ret_data['cmd']        = "queue_task_list";
    $ret_data['queue_task'][] = $queue_task;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

  }

  function delete_queue_task_device($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'queue_task_id'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $QueueTaskService = \Common\Service\QueueTaskService::instance();
    
    $ret = $QueueTaskService->delete_queue_task_device($filter['queue_task_id']);

    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "删除队列设备信息更新失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

   

  }


  function add_queue_task_device($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'queue_task_id'          => 'require',
      'mobile_serila'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $QueueTaskService = \Common\Service\QueueTaskService::instance();
    $ret = $QueueTaskService->add_queue_task_device($filter['queue_task_id'],$filter['mobile_serila']);


    if(!$ret['status'])
    {
      $b_mess['code'] = -1;
      $b_mess['info'] = "任务队列设备信息更新失败";
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $queue_task = $QueueTaskService->get_by_id($filter['queue_task_id']);
    
    $ret_data = [];
    $ret_data['cmd']          = "queue_task_list";
    $ret_data['queue_task'][] = $queue_task;
    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));
  }
  

  function exec_queue_task($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'queue_task_id'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $QueueTaskService = \Common\Service\QueueTaskService::instance();

    $queue_task = $QueueTaskService->get_by_id($filter['queue_task_id']);

    $config = [
                'queue_task_id'        => $filter['queue_task_id'],
                'page_size'            => false,
              ];

    $QueueTaskItemService = \Common\Service\QueueTaskItemService::instance();
    $queue_task_item_list = $QueueTaskItemService->get_by_cond($config);

    foreach ($queue_task_item_list as $key => $value) {
      $queue_task_item_list[$key]['run_time'] = 0;
    }

    $mobile_list = $QueueTaskService->get_queue_task_device($filter['queue_task_id']);

    foreach ($mobile_list as $key => $value) {

      S("queue_task_".$value['mobile_serila'],[]);

      if($value['fd']==0)
        continue;


      S("queue_task_".$value['mobile_serila'],$queue_task_item_list,5*60);

      $ret_data = [];
      $ret_data['cmd']        = "client_queue_task_item";
      $ret_data['queue_task_item']    = json_encode($queue_task_item_list);
      $this->send_message($serv,$value['fd'],json_encode($ret_data));

    }

  }

  function stop_queue_task($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'queue_task_id'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $QueueTaskService = \Common\Service\QueueTaskService::instance();

    $queue_task = $QueueTaskService->get_by_id($filter['queue_task_id']);

    $config = [
                'queue_task_id'        => $filter['queue_task_id'],
                'page_size'            => false,
              ];

    $QueueTaskItemService = \Common\Service\QueueTaskItemService::instance();
    $queue_task_item_list = $QueueTaskItemService->get_by_cond($config);

    $mobile_list = $QueueTaskService->get_queue_task_device($filter['queue_task_id']);
    foreach ($mobile_list as $key => $value) {

      S("queue_task_".$value['mobile_serila'],[],1);

      if($value['fd']==0)
        continue;

      $ret_data = [];
      $ret_data['cmd']        = "client_queue_task_item";
      $ret_data['queue_task_item']    = json_encode([]);
      $this->send_message($serv,$value['fd'],json_encode($ret_data));

    }

  }

  function get_client_task_item_list($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'Serial'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $queue_task_item_list = S("queue_task_".$filter['Serial']);

    $ret_data = [];
    $ret_data['cmd']                = "client_queue_task_item";
    $ret_data['queue_task_item']    = json_encode($queue_task_item_list);

    $this->send_message($serv,$filter['rec_fd'],json_encode($ret_data));

  }


  function update_running_task_item($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'Serial'                => 'require',
      'task_item_id'          => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    $queue_task_item_list = S("queue_task_".$filter['Serial']);

    S("queue_task_".$filter['queue_task_id'],$filter['Serial'],2*60);

    foreach ($queue_task_item_list as $key => $value) {

      if($value['id']==$filter['task_item_id'])
        $queue_task_item_list[$key]['run_time'] = $filter['run_time'];
    }

    S("queue_task_".$filter['Serial'],$queue_task_item_list,5*60);
  }

  function remove_running_task_item($serv,$filter)
  {

    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'Serial'                => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

    S("queue_task_".$filter['Serial'],[],1);

  }

  function pulse_queue_task($serv,$filter)
  {
    $filter['rec_fd'] = $filter['fd'];

    $validate = new Validate([
      'queue_task_id'                => 'require',
    ]);

    if (!$validate->check($filter)) {
      $b_mess['code'] = -1;
      $b_mess['info'] = $validate->getError();
      $b_mess['cmd']  = "notice";
      $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));
      return;
    }

      
    if(S("queue_task_".$filter['queue_task_id']))
      $b_mess['status'] = 1;
    else
      $b_mess['status'] = 0;

    $b_mess['queue_task_id'] = $filter['queue_task_id'];
    $b_mess['cmd']  = "pulse_queue_task";
    $this->send_message($serv,$filter['rec_fd'],json_encode($b_mess));

  }


}