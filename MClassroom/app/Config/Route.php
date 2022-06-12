<?php

class Route{

    private $routes = [
        'home' => ['index'],
        'auth' => ['index','login','register','check_user','store','forget'],
    ];
    private $studentRoutes = [
        'home' => ['index'],
        'course' => ['index','course'],
        'event' => ['index'],
        'group' => ['index','get_group_chats','get_group_members','exit_from_group','get_refresh','opened','add_member'],
        'livechat' => ['store'],
        'message' => ['index','store_msg'],
        'task' => ['index','send'],
        'quiz' => ['index','send'],
        'exercice' => ['index','send'],
        'user' => ['profile','update_profile'],
        'auth' => ['index','login','register','logout','check_user','store','forget'],
    ];
    private $teacherRoutes = [
        'home' => ['index'],
        'course' => ['index','course','create','store','edit','update','delete','disable'],
        'event' => ['index'],
        'group' => ['index','opened','get_refresh','settings','get_group_by_id','search_user','create','get_group_chats','edit','update','delete','add_member','get_group_members','delete_member'],
        'livechat' => ['store'],
        'message' => ['index','store_msg'],
        'task' => ['index','send'],
        'quiz' => ['index','send'],
        'exercice' => ['index','send'],
        'user' => ['search','send_invitation','profile','update_profile'],
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