<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 2:31 PM
 */

$page_title = "Student Profile";
require_once 'config/core.php';
require_once 'assets/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-red-gradient">
                    <h3 class="widget-user-username"><?= ucwords(student_details('fname')) ?></h3>
                    <h5 class="widget-user-desc"><?= ucwords(student_class(student_details('class_id'),'name')) ?></h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?= image_url(student_details('image')) ?>" style="width: 80px; height: 80px;" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= term(student_details('term')) ?></h5>
                                <span class="description-text">Term</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header"><?= student_details('academic_session') ?></h5>
                                <span class="description-text">Academic Session</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header"><?= student_details('birth')  ?></h5>
                                <span class="description-text">Date Of Birth</span>
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
    </div>
</section>

<?php require_once 'assets/foot.php';?>
