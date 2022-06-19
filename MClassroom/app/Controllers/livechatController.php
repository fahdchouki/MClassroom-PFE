<?php

class livechatController extends Controller{

    public function index(){
        if(auth()->isTeacher()){
            $data['livechats'] = (new Model)->getLivechatsWithGroups(auth()->getTeacherID());
            $data['groups'] = (new Model)->table('m_group')->getWhere('idUser',auth()->getTeacherID());
            return $this->view('admin' . DS . 'livechat',$data);
        }else{
            $data['livechats'] = (new Model)->getUserLivechats(auth()->getStudentID());
            return $this->view('admin' . DS . 'livechat',$data);
        }
    }

    public function create(){
        if(isset($_POST['title'])){
            $data['subject'] = $_POST['title'];
            $data['for_date'] = $_POST['forDate'];
            $data['channel'] = $_POST['channel'];
            $data['idUser'] = auth()->getTeacherID();
            $liveModel = (new Model)->table('livechat');
            if($liveModel->insert($data)){
                $livechatID = $liveModel->get_last_inserted_id();
                if((new Model)->table('livechat_for_group')->insert(['idLive'=>$livechatID,'idGroup'=>$_POST['groupid']])){
                    echo 'ok';
                            $data = [];
                            $data['title'] = "New Livechat From " . auth()->getSessUserInfo()['name'];
                            $data['content'] = excerpt($_POST['title'],20);
                            $data['type'] = 2;//group
                            $data['link'] = BURL . "livechat/";
                            $data['icon'] = BURL . "uploads/default_noti_icon_livechat.png";
                            $notModel = (new Model)->table('notification');
                            if($notModel->insert($data)){
                                $notID = $notModel->get_last_inserted_id();
                                (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>$_POST['groupid']]);
                            }
                    exit;
                }
            }
        }else{
            redirect('livechat');
        }
    }

    public function delete(){
        if(isset($_POST['idLivechat'])){
            if((new Model)->table('livechat')->delete('idLive',$_POST['idLivechat'])){
                echo 'ok';
                exit;
            }
        }
    }
}