<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 2:21 PM
 */

$page_title = "Dashboard";
require_once 'config/core.php';
require_once 'assets/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient">
                <span class="info-box-icon"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Class name</span>
                    <span class="info-box-number">
                        <?= ucwords(student_class(student_details('class_id'),'name')) ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Application Id </span>
                    <span class="info-box-number">
                        <?= student_details('application_id') ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Student Name </span>
                    <span class="info-box-number">
                        <?= ucwords(student_details('fname')) ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text mt-10">Term </span>
                    <span class="info-box-number">
                        <?= term(student_details('term')) ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
</section>

<?php require_once 'assets/foot.php'?>
