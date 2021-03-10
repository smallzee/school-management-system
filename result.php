<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 2:34 PM
 */

$page_title = "Check Result";
require_once 'config/core.php';
require_once 'assets/head.php';
?>

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

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Term</label>
                            <select name="term" id="" class="form-control">
                                <option value="" disabled selected>Select</option>
                            </select>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'assets/foot.php';?>
