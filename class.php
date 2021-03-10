<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 3:30 PM
 */

$page_title = "Student Classes";
require_once 'config/core.php';

if (isset($_POST['add'])){
    $name = strtolower($_POST['name']);
    $amount = $_POST['amount'];
    if (empty($name)){
        $error[] = "Class name is required";
    }

    if (empty($amount)){
        $error[] = "school fee amount is required";
    }

    if (!is_numeric($amount)){
        $error[] = "Invalid school fee amount entered";
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."class WHERE name='$name'");
    if ($sql->rowCount() >= 1){
        $error[] = "$name has already exist";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $in = $db->query("INSERT INTO ".DB_PREFIX."class (name,school_fee)VALUE('$name','$amount')");
        set_flash("$name has been added successfully","info");

        redirect(base_url('class.php'));

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

if (isset($_POST['edit'])){
    $name = strtolower($_POST['name']);
    $id = $_POST['id'];
    $amount = $_POST['amount'];


    if (empty($name)){
        $error[] = "Class name is required";
    }

    if (empty($amount)){
        $error[] = "school fee amount is required";
    }

    if (!is_numeric($amount)){
        $error[] = "Invalid school fee amount entered";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $up = $db->query("UPDATE ".DB_PREFIX."class SET name='$name', school_fee='$amount' WHERE id='$id'");
        set_flash("$name has been updated successfully","info");

        redirect(base_url('class.php'));

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

if (isset($_POST['delete'])){
    $class_id = $_POST['class_id'];
    $db->query("DELETE FROM ".DB_PREFIX."class WHERE id='$class_id'");
    $data = array('error'=>1,'msg'=>'Class has been deleted success');
    echo json_encode($data);
    exit();
}

require_once 'libs/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Class</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Class Name</label>
                        <input type="text" class="form-control" required name="name" placeholder="Class Name" id="">
                    </div>

                    <div class="form-group">
                        <label for="">School Fee Amount</label>
                        <input type="text" class="form-control" name="amount" required placeholder="School Fee Amount" id="">
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

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit  Class</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Class Name</label>
                        <input type="text" class="form-control" required name="name" placeholder="Class Name" id="name">
                        <input type="hidden" name="id" id="id">
                    </div>

                    <div class="form-group">
                        <label for="">School Fee Amount</label>
                        <input type="text" class="form-control" name="amount" required placeholder="School Fee Amount" id="amount">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="edit" class="btn btn-primary btn-sm" value="Edit" id="">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<a href="" class="show-modal" data-toggle="modal" data-target="#modal-default2"></a>
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
                       Add New Class
                    </button>

                    <?php flash(); ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>School Fee</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>School Fee</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."class ORDER BY name");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= ucwords($rs['name']) ?></td>
                                        <td><?= amount_format($rs['school_fee']); ?></td>
                                        <td><?= $rs['created_at'] ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" onclick="update_class('<?= $rs['id'] ?>','<?= $rs['name'] ?>','<?= $rs['school_fee'] ?>')" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="#" onclick="delete_class('<?= $rs['id'] ?>')" class="btn btn-danger btn-sm">Danger</a>
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
