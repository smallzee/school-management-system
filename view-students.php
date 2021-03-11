<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 10:51 AM
 */

require_once 'config/core.php';
$class_id = $_GET['id'];
if (!isset($class_id) or empty($class_id)){
    redirect(base_url('404.php'));
    return;
}

$sql = $db->query("SELECT c.*, a.fname, a.phone, a.email, a.username, cc.name FROM ".DB_PREFIX."class_teacher c 
LEFT JOIN ".DB_PREFIX."admin a
     ON c.staff_id = a.id 
LEFT JOIN ".DB_PREFIX."class cc
     ON c.class_id = cc.id WHERE c.class_id='$class_id'");

if ($sql->rowCount() == 0){
    redirect(base_url('404.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);

$page_title = ucwords($data['name'])." Class Teacher";


require_once 'libs/head.php';
?>

<section class="content">
    <div class="row">

        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-red-gradient">
                    <h3 class="widget-user-username"><?= ucwords($data['fname']) ?></h3>
                    <h5 class="widget-user-desc"><?= ucwords($data['name']) ?></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?= image_url('icon.jpeg') ?>" style="width: 80px; height: 80px;" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= $data['username'] ?></h5>
                                <span class="description-text">Staff Id</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= $data['phone'] ?></h5>
                                <span class="description-text">Phone Number</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header"><?= $data['email']  ?></h5>
                                <span class="description-text">Email Address</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= ucwords($data['name']) ?> Students</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>Application Id</th>
                                <th>Passport</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Date Of Birth</th>
                                <th>Class</th>
                                <th>Terms</th>
                                <th>Parent Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Application Id</th>
                                <th>Passport</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Date Of Birth</th>
                                <th>Class</th>
                                <th>Terms</th>
                                <th>Parent Name</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $sql = $db->query("SELECT s.*, c.name, p.fname as parent_name FROM ".DB_PREFIX."students s 
                                LEFT JOIN ".DB_PREFIX."class c
                                    ON s.class_id = c.id
                                LEFT JOIN ".DB_PREFIX."parents p 
                                    ON s.parent_id = p.id   
                                WHERE s.class_id ='$class_id'     
                                ORDER BY s.id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><img src="<?= image_url($rs['image']) ?>" class="img-thumbnail" style="width: 50px; height: 50px;" alt=""></td>
                                        <td><?= $rs['application_id'] ?></td>
                                        <td><?= $rs['fname'] ?></td>
                                        <td><?= date('Y') - explode("-",$rs['birth'])[0]  ?></td>
                                        <td><?= $rs['gender'] ?></td>
                                        <td><?= $rs['birth'] ?></td>
                                        <td><?= $rs['name'] ?></td>
                                        <td><?= term($rs['term']) ?></td>
                                        <td><?= $rs['parent_name'] ?></td>
                                        <td><a href="profile.php?student-id=<?= $rs['id'] ?>" class="btn btn-primary btn-sm">View</a></td>
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

<?php require_once 'libs/foot.php';?>
