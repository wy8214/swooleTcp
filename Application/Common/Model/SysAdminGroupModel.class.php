<?php

namespace Common\Model;

use Think\Model;

class SysAdminGroupModel extends Model {
  protected $trueTableName = 'sys_admin_group';
  function get_group($web_type) {
    $where = array (
        'web_type' => $web_type 
    );
    if ($web_type == 2) {
      $where ["id"] = array (
          "NEQ",
          1 
      );
    }
    return $this->where ( $where )->select ();
  }
}
