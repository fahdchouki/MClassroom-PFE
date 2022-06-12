<?php 

// define routes 
function url($url='')
{
    echo BURL . $url;
}
// auth function return object of Auth
function auth(){
    return new Auth;
}
// redirect with optional flash message
function redirect($url='',$msgKey = null,$message=null,$period = 5)
{
    if($msgKey !== null){
        if(is_array($message)){
            setcookie($msgKey,serialize($message),
                    time()+ $period,'/','',
                    (strtolower($_SERVER['REQUEST_SCHEME']) === 'http' ? false : true),
                    true
            );
        }else{
            setcookie($msgKey,$message,
                    time()+ $period,'/','',
                    (strtolower($_SERVER['REQUEST_SCHEME']) === 'http' ? false : true),
                    true
            );
        }
    }
    header("location:" . BURL.$url);
    exit;
}

//dump an array or object
function pre($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    die();
}

// excerpt function to get a part of string

function excerpt($text,$numOfChars = 10){
    return strlen($text) >= $numOfChars ? mb_substr($text,0,$numOfChars) . '...' : $text;
}

// format date function

function formatDate($date,$format = 'd-m-Y'){
    return date_format(date_create($date), $format);
}
