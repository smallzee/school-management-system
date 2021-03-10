<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 9:04 PM
 */

$page_title = "Student Information";
require_once 'config/core.php';
if (isset($_POST['add'])){
    $fname = $_POST['fname'];
    $class_id = $_POST['class'];
    $term = $_POST['term'];
    $session = $_POST['session'];
    $gender = $_POST['gender'];
    $birth = $_POST['birth'];
    $parent_id = $_POST['parent_id'];

    if (empty($fname) or empty($class_id) or empty($term) or empty($session)
        or empty($birth) or empty($gender) or empty($parent_id)){
        $error[] = "All field(s) are required";
    }


    if (strlen($fname) > 100 or strlen($fname) < 10){
        $error[] = "Full name should be between 10 - 100 characters";
    }

    if (isset($_FILES['upl'])){
        $file = $_FILES['upl'];
        $image_name = $file['name'];
        $path = pathinfo($image_name,PATHINFO_EXTENSION);

        $allowed = array('jpg','jpeg','png');
        if (!in_array($path,$allowed)){
            $error[] = "Invalid image format, it should be between jpg, jpeg or png";
        }

        if ($file['size'] > 1048576){
            $error[] = "Image too large, please reduce the image size";
        }

        $folder ='templates/images/';
        $img = time().$image_name;
        $destination = $folder.$img;

    }

    $error_count = count($error);
    if ($error_count == 0){


        if (move_uploaded_file($file['tmp_name'], $destination)){
            $db->query("INSERT INTO ".DB_PREFIX."students (image,parent_id,fname,class_id,
            term,academic_session,gender,birth)VALUES('$img','$parent_id','$fname','$class_id',
            '$term','$session','$gender','$birth')");

            set_flash("Student has been registered successfully","info");

            redirect(base_url('student.php'));
        }

    }else{
        $msg = ($error_count == 1) ? 'An error is occurred' : 'Some error(s) are occurred';
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
                <h4 class="modal-title">Register New Student</h4>
            </div>
            <div class="modal-body">

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Upload Passport</label>
                                <input type="file" name="upl" required accept="image/*" id="">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control" required placeholder="Full Name" name="fname" id="">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Class Name</label>
                                <select name="class" id="" required class="form-control">
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."class");
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

                        <div class="col-sm-12">
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

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" class="form-control" required id="">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Date Of Birth</label>
                                <input type="date" class="form-control" required placeholder="Date Of Birth" name="birth" id="">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Parent Name</label>
                                <select name="parent_id" class="form-control select2" style="width: 100%" required id="">
                                    <option value="" disabled selected>Select</option>
                                    <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."parents ORDER BY fname");
                                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <option value="<?= $rs['id'] ?>"><?= ucwords($rs['fname']) ?> (<?= $rs['phone'] ?>)</option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Register" id="">
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

            <?php flash(); ?>

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

                    <button type="button" class="btn btn-primary mb-20" data-toggle="modal" data-target="#modal-default">
                        Add New Student
                    </button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="example1">
                            <thead>
                                <tr>
                                    <th>Id</th>
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
                                <th>Id</th>
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
                                ORDER BY s.id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $rs['id'] ?></td>
                                        <td><img src="<?= image_url($rs['image']) ?>" class="img-thumbnail" style="width: 50px; height: 60px;" alt=""></td>
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

<?php require_once 'libs/foot.php'?>
