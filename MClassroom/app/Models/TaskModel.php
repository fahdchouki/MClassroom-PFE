<?php
class TaskModel extends Model{
    public function __construct()
    {
        $this->table = 'task';
        $this->con = (new Model)->con;
    }
    public function getUsersByGroupID($idGroup,$idUser){
        $stmt = $this->con->prepare("SELECT u.idUser,u.name,u.username FROM `joingroup` j inner join `user` u on j.idUser = u.idUser and j.idGroup = ? and j.idUser != ?");
        return $stmt->execute(array($idGroup,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getTaskGroups($idTask,$idUser){
        $stmt = $this->con->prepare("SELECT g.label,g.group_icon FROM `task_for_group` tg inner join `m_group` g on tg.idGroup = g.idGroup and tg.idTask = ? inner join `task` t on t.idUser = ? and t.idTask = tg.idTask");
        return $stmt->execute(array($idTask,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getTaskUsers($idTask,$idUser){
        $stmt = $this->con->prepare("SELECT u.name,u.username,u.photo FROM `task_for_user` tu inner join `user` u on tu.idUser = u.idUser and tu.idTask = ? inner join `task` t on t.idUser = ? and t.idTask = tu.idTask");
        return $stmt->execute(array($idTask,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getTasksForUsers($idUser){
        $stmt = $this->con->prepare("SELECT t.*,st.submit_date FROM `task_for_user` tu inner join `user` u on tu.idUser = u.idUser and tu.idUser = ? INNER join `task` t on t.idTask = tu.idTask and t.status = 2 left join `submittask` st on st.idTask = t.idTask");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getTasksForGroups($idUser){
        $stmt = $this->con->prepare("SELECT t.*,st.submit_date,g.label as group_label FROM `task_for_group` tg inner join `joingroup` jg on tg.idGroup = jg.idGroup and jg.idUser = ? inner join `task` t on tg.idTask = t.idTask and t.status = 2 inner join `m_group` g on g.idGroup = jg.idGroup left join `submittask` st on st.idTask = t.idTask");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function isAlreadySubmited($idTask,$idUser){
        $stmt = $this->con->prepare("SELECT * FROM submittask WHERE idTask = ? AND idUser = ?");
        $stmt->execute(array($idTask,$idUser));
        return $stmt->rowCount() > 0 ? true : false;
    }

    public function updateSubmitedTask($idUser,$idTask,$content){
        $stmt = $this->con->prepare("UPDATE submittask SET content = ? WHERE idTask = ? AND idUser = ?");
        return $stmt->execute(array($content,$idTask,$idUser)) ? true : false;
    }

    public function getTaskSubmitions($idTask,$idUser){
        $stmt = $this->con->prepare("SELECT st.*,t.task_type,t.id_type,u.name,u.username,g.label FROM `submittask` st inner join `user` u on st.idUser = u.idUser and st.idTask = ? inner join `task` t on t.idTask = st.idTask inner join `joingroup` jg on jg.idUser = st.idUser inner join `m_group` g on g.idGroup = jg.idGroup and g.idUser = t.idUser and t.idUser = ? group by st.idTask");
        return $stmt->execute(array($idTask,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getQuizContent($idTask,$idUser){
        $stmt = $this->con->prepare("SELECT q.content FROM `quiz` q inner join `task` t ON q.idQuiz = t.id_type and t.idTask = ? AND t.idUser = ?");
        return $stmt->execute(array($idTask,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC)[0] : [];
    }

    public function getExerciceContent($idTask,$idUser){
        $stmt = $this->con->prepare("SELECT q.content FROM `exercice` q inner join `task` t ON q.idExercice = t.id_type and t.idTask = ? AND t.idUser = ?");
        return $stmt->execute(array($idTask,$idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC)[0] : [];
    }
}