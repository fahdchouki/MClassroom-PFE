<?php

class userController extends Controller{
    public $userModel;
    public function __construct(){
        $this->userModel = new UserModel;
    }

    public function index(){
        $this->profile();
    }

    public function profile(){
        if(auth()->isLogged()){
            if(auth()->isStudent()){
                $data['infoUser'] = $this->userModel->getWhere('idUser',auth()->getStudentID())[0];
            }else{
                $data['infoUser'] = $this->userModel->getWhere('idUser',auth()->getTeacherID())[0];
            }
            pre($data['infoUser']);
            return $this->view('admin' . DS . 'profile',$data);
        }else{
            redirect();
        }
    }

    public function update_profile(){

    }

    public function search($query){

    }

    public function send_invitation(){
        
    }

    public function destroy(){
        if(isset($_POST['user_id'])){
            if($this->userModel->delete('id',$_POST['user_id'])){
                redirect('users');
            }else{
                $errors['error'] = 'something went wrong';
            }
            if(!empty($errors)){
                redirect('users','errors',$errors);
            }
        }else{
            redirect();
        }
    }
}