<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 2:31 PM
 */

$page_title = "Student Profile";
require_once 'config/core.php';
$student_id = student_details('id');
require_once 'assets/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-red-gradient">
                    <h3 class="widget-user-username"><?= ucwords(student_details('fname')) ?></h3>
                    <h5 class="widget-user-desc"><?= ucwords(student_class(student_details('class_id'),'name')) ?></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?= image_url(student_details('image')) ?>" style="width: 80px; height: 80px;" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= term(student_details('term')) ?></h5>
                                <span class="description-text">Term</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= student_details('academic_session') ?></h5>
                                <span class="description-text">Academic Session</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header"><?= student_details('birth')  ?></h5>
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
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
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
                                $class_id = student_details('class_id');
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
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->

        </div>
    </div>
</section>

<?php require_once 'assets/foot.php';?>
