<?php
namespace Common\Controller;

class EmptyController extends MyController {
    
    public function index(){
        
        $this->display('/App/Common/View/Index/404');
        
    }    

}
