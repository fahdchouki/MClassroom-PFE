<?php
class courseController extends Controller{
    public $courseModel;
    public function __construct()
    {
        $this->courseModel = new CourseModel;
    }

    public function index(){
        if(auth()->isTeacher()){
            $idUser = auth()->getTeacherID();
            $courses = $this->courseModel->getTeacherCourses($idUser);
            foreach($courses as $course){
                $groups = $this->courseModel->getGroups_by_courseID($course['idCourse']);
                $grpsString = "";
                foreach($groups as $group){
                    $grpsString .= "<div class='grpCourse' data-groupid='{$group['idGroup']}' >" . $group['label'] . "</div>";
                }
                $course['groups'] = $grpsString;
                $data['courses'][] = $course;
            }
            if(empty($courses)){
                $data['courses'] = [];
            }
            return $this->view('admin' . DS . 'course' . DS . 'courses',$data);
        }
        $courses = $this->courseModel->getStudentCourses(auth()->getStudentID());
        if(empty($courses)){
            $data['courses'] = [];
        }else{
            $data['courses'] = $courses;
        }
        return $this->view('admin' . DS . 'course' . DS . 'courses',$data);
    }


    public function edit($idCourse){
        $idCourse = intval($idCourse);
        if($course = $this->courseModel->getTeacherCourse(auth()->getTeacherID(),$idCourse)){
            $groups = $this->courseModel->getGroups_by_courseID($course['idCourse']);
            $data['grps'] = (new Model)->table('m_group')->getWhere('idUser',auth()->getTeacherID());
            $data['course'] = $course;
            $content = json_decode($course['content']);
            $data['courseContent'] = file_get_contents(UPLOADS . 'courses' . DS . $content->courseFileName);
            $data['courseFileName'] = $content->courseFileName;
            $data['attachedFilename'] = $content->attachedFilename;
            $data['course_grps'] = $groups;
            return $this->view('admin' . DS . 'course' . DS . 'edit-course',$data);
        }
        
    }

    public function create(){
        $data['teacherGroups'] = (new Model)->table('m_group')->getWhere('idUser',auth()->getTeacherID());
        return $this->view('admin' . DS . 'course' . DS . 'create-course',$data);
    }
    public function store(){ // need check for inputs
        if(isset($_POST['cTitle'])){
            $data['title'] = $_POST['cTitle'];
            $data['status'] = $_POST['cStatus'];
            $data['idUser'] = auth()->getTeacherID();
            if(!empty($_FILES['cAttachedFile'])){
                $fileUpload = new Uploader;
                $fileUpload->setDir(UPLOADS . 'courses' . DS)->setMaxSize(100)->setExtensions(['jpg', 'jpeg', 'png', 'webp', 'jfif','pdf','ppt','pptx','doc','docx','html','css','js','txt','zip','rar']);
                if ($fileUpload->uploadFile('cAttachedFile', true)) {
                    $attachedFilename = $fileUpload->getUploadName();
                    $courseFilename = rand(0,9999) . "-" . time() . "-course.html";
                    $f = fopen(UPLOADS . 'courses' . DS . $courseFilename,"a");
                    if(fputs($f,$_POST['cContent'])){
                        fclose($f);
                        $data['content'] = json_encode(array('attachedFilename'=>$attachedFilename,'courseFileName'=>$courseFilename));
                        $coursesModel = (new Model)->table('course');
                        if($coursesModel->insert($data)){

                            if(strlen($_POST['cGroups']) > 0){
                                $idCourse = $coursesModel->get_last_inserted_id();
                                $courseModel = (new Model)->table('course_for_group');
                                $grps = explode(",",$_POST['cGroups']);
                                $cdata['idCourse'] = $idCourse;
                                foreach($grps as $grpID){
                                    $cdata['idGroup'] = intval($grpID);
                                    if(!$courseModel->insert($cdata)){
                                        exit;
                                    }
                                }
                                echo 'ok';
                                if($data['status'] == 3){
                                    $dataCourse['title'] = "New Course From " . auth()->getSessUserInfo()['name'];
                                    $dataCourse['content'] = excerpt($data['title'],20);
                                    $dataCourse['type'] = 2;//group
                                    $dataCourse['link'] = BURL . "course/";
                                    $dataCourse['icon'] = BURL . "uploads/default_noti_icon_course.png";
                                    $notModel = (new Model)->table('notification');
                                    if($notModel->insert($dataCourse)){
                                        $notID = $notModel->get_last_inserted_id();
                                        $grps = explode(",",$_POST['cGroups']);
                                        foreach($grps as $grpID){
                                            (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>intval($grpID)]);
                                        }
                                    }
                                }

                                exit;
                            }
                            echo 'ok';
                                exit;
                        }
                    }else{
                        fclose($f);
                    }
                }
            }else{
                $attachedFilename = "";
                $courseFilename = rand(0,9999) . "-" . time() . "-course.html";
                $f = fopen(UPLOADS . 'courses' . DS . $courseFilename,"a");
                if(fputs($f,$_POST['cContent'])){
                    fclose($f);
                    $data['content'] = json_encode(array('attachedFilename'=>$attachedFilename,'courseFileName'=>$courseFilename));
                    $coursesModel = (new Model)->table('course');
                    if($coursesModel->insert($data)){
                        if(strlen($_POST['cGroups']) > 0){
                            $idCourse = $coursesModel->get_last_inserted_id();
                            $grps = explode(",",$_POST['cGroups']);
                            $courseModel = (new Model)->table('course_for_group');
                            $cdata['idCourse'] = $idCourse;
                            foreach($grps as $grpID){
                                $cdata['idGroup'] = intval($grpID);
                                if(!$courseModel->insert($cdata)){
                                    exit;
                                }
                            }
                            echo 'ok';
                            if($data['status'] == 3){
                                $dataCourse['title'] = "New Course From " . auth()->getSessUserInfo()['name'];
                                $dataCourse['content'] = excerpt($data['title'],20);
                                $dataCourse['type'] = 2;//group
                                $dataCourse['link'] = BURL . "course/";
                                $dataCourse['icon'] = BURL . "uploads/default_noti_icon_course.png";
                                $notModel = (new Model)->table('notification');
                                if($notModel->insert($dataCourse)){
                                    $notID = $notModel->get_last_inserted_id();
                                    $grps = explode(",",$_POST['cGroups']);
                                    foreach($grps as $grpID){
                                        (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>intval($grpID)]);
                                    }
                                }
                            }
                            exit;
                        }
                        echo 'ok';
                            exit;
                    }
                }else{
                    fclose($f);
                }
            }
            exit;
        }
    }

    public function update(){
        if(isset($_POST['cTitle'])){
            $data['title'] = $_POST['cTitle'];
            $data['status'] = $_POST['cStatus'];
            $data['idUser'] = auth()->getTeacherID();
            if(!empty($_FILES['cAttachedFile'])){
                $fileUpload = new Uploader;
                $fileUpload->setDir(UPLOADS . 'courses' . DS)->setMaxSize(100)->setExtensions(['jpg', 'jpeg', 'png', 'webp', 'jfif','pdf','ppt','pptx','doc','docx','html','css','js','txt','zip','rar']);
                if ($fileUpload->uploadFile('cAttachedFile', true)) {
                    $attachedFilename = $fileUpload->getUploadName();
                    $courseFilename = $_POST['fileCourseName'];
                    $f = fopen(UPLOADS . 'courses' . DS . $courseFilename,"w");
                    if(fputs($f,$_POST['cContent'])){
                        fclose($f);
                        $data['content'] = json_encode(array('attachedFilename'=>$attachedFilename,'courseFileName'=>$courseFilename));
                        $coursesModel = (new Model)->table('course');
                        if($coursesModel->update($data,'idCourse',intval($_POST['courseID']))){
                            if(strlen($_POST['cGroups']) > 0){
                                $grps = explode(",",$_POST['cGroups']);
                                $courseModel = (new Model)->table('course_for_group');
                                $cdata['idCourse'] = $_POST['courseID'];
                                $courseModel->delete('idCourse',$_POST['courseID']);
                                foreach($grps as $grpID){
                                    $cdata['idGroup'] = intval($grpID);
                                    if(!$courseModel->insert($cdata)){
                                        exit;
                                    }
                                }
                                echo 'ok';
                                if($data['status'] == 3){
                                    $dataCourse['title'] = "New Course From " . auth()->getSessUserInfo()['name'];
                                    $dataCourse['content'] = excerpt($data['title'],20);
                                    $dataCourse['type'] = 2;//group
                                    $dataCourse['link'] = BURL . "course/";
                                    $dataCourse['icon'] = BURL . "uploads/default_noti_icon_course.png";
                                    $notModel = (new Model)->table('notification');
                                    if($notModel->insert($dataCourse)){
                                        $notID = $notModel->get_last_inserted_id();
                                        $grps = explode(",",$_POST['cGroups']);
                                        foreach($grps as $grpID){
                                            (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>intval($grpID)]);
                                        }
                                    }
                                }
                                exit;
                            }
                            echo 'ok';
                            exit;
                        }
                    }else{
                        fclose($f);
                        exit;
                    }
                }
            }else{
                $attachedFilename = $_POST['fileName'];
                $courseFilename = $_POST['fileCourseName'];
                $f = fopen(UPLOADS . 'courses' . DS . $courseFilename,"w");
                if(fputs($f,$_POST['cContent'])){
                    fclose($f);
                    $data['content'] = json_encode(array('attachedFilename'=>$attachedFilename,'courseFileName'=>$courseFilename));
                    $coursesModel = (new Model)->table('course');
                    if($coursesModel->update($data,'idCourse',intval($_POST['courseID']))){
                        if(strlen($_POST['cGroups']) > 0){
                            $grps = explode(",",$_POST['cGroups']);
                            $courseModel = (new Model)->table('course_for_group');
                            $cdata['idCourse'] = $_POST['courseID'];
                            $courseModel->delete('idCourse',$_POST['courseID']);
                            foreach($grps as $grpID){
                                $cdata['idGroup'] = intval($grpID);
                                if(!$courseModel->insert($cdata)){
                                    exit;
                                }
                            }
                            echo 'ok';
                            if($data['status'] == 3){
                                $dataCourse['title'] = "New Course From " . auth()->getSessUserInfo()['name'];
                                $dataCourse['content'] = excerpt($data['title'],20);
                                $dataCourse['type'] = 2;//group
                                $dataCourse['link'] = BURL . "course/";
                                $dataCourse['icon'] = BURL . "uploads/default_noti_icon_course.png";
                                $notModel = (new Model)->table('notification');
                                if($notModel->insert($dataCourse)){
                                    $notID = $notModel->get_last_inserted_id();
                                    $grps = explode(",",$_POST['cGroups']);
                                    foreach($grps as $grpID){
                                        (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>intval($grpID)]);
                                    }
                                }
                            }
                            exit;
                        }
                        echo 'ok';
                        exit;
                    }
                }
            }
        }
    }

    public function delete(){
        if(isset($_POST['idCourse'])){
            if($this->courseModel->delete('idCourse',$_POST['idCourse'])){
                echo 'ok';
                exit;
            }
        }
    }
}