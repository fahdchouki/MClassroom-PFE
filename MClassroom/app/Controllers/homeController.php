<?php 

class homeController extends Controller{

    public function index()
    {
        return auth()->isLogged() ? $this->view('admin' . DS . 'index') : $this->view('login');
    }
    
}