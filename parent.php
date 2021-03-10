<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 8:56 PM
 */

$page_title = "Parent Information";
require_once 'config/core.php';

if (isset($_POST['add'])){
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $occupation = $_POST['occupation'];
    $school_fee_deduction = $_POST['school-fee-deduction'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    if (empty($fname) or empty($phone) or empty($occupation) or empty($address) or empty($gender)){
        $error[] = "Full name and phone number and occupation and address are required";
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."parents WHERE phone='$phone'");
    if ($sql->rowCount() >= 1){
        $error[] = "This number $phone has already registered";
    }

    if ($occupation == 'fpe staff'){
        if (empty($school_fee_deduction)){
            $error[] = "School fee deduction from fpe staff salary is required";
        }
        $deduction = $school_fee_deduction;
    }else{
        $deduction = "No";
    }


    if (strlen($phone) != 11){
        $error[] = "Invalid phone number entered, it should be exactly 11 numbers";
    }

    if (!is_numeric($phone)){
        $error[] = "Invalid phone number format, it should be only digit number";
    }

    if (!empty($email) && !checkemail($email)){
        $error[] = "Invalid email address entered";
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

        if (move_uploaded_file($file['tmp_name'],$destination)) {

            $in = $db->query("INSERT INTO " . DB_PREFIX . "parents (image,fname,email,phone,occupation,address,school_fee_deduction,gender)
        VALUES('$img','$fname','$email','$phone','$occupation','$address','$deduction','$gender')");

            $last_id = $db->lastInsertId();
            $parent_id = sprintf("%05d", $last_id);

            $up = $db->query("UPDATE " . DB_PREFIX . "parents SET parent_id='$parent_id', password='$parent_id' WHERE id='$last_id'");

            set_flash("Parent has been added successfully", "info");

            redirect(base_url('parent.php'));
        }

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
                <h4 class="modal-title">Add New Parent</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Upload Passport</label>
                                <input type="file" name="upl" accept="image/*" required id="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control" required placeholder="Full Name"  name="fname" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email Address (Optional)</label>
                                <input type="email" class="form-control" placeholder="Email Address" name="email" id="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control" required name="phone" placeholder="Phone Number" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Occupation</label>
                                <select name="occupation" required id="occupation" class="form-control">
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                        $occup = array('fpe staff', 'trader','civil servant','others');
                                        foreach ($occup as $value){
                                            ?>
                                            <option value="<?= $value ?>"><?= ucwords($value); ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 hide school-fee-deduction">
                            <div class="form-group">
                                <label for="">Should we deduct children school fee from your salary</label>
                                <select name="school-fee-deduction" class="form-control" id="">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" class="form-control" required id="">
                                    <option value="" disabled selected>Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Home Address</label>
                                <textarea name="address" class="form-control" id="" style="resize: none" placeholder="Address"></textarea>
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
                        Add New Parent
                    </button>

                    <?php flash(); ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Passport</th>
                                <th>Parent Id</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                                <th>Occupation</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Password</th>
                                <th>Parent Id</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                                <th>Occupation</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."parents ORDER BY id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><img src="<?= image_url($rs['image']) ?>" class="img-thumbnail" style="width: 50px; height: 60px;" alt=""></td>
                                        <td><?= $rs['parent_id'] ?></td>
                                        <td><?= ucwords($rs['fname']) ?></td>
                                        <td><?= !(empty($rs['email'])) ? $rs['email'] :'N/A' ?></td>
                                        <td><?= $rs['phone'] ?></td>
                                        <td><?= ucwords($rs['gender']) ?></td>
                                        <td><?= ucwords($rs['occupation']) ?></td>
                                        <td><?= $rs['created_at'] ?></td>
                                        <td><a href="<?= base_url('view-parent.php?id=').$rs['id']; ?>" class="btn btn-primary btn-sm">View</a></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
    </div>
</section>

<?php require_once 'libs/foot.php'?>
