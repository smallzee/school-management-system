<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 1:18 PM
 */

    session_start();
    require_once 'func.php';
    define('Env', 'onlin');

    define("DB_PREFIX", "ch_");

    define("HOME_DIR","http://projects.io/web/school-management/");
    define("HTML_TEMPLATE",base_url('templates/'));
    define("LIB_TEMPLATE",HTML_TEMPLATE.'libs/');

    define("USER_SESSION_HOLDER", "admin");
    define("STUDENT_SESSION_HOLDER", "student");
    define("TEACHER_SESSION_HOLDER", "teacher");

    define("WEB_TITLE","FPE Staff School");
    define("WEB_SUB_TITLE","CH");

    define("APP_PROTOCOL", "http://");

    if (Env == "online") {
        define('DB_HOST', 'localhost');
        define('DB_TABLE', 'verajnse_creche');
        define('DB_USER', 'verajnse_creche');
        define('DB_PASSWORD', ';XW8Ll#wss&j');
    }else{
        define('DB_HOST', 'localhost');
        define('DB_TABLE', 'web_fpe_school_management');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
    }

    try {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_TABLE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    catch (PDOException $e){
        die('<br/><center><font size="15">Could not connect with database</font></center>');
    }