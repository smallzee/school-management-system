<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 1/29/21
 * Time: 12:21 PM
 */

$page_title = "Class Subjects";
require_once 'config/core.php';
if (isset($_POST['add'])){
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];

    if (empty($class_id) or empty($subject_id)){
        $error[] = "Subject or class name are required";
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."offering_subjects WHERE class_id='$class_id' and subject_id='$subject_id'");
    if ($sql->rowCount() >= 1){
        $error[] = subject($subject_id,'name')." has already assigned for ".student_class($class_id,'name');
    }

    $error_count = count($error);
    if ($error_count == 0){

        $db->query("INSERT INTO ".DB_PREFIX."offering_subjects (class_id,subject_id)VALUES('$class_id','$subject_id') ");

        set_flash(subject($subject_id,"name"). ' has been assigned for '.student_class($class_id,'name').' successfully','info');

        redirect(base_url('class-subject.php'));


    }else{
        $msg = ($error_count == 1) ? 'An error is occurred' : 'Some error are occured';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}
require_once 'libs/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Offering Subject</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <div class="form-group">
                        <label for="">Class Name</label>
                        <select name="class_id" class="form-control" required id="">
                            <option value="" disabled selected>Select</option>
                            <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."class ORDER BY name");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Subject Name</label>
                        <select name="subject_id" class="form-control" required id="">
                            <option value="" disabled selected>Select</option>
                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."subjects ORDER BY name");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit" id="">
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
        <div class="col-md-12">

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

                    <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-default mb-20">Add Offering Subject</a>

                    <?php flash() ?>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>Subject Name</th>
                                <th>Class Teacher Name</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>Subject Name</th>
                                <th>Class Teacher Name</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."class ORDER BY name");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    $class_id = $rs['id'];
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= ucwords($rs['name']) ?></td>
                                        <td>
                                            <table>
                                                <?php
                                                    $i =1;
                                                    $sql3 = $db->query("SELECT o.*, s.name FROM ".DB_PREFIX."offering_subjects o
                                                     INNER JOIN ".DB_PREFIX."subjects s ON o.subject_id = s.id
                                                     WHERE o.class_id='$class_id'");
                                                    while ($rs3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <tr>
                                                            <td style="padding-bottom: 5px;"><?= $i.'. '. ucwords($rs3['name']) ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td>
                                            <?php
                                                $sql2 = $db->query("SELECT c.*, a.fname FROM ".DB_PREFIX."class_teacher c
                                                 LEFT JOIN ".DB_PREFIX."admin a ON c.staff_id = a.id
                                                 WHERE c.class_id='$class_id'");
                                                while ($rs2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <span class="label label-primary" style="margin-left: 5px;"><?= $rs2['fname'] ?></span>
                                                    <?php
                                                }
                                            ?>
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

        </div>
    </div>
</section>


<?php require_once 'libs/foot.php'?>
