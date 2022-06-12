<?php
class UserModel extends Model{

    public function __construct()
    {
        $this->table = 'user';
        $this->con = (new Model)->con;
    }

    public function isUserExistByUsername($username,$password){
        $query = "SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($username,$password));
        return $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function isUserExistByEmail($email,$password){
        $query = "SELECT * FROM user WHERE email = ? AND password = ? LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($email,$password));
        return $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function isEmailExists($email){
        $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($email));
        return $stmt->rowCount() > 0 ? true : false;
    }

    public function isForgetTokenExists($email,$token){
        $query = "SELECT * FROM user WHERE email = ? AND account_token = ? LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($email,$token));
        return $stmt->rowCount() > 0 ? true : false;
    }

}