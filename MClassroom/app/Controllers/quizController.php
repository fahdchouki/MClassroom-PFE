<?php

class quizController extends Controller{

    protected $taskModel;

    public function __construct(){
        $this->taskModel = new TaskModel;
    }

    public function index(){
        if(isset($_COOKIE['quizInfo'])){
            return $this->view('admin' . DS . 'task' . DS . 'quiz');
        }else{
            redirect('task');
        }
        
    }

    public function create(){
        if(isset($_POST['taskTitle'])){
            $quizInfo = $_POST;
            setcookie('quizInfo',@serialize($quizInfo),time()+3600,'/');
            echo 'ok';
            exit;
        }else{
            redirect();
        }
    }

    public function store(){
        if(isset($_POST['quizContent']) && isset($_COOKIE['quizInfo'])){
            $quizInfo = @unserialize($_COOKIE['quizInfo']);
            $quizName = rand(0,9999) . "-" . time() . "-quiz.txt";
            $f = fopen(UPLOADS . 'tasks' . DS . 'quiz' . DS . $quizName,"a");
            if(fputs($f,$_POST['quizContent'])){
                fclose($f);
                $quizMod = $this->taskModel->table('quiz');
                if($quizMod->insert(['content'=>$quizName])){
                    $quizID = $quizMod->get_last_inserted_id();
                    $data['title'] = $quizInfo['taskTitle'];
                    $data['status'] = $quizInfo['taskStatus']; // 2 means public
                    $data['task_type'] = "1";
                    $data['id_type'] = $quizID;
                    $data['deadline'] = date('Y-m-d', strtotime($quizInfo['taskDueDate']));
                    $data['idUser'] = auth()->getTeacherID();
                    $taskMod = $this->taskModel->table('task');

                    if($taskMod->insert($data)){
                        $taskID = $taskMod->get_last_inserted_id();
                        $quizInfo['participants'] = json_decode($quizInfo['participants']);
                        if($quizInfo['taskFor'] == 1){ // means group
                            foreach($quizInfo['participants'] as $q){
                                $this->taskModel->table('task_for_group')->insert(['idTask'=>$taskID,'idGroup'=>$q]);
                            }


                            if($data['status'] == 2){
                                $dataQuiz['title'] = "New Quiz Created By " . auth()->getSessUserInfo()['name'];
                                $dataQuiz['content'] = excerpt($data['title'],20);
                                $dataQuiz['type'] = 2;//group
                                $dataQuiz['link'] = BURL . "task/";
                                $dataQuiz['icon'] = BURL . "uploads/default_noti_icon_task.png";
                                $notModel = (new Model)->table('notification');
                                if($notModel->insert($dataQuiz)){
                                    $notID = $notModel->get_last_inserted_id();
                                    foreach($quizInfo['participants'] as $q){
                                        (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>$q]);
                                    }
                                }
                            }

                            unset($_COOKIE['quizInfo']); 
                            setcookie('quizInfo', null, -1, '/');
                            echo 'ok';exit;
                        }else{ // means user
                            foreach($quizInfo['participants'] as $q){
                                $this->taskModel->table('task_for_user')->insert(['idTask'=>$taskID,'idUser'=>$q]);
                            }

                            if($data['status'] == 2){
                                $dataQuiz['title'] = "New Quiz Created By " . auth()->getSessUserInfo()['name'];
                                $dataQuiz['content'] = excerpt($data['title'],20);
                                $dataQuiz['type'] = 1;//user
                                $dataQuiz['link'] = BURL . "task/";
                                $dataQuiz['icon'] = BURL . "uploads/default_noti_icon_task.png";
                                $notModel = (new Model)->table('notification');
                                if($notModel->insert($dataQuiz)){
                                    $notID = $notModel->get_last_inserted_id();
                                    foreach($quizInfo['participants'] as $q){
                                        (new Model)->table('notification_for_user')->insert(['idNotification'=>$notID,'idUser'=>$q]);
                                    }
                                }
                            }

                            unset($_COOKIE['quizInfo']); 
                            setcookie('quizInfo', null, -1, '/');
                            echo 'ok';exit;
                        }
                    }
                }
            }
        }else{
            redirect('task');
        }
    }

    public function discard(){
        if(isset($_COOKIE['quizInfo'])){
            unset($_COOKIE['quizInfo']); 
            setcookie('quizInfo', null, -1, '/');
            echo 'ok';
            exit;
        }
    }

}