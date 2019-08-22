<?php

/**
 * 验证服务
 * 登录、注册、修改密码、登出
 * 
 * @filepath /Apps/Common/Service/AuthService.class.php
 * @author Huwei
 * @version 1.0 , 2015-06-08
 */

namespace Common\Service;

use Common\Service\SysRoleService;
use Common\Service\MerchantService;
use Common\Vendor\SmsVendor;
use Common\Vendor\CCPRestSDK;

class AuthService {

  private static $instance;
  var $token_expried_time = 7200; //token  过期时间 2小时
  var $cookie_expried_time = 604800; //cookie 过期时间 7天

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new AuthService();
    }

    return self::$instance;
  }

  /**
   * 远程登录
   * @param string $username
   * @param string $password
   * @param int    $remember
   * @param string $session_name
   * @return array ajax_arr
   */
  public function login_for_client($username, $password, $remember, $session_name) {
    //检查用户名
    if (empty($username)) {
      return ajax_arr('用户名不能为空');
    }
    if (empty($password)) {
      return ajax_arr('密码不能为空');
    }

    $SysUser = M('SysUser');
    $data = $SysUser->where(' username = "%s"', $username)->find();

    if (empty($data)) {
      return ajax_arr('用户未找到');
    }
    if ($data['status'] == 5) {
      return ajax_arr('用户已禁用');
    }
    if ($data['status'] == 6) {
      return ajax_arr('用户待审核');
    }
    if ($data['password'] != md5($password)) {
      return ajax_arr('您输入的密码不正确');
    }

    //取用户角色信息
    $role_ret = $this->_get_role_data($data);
    if (!$role_ret['status']) {
      return $role_ret;
    }
    $data += $role_ret['data'];

    //取用户组信息
    $group_ret = $this->_get_group_data($data);
    if (!$group_ret['status']) {
      return $group_ret;
    }
    $data += $group_ret['data'];

    unset($data['password']);

    //取商户信息
    $Merchant = MerchantService::instance();
    $data['mer_data'] = $Merchant->get_by_manager_user_id($data['id']);
    if (empty($data['mer_data'])) {
      return ajax_arr('商户信息未找到');
    }
    // session(array('name'=>$session_name,'expire'=>3600));
    // session($session_name, $data);


    $ret['token'] = $this->_after_login($data, $remember, $session_name);
    return ajax_arr('登录成功', TRUE, ['data'=>$data]);
  }

  /**
   * 管理员登录
   * @param string $username
   * @param string $password
   * @param int    $remember
   * @param string $session_name
   * @return array ajax_arr
   */
  public function login_for_backend($username, $password, $remember, $session_name) {
    //检查用户名
    if (empty($username)) {
      return ajax_arr('用户名不能为空');
    }
    if (empty($password)) {
      return ajax_arr('密码不能为空');
    }

    $SysUser = M('SysUser');
    $data = $SysUser->where(' username = "%s"', $username)->find();

    if (empty($data)) {
      return ajax_arr('用户未找到');
    }
    if ($data['status'] == 5) {
      return ajax_arr('用户已禁用');
    }
    if ($data['status'] == 6) {
      return ajax_arr('用户待审核');
    }
    if ($data['password'] != md5($password)) {
      return ajax_arr('您输入的密码不正确');
    }

    //取用户角色信息
    $role_ret = $this->_get_role_data($data);
    if (!$role_ret['status']) {
      return $role_ret;
    }
    $data += $role_ret['data'];

    //取用户组信息
    $group_ret = $this->_get_group_data($data);
    if (!$group_ret['status']) {
      return $group_ret;
    }
    $data += $group_ret['data'];


    unset($data['password']);
    session($session_name, $data);


    $ret['token'] = $this->_after_login($data, $remember, $session_name);
    return ajax_arr('登录成功', TRUE, $ret);
  }

  /**
   * 取用户角色信息
   * @param type $data
   * @return type
   */
  function _get_role_data($data) {
    $SysRole = SysRoleService::instance();
    $role_data = $SysRole->get_by_user_id_for_auth($data['id']);
    if (empty($role_data)) {
      return ajax_arr('用户角色错误');
    }
    return ajax_arr('OK', TRUE, array(
      'data' => $role_data
    ));
  }

  /**
   * 取用户组信息
   * @param type $data
   * @return type
   */
  function _get_group_data($data) {
    $SysGroup = SysGroupService::instance();
    $group_data = $SysGroup->get_by_user_id_for_auth($data['id']);
    if (empty($group_data)) {
      return ajax_arr('用户组错误');
    }
    return ajax_arr('OK', TRUE, array(
      'data' => $group_data
    ));
  }

  /**
   * 管理员登录
   * @param string $username
   * @param string $password
   * @param int    $remember
   * @param string $session_name
   * @return array ajax_arr
   */
  public function login_for_mp($username, $password, $remember, $session_name) {
    //检查用户名
    if (empty($username)) {
      return ajax_arr('用户名不能为空');
    }
    if (empty($password)) {
      return ajax_arr('密码不能为空');
    }

    $SysUser = M('SysUser');
    $data = $SysUser->where(' username = "%s"', $username)->find();

    if (empty($data)) {
      return ajax_arr('用户未找到');
    }
    if ($data['status'] == 5) {
      return ajax_arr('用户已禁用');
    }
    if ($data['status'] == 6) {
      return ajax_arr('用户待审核');
    }
    if ($data['password'] != md5($password)) {
      return ajax_arr('您输入的密码不正确');
    }

    //取用户角色信息
    $role_ret = $this->_get_role_data($data);

    if (!$role_ret['status']) {
      return $role_ret;
    }
    $data += $role_ret['data'];

    //取用户组信息
    $group_ret = $this->_get_group_data($data);
    if (!$group_ret['status']) {
      return $group_ret;
    }
    $data += $group_ret['data'];

    unset($data['password']);

    
    //取商户信息
    $Merchant = MerchantService::instance();
    $data['mer_data'] = $Merchant->get_by_manager_user_id($data['id']);
    if (empty($data['mer_data'])) {
      return ajax_arr('商户信息未找到');
    }

    session(array('name'=>$session_name,'expire'=>3600));
    session($session_name, $data);
    $ret['token'] = $this->_after_login($data, $remember, $session_name);
    return ajax_arr('登录成功', TRUE, $ret);
  }
  
  public function login_by_id($member_id,$session_name)
  {
  	$Member = M('Member');
  	$data = $Member->where(' id = "%s"', $member_id)->find();
  	
  	
  	//查询用户会员信息
  	$member_group=M('member_group')->where(array('id'=>$data['group_id']))->find();
  	$data['member_name']=$member_group['name'];
  	 
  	session($session_name, $data);
  	
  	//更新用户登录的IP和时间
  	$m_mod=D('member');
  	
  	$m_mod->login_ipaddress=get_client_ip();
  	$m_mod->last_login=date("Y-m-d H:i:s",time());//get_client_ip();
  	$user_id=$m_mod->where('id='.$data['id'])->save();
  	
  	return ajax_arr('登录成功', TRUE,array('username'=>$data['username']));
  }

  /**
   * 商城用户登录
   * @param string $username
   * @param string $password
   * @param int    $remember
   * @param string $session_name
   * @return array ajax_arr
   */
  public function login_for_home($username, $password, $autologin, $session_name) {
  	
    //检查用户名
    if (empty($username)) {
      return ajax_arr('用户名不能为空');
    }
    if (empty($password)) {
      return ajax_arr('密码不能为空');
    }
  
    $Member = M('Member');
    $data = $Member->where(' username = "%s"', $username)->find();
    
    if (empty($data)) {
      return ajax_arr('当前账号不存在');
    }
   if ($data['status'] == 5) {
     return ajax_arr('用户已禁用');
   }
   if ($data['status'] == 6) {
     return ajax_arr('用户待审核');
   }
   
   
   if ($data['password'] != md5($password)) {
     return ajax_arr('您输入的密码不正确');
   }

    unset($data['password']);
    
    //查询用户会员信息
    $member_group=M('member_group')->where(array('id'=>$data['group_id']))->find();
    $data['member_name']=$member_group['name'];
    
   
    session($session_name, $data);

   	//保存用户名cookie 7天有效期
    if (!empty($autologin)) {
      cookie($session_name, $data['username'], $this->cookie_expried_time);
    }
    else
    	cookie($session_name, null);
    
    //更新用户登录的IP和时间
    $m_mod=D('member');
    
    $m_mod->login_ipaddress=get_client_ip();
    $m_mod->last_login=date("Y-m-d H:i:s",time());//get_client_ip();
    $user_id=$m_mod->where('id='.$data['id'])->save();
    
    return ajax_arr('登录成功', TRUE,array('username'=>$data['username']));
  }

  /**
   * 登录完成的处理
   * @param array $data
   * @param bool $remember
   * @param string $session_name
   * @return string
   */
  function _after_login($data, $remember, $session_name) {
    if (!empty($remember)) {
      cookie($session_name, $data['username'], $this->cookie_expried_time);
    }

    $login_data = array(
      'last_login' => date('Y-m-d H:i:s'),
    );

    //如果token过期 则更新
    if ($data['token_expired'] < time()) {
      $login_data['token'] = md5(rand_string(12));
      $login_data['token_expired'] = time() + $this->token_expried_time;
    }

    //生产token 写登录时间
    $SysUser = M('SysUser');
    $SysUser->where('id = %d', $data['id'])->save($login_data);

    //写统计
    return isset($login_data['token']) ? $login_data['token'] : $data['token'];
  }

  /**
   * 登出 删除session 和 cookie
   */
  public function logout($session_name, $session_menu_name,$session_func_name) {
    session($session_name, null);
    session($session_menu_name, null);
    session($session_func_name, null);
    session('mer_id',null);
//     cookie($session_name, null);
  }

  /**
   * 判断是否登录
   * @param type $session_name
   * @return boolean
   */
  function is_login($session_name) {
    $auth = session($session_name);
    if ($auth && !empty($auth)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * 修改密码
   * $config { '' }
   */
  public function chpass_backend($old_pwd, $pwd, $pwd_confirm, $session_name) {
    $auth = session($session_name);

    $uid = $auth['id'];

    if (empty($old_pwd)) {
      return ajax_arr('原密码不能为空');
    }

    $SysUser = M('SysUser');

    $userdata = $SysUser->where('id = %d', $uid)->find();

    if (empty($userdata)) {
      return ajax_arr('用户未找到');
    }

    if ($userdata['pwd'] != $old_pwd && $userdata['pwd'] != md5($old_pwd)) {
      return ajax_arr('原密码输入不正确');
    }
    if (empty($pwd)) {
      return ajax_arr('新密码不能为空');
    }
    if ($pwd != $pwd_confirm) {
      return ajax_arr('两次输入的密码不正确');
    }

    $ret = $SysUser->where('id = %d', $uid)->save(array(
      'pwd' => md5($pwd)
    ));

    if ($ret) {
      return ajax_arr('密码修改成功', TRUE);
    } else {
      return ajax_arr('密码修改失败，请稍后再试');
    }
  }

  function reset_pwd($user_id) {
    $SysUser = M('SysUser');

    $data = array(
      'password' => md5('123456'),
      'update_time' => date('Y-m-d H:i:s'),
    );

    $ret = $SysUser->where('id=%d', $user_id)->save($data);
    if ($ret) {
      return ajax_arr('用户密码已重置为：123456');
    } else {
      return ajax_arr('密码重置失败，请稍后再试');
    }
  }

  function register_for_store($data) {
   
    $MerUser = M('member');
    $data['group_id']=4;
    $data['create_time'] = date('Y-m-d H:i:s');
    $ret = $MerUser->add($data);
    return ajax_arr($ret, TRUE,array('id'=>$ret));
  }

  function check_username($username) {
    if (!$username)
      return ajax_arr('用户名不能为空');
    $MerUser = M('member');

    $user_data = $MerUser->field('username')->where('username = "' . $username . '"')->find();
    if ($user_data['username']) {
      return ajax_arr('用户名已存在，请重新输入');
    } else {
      return ajax_arr(TRUE, TRUE);
    }
  }
  
  /**
   * 修改密码
   * @param $data['username'] 用户 就是手机号
   * @param $data['phone'] 手机号
   * @param $data['password'] 新密码
   * 
   */
  function reback_pwd($data)
  {
  	$MerUser = D('member');
  	
  	$user_data = $MerUser->where('username = "' . $data['username'] . '"')->save(array("password"=>$data['password']));
  	if ($user_data!==false) {
  		return ajax_arr(TRUE, TRUE);
  	} else {
  		return ajax_arr("密码修改失败", 0);
  	}
  }

  /**
   * 发送短信验证码
   * @param type $account 手机号码集合，用英文逗号分开
   * @param type $datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
   * @param type $class 类别，用于区分哪个发送的短信，1注册模块
   * @return type
   */
  function send_sms($account, $class = 1, $session_name, $tempId) {
    if (!$account)
      return ajax_arr('请输入手机号。');

    $SmsLogs = M('SmsLogs');

    $sms_data = $SmsLogs->field('max(send_time) as send_time')->where('account ="' . $account . '"')->find();
    if ($sms_data['send_time']) {
      $second = time() - strtotime($sms_data['send_time']);
      if ($second < intval(C('send_gap'))) {
        return ajax_arr('验证码发送过于频繁，请稍后再试');
      }
    }

    $tempId = $tempId ? $tempId : C('SMS_TEMPID');
    //生成6位短信随机验证码
    $rand_nums = rand(100000, 999999);
    $datas[] = $rand_nums;

    // 初始化 SDK 
    $SmsVendor = new SmsVendor(C('SMS_SERVERIP'), C('SMS_SERVERPORT'), C('SMS_SOFTVERSION'));
    $SmsVendor->setAccount(C('SMS_ACCOUNT_SID'), C('SMS_ACCOUNT_TOKEN'));
    $SmsVendor->setAppId(C('SMS_APPID'));

    // 发送模板短信
    $result = $SmsVendor->sendTemplateSMS($account, $datas, $tempId);
    if ($result == NULL) {
      return ajax_arr('发送验证码失败');
    }

    if ($result->statusCode != 0) {
      return ajax_arr($result->statusMsg);
    } else {
      // 获取返回信息
      $smsmessage = $result->TemplateSMS;

      $data = array(
        'account' => $account,
        'content' => $rand_nums,
        'send_time' => date('Y-m-d H:i:s', strtotime($smsmessage->dateCreated)),
        'messageid' => $smsmessage->smsMessageSid . '',
        'class' => $class
      );

      $ret = $SmsLogs->add($data);
      session($session_name, $rand_nums);
      return ajax_arr($ret, TRUE);
    }
  }
  
  // function sendTemplateSMS($to,$datas,$tempId)
  // {
  	
  // 	//主帐号
  // 	$accountSid= '8a48b55151f715fb0152006db9190c86';
  	
  // 	//主帐号Token
  // 	$accountToken= '2f90800e4bd140769a14bd052a079e40';
  	
  // 	//应用Id
  // 	$appId='aaf98f8951f73625015200b5e9550d9a';
  	
  // 	//请求地址，格式如下，不需要写https://
  // 	$serverIP='app.cloopen.com';
  	
  // 	//请求端口
  // 	$serverPort='8883';
  	
  // 	//REST版本号
  // 	$softVersion='2013-12-26';
  
  // 	// 初始化REST SDK
  // 	$rest = new SmsVendor($serverIP,$serverPort,$softVersion);
  	
  // 	$rest->setAccount($accountSid,$accountToken);
  // 	$rest->setAppId($appId);
  
  // 	$result = $rest->sendTemplateSMS($to,$datas,$tempId);
  	
  // 	if($result == NULL ) {
  // 		echo 0;
  // 		break;
  // 	}
  // 	if($result->statusCode!=0) {
  // 		return 0;
  // 		//下面可以自己添加错误处理逻辑
  // 	}else{
  // 		return 1;
  // 		//下面可以自己添加成功处理逻辑
  // 	}
  // }
  
 function update_password($newpassword, $username) {
  	$SysUser = M('SysUser');
  	$data['password'] = md5($newpassword);
  	$data['update_time'] =date('Y-m-d H:i:s');
  	$ret = $SysUser->where(' username = "%s"', $username)->save($data);
  	if ($ret == false) {
  		return ajax_arr('密码修改失败', FALSE);
  	} else {
  		return ajax_arr('密码修改成功', TRUE);
  	}
  }
function check_password($password,$username){
  	$SysUser = M('SysUser');
  	$data = $SysUser->field('password')->where(' username = "%s"', $username)->find();
  	if ($data['password']==md5($password)) {
  		return ajax_arr($password,TRUE);
  	} else {
  		return ajax_arr($password,FALSE);
  	}
  }
  //修改密码
  function retrieve_pwd($data)
  {
  	$MerUser = D('member');
  	 if($data['type']==1){
  	 	$user_data = $MerUser->where('phone = "' . $data['phone'] . '"')->save(array("password"=>$data['password']));
  	 	if ($user_data!==false) {
  	 		return ajax_arr(TRUE, TRUE);
  	 	} else {
  	 		return ajax_arr("密码修改失败", 0);
  	 	}
  	 	}else if($data['type']==2){
  	 		$user_data = $MerUser->where('email = "' . $data['email'] . '"')->save(array("password"=>$data['password']));
  	 		if ($user_data!==false) {
  	 			return ajax_arr(TRUE, TRUE);
  	 		} else {
  	 			return ajax_arr("密码修改失败", 0);
  	 		}
  	 	}
  	 
  }
  	
}
