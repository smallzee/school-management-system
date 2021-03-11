<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 3:20 PM
 */

require_once 'config/core.php';
unset($_SESSION['teacher-loggedin']);
unset($_SESSION[TEACHER_SESSION_HOLDER]);
set_flash("You have logged out successfully","info");
redirect(base_url('teacher.php'));

