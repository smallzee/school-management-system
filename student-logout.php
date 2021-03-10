<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 3:20 PM
 */
require_once 'config/core.php';
unset($_SESSION['student-loggedin']);
unset($_SESSION[STUDENT_SESSION_HOLDER]);
set_flash("You have logged out successfully","info");
redirect(base_url('login.php'));