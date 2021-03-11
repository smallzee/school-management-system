<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/11/21
 * Time: 9:51 AM
 */

$page_title = "Teacher Offering Class Subject";
require_once 'config/core.php';
$staff_id = teacher_details('id');
require_once 'base/head.php';
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
                        <table class="table table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>Subject Name</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Class Name</th>
                                <th>Subject Name</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            <?php
                            $sql = $db->query("SELECT c.*, a.fname, a.username, cc.name FROM ".DB_PREFIX."class_teacher c 
                                LEFT JOIN ".DB_PREFIX."admin a
                                     ON c.staff_id = a.id 
                                LEFT JOIN ".DB_PREFIX."class cc
                                     ON c.class_id = cc.id 
                                WHERE c.staff_id = '$staff_id'    
                            ORDER BY c.id DESC");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                $class_id = $rs['class_id'];
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= ucwords($rs['name']) ?></td>
                                    <td>
                                        <table>
                                            <?php
                                            $i =1;
                                            $sql3 = $db->query("SELECT o.*, s.name FROM ".DB_PREFIX."offering_subjects o
                                                     INNER JOIN ".DB_PREFIX."subjects s ON o.subject_id = s.id
                                                     WHERE o.class_id='$class_id'");
                                            while ($rs3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <tr>
                                                    <td style="padding-bottom: 5px;"><?= $i.'. '. ucwords($rs3['name']) ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
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

        </div>
    </div>
</section>

<?php require_once 'base/foot.php'?>
