<?php
class GroupModel extends Model{
    public function __construct()
    {
        $this->table = 'm_group';
        $this->con = (new Model)->con;
    }

    public function getGroupsWithMemsByIdUser($idUser){
        $stmt = $this->con->prepare("SELECT count(`joingroup`.`idGroup`) as 'members' , `m_group`.* FROM `joingroup` right join `m_group` on `joingroup`.`idGroup` = `m_group`.`idGroup` group by `m_group`.`idGroup` HAVING `m_group`.`idUser` = ?");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupsWithLastMsg($idAdmin){
        $stmt = $this->con->prepare("SELECT t1.*,DATE_FORMAT(t1.created_at,'%a %d %b  %H:%i  %p') as created_atF,grp.idGroup grpID,grp.label,grp.group_icon,grp.idUser grp_admin,grp.created_at grp_created_at
        FROM message t1 LEFT JOIN message t2
        ON (t1.idGroup = t2.idGroup AND t1.created_at < t2.created_at)
        RIGHT JOIN `m_group` grp ON t1.idGroup = grp.idGroup
        WHERE t2.created_at IS NULL AND grp.idUser = ? ORDER BY t1.created_at DESC");
        return $stmt->execute(array($idAdmin)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupsWithLastMsg_std($idStd){
        $stmt = $this->con->prepare("SELECT t1.*,DATE_FORMAT(t1.created_at,'%a %d %b  %H:%i  %p') as created_atF,grp.idGroup grpID,grp.label,grp.group_icon,grp.idUser grp_admin,grp.created_at grp_created_at
        FROM message t1 LEFT JOIN message t2
        ON (t1.idGroup = t2.idGroup AND t1.created_at < t2.created_at)
        RIGHT JOIN `m_group` grp ON t1.idGroup = grp.idGroup 
        INNER JOIN joingroup j ON grp.idGroup = j.idGroup AND j.idUser = ?
        WHERE t2.created_at IS NULL ORDER BY t1.created_at DESC");
        return $stmt->execute(array($idStd)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupMessages($idUser,$idGroup){
        $stmt = $this->con->prepare("select message.*,DATE_FORMAT(message.created_at,'%a %d %b  %H:%i  %p') as created_atF,user.name,user.photo from message inner join user on user.idUser = message.idUser INNER JOIN m_group on m_group.idGroup = message.idGroup where message.idGroup = ? and m_group.idUser = ? ORDER BY message.created_at");
        return $stmt->execute(array($idGroup,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupMessages_std($idGroup){
        $stmt = $this->con->prepare("select message.*,DATE_FORMAT(message.created_at,'%a %d %b  %H:%i  %p') as created_atF,user.name,user.photo from message inner join user on user.idUser = message.idUser INNER JOIN m_group on m_group.idGroup = message.idGroup where message.idGroup = ? ORDER BY message.created_at");
        return $stmt->execute(array($idGroup)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupInfo($idUser,$idGroup){
        $stmt = $this->con->prepare("SELECT count(`joingroup`.`idGroup`) as 'members' , `m_group`.`idGroup`,`m_group`.`label`,`m_group`.`idUser` FROM `joingroup` inner join `m_group` ON `joingroup`.`idGroup` = `m_group`.`idGroup` AND `joingroup`.`idGroup` = ? where `m_group`.`idUser` = ? group by `m_group`.`idGroup` ");
        return $stmt->execute(array($idGroup,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getGroupInfo_std($idGroup){
        $stmt = $this->con->prepare("SELECT count(`joingroup`.`idGroup`) as 'members' , `m_group`.`idGroup`,`m_group`.`label`,`m_group`.`idUser` FROM `joingroup` inner join `m_group` ON `joingroup`.`idGroup` = `m_group`.`idGroup` AND `joingroup`.`idGroup` = ? group by `m_group`.`idGroup` ");
        return $stmt->execute(array($idGroup)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function get_group_members($idGrp){
        $stmt = $this->con->prepare("SELECT user.idUser,user.username,user.name FROM `joingroup` inner join `user` on user.idUser = joingroup.idUser and joingroup.idGroup = ?");
        return $stmt->execute(array($idGrp)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function deleteMember($idUser,$idGroup){
        $stmt = $this->con->prepare("DELETE FROM joingroup WHERE idUser = ? AND idGroup = ?");
        return $stmt->execute(array($idUser,$idGroup)) ? true : false;
    }

    public function getOpenedGroups($idUser){
        $stmt = $this->con->prepare("SELECT * FROM `m_group` where m_group.group_type = 1 and m_group.idGroup not in (select idGroup from joingroup where idUser = ? )");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
}