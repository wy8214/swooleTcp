<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/DoctorService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class VerCodeService {
  
  private static $instance;
  

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new VerCodeService();
    }

    return self::$instance;
  }

  function get_ver_code($str)
  {

    $code = "";

    echo "body+++++++".$str."\n";
    if (strpos($str, "趣头条"))
    {
      $code = mb_substr($str,11,4,"UTF-8");//substr($str, 32,6);
    }

    if (strpos($str, "支付宝"))
    {
      $code = mb_substr($str,6,10,"UTF-8");//substr($str, 32,6);
    }

    if (strpos($str, "东方头条"))
    {
      $code = mb_substr($str,10,14,"UTF-8");//substr($str, 32,6);
    }

    if (strpos($str, "快头条"))
    {
      $str = mb_substr($str,15,21,"UTF-8");
      $code = mb_substr($str,0,6,"UTF-8");
    }

    echo "code111111+++++++".$code."\n";

    return $code;
  }
}