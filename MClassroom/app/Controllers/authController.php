<?php

class authController extends Controller{

    protected $userModel;
    public $user;

    public function __construct(){
        $this->userModel = new UserModel;
    }

    public function index(){
        $this->login();
    }

    public function login(){
        return auth()->isLogged() ? redirect() : $this->view('login');
    }

    public function register(){
        return auth()->isLogged() ? redirect() : $this->view('register');
    }

    public function check_user(){

        if(isset($_POST['login'])){

            $username = trim($_POST['username']);
            $password = crypt_password($_POST['pass']);

            if(valid_email($username)){
                $this->user = $this->userModel->isUserExistByEmail($username,$password);
            }else{
                $username = filter_username($username);
                $this->user = $this->userModel->isUserExistByUsername($username,$password);
            }

            if($this->user){

                if($this->user['account_type'] == 1){
                    auth()->setSessStudent($this->user['idUser']);
                    $userInfo = array(
                        'username' => $this->user['username'],
                        'email' => $this->user['email'],
                        'name' => $this->user['name'],
                        'photo' => $this->user['photo']
                    );
                    auth()->setSessUserInfo($userInfo);
                    redirect();
                }elseif($this->user['account_type'] == 2){
                    auth()->setSessTeacher($this->user['idUser']);
                    $userInfo = array(
                        'username' => $this->user['username'],
                        'email' => $this->user['email'],
                        'name' => $this->user['name'],
                        'school_subject' => $this->user['school_subject'] ?? '',
                        'photo' => $this->user['photo']
                    );
                    auth()->setSessUserInfo($userInfo);
                    redirect();
                }
            }

            redirect('auth/login','wrong','invalid username/email or password');

        }else{
            redirect();
        }
    }

    public function store(){
        if(isset($_POST['reg'])){

            $data = [
                'name' => trim($_POST['fullname']),
                'username' => strtolower(trim($_POST['username'])),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['pass']),
                'password2' => trim($_POST['rpass']),
                'account_type' => intval($_POST['type']),
            ];

            $errors = array();

            if(valid_username($data['username']) && strlen($data['username']) > 4){
                if(! $this->userModel->is_unique('username',$data['username'])){
                    $errors['username'] = 'this username already exists';
                }
            }else{
                $errors['username'] = 'username must have more than 4 characters and contains only letters, numbers and _';
            }

            if(valid_email($data['email']) && !empty($data['email'])){
                if(! $this->userModel->is_unique('email',$data['email'])){
                    $errors['email'] = 'this email already exists';
                }
            }else{
                $errors['email'] = 'please use a valid email address';
            }

            if(valid_string($data['name'])){
                if(strlen($data['name']) < 4) $errors['name'] = 'please enter a valid name';
            }else{
                $errors['name'] = 'please enter a valid name';
            }

            if($data['account_type'] != 1 && $data['account_type'] != 2){
                $errors['account_type'] = 'You must choose either you are a teacher or a student';
            }

            if(strlen($data['password']) < 8){
                $errors['password'] = 'please must have at least 8 characters';
            }elseif($data['password'] != $data['password2']){
                $errors['password'] = 'password doesn\'t match';
            }

            if(empty($errors)){
                $data['password'] = crypt_password($data['password']);
                $data['photo'] = 'default.jpg';
                unset($data['password2']);
                if($this->userModel->insert($data)){
                    redirect('auth/login');
                }else{
                    $errors['error'] = 'something went wrong';
                }
            }

            if(!empty($errors)){
                $errors['data'] = $data;
                redirect('auth/register','errors',$errors);
            }
        }else{
            redirect();
        }
    }

    public function forget(){
        if(isset($_GET['resend'])){
            setcookie('forgetEmail','',500);
            redirect('auth/forget');
        }
        if(isset($_POST['sendemail'])){
            $email = $_POST['email'];
            if(valid_email($email)){
                if($this->userModel->isEmailExists($email)){
                    $forget_token = random_int(555,999) . ucfirst($email)[0] . random_int(1,999) ;
                    setcookie("forgetEmail",$email,time() + 900);
                    if($this->userModel->update(array('account_token' => $forget_token),'email',$email)){
                        if(mail($email,"Reset password","Your verification code is : <b>$forget_token</b>")){
                            redirect("auth/forget");
                        }else{
                            echo "<div class='alert alert-danger'>email not sent</div>";
                            return;
                        }
                    }else{
                        setcookie('forgetEmail','',500);
                    }
                }
            }
        }elseif(isset($_POST['sendcode'])){
            if(isset($_COOKIE['forgetEmail'])){
                $email = valid_email($_COOKIE['forgetEmail']) ? $_COOKIE['forgetEmail'] : '';
                $token = filter_username($_POST['vefcode']);
                if($this->userModel->isForgetTokenExists($email,$token)){
                    $newPass = explode("@",$email)[0] . "@" . random_int(100,999);
                    $hashedPass = crypt_password($newPass);
                    if($this->userModel->update(array('password' => $hashedPass),'email',$email)){
                        setcookie('forgetEmail','',500);
                        setcookie("npass",openssl_encrypt($newPass,"AES-128-CTR","F0r%e1p@sS"),time() + 300);
                        redirect("auth/forget");
                    }
                }
            }
        }
        return $this->view('forget');
    }

    public function logout(){
        if(auth()->isLogged()){
            session_unset();
            session_destroy();
        }
        redirect(url());
    }

}