<?php

class exerciceController extends Controller{

    protected $taskModel;

    public function __construct(){
        $this->taskModel = new TaskModel;
    }

    public function index(){
        if(isset($_COOKIE['exerciceInfo'])){
            return $this->view('admin' . DS . 'task' . DS . 'exercice');
        }else{
            redirect('task');
        }
    }

    public function store(){
        if(isset($_POST['exerciceContent']) && isset($_COOKIE['exerciceInfo'])){
            $exerciceInfo = @unserialize($_COOKIE['exerciceInfo']);
            $exerciceName = rand(0,9999) . "-" . time() . "-exercice.txt";
            $f = fopen(UPLOADS . 'tasks' . DS . 'exercice' . DS . $exerciceName,"a");
            if(fputs($f,$_POST['exerciceContent'])){
                fclose($f);
                $exerciceMod = $this->taskModel->table('exercice');
                if($exerciceMod->insert(['content'=>$exerciceName])){
                    $exerciceID = $exerciceMod->get_last_inserted_id();
                    $data['title'] = $exerciceInfo['taskTitle'];
                    $data['status'] = $exerciceInfo['taskStatus'];
                    $data['task_type'] = "2";
                    $data['id_type'] = $exerciceID;
                    $data['deadline'] = date('Y-m-d', strtotime($exerciceInfo['taskDueDate']));
                    $data['idUser'] = auth()->getTeacherID();
                    $taskMod = $this->taskModel->table('task');

                    if($taskMod->insert($data)){
                        $taskID = $taskMod->get_last_inserted_id();
                        $exerciceInfo['participants'] = json_decode($exerciceInfo['participants']);
                        if($exerciceInfo['taskFor'] == 1){
                            foreach($exerciceInfo['participants'] as $q){
                                $this->taskModel->table('task_for_group')->insert(['idTask'=>$taskID,'idGroup'=>$q]);
                            }

                            if($data['status'] == 2){
                                $dataQuiz['title'] = "New Exercice Created By " . auth()->getSessUserInfo()['name'];
                                $dataQuiz['content'] = excerpt($data['title'],20);
                                $dataQuiz['type'] = 2;//group
                                $dataQuiz['link'] = BURL . "task/";
                                $dataQuiz['icon'] = BURL . "uploads/default_noti_icon_task.png";
                                $notModel = (new Model)->table('notification');
                                if($notModel->insert($dataQuiz)){
                                    $notID = $notModel->get_last_inserted_id();
                                    foreach($exerciceInfo['participants'] as $q){
                                        (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>$q]);
                                    }
                                }
                            }

                            unset($_COOKIE['exerciceInfo']); 
                            setcookie('exerciceInfo', null, -1, '/');
                            echo 'ok';exit;
                        }else{
                            foreach($exerciceInfo['participants'] as $q){
                                $this->taskModel->table('task_for_user')->insert(['idTask'=>$taskID,'idUser'=>$q]);
                            }


                            if($data['status'] == 2){
                                $dataQuiz['title'] = "New Exercice Created By " . auth()->getSessUserInfo()['name'];
                                $dataQuiz['content'] = excerpt($data['title'],20);
                                $dataQuiz['type'] = 1;//user
                                $dataQuiz['link'] = BURL . "task/";
                                $dataQuiz['icon'] = BURL . "uploads/default_noti_icon_task.png";
                                $notModel = (new Model)->table('notification');
                                if($notModel->insert($dataQuiz)){
                                    $notID = $notModel->get_last_inserted_id();
                                    foreach($exerciceInfo['participants'] as $q){
                                        (new Model)->table('notification_for_user')->insert(['idNotification'=>$notID,'idUser'=>$q]);
                                    }
                                }
                            }

                            unset($_COOKIE['exerciceInfo']); 
                            setcookie('exerciceInfo', null, -1, '/');
                            echo 'ok';exit;
                        }
                    }
                }
            }
        }else{
            redirect('task');
        }
    }

    public function create(){
        if(isset($_POST['taskTitle'])){
            $exerciceInfo = $_POST;
            setcookie('exerciceInfo',@serialize($exerciceInfo),time()+400,'/');
            echo 'ok';
            exit;
        }else{
            redirect();
        }
    }

}