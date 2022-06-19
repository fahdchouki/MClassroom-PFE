<?php

class eventController extends Controller{

    public function index(){
        if(auth()->isTeacher()){
            $data['events'] = (new Model)->getEventsWithGroups(auth()->getTeacherID());
            $data['groups'] = (new Model)->table('m_group')->getWhere('idUser',auth()->getTeacherID());
            $data['eventsStr'] = json_encode($data['events']);
            return $this->view('admin' . DS . 'event',$data);
        }else{
            $data['eventsStr'] = json_encode((new Model)->getUserEvents(auth()->getStudentID()));
            return $this->view('admin' . DS . 'event',$data);
        }
    }

    public function add_event(){
        if(isset($_POST['title'])){
            $data['title'] = $_POST['title'];
            $data['start_date'] = $_POST['start'];
            $data['end_date'] = $_POST['end'];
            $data['idUser'] = auth()->getTeacherID();
            $evModel = (new Model)->table('event');
            if($evModel->insert($data)){
                $eventID = $evModel->get_last_inserted_id();
                if((new Model)->table('event_for_group')->insert(['idEvent'=>$eventID,'idGroup'=>$_POST['groupid']])){
                    echo 'ok';
                            $data = [];
                            $data['title'] = "New Event From " . auth()->getSessUserInfo()['name'];
                            $data['content'] = excerpt($_POST['title'],20);
                            $data['type'] = 2;//group
                            $data['link'] = BURL . "event/";
                            $data['icon'] = BURL . "uploads/default_noti_icon_event.png";
                            $notModel = (new Model)->table('notification');
                            if($notModel->insert($data)){
                                $notID = $notModel->get_last_inserted_id();
                                (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>$_POST['groupid']]);
                            }
                    exit;
                }
            }
        }else{
            redirect('event');
        }
    }

    public function delete(){
        if(isset($_POST['idEvent'])){
            if((new Model)->table('event')->delete('idEvent',$_POST['idEvent'])){
                echo 'ok';
                exit;
            }
        }
    }
}