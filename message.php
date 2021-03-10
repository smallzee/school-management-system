<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 1/29/21
 * Time: 10:42 AM
 */

$page_title = "Sent Messages";
require_once 'config/core.php';
require_once 'libs/head.php';
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Subject</th>
                                <th>Parent Details</th>
                                <th>Sent By</th>
                                <th>Message</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Subject</th>
                                <th>Parent Details</th>
                                <th>Sent By</th>
                                <th>Message</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."notifications ORDER BY id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= ucwords($rs['subject']) ?></td>
                                        <td>
                                            <?php
                                                $parent_json = json_decode($rs['parent_json'],1);
                                                for ($i =0; $i < count($parent_json); $i++){
                                                    ?>
                                                    <span class="label label-primary" style="margin-right: 10px;">
                                                        <?= parent_info($parent_json[$i],'fname'). ' '. parent_info($parent_json[$i],'email')  ?>
                                                    </span>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td></td>
                                        <td><?= $rs['message'] ?></td>
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

<?php require_once 'libs/foot.php';?>
