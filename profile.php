<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 1/18/21
 * Time: 4:06 PM
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

if (isset($_POST['update'])){
    $class_id = $_POST['class'];
    $session = $_POST['session'];
    $term = $_POST['term'];

    $up = $db->query("UPDATE ".DB_PREFIX."students SET class_id='$class_id', academic_session='$session', term='$term' WHERE id='$student_id'");

    set_flash("Profile has been updated successful","info");
}

require_once 'libs/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

            <?php flash() ?>

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
                    <li><a href="#tab_3" data-toggle="tab">Profile</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Payment Histery</a></li>
                    <li class="pull-right"><a href="#tab_4" data-toggle="tab" class="text-muted"><i class="fa fa-gear"></i> Student Profile</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
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
                    <div class="tab-pane" id="tab_5">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Amount Paid</th>
                                    <th>Reference</th>
                                    <th>Term</th>
                                    <th>Class</th>
                                    <th>Payment Status</th>
                                    <th>Academic Session</th>
                                    <th>Paid At</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Amount Paid</th>
                                    <th>Reference</th>
                                    <th>Term</th>
                                    <th>Class</th>
                                    <th>Payment Status</th>
                                    <th>Academic Session</th>
                                    <th>Paid At</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                $sql = $db->query("SELECT p.*, c.name as class_name, s.application_id, s.fname  FROM ".DB_PREFIX."payment p 
                                    LEFT JOIN ".DB_PREFIX."class c 
                                        ON p.class_id = c.id    
                                        
                                      INNER JOIN ".DB_PREFIX."students s
                                      ON p.student_id = s.id  
                                      WHERE p.student_id = '$student_id'
                                    ORDER BY p.id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= amount_format($rs['amount']) ?></td>
                                        <td><?= $rs['ref'] ?></td>
                                        <td><?= term($rs['term_id']) ?></td>
                                        <td><?= $rs['class_name'] ?></td>
                                        <td><?= $rs['status'] ?></td>
                                        <td><?= $rs['academic_session'] ?></td>
                                        <td><?= $rs['paid_at'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                    <div class="tab-pane" id="tab_4">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Term</label>
                                <select name="term" class="form-control" id="" required>
                                    <?php
                                       foreach (array(1,2,3) as $value){
                                           ?>
                                           <option value="<?= $value ?>" <?= ($value == $data['term']) ? 'selected' : ''?>><?= term($value) ?></option>
                                           <?php
                                       }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Class</label>
                                <select name="class" id="" required class="form-control">
                                    <?php
                                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."class");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option value="<?= $rs['id'] ?>" <?= ($rs['id'] == $data['class_id']) ? 'selected' : '' ?> ><?= ucwords($rs['name']) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Academic Session</label>
                                <select name="session" class="form-control" required id="">
                                    <option value="" disabled selected>Select</option>
                                    <?php
                                    foreach (range('2020',date('Y')) as $value){
                                        $start = $value-1;
                                        ?>
                                        <option value="<?= $start.'-'.$value ?>" <?= ($start.'-'.$value == $data['academic_session']) ? 'selected' : '' ?>><?= $start.'-'.$value ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-danger" value="Submit" name="update" id="">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_3">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Application Id</td>
                                    <td><?= $data['application_id'] ?></td>
                                </tr>
                                <tr>
                                    <td>Student Name</td>
                                    <td><?= $data['fname'] ?></td>
                                </tr>
                                <tr>
                                    <td>Class Name</td>
                                    <td><?= student_class($data['class_id'],'name') ?></td>
                                </tr>
                                <tr>
                                    <td>Term</td>
                                    <td><?= term($data['term']) ?></td>
                                </tr>
                                <tr>
                                    <td>Academic Session</td>
                                    <td><?= $data['academic_session'] ?></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td><?= ucwords($data['gender']) ?></td>
                                </tr>
                            </table>

                            <h6 class="page-header">Parent Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Full Name</td>
                                    <td><?= parent_info($data['parent_id'],'fname') ?></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td><?= parent_info($data['parent_id'],'gender') ?></td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td><?= parent_info($data['parent_id'],'phone') ?></td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td><?= parent_info($data['parent_id'],'email') ?></td>
                                </tr>
                                <tr>
                                    <td>Occupation</td>
                                    <td><?= parent_info($data['parent_id'],'occupation') ?></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->

        </div>
    </div>
</section>



<?php require_once 'libs/foot.php'?>
