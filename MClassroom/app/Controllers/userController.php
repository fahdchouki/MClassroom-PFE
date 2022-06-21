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
            return $this->view('admin' . DS . 'profile',$data);
        }else{
            redirect();
        }
    }

    public function update_profile(){
        if(isset($_POST['username'])){
            $data = [
                'name' => trim($_POST['name']),
                'username' => strtolower(trim($_POST['username'])),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'school_subject' => trim($_POST['school_subject']),
            ];
            if(valid_username($data['username']) && strlen($data['username']) > 4){
                if(! $this->userModel->is_unique_except('username',$data['username'],auth()->getSessUserInfo()['username'])){
                    echo "Username is taken";
                    exit;
                }
            }else{
                echo "username must have more than 4 characters and contains only letters, numbers and _";
                    exit;
            }

            if(valid_email($data['email']) && !empty($data['email'])){
                if(! $this->userModel->is_unique_except('email',$data['email'],auth()->getSessUserInfo()['email'])){
                    echo 'This email already exists';
                    exit;
                }
            }else{
                echo 'Please use a valid email address';
                exit;
            }

            if(valid_string($data['name'])){
                if(strlen($data['name']) < 3){
                    echo 'Please enter a valid name'; exit;
                }
            }else{
                echo 'Please enter a valid name'; exit;
            }

            if(strlen($data['password']) > 0 && strlen($data['password']) < 8){
                echo 'Password must have at least 8 characters'; exit;
            }elseif(strlen($data['password']) == 0){
                unset($data['password']);
            }else{
                $data['password'] = crypt_password($data['password']);
            }


            if(empty($_FILES['photoUpload'])){
                $subject = $_POST['school_subject'];
                if($this->userModel->update($data,'username',auth()->getSessUserInfo()['username'])){
                    $photo = auth()->getSessUserInfo()['photo'];
                    $userInfo = array(
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'name' => $data['name'],
                        'photo' => $photo,
                        'school_subject' => $subject
                    );
                    auth()->setSessUserInfo($userInfo);
                    echo 'ok';exit;
                }else{
                    echo 'Something went wrong';exit;
                }
            }else{
                $fileUpload = new Uploader;
                $fileUpload->setDir(UPLOADS . 'profiles' . DS)->setMaxSize(10)->setExtensions(['jpg', 'jpeg', 'png', 'webp', 'jfif']);
                if ($fileUpload->uploadFile('photoUpload', true)) {
                    $data['photo'] = $fileUpload->getUploadName();
                    $subject = $_POST['school_subject'];
                    if($this->userModel->update($data,'username',auth()->getSessUserInfo()['username'])){
                        $userInfo = array(
                            'username' => $data['username'],
                            'email' => $data['email'],
                            'name' => $data['name'],
                            'photo' => $data['photo'],
                            'school_subject' => $subject
                        );
                        auth()->setSessUserInfo($userInfo);
                        echo 'ok';exit;
                    }else{
                        echo 'Something went wrong';exit;
                    }
                } else {
                    echo $fileUpload->getMessage(); exit;
                }
            }
        }
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