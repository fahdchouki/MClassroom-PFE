<?php
class courseController extends Controller{
    public function create(){
        if(auth()->isLogged()){
            // $data['orders'] = $this->orderModel->getOrders();
            return $this->view('admin' . DS . 'course' . DS . 'create-course');
        }else{
            
        }
    }
}