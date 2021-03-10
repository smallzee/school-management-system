<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 1/29/21
 * Time: 11:54 AM
 */

$page_title = "Subject";
require_once 'config/core.php';
if (isset($_POST['add'])){
    $subject = strtolower($_POST['subject']);

    if (empty($subject)){
        $error[] = "Subject is required";
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."subjects WHERE name='$subject'");
    if ($sql->rowCount() >= 1){
        $error[] = "$subject already exit";
    }

    if (strlen($subject) > 100 or strlen($subject) < 3){
        $error[] = "Subject name should be between 3 - 100 characters long";
    }

    $error_count = count($error);

    if ($error_count == 0){

        $db->query("INSERT INTO ".DB_PREFIX."subjects (name)VALUES('$subject') ");

        set_flash("$subject has been added successfully","info");

        redirect(base_url('subject.php'));

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
                <h4 class="modal-title">Add New Subject</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <div class="form-group">
                        <label for="">Subject Name</label>
                        <input type="text" name="subject" class="form-control" required placeholder="Subject Name" id="">
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

                    <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-default mb-20">Add Subject</a>

                    <?php flash() ?>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Subject Name</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Subject Name</th>
                                <th>Created At</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."subjects ORDER BY name");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?=$sn++?></td>
                                        <td><?= ucwords($rs['name']) ?></td>
                                        <td><?= $rs['created_at'] ?></td>
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
