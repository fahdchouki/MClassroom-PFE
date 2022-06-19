<?php 

class homeController extends Controller{

    protected $homeModel;

    public function __construct()
    {
        $this->homeModel = new Model;
    }

    public function index()
    {
        if(auth()->isTeacher()){ // created ones
            $data['eventsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `event` where idUser = ?",[auth()->getTeacherID()])[0]['counter'];
            $data['coursesCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `course` where idUser = ?",[auth()->getTeacherID()])[0]['counter'];
            $data['groupsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `m_group` where idUser = ?",[auth()->getTeacherID()])[0]['counter'];
            $data['quizsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `task` where idUser = ? and task_type = 1",[auth()->getTeacherID()])[0]['counter'];
            $data['exercicesCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `task` where idUser = ? and task_type = 2",[auth()->getTeacherID()])[0]['counter'];
            $data['livechatsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `livechat` where idUser = ?",[auth()->getTeacherID()])[0]['counter'];
            return $this->view('admin' . DS . 'index',$data);
        }elseif(auth()->isStudent()){  // enrolled ones
            $data['eventsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `event_for_group` eg inner join `joingroup` jg on eg.idGroup = jg.idGroup and jg.idUser = ? group by eg.idEvent",[auth()->getStudentID()])[0]['counter'];
            $data['coursesCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `course_for_group` eg inner join `joingroup` jg on eg.idGroup = jg.idGroup and jg.idUser = ? inner join `course` co on eg.idCourse = co.idCourse and co.status = 3 group by co.idCourse",[auth()->getStudentID()])[0]['counter'];
            $data['groupsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `joingroup` where idUser = ?",[auth()->getStudentID()])[0]['counter'];
            $data['quizsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `task_for_group` eg inner join `joingroup` jg on eg.idGroup = jg.idGroup and jg.idUser = ? inner join `task` t on eg.idTask = t.idTask and t.task_type = 1 and t.status = 2 group by t.idTask",[auth()->getStudentID()])[0]['counter'] + $this->homeModel->runQuery("SELECT count(*) counter FROM `task_for_user` eg inner join `task` t on eg.idTask = t.idTask and t.task_type = 1 and eg.idUser = ? and t.status = 2 group by t.idTask",[auth()->getStudentID()])[0]['counter'];
            $data['exercicesCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `task_for_group` eg inner join `joingroup` jg on eg.idGroup = jg.idGroup and jg.idUser = ? inner join `task` t on eg.idTask = t.idTask and t.task_type = 2 and t.status = 2 group by t.idTask",[auth()->getStudentID()])[0]['counter'] + $this->homeModel->runQuery("SELECT count(*) counter FROM `task_for_user` eg inner join `task` t on eg.idTask = t.idTask and t.task_type = 2 and eg.idUser = ? and t.status = 2 group by t.idTask",[auth()->getStudentID()])[0]['counter'];
            $data['livechatsCount'] = $this->homeModel->runQuery("SELECT count(*) counter FROM `livechat_for_group` eg inner join `joingroup` jg on eg.idGroup = jg.idGroup and jg.idUser = ? group by eg.idLive",[auth()->getStudentID()])[0]['counter'];
            return $this->view('admin' . DS . 'index',$data);
        }else{
            return $this->view('index');
        }
    }
    
}