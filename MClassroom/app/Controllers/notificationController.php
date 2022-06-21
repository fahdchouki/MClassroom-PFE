<?php
class notificationController extends Controller{

    public function index(){
        if(isset($_POST['getNot'])){
            $idUser = auth()->getStudentID();
            $notsGroup = (new Model)->getGroupsNots($idUser);
            $notsUser = (new Model)->getUserNots($idUser);
            $nots = array_merge($notsGroup,$notsUser);
            if(isset($_COOKIE['nots'])){
                $data = @unserialize($_COOKIE['nots']);
                $notsIDs = $data['notsids'];
                $lastTime = $data['time'];
                $filteredNots = [];
                foreach($nots as $not){
                    if(!in_array($not['idNotification'],$notsIDs)){
                        $filteredNots[] = $not;
                        $notsIDs[] = $not['idNotification'];
                        $data = [
                            'time' => $lastTime,
                            'notsids' => $notsIDs
                        ];
                        setcookie('nots',serialize($data),$lastTime,'/');
                    }
                }
                echo json_encode($filteredNots);
                exit;
            }else{
                $filteredNots = [];
                foreach($nots as $not){
                    if(time() - strtotime($not['created_at']) >= ((time() + (3600 * 24 * 7)) - time())){
                        (new Model)->table('notification')->delete('idNotification',$not['idNotification']);
                    }else{
                        $filteredNots[] = $not['idNotification'];
                    }
                }
                $cookie = [
                    'time' => time()+(3600 * 24 * 7),
                    'notsids' => $filteredNots
                ];
                setcookie('nots',serialize($cookie),time()+(3600 * 24 * 7),'/');
                echo json_encode($nots);
                exit;
            }
        }
    }
}