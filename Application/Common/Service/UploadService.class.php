<?php

/**
 * 上传 Service
 * 
 * @filepath Apps/Common/Service/UploadService.class.php
 * @author Huwei
 * @version 1.0 , 2015-10-13
 */

namespace Common\Service;

class UploadService {

  private static $instance;
  var $error;
  var $type = array(
    'img' => array('jpg', 'gif', 'png', 'bmp', 'jpeg'),
    'file' => array('pem','zip', 'rar', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'chm', 'txt', 'php', 'js', 'html', 'css'),
    'all' => '',
  );
  var $path = array(
    'common',
    'merchant',
    'tmp',
    'kindeditor',
  );
  var $file_list = array(); //用以ftp

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new UploadService ();
    }

    return self::$instance;
  }

  function set_error($err) {
    $this->error = $err;
  }

  function get_error() {
    return $this->error;
  }

  /**
   * 上传
   * @param type $config
   * @return type
   */
  function do_upload($config) {

    $this->file_list = array();
    $root_path = "./Public/upload/";
    
    $save_path = $config['path'] . '/';
    if (!empty($config['mer_id'])) {
      $save_path .= 'mer_' . $config['mer_id'] . '/';
    }

    //echo $root_path ;
    //上传配置
    $upload_config = array(
      'maxSize' => $config['max_size'],
      'rootPath' => $root_path,
      'savePath' => $save_path,
      'saveName' => $config['save_name']?:array('uniqid', '') ,
      'exts' => $this->type[$config['type']],
      'autoSub' => true,
      'subName' => array('date', 'Ym')
    );

    $upload = new \Think\Upload($upload_config); //本地上传
    $info = $upload->upload();
 
    if (!$info) {
      // 上传错误提示错误信息
      if ($config['is_ke']) {
        return array(
          'error' => 1,
          'message' => $upload->getError()
        );
      } else {
        return ajax_arr($upload->getError(), FALSE);
      }
    } else {
      $save_path = $root_path . $info['imgFile']['savepath'] . $info['imgFile']['savename'];
      $ab_path = $config['save_type'] == 'ftp' ? C('UPLOAD_BASE_URL') . $save_path : U($save_path, '', TRUE, TRUE);

      $ab_path=str_replace("https", "http", $ab_path);


      $ret['data'] = array(
        'ab_path'   => $ab_path,
        'save_path' => $save_path,
        'mimes'     => $info['imgFile']['type'],
        'size'      => $info['imgFile']['size'],
        'name'      => $info['imgFile']['savename'],
        'filename'  => $info['imgFile']['name'],
      );
      
      $img_info = getimagesize($save_path);
     
      //如果是图片
      if ($img_info) {
        $ret = $this->_do_img($img_info, $config, $ret);
        if(!$ret['status']) return ajax_arr($ret['info'], FALSE);
      }

      $ret['data']['ab_path']=str_replace("./", "/", $ret['data']['ab_path']);
      $ret['data']['save_path']=str_replace("./", "/", $ret['data']['save_path']);
      
      //如果是kindeditor
      if ($config['is_ke']) {
        return array(
          'error' => 0,
          'url' => $ret['data']['ab_path']
        );
      } else {
        return ajax_arr("上传成功", TRUE, $ret);
      }
    }
  }

  /**
   * 如果是图片 则处理
   * @param type $img_info
   * @param type $config
   * @param type $ret
   * @return type
   */
  function _do_img($img_info, $config, $ret) {
    $ret['data']['width'] = $img_info[0];
    $ret['data']['height'] = $img_info[1];

    //检查图片尺寸
    $ret_check_img = $this->_check_img($ret['data']['save_path'], $config);
    $ret['status'] = true;
    $ret_check_img['status']=1;
    if (!$ret_check_img['status']) {
      unlink($ret['data']['save_path']);
      return $ret_check_img;
    }
    $this->file_list[] = $ret['data']['save_path'];

   
    //创建缩略图
    if (!empty($config['thumb'])) {
      $this->_create_thumb($ret['data']['save_path'], $config);
    }
    //如果传FTP
    if ($config['save_type'] == 'ftp') {
      $this->_do_ftp($config);
    }

    if ($config['save_type'] == 'cos') {

      $ab_path = $ret['data']['ab_path'];
      $thumb = explode('|', $config['thumb']);
      foreach ($thumb as $size) {
        $size_arr = explode(',', $size);
        $ret['data']['ab_path'] = get_thumb($ab_path,$size_arr[0]);
        $ret = $this->cos_upload($ret);
      }

      $ret['data']['ab_path'] = $ab_path;
      $ret = $this->cos_upload($ret);

    }
    //如果存到相册
    if ($config['save_ablum'] == 1) {

      $ret['data']['save_path']=str_replace("./", "/", $ret['data']['save_path']);
      $ablum_data = $ret['data'];

      $ablum_data['catalog_id'] = $config['ablum_cata'];
      $ablum_data['mer_id'] = $config['mer_id'];
      $this->_save_ablum($ablum_data);
    }
    $ret['status'] = true;
    return $ret;
  }

  /**
   * 保存到相册
   * @param type $data
   */
  function _save_ablum($data) {
    unset($data['ab_path']);

    $MerAlbumService = \Common\Service\AlbumService::instance();
    $MerAlbumService->create($data);
  }

  /**
   * 检查文件尺寸
   * @param type $save_path
   * @param type $config
   * @return type
   */
  function _check_img($save_path, $config) {
    
    $image = new \Think\Image ();
    $image->open($save_path);

    $width = $image->width(); // 返回图片的宽度
    $height = $image->height(); // 返回图片的高度

    if ($config['min_width'] > 0 && $width < $config['min_width']) {
      return ajax_arr('图片宽度需大于' . $config['min_width']);
    }

    if ($config['min_height'] > 0 && $height < $config['min_height']) {
      return ajax_arr('图片高度需大于' . $config['min_height']);
    }

    if ($config['max_width'] > 0 && $width > $config['max_width']) {
      return ajax_arr('图片宽度需小于' . $config['max_width']);
    }

    if ($config['max_height'] > 0 && $height > $config['max_height']) {
      return ajax_arr('图片高度需小于' . $config['max_height']);
    }

    return ajax_arr('OK', TRUE);
  }

  /**
   * 创建 缩略图
   * @param type $img_path
   * @param type $config
   */
  function _create_thumb($img_path, $config) {
    $image = new \Think\Image();
    $image->open($img_path); // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg

    $path_info = pathinfo($img_path);

    $thumb = explode('|', $config['thumb']);
    foreach ($thumb as $size) {
      $size_arr = explode(',', $size);
      $save_path = $path_info['dirname'] . '/' . $path_info['filename'] . '.' . $size_arr[0] . '.' . $path_info['extension'];

      $image->thumb($size_arr[0], $size_arr[1])->save($save_path);
      $this->file_list[] = $save_path;
    }
  }

  /**
   * 通过ftp传到其他服务器
   * @param type $config
   * @return type
   */
  function _do_ftp() {
//   	$remote_file="/tfiles.pchmall.com/Public/upload/merchant/1.jpg";
  	$UPLOAD_FTP_CONFIG=C('UPLOAD_FTP_CONFIG');
    $ftp = new FtpService($UPLOAD_FTP_CONFIG);
    foreach ($this->file_list as $file) {
    	$remote_file=$UPLOAD_FTP_CONFIG['root_dir'].str_replace("./", "/", $file);
    	
      if ($ftp->put($remote_file, $file)) {
        unlink($file);
      } else {
        echo $ftp->get_error();
      }
    }

    $ftp->close();
  }


  function cos_upload($ret)
  {
    // 配置项 start
    $appid = '1252350619';
    $bucket_name = 'ds';
    $dir_name = 'upload';
    $secretID = 'AKIDERXUGzu7RabRC8rgATgw7INMBoFYLrvu';
    $secretKey = 'sfQBpJbt7GED4mImItPn4A5pNj0DID9A';

    // 配置项 end
    $pic_url = str_replace("./", "/", $ret['data']['ab_path']);

    // 获取文件名
    $filename = end(explode('/', $pic_url));
    // 构造上传url
    $upload_url = "sh.file.myqcloud.com/files/v2/$appid/$bucket_name/$dir_name/$filename";
   
   // 设置过期时间
    $exp = time() + 3600;
    // 构造鉴权key
    $sign = "a=$appid&b=$bucket_name&k=$secretID&e=$exp&t=" . time() . '&r=' . rand() . "&f=/$appid/$bucket_name/$dir_name/$filename";
    $sign = base64_encode(hash_hmac('SHA1', $sign, $secretKey, true) . $sign);
    // 构造post数据
    $post_data = [
        'op' => 'upload',
        'filecontent' => file_get_contents($pic_url),  // baidu logo
    ];
    // 设置post的headers, 加入鉴权key
    $header = [
        'Content-Type: multipart/form-data',
        'Authorization: ' . $sign,
    ];
    // post
    $ch = curl_init($upload_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($res, true);
    if (isset($res['data']['access_url'])) {

      $ret['data']['save_path'] = $res['data']['access_url'];
        // 成功, 输出文件url
        return  $ret;
    } else {
        // 失败
        return  $ret;
    }
  }

}
