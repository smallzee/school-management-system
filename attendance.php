<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/11/21
 * Time: 10:10 AM
 */

require_once 'config/core.php';
$class_id = $_GET['id'];
if (!isset($class_id) or empty($class_id)){
    redirect(base_url('teacher-dashboard.php'));
    return;
}


$staff_id = teacher_details('id');

$sql = $db->query("SELECT c.*, a.fname, a.phone, a.email, a.username, cc.name FROM ".DB_PREFIX."class_teacher c 
LEFT JOIN ".DB_PREFIX."admin a
     ON c.staff_id = a.id 
LEFT JOIN ".DB_PREFIX."class cc
ON c.class_id = cc.id WHERE c.class_id='$class_id' and c.staff_id='$staff_id'");

if ($sql->rowCount() == 0){
    redirect(base_url('teacher-dashboard.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);

$page_title = ucwords($data['name'])." Attendance";

require_once 'base/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page_title ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table-bordered table table-striped" id="example">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Application Id</th>
                                <th>Full Name</th>
                                <th>Attendance</th>
                                <th>Attendance Date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Application Id</th>
                                <th>Full Name</th>
                                <th>Attendance</th>
                                <th>Attendance Date</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $sql = $db->query("SELECT a.*, s.application_id, s.fname FROM ".DB_PREFIX."attendance a
                              LEFT JOIN ".DB_PREFIX."students s ON a.student_id = s.id ORDER BY id DESC");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $rs['application_id'] ?></td>
                                    <td><?= $rs['fname'] ?></td>
                                    <td><?= ucwords($rs['attendance']) ?></td>
                                    <td><?= $rs['attendance_date'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'base/foot.php';?>
