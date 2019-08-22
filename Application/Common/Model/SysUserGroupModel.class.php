<?php

namespace Common\Model;

use Think\Model;

class SysUserGroupModel extends Model {

  protected $trueTableName = 'sys_user_group';

  function get_group($web_type) {
    $where['web_type'] = $web_type;
    
    if ( $web_type == 2 ) {
      $where ["id"] = array("NEQ", 1);
    }
    
    return $this->where($where)->select();
  }

}
