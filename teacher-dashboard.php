<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 3:10 PM
 */

$page_title = "Teacher Dashboard";
require_once 'config/core.php';
$staff_id = teacher_details('id');
require_once 'base/head.php';
?>

<section class="content">
    <div class="row">
        <?php
        $sql = $db->query("SELECT c.*, a.fname, a.username, cc.name FROM ".DB_PREFIX."class_teacher c 
                LEFT JOIN ".DB_PREFIX."admin a
                     ON c.staff_id = a.id 
                LEFT JOIN ".DB_PREFIX."class cc
                     ON c.class_id = cc.id 
                WHERE c.staff_id = '$staff_id'    
            ORDER BY c.id DESC");
        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-red-gradient">
                    <span class="info-box-icon"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text mt-10">Total <?= ucwords($rs['name']) ?></span>
                        <span class="info-box-number">
                     <?php
                        $class_id = $rs['id'];
                         $sqls = $db->query("SELECT * FROM ".DB_PREFIX."students WHERE class_id='$class_id' ");
                         echo $sqls->rowCount();
                     ?>
                    </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <?php
        }
        ?>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Role</span>
                    <span class="info-box-number">
                        <?= ucwords(role(teacher_details('role'))) ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Staff Id</span>
                    <span class="info-box-number">
                        <?= ucwords(teacher_details('username')) ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

    </div>
</section>

<?php require_once 'base/foot.php';?>
