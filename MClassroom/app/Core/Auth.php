<?php

class Auth{

    private $session;

    public function __construct()
    {
        $this->session = new Session;
        $this->session->start();
    }

    //================= setting and checking private methods

    private function setUserSess($key){
        $this->session->set('user',[sha1($key),md5($_SERVER['HTTP_USER_AGENT'])]);
    }

    private function authCheck($key){
        if($this->session->is_exists('user')){
            if($this->session->get('user')[0] == sha1($key) 
            && $this->session->get('user')[1] == md5($_SERVER['HTTP_USER_AGENT'])){
                return true;
            }
        }
        return false;
    }

    //===========

    //======= setting user session methods

    public function setSessStudent($id){
        $this->setUserSess('student');
        $this->session->set('studentID',@openssl_encrypt("$id","AES-128-CTR","M5LaSsROoM"));
    }
    
    public function setSessTeacher($id){
        $this->setUserSess('teacher');
        $this->session->set('teacherID',@openssl_encrypt("$id","AES-128-CTR","M5LaSsROoM"));
    }

    public function setSessUserInfo($userInfoArray){
        $this->session->set('userInfoArray',@openssl_encrypt(serialize($userInfoArray),"AES-128-CTR","M5LaSsROoM"));
    }

    public function getStudentID(){
        return @openssl_decrypt($this->session->get('studentID'),"AES-128-CTR","M5LaSsROoM");
    }

    public function getTeacherID(){
        return @openssl_decrypt($this->session->get('teacherID'),"AES-128-CTR","M5LaSsROoM");
    }

    public function getSessUserInfo(){
        return unserialize(@openssl_decrypt($this->session->get('userInfoArray'),"AES-128-CTR","M5LaSsROoM"));
    }

    //================

    public function isStudent(){
        return $this->authCheck('student');
    }

    public function isTeacher(){
        return $this->authCheck('teacher');
    }

    public function isLogged(){
        return $this->isTeacher() || $this->isStudent();
    }
}