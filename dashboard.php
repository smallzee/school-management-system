<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 2:27 PM
 */

$page_title = "Dashboard";
require_once 'config/core.php';
require_once 'libs/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Total Admin</span>
                    <span class="info-box-number">
                        <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE role=1");
                            echo $sql->rowCount();
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Total Staff</span>
                    <span class="info-box-number">
                     <?php
                         $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE role=2");
                         echo $sql->rowCount();
                     ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Total Class Teachers</span>
                    <span class="info-box-number">
                     <?php
                     $sql = $db->query("SELECT * FROM ".DB_PREFIX."class_teacher");
                     echo $sql->rowCount();
                     ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient">
                <span class="info-box-icon"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Total Class Subject</span>
                    <span class="info-box-number">
                     <?php
                     $sql = $db->query("SELECT * FROM ".DB_PREFIX."subjects ");
                     echo $sql->rowCount();
                     ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-sm-6">
            <div class="box ">
                <div class="box-header with-border">All Staffs</div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin ORDER BY id DESC LIMIT 0,8");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= $rs['fname'] ?></td>
                                        <td><?= $rs['phone'] ?></td>
                                        <td><?= $rs['email'] ?></td>
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

        <div class="col-sm-6">
            <div class="box ">
                <div class="box-header with-border">All Staffs</div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin ORDER BY id DESC LIMIT 0,8");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $rs['fname'] ?></td>
                                    <td><?= $rs['phone'] ?></td>
                                    <td><?= $rs['email'] ?></td>
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
