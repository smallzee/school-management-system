<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-04-05
 * Time: 06:02
 */

require_once 'config/core.php';
$student_id = $_GET['student-id'];
if (!isset($student_id) or empty($student_id)){
    redirect(base_url('404.php'));
    return;
}

$sql = $db->query("SELECT s.*, c.name FROM ".DB_PREFIX."students s
 LEFT JOIN ".DB_PREFIX."class c 
    ON s.class_id = c.id
 WHERE c.id='$student_id'");
if ($sql->rowCount() == 0){
    redirect(base_url('404.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);

$page_title = ucwords($data['fname'])." Profile";

if (isset($_POST['add'])){
    $attendance = $_POST['attendance'];
    $attendance_date = $_POST['attendance_date'];

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."attendance WHERE student_id='$student_id' and attendance_date='$attendance_date'");

    if (date('Y-m-d') != $attendance_date){
        $error[] = "You cannot mark attendance for ".$data['fname']." ahead";
    }

    if ($sql->rowCount() >= 1){
        $error[] = "You have already mark an attendance for ".$data['fname']." on $attendance_date";
    }


    $error_count = count($error);
    if ($error_count == 0 ){

        $db->query("INSERT INTO ".DB_PREFIX."attendance (student_id,attendance,attendance_date)VALUES('$student_id','$attendance','$attendance_date')");

        set_flash("Attendance has been marked succcessful","info");

    }else{
        $msg = ($error_count == 1) ? 'An error is occurred' : 'Some errors are occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

require_once 'base/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Attendance</h4>
            </div>
            <div class="modal-body">

                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Attendance</label>
                        <select name="attendance" class="form-control" required id="">
                            <option value="" disabled selected>Select</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="left">Left</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Attendance Date</label>
                        <input type="date" class="form-control" required name="attendance_date" id="">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-danger" value="Submit" id="">
                    </div>
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

            <?php flash();?>

            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-red-gradient">
                    <h3 class="widget-user-username"><?= ucwords($data['fname']) ?></h3>
                    <h5 class="widget-user-desc"><?= ucwords($data['name']) ?></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?= image_url($data['image']) ?>" style="width: 80px; height: 80px;" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= term($data['term']) ?></h5>
                                <span class="description-text">Term</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= $data['academic_session'] ?></h5>
                                <span class="description-text">Academic Session</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header"><?= $data['birth']  ?></h5>
                                <span class="description-text">Date Of Birth</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Attendance List</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Offering Subjects</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Payment History</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal-default" style="margin-bottom: 20px;">Add Attendance</a>

                        <div class="table-responsive">
                            <table class="table-bordered table table-striped" id="example">
                                <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Attendance</th>
                                    <th>Attendance Date</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Attendance</th>
                                    <th>Attendance Date</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."attendance WHERE student_id='$student_id' ORDER BY id DESC");
                                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <tr>
                                                <td><?= $sn++ ?></td>
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
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Subject Name</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Subject Name</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                $class_id = $data['class_id'];
                                $ii =1;
                                $sql = $db->query("SELECT o.*, s.name FROM ".DB_PREFIX."offering_subjects o 
                                       INNER JOIN ".DB_PREFIX."subjects s 
                                        ON o.subject_id = s.id 
                                    WHERE o.class_id='$class_id'");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $ii++ ?></td>
                                        <td><?= ucwords($rs['name']) ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                        sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                        like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->

        </div>
    </div>
</section>

<?php require_once 'base/foot.php';?>
