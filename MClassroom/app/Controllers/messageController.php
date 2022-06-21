<?php

class messageController extends Controller{
    public $msgModel;
    public function __construct()
    {
        $this->msgModel = new MsgModel;
    }

    public function store_msg(){
        if(isset($_POST['msgContent'])){
            $senderID = $_POST['senderID'];
            $groupID = $_POST['groupID'];
            $msgContent = $_POST['msgContent'];
            if($this->msgModel->insert(array(
                'content' => $msgContent,
                'idUser' => $senderID,
                'idGroup' => $groupID,
                'created_at' => (new DateTime())->format("Y-m-d H:i:s.v"),
            ))){
                echo 'ok';
                if(auth()->isTeacher()){
                    $data['title'] = "New message From " . auth()->getSessUserInfo()['name'];
                    $data['content'] = excerpt($msgContent,20);
                    $data['type'] = 2;//group
                    $data['link'] = BURL . "group/";
                    $data['icon'] = BURL . "uploads/default_noti_icon.png";
                    $notModel = (new Model)->table('notification');
                    if($notModel->insert($data)){
                        $notID = $notModel->get_last_inserted_id();
                        (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>$groupID]);
                    }
                }
                exit;
            }
        }
        if(!empty($_FILES['imgToSend'])){
            $fileUpload = new Uploader;
            $fileUpload->setDir(UPLOADS . 'messages' . DS)->setMaxSize(10)->setExtensions(['jpg', 'jpeg', 'png', 'webp', 'jfif','gif']);
            if ($fileUpload->uploadFile('imgToSend', true)) {
                $msg = "<img class='clickMeImg' src='". BURL . 'uploads/messages/' . $fileUpload->getUploadName() ."' />";
                $senderID = $_POST['dataUserID'];
                $groupID = $_POST['group_id'];
                if($this->msgModel->insert(array(
                    'content' => $msg,
                    'idUser' => $senderID,
                    'idGroup' => $groupID,
                    'created_at' => (new DateTime())->format("Y-m-d H:i:s.v"),
                ))){
                    echo 'ok';
                    if(auth()->isTeacher()){
                        $data['title'] = "New message From " . auth()->getSessUserInfo()['name'];
                        $data['content'] = excerpt("new image sent",20);
                        $data['type'] = 2;//group
                        $data['link'] = BURL . "group/";
                        $data['icon'] = BURL . "uploads/default_noti_icon.png";
                        $notModel = (new Model)->table('notification');
                        if($notModel->insert($data)){
                            $notID = $notModel->get_last_inserted_id();
                            (new Model)->table('notification_for_group')->insert(['idNotification'=>$notID,'idGroup'=>$groupID]);
                        }
                    }
                    exit;
                }
            }
        }
    }
}