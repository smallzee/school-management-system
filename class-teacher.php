<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 4:01 PM
 */

$page_title = "Student Class Teachers";
require_once 'config/core.php';
if (isset($_POST['add'])){
    $staff_id = $_POST['staff-id'];
    $class_id = $_POST['class-id'];
    $term = $_POST['term'];
    $session = $_POST['session'];

    if (empty($staff_id) or empty($class_id) or empty($term) or empty($session)){
        $error[] = "All field(s) are required";
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."class_teacher WHERE staff_id='$staff_id' and class_id='$staff_id' and session='$session'");
    if ($sql->rowCount() >= 1){
        $error[] = "";
    }


    $error_count = count($error);
    if ($error_count == 0){

        $in = $db->query("INSERT INTO ".DB_PREFIX."class_teacher (staff_id,class_id,term,session)VALUES('$staff_id','$class_id','$term','$session')");

        set_flash(admin_info($staff_id,'fname')." has been assigned as class teacher for ".student_class($class_id,'name'),'info');

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
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
                <h4 class="modal-title">Add New Class Teacher</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Staff Name</label>
                                <select name="staff-id" required id="" class="form-control">
                                    <option value="" disabled selected>Select</option>
                                    <?php
                                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE role=2 ORDER BY fname");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option value="<?= $rs['id'] ?>"><?= ucwords($rs['fname']) ?> (<?= $rs['username'] ?>)</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Class Name</label>
                                <select name="class-id" required id="" class="form-control">
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
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Term</label>
                                <select name="term" class="form-control" required id="">
                                    <option value="" disabled selected>Select</option>
                                    <option value="1">First Term</option>
                                    <option value="2">Second Term</option>
                                    <option value="3">Third Term</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Academic Session</label>
                                <select name="session" class="form-control" required id="">
                                    <option value="" disabled selected>Select</option>
                                    <?php
                                        foreach (range('2020',date('Y')) as $value){
                                            $start = $value-1;
                                            ?>
                                            <option value="<?= $start.'-'.$value ?>"><?= $start.'-'.$value ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary btn-sm" value="Submit" id="">
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

                    <button type="button" class="btn btn-default mb-20" data-toggle="modal" data-target="#modal-default">
                        Add New Class Teacher
                    </button>

                    <?php flash(); ?>

                    <div class="table-responsive">
                        <table class="table-bordered table-striped table" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Class Teacher Id</th>
                                <th>Class Teacher Name</th>
                                <th>Class Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Class Teacher Id</th>
                                <th>Class Teacher Name</th>
                                <th>Class Name</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                                $sql = $db->query("SELECT c.*, a.fname, a.username, cc.name FROM ".DB_PREFIX."class_teacher c 
                                LEFT JOIN ".DB_PREFIX."admin a
                                     ON c.staff_id = a.id 
                                LEFT JOIN ".DB_PREFIX."class cc
                                     ON c.class_id = cc.id 
                                ORDER BY c.id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= $rs['username'] ?></td>
                                        <td><?= ucwords($rs['fname']) ?></td>
                                        <td><?= ucwords($rs['name']) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="" class="btn btn-primary btn-sm">View student</a>
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

<?php require_once 'libs/foot.php'?>
