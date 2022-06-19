<?php

class Route{

    private $routes = [
        'home' => ['index'],
        'services' => ['index'],
        'auth' => ['index','login','register','check_user','store','forget'],
    ];
    private $studentRoutes = [
        'home' => ['index'],
        'course' => ['index'],
        'event' => ['index'],
        'group' => ['index','get_group_chats','get_group_members','exit_from_group','get_refresh','opened','add_member'],
        'livechat' => ['index'],
        'message' => ['index','store_msg'],
        'task' => ['index','submit_task','can_submit','submit'],
        'notification' => ['index'],
        'user' => ['index','profile','update_profile'],
        'auth' => ['index','login','register','logout','check_user','store','forget'],
    ];
    private $teacherRoutes = [
        'home' => ['index'],
        'course' => ['index','create','store','edit','update','delete'],
        'event' => ['index','delete','add_event'],
        'group' => ['index','opened','get_refresh','settings','get_group_by_id','search_user','create','get_group_chats','edit','update','delete','add_member','get_group_members','delete_member'],
        'livechat' => ['index','create','delete'],
        'message' => ['index','store_msg'],
        'task' => ['index','create','get_users_by_group','delete','participants','results','get_task_content'],
        'quiz' => ['index','create','store','discard'],
        'exercice' => ['index','create','store','discard'],
        'user' => ['index','profile','update_profile'],
        'auth' => ['index','login','register','logout','check_user','store','forget'],
    ];
    

    public function getList(Auth $auth){
        if($auth->isStudent()){
            return $this->studentRoutes;
        }elseif($auth->isTeacher()){
            return $this->teacherRoutes;
        }else{
            return $this->routes;
        }
    }
}