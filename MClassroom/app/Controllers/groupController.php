<?php

class groupController extends Controller
{
    protected $groupModel;

    public function __construct(){
        $this->groupModel = new GroupModel;
    }

    public function index()
    {
        if(auth()->isTeacher()){
            $data['allGroups'] = $this->groupModel->getGroupsWithLastMsg(auth()->getTeacherID());
            return $this->view('admin' . DS . 'group' . DS . 'groups',$data);
        }elseif(auth()->isStudent()){
            $data['allGroups'] = $this->groupModel->getGroupsWithLastMsg_std(auth()->getStudentID());
            return $this->view('admin' . DS . 'group' . DS . 'groups',$data);
        }
    }

    public function opened()
    {
        $idUser = auth()->isTeacher() ? auth()->getTeacherID() : auth()->getStudentID();
        $data['allGroups'] = $this->groupModel->getOpenedGroups($idUser);
        return $this->view('admin' . DS . 'group' . DS . 'open-groups',$data);
    }

    public function get_refresh(){
        if(isset($_GET['getall'])){
            if(auth()->isTeacher()){
                echo json_encode($this->groupModel->getGroupsWithLastMsg(auth()->getTeacherID()));
                exit;
            }elseif(auth()->isStudent()){
                echo json_encode($this->groupModel->getGroupsWithLastMsg_std(auth()->getStudentID()));
                exit;
            }
        }
    }

    public function settings()
    {
        $data['groups'] = $this->groupModel->getGroupsWithMemsByIdUser(auth()->getTeacherID());
        return $this->view('admin' . DS . 'group' . DS . 'manage-groups',$data);
    }

    public function search_user(){
        if($_POST['searchByUsername']){
             echo json_encode((new Model)->table('user')->getUserLike($_POST['grpID'],$_POST['searchByUsername']));
            exit;
        }
    }

    public function get_group_by_id(){
        if($_POST['idGroup']){
            echo json_encode($this->groupModel->getWhere('idGroup',$_POST['idGroup'])[0]);
           exit;
       }
    }

    public function create()
    {
        if (isset($_POST['groupName'])) {
            $data = [
                'label' => trim($_POST['groupName']),
                'group_type' => trim($_POST['groupType']),
                'idUser' => auth()->getTeacherID(),
            ];

            $errors = array();

            // if (!valid_string($data['client_name']) || strlen($data['client_name']) < 4) {
            //     $errors['client_name'] = 'username must be mor than 4 character and contains only letters, numbers and _';
            // }
            
            // if (!valid_email($data['client_email']) || strlen($data['client_email']) < 4) {
            //     $errors['client_email'] = 'invalid email';
            // }
            // if (!valid_string($data['client_address'],true) || strlen($data['client_address']) < 4) {
            //     $errors['client_address'] = 'invalid address';
            // }

            if(empty($errors)){
                if(!empty($_FILES['groupIcon'])){
                    $fileUpload = new Uploader;
                    $fileUpload->setDir(UPLOADS . 'groups' . DS)->setMaxSize(10)->setExtensions(['jpg', 'jpeg', 'png', 'webp', 'jfif']);
                    if ($fileUpload->uploadFile('groupIcon', true)) {
                        $data['group_icon'] = $fileUpload->getUploadName();
                    } else {
                        $errors['group_icon'] = $fileUpload->getMessage();
                    }
                    if (empty($errors)) {              
                        $grpMd = (new Model)->table('m_group');
                        if ($grpMd->insert($data)) {
                            (new Model)->table('joingroup')->insert(array(
                                'idGroup' => $grpMd->get_last_inserted_id(),
                                'idUser' => auth()->getTeacherID()
                            ));
                            echo "ok";
                            exit;
                        } else {
                            $errors['error'] = 'something went wrong';
                            echo json_encode($errors);
                            exit;
                        }
                    }
                }else{
                    $grpMd = (new Model)->table('m_group');
                    $data['group_icon'] = 'default.jpg';
                    if ($grpMd->insert($data)) {
                        (new Model)->table('joingroup')->insert(array(
                            'idGroup' => $grpMd->get_last_inserted_id(),
                            'idUser' => auth()->getTeacherID()
                        ));
                        echo "ok";
                        exit;
                    } else {
                        $errors['error'] = 'something went wrong';
                        echo json_encode($errors);
                            exit;
                    }
                }
            }else{
                echo json_encode($errors);
                            exit;
            }
        }else{
            redirect();
        }
    }

    public function update(){
        if (isset($_POST['groupName'])) {
            $data = [
                'label' => trim($_POST['groupName']),
                'group_type' => trim($_POST['groupType']),
            ];

            $errors = array();

            // if (!valid_string($data['client_name']) || strlen($data['client_name']) < 4) {
            //     $errors['client_name'] = 'username must be mor than 4 character and contains only letters, numbers and _';
            // }
            
            // if (!valid_email($data['client_email']) || strlen($data['client_email']) < 4) {
            //     $errors['client_email'] = 'invalid email';
            // }
            // if (!valid_string($data['client_address'],true) || strlen($data['client_address']) < 4) {
            //     $errors['client_address'] = 'invalid address';
            // }

            if(empty($errors)){
                if(!empty($_FILES['groupIcon'])){
                    $fileUpload = new Uploader;
                    $fileUpload->setDir(UPLOADS . 'groups' . DS)->setMaxSize(10)->setExtensions(['jpg', 'jpeg', 'png', 'webp', 'jfif']);
                    if ($fileUpload->uploadFile('groupIcon', true)) {
                        $data['group_icon'] = $fileUpload->getUploadName();
                    } else {
                        $errors['group_icon'] = $fileUpload->getMessage();
                    }
                    if (empty($errors)) {              
                        if ($this->groupModel->update($data,'idGroup',$_POST['groupID'])) {
                            echo "ok";
                            exit;
                        } else {
                            $errors['error'] = 'something went wrong';
                            echo json_encode($errors);
                            exit;
                        }
                    }
                }else{
                    if ($this->groupModel->update($data,'idGroup',$_POST['groupID'])) {
                        echo "ok";
                        exit;
                    } else {
                        $errors['error'] = 'something went wrong';
                        echo json_encode($errors);
                            exit;
                    }
                }
            }else{
                echo json_encode($errors);
                            exit;
            }
        }else{
            redirect();
        }
    }

    public function delete()
    {
        if(isset($_POST['grpID'])){
            if($this->groupModel->delete('idGroup',$_POST['grpID'])){
                echo "ok";
                        exit;
            }else{
                echo "wrong";
                        exit;
            }
        }else{
            redirect();
        }
    }

    public function get_group_chats(){
        if(isset($_POST['grpID'])){
            $grpID = intval($_POST['grpID']);
            $idUser = auth()->isTeacher() ? auth()->getTeacherID() : auth()->getStudentID();
            $msgs = $this->groupModel->getGroupMessages($idUser,$grpID);
            $groupInfo = $this->groupModel->getGroupInfo($idUser,$grpID);
            if(auth()->isStudent()){
                $msgs = $this->groupModel->getGroupMessages_std($grpID);
                $groupInfo = $this->groupModel->getGroupInfo_std($grpID);
            }
            echo  json_encode(array(
                'groupInfo' => $groupInfo,
                'groupMsgs' => $msgs,
            ));
            exit;
        }
    }


    public function add_member(){
        if(isset($_POST['userID'])){
            if((new Model)->table('joingroup')->insert(array(
                'idGroup' => $_POST['groupID'],
                'idUser' => $_POST['userID'],
            ))){
                echo 'ok';
                    $dataMember['title'] = "You are a new member in " . auth()->getSessUserInfo()['name'] . " group";
                    $dataMember['content'] = "The group admin added you recently";
                    $dataMember['type'] = 1;//user
                    $dataMember['link'] = BURL . "group/";
                    $dataMember['icon'] = BURL . "uploads/default_noti_icon_new_mem.png";
                    $notModel = (new Model)->table('notification');
                    if($notModel->insert($dataMember)){
                        $notID = $notModel->get_last_inserted_id();
                        (new Model)->table('notification_for_user')->insert(['idNotification'=>$notID,'idUser'=>$_POST['userID']]);
                    }
                exit;
            }
        }
    }

    public function get_group_members(){
        if(isset($_POST['grpID'])){
            echo json_encode($this->groupModel->get_group_members($_POST['grpID']));
            exit;
        }
    }

    public function delete_member(){
        if(isset($_POST['group_id'])){
            $userID = $_POST['user_id'];
            $groupID = $_POST['group_id'];
            if($this->groupModel->deleteMember($userID,$groupID)){
                echo 'ok';
                exit;
            }
        }
    }

    public function exit_from_group(){
        if(isset($_POST['studentID'])){
            $stdID = $_POST['studentID'];
            $grpID = $_POST['groupID'];
            if($this->groupModel->deleteMember($stdID,$grpID)){
                echo 'ok';
                exit;
            }
        }
    }
}
