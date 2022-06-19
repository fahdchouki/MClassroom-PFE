<?php
class CourseModel extends Model{
    public function __construct()
    {
        $this->table = 'course';
        $this->con = (new Model)->con;
    }
    public function getGroups_by_courseID($idCourse){
        $stmt = $this->con->prepare("SELECT g.* FROM `course_for_group` cg inner join `m_group` g on cg.idGroup = g.idGroup AND cg.idCourse = ?");
        return $stmt->execute(array($idCourse)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
    public function getTeacherCourses($idUser){
        $stmt = $this->con->prepare("SELECT * FROM `course` WHERE idUser = ?");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
    public function getTeacherCourse($idUser,$idCourse){
        $stmt = $this->con->prepare("SELECT * FROM `course` WHERE idUser = ? AND idCourse = ?");
        return $stmt->execute(array($idUser,$idCourse)) ? $stmt->fetchAll(PDO::FETCH_ASSOC)[0] : [];
    }
    public function getJoinedGroups($idUser){
        $stmt = $this->con->prepare("SELECT g.idGroup,g.label FROM `joingroup` j inner join `m_group` g on j.idGroup = g.idGroup and j.idUser = ?");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
    public function getCoursesOfGroup($idGroup){
        $stmt = $this->con->prepare("SELECT c.* FROM `course_for_group` cg inner join `course` c on c.idCourse = cg.idCourse and cg.idGroup = ? and c.status = 3 ");
        return $stmt->execute(array($idGroup)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
    public function getStudentCourses($idUser){
        $stmt = $this->con->prepare("SELECT g.idGroup,g.label,c.* FROM `joingroup` j inner join `m_group` g on j.idGroup = g.idGroup and j.idUser = ? inner join `course_for_group` cg on g.idGroup = cg.idGroup inner join `course` c on c.idCourse = cg.idCourse and c.status = 3");
        return $stmt->execute(array($idUser)) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }
}