<?php
class Model{

    protected $con;
    protected $table;

    public function __construct()
    {
        $con = new DB;
        $this->con = $con->connect();
    }

    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function runQuery($query,$params){
        $stmt = $this->con->prepare($query);
        return $stmt->execute($params) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function get_last_inserted_id(){
        return $this->con->lastInsertId();
    }

    public function getAll($column = "*" , $orderBy = null , $sort = "desc"){

        $query = "SELECT " . $column . " FROM " . $this->table;
        if($orderBy !== null){
            $query = "SELECT " . $column . " FROM " . $this->table . " ORDER BY " . $orderBy . " " . $sort ;
        }
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    }

    public function getWhere($key, $value, $op='=', $orderBy = null , $sort = "desc"){
        $query = "SELECT * FROM " . $this->table . " WHERE " . $key . " " . $op . " ? ";
        if($orderBy !== null){
            $query = "SELECT * FROM " . $this->table . " WHERE " . $key . " " . $op . " ? ORDER BY " . $orderBy . " " . $sort;
        }
        if($value == null){
            $query = "SELECT * FROM " . $this->table . " WHERE " . $key . " IS NULL";
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        }
        $stmt = $this->con->prepare($query);
        $stmt->execute(array($value));
        return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function insert($data){
        $keys = trim(implode(", ",array_keys($data)),", ");
        $values = ":" . trim(implode(", :",array_keys($data)),", :");
        $query = "INSERT INTO " . $this->table . " (" . $keys . ") VALUES (" . $values . ")";
        $stmt = $this->con->prepare($query);
        return $stmt->execute($data) ? true : false;
    }

    public function update($data,$key,$value){
        $keys = explode('?',trim(implode(" = ? , ",array_keys($data)),",") . " = ?");
        $ks = '';
        for($i=0;$i < count($keys) - 1;$i++){
            $ks .= $keys[$i] . ":" . array_keys($data)[$i];
        }
        $stmt = $this->con->prepare("UPDATE ". $this->table ." SET " . $ks . " WHERE " . $key . " =  :upVal ");
        $data['upVal'] = $value;
        return $stmt->execute($data) ? true : false;
    }

    public function delete($key,$value){
        $stmt = $this->con->prepare("DELETE FROM " . $this->table . " WHERE " . $key . " = ?");
        return $stmt->execute(array($value)) ? true : false;
    }

    public function is_unique($key,$value){
        $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $key . " = ? LIMIT 1");
        $stmt->execute(array($value));
        return $stmt->rowCount() > 0 ? false : true;
    }

    public function is_unique_except($key,$value,$exceptionValue){
        $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $key . " = ? AND ". $key ." != ? LIMIT 1");
        $stmt->execute(array($value,$exceptionValue));
        return $stmt->rowCount() > 0 ? false : true;
    }

    public function getLike($key,$value,$column = "*"){
        $query = "select $column from " . $this->table . " where :key like CONCAT(:val, '%')";
        $stmt = $this->con->prepare($query);
        $stmt->execute([':key'=>$key,':val'=>$value]);
        return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getUserLike($grpID,$value){
        $query = "SELECT user.username,user.name,user.idUser FROM user where user.idUser not in (select joingroup.idUser from joingroup where joingroup.idGroup = :grpid) and user.username LIKE CONCAT(:val, '%')";
        $stmt = $this->con->prepare($query);
        $stmt->execute([':val'=>$value,':grpid'=>$grpID]);
        return $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getEventsWithGroups($idUser){
        $stmt = $this->con->prepare("SELECT e.* , g.label from `event` e inner join `event_for_group` eg on e.idEvent = eg.idEvent and e.idUser = ? inner join `m_group` g on eg.idGroup = g.idGroup");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getUserEvents($idUser){
        $stmt = $this->con->prepare("SELECT e.* , g.label from `event` e inner join `event_for_group` eg on e.idEvent = eg.idEvent inner join `m_group` g on eg.idGroup = g.idGroup inner join `joingroup` jg on jg.idGroup = g.idGroup and jg.idUser = ?");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getLivechatsWithGroups($idUser){
        $stmt = $this->con->prepare("SELECT e.* , g.label from `livechat` e inner join `livechat_for_group` eg on e.idLive = eg.idLive and e.idUser = ? inner join `m_group` g on eg.idGroup = g.idGroup");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getUserLivechats($idUser){
        $stmt = $this->con->prepare("SELECT e.* , g.label from `livechat` e inner join `livechat_for_group` eg on e.idLive = eg.idLive inner join `m_group` g on eg.idGroup = g.idGroup inner join `joingroup` jg on jg.idGroup = g.idGroup and jg.idUser = ?");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupsNots($idUser){
        $stmt = $this->con->prepare("SELECT n.* FROM `joingroup` jg inner join `notification_for_group` ng on jg.idGroup = ng.idGroup and jg.idUser = ? inner join `notification` n on ng.idNotification = n.idNotification");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getUserNots($idUser){
        $stmt = $this->con->prepare("SELECT n.* FROM `notification_for_user` nu inner join `notification` n on nu.idNotification = n.idNotification and nu.idUser = ?");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
}