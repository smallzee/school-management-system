<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/11/21
 * Time: 9:30 AM
 */

$page_title = "Teacher Student Classes";
require_once 'config/core.php';
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
                        <table class="table-bordered table-striped table" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $staff_id = teacher_details('id');
                            $sql = $db->query("SELECT c.*, a.fname, a.username, cc.name FROM ".DB_PREFIX."class_teacher c 
                                LEFT JOIN ".DB_PREFIX."admin a
                                     ON c.staff_id = a.id 
                                LEFT JOIN ".DB_PREFIX."class cc
                                     ON c.class_id = cc.id 
                                 WHERE c.staff_id = '$staff_id'    
                                ORDER BY c.id DESC");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= ucwords($rs['name']) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="teacher-student.php?id=<?= $rs['class_id'] ?>" class="btn btn-primary btn-sm">View student</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

<?php require_once 'base/foot.php';?>
