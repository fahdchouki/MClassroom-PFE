<?php

class taskController extends Controller
{
    public $taskModel;
    public function __construct()
    {
        $this->taskModel = new TaskModel;
    }
    public function index(){
        if(auth()->isTeacher()){
            $data['tasks'] = $this->taskModel->getWhere('idUser',auth()->getTeacherID());
            return $this->view('admin' . DS . 'task' . DS . 'tasks',$data);
        }else{
            $idUser = auth()->getStudentID();
            $tasks1 = $this->taskModel->getTasksForUsers($idUser);
            $tasks2 = $this->taskModel->getTasksForGroups($idUser);
            $data['tasks'] = array_merge($tasks1,$tasks2);
            return $this->view('admin' . DS . 'task' . DS . 'tasks',$data);
        }
    }
    public function create(){
        $data['groups'] = (new Model)->table('m_group')->getWhere('idUser',auth()->getTeacherID());
        return $this->view('admin' . DS . 'task' . DS . 'create-task',$data);
    }
    public function get_users_by_group(){
        if(isset($_POST['idGroup'])){
            echo json_encode($this->taskModel->getUsersByGroupID($_POST['idGroup'],auth()->getTeacherID()));
            exit;
        }else{
            redirect();
        }
    }
    public function delete(){
        if(isset($_POST['idTask'])){
            if($_POST['taskType'] == 1){
                if($this->taskModel->table('quiz')->delete('idQuiz',$_POST['idTaskType'])){
                    if($this->taskModel->table('task')->delete('idTask',$_POST['idTask'])){
                        echo 'ok';
                        exit;
                    }
                }
            }elseif($_POST['taskType'] == 2){
                if($this->taskModel->table('exercice')->delete('idExercice',$_POST['idTaskType'])){
                    if($this->taskModel->table('task')->delete('idTask',$_POST['idTask'])){
                        echo 'ok';
                        exit;
                    }
                }
            }
            
        }
    }

    public function participants(){
        if(isset($_POST['idTask'])){
            $groups = $this->taskModel->getTaskGroups($_POST['idTask'],auth()->getTeacherID());
            $users = $this->taskModel->getTaskUsers($_POST['idTask'],auth()->getTeacherID());

            if(!empty($groups)){
                echo json_encode($groups);
            }elseif(!empty($users)){
                echo json_encode($users);
            }
            exit;
        }
    }

    public function can_submit(){
        if(isset($_POST['idTask'])){
            $taskInfo = @serialize($_POST);
            setcookie('taskInfo',$taskInfo,time()+8000,'/');
            echo 'ok';
            exit;
        }
    }

    public function submit(){
        if(isset($_COOKIE['taskInfo'])){
            $taskInfo = @unserialize($_COOKIE['taskInfo']);
            $taskType = $taskInfo['taskType'];
            if($taskType == 1){
                $quizID = $taskInfo['idTaskType'];
                $quiz = $this->taskModel->table("quiz")->getWhere('idQuiz',$quizID)[0];
                $data['quizContent'] = json_decode(file_get_contents(UPLOADS . 'tasks' . DS . 'quiz' . DS . $quiz['content']));
                $data['isQuiz'] = true;
                return $this->view('admin' . DS . 'task' . DS . 'submit',$data);
            }elseif($taskType == 2){
                $exerciceID = $taskInfo['idTaskType'];
                $exercice = $this->taskModel->table("exercice")->getWhere('idExercice',$exerciceID)[0];
                $data['exerciceContent'] = file_get_contents(UPLOADS . 'tasks' . DS . 'exercice' . DS . $exercice['content']);
                $data['isQuiz'] = false;
                return $this->view('admin' . DS . 'task' . DS . 'submit',$data);
            }
        }else{
            redirect();
        }
    }

    public function submit_task(){
        if(isset($_COOKIE['taskInfo'])){
            $taskInfo = @unserialize($_COOKIE['taskInfo']);
            if(isset($_POST['quizAnswers'])){
                $data['idTask'] = $taskInfo['idTask'];
                $data['idUser'] = auth()->getStudentID();
                $data['content'] = $_POST['quizAnswers'];
                if($this->taskModel->isAlreadySubmited( $data['idTask'],$data['idUser'])){
                    if($this->taskModel->updateSubmitedTask($data['idUser'],$data['idTask'],$data['content'])){
                        echo 'ok';
                        exit;
                    }
                }else{
                    if($this->taskModel->table('submittask')->insert($data)){
                        echo 'ok';
                        exit;
                    }
                }
            }elseif(isset($_POST['exerciceAnswer'])){
                $data['idTask'] = $taskInfo['idTask'];
                $data['idUser'] = auth()->getStudentID();
                $data['content'] = $_POST['exerciceAnswer'];
                if($this->taskModel->isAlreadySubmited( $data['idTask'],$data['idUser'])){
                    if($this->taskModel->updateSubmitedTask($data['idUser'],$data['idTask'],$data['content'])){
                        echo 'ok';
                        exit;
                    }
                }else{
                    if($this->taskModel->table('submittask')->insert($data)){
                        echo 'ok';
                        exit;
                    }
                }
            }else{
                redirect('task');
            }
        }
    }

    public function results($idTask){
        if($idTask = intval($idTask)){
            $data['submitions'] = $this->taskModel->getTaskSubmitions($idTask,auth()->getTeacherID());
            return $this->view('admin' . DS . 'task' . DS . 'results',$data);
        }
    }

    public function get_task_content(){
        if(isset($_POST['idTask'])){
            $idUser = auth()->getTeacherID();
            if($_POST['taskType'] == 1){ // quiz
                echo file_get_contents(UPLOADS . 'tasks' . DS . 'quiz' . DS . $this->taskModel->getQuizContent($_POST['idTask'],$idUser)['content']);
                exit;
            }elseif($_POST['taskType'] == 2){
                echo file_get_contents(UPLOADS . 'tasks' . DS . 'exercice' . DS . $this->taskModel->getExerciceContent($_POST['idTask'],$idUser)['content']);
                exit;
            }
        }
    }
}
