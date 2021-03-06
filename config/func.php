<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 1:18 PM
 */

$error = array();

function base_url($url = ""){
    if (empty($url)){
        return HOME_DIR;
    }else{
        return HOME_DIR.$url;
    }
}

function page_title($page_title = ""){
    if (empty($page_title)){
        return WEB_TITLE;
    }else{
        return $page_title." &dash; ".WEB_TITLE;
    }
}

function image_url($src){
    return base_url('templates/images/'.$src);
}

function set_flash ($msg,$type){
    $_SESSION['flash'] = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>'.$msg.'</div>';
}

function flash(){
    if (isset($_SESSION['flash'])) {
        echo $_SESSION['flash'];
        unset($_SESSION['flash']);
    }
}

function redirect($url){
    header("location:$url");
    exit();
}

function is_login(){
    if (!isset($_SESSION['loggedin'])){
        return 0;
    }else{
        return 1;
    }
}

function admin_details($value){
    global $db;
    $username = $_SESSION[USER_SESSION_HOLDER]['username'];
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE username='$username'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function teacher_details($value){
    global $db;
    $username = $_SESSION[TEACHER_SESSION_HOLDER]['username'];
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE username='$username'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function class_teacher($value){
    global $db;
    $teacher_id = teacher_details('id');
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."class_teacher WHERE staff_id='$teacher_id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function role($id){
    global $db;
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."role WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs['name'];
}

function admin_info($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function student_class($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."class WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function subject($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."subjects WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function term($n){
    if ($n == 1){
        $msg = "First Term";
    }elseif($n == 2){
        $msg = "Second Term";
    }else{
        $msg = "Third Term";
    }
    return $msg;
}

function amount_format($amount){
    return "&#8358;".number_format($amount,2);
}

function get_current_url($with_query = 1){
    return APP_PROTOCOL.$_SERVER['HTTP_HOST'].
        ($with_query? $_SERVER['REQUEST_URI'] : parse_url(
            APP_PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], PHP_URL_PATH));
}

function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function parent_info($id,$value){
    global $db;
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."parents WHERE id='$id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}


function student_details($value){
    global $db;
    $application_id = $_SESSION[STUDENT_SESSION_HOLDER]['application_id'];
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."students WHERE application_id='$application_id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}

function is_student_login(){
    if (!isset($_SESSION['student-loggedin'])){
        return 0;
    }else{
        return 1;
    }
}

function is_teacher_login(){
    if (!isset($_SESSION['teacher-loggedin'])){
        return 0;
    }else{
        return 1;
    }
}
