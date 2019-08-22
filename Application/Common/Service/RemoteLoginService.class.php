<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/DoctorService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class RemoteLoginService {
  
  private static $instance;
  
  var $status = array(
      0=>'禁用',
      1=>'启用',
      2=>'待审核',
    );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new RemoteLoginService();
    }

    return self::$instance;
  }
  
  function loing_remote($username,$password,$session_name)
  {
    if (empty($username)) {
      return ajax_arr('用户名不能为空');
    }
    if (empty($password)) {
      return ajax_arr('密码不能为空');
    }


    $param_data['session_id'] = session_id();
    $param_data['username']   = $username;
    $param_data['password']   = $password;
    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/userLogin';

    $res = http_post_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('登录失败');

    session(array('name'=>$session_name,'expire'=>3600));
    session($session_name, $res['result']);

    return ajax_arr('登录成功',true);

  }


  function get_menu_remote($sys_type)
  {

    $param_data['session_id'] = session_id();
    $param_data['sys_type']   = $sys_type;

    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/getAuthBySessionID';

    $res = http_post_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('获取菜单失败');

    return ajax_arr('获取菜单成功',true,['data'=>$res['result']]);

  }

  function get_func_url_remote($role_id,$sys_type)
  {

    $param_data['role_id']    = $role_id;
    $param_data['sys_type']   = $sys_type;


    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/getRoleOpt';

    $res = http_post_function($url,$param_data);
    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('获取角色权限失败');

    return ajax_arr('获取角色权限成功',true,['data'=>$res['result']]);

  }

  function get_mer_role($mer_id,$sys_type)
  {
    $param_data['sys_type']   = $sys_type;
    $param_data['mer_id']   = $mer_id;

    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/getMerRole';

    $res = http_post_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('获取角色失败');

    return ajax_arr('获取角色权限成功',true,['data'=>$res['list']]);
  }

  function create_mer_role($mer_id,$name,$sys_type,$status,$sort,$desc="",$expand="")
  {

    $param_data['sys_type']   = $sys_type;
    $param_data['mer_id']     = $mer_id;
    $param_data['name']       = $name;
    $param_data['desc']       = $desc;
    $param_data['expand']     = $expand;
    $param_data['sort']       = $sort;
    $param_data['status']     = $status;

    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/createMerRole';

    $res = http_post_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('创建角色失败');

    return ajax_arr('创建角色权限成功',true,['data'=>$res['result']]);
  }

  function get_merchant_byphone($phone)
  {

    $param_data['phone']   = $phone;
   
    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/getMerchant';

    $res = http_post_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('获取商户信息失败');

    return ajax_arr('获取商户信息成功',true,['data'=>$res['result']]);

  }


  function get_merchant_byid($id)
  {

    $param_data['id']   = $id;
   
    $remote_interface = C('REMOTE_INTERFACE');

    $url = $remote_interface.'/Center/MpLogin/getMerchant';

    $res = http_post_function($url,$param_data);

    $res = json_decode(trim($res,chr(239).chr(187).chr(191)),true);

    if($res['code']!=0)
      return ajax_arr('获取商户信息失败');

    return ajax_arr('获取商户信息成功',true,['data'=>$res['result']]);

  }
 
}
