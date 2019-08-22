<?php
/**
 * {module_name} Service
 * 
 * @filepath  Apps/Common/Service/ArticleClassService.class.php
 * @author  ryadmin 
 * @version 1.0 , 2015-12-21
 */
namespace Common\Service;


class ArticleClassService {
  
  private static $instance;
  var $status = array(
    1 => '启用',
    0 => '禁用',
  );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new ArticleClassService();
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
    $ArticleClass = M('ArticleClass');
    $data = $ArticleClass->where($where)->find();
    return $data ? $data : array();
  }

  function get_by_id( $id ){
    $ArticleClass = M('ArticleClass');
    $data = $ArticleClass->find( $id ) ;
    return $data ? $data : array();
  }
  
  function get_by_cond( $config ) {
    $default = array(
        'page' => 1,
        'page_size' => 6,
        'status' => '' ,
        'count' => FALSE,
        'order' => 'ASC' ,
        'sort' => 'ac_sort',
    );

    $config = extend($config, $default);

    $ArticleClass = M('ArticleClass');
    
    $where = array();
    
    if(!empty($config['keyword'])){
    	$k=$config['keyword'];
    	$where['_string']=" ac_name like '%$k%' ";
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
      return $ArticleClass->where($where)->count() ;
    } else {
      $order = $config['sort'] . ' ' . $config['order'] ;
      $limit = ($config['page'] - 1 ) * $config['page_size'] . ' , ' . $config['page_size'];
      $data = $ArticleClass
              ->where($where)
              ->limit($limit)->order( $order )->select();
//      echo $ArticleClass->_sql();
      return $data ? $data : array();
    }
  }
  
  function get_by_class($config) {
    $default = array(
      'ac_parent_id' => 0 ,
      'status' => '',
    );

    $config = extend($config, $default);
    $where = array(
      'id' => array('NEQ' , 0 )
    );
    if (!empty($config['status'])) {
      $where['status'] = $config['status'];
    }
 
    
    $ArticleClass = M('ArticleClass');
    $order = 'ac_sort ASC ';
    $data = $ArticleClass
      ->where($where)->order($order)->select();

//    echo $ArticleClass->_sql();
    $result = array();
    $index = array();

    foreach ( $data as $row ) {
      if ( $row['ac_parent_id'] == $config['ac_parent_id'] ) {  
        $result[$row['id']] = $row;
        $index[$row['id']] = & $result[$row['id']];
      } else {
        $index[$row['ac_parent_id']]['son'][$row['id']] = $row;
        $index[$row['id']] = & $index[$row['ac_parent_id']]['son'][$row['id']];
      }
    }
    return $this->_tree_to_array($result);
  }

  function _tree_to_array($arr) {
    $ret = array();
    foreach ($arr as $val) {
      if (isset($val['son'])) {
        $val['son'] = $this->_tree_to_array($val['son']);
      }
      $ret[] = $val;
    }
    return $ret;
  }
  
  function create($data, $is_ajax = true) {
    $ArticleClass = M('ArticleClass');
    $ret = $ArticleClass->add($data);
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

  function update( $id , $data ) {
    $ArticleClass = M('ArticleClass');
    
    $ret = $ArticleClass->where("id = %d", $id)->save($data);
    if ($ret === false ) {
      return ajax_arr('编辑失败', FALSE);
    } else {
      return ajax_arr('编辑成功', TRUE);
    }
  }
  
  function delete( $ids ) {
    $ArticleClass = M('ArticleClass');
    $ret = $ArticleClass->delete($ids);
    if ($ret == 0) {
      return ajax_arr('未删除任何数据', FALSE);
    } else if (!$ret) {
      return ajax_arr('删除失败', FALSE);
    } else {
      return ajax_arr('删除' . $ret . '行数据', TRUE);
    }
  }
  function update_inc( $id ) {
  	$Article = M('Article');
  
  	$ret = 	$Article->where("id = %d", $id)->setInc("count");
  	if ($ret === false ) {
  		return ajax_arr('编辑失败', FALSE);
  	} else {
  		return ajax_arr('编辑成功', TRUE);
  	}
  }
   
  function get_class_all($config){
  	
  	$ArticleClass = M('ArticleClass');
    $field = '  ac.id,ac.ac_name,ac.ac_parent_id,a.id as a_id,a.ac_id,a.article_title ';
    $where = array(
      'ac.status' => $config['status'] ,
      'ac.is_show' => $config['is_show'],
      'a.article_show' => $config['is_show'],
     // 'ac.type' => $config['type']
    );
    $data = $ArticleClass
              ->alias('ac')
              ->field($field)
              ->join(' article a  on ac.id=a.ac_id ')
              ->where( $where )
              ->order( ' ac.id DESC ' )
              ->select();
    
    $field1 = '  ac.id,ac.ac_name,ac.ac_parent_id';
    $where1 = array(
    		'ac.status' => $config['status'] ,
    		'ac.is_show' => $config['is_show'],
    		//'ac.type' => $config['type']
    );
    $data1 = $ArticleClass->alias('ac')->field($field1)->where( $where1 )->order( ' ac.id asc ' )->select();
    
  	$result = array();
  	
  	foreach ( $data1 as $row1 ) {
  		$result[$row1['id']] = $row1;
  		foreach ( $data as $row ){
  			if($row1['id']==$row['id']){
  				$result[$row1['id']]['son'][$row['a_id']] = $row;
  			}
  		}
  	}
  	
  
  	return  $this->_tree_to_array($result);
  }
}
