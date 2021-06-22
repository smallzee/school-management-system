<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/10/21
 * Time: 2:34 PM
 */

$page_title = "Check Result";
require_once 'config/core.php';

$data_result = $results = array();

if (isset($_POST['check-result'])){
    $term = $_POST['term'];
    $class_id = $_POST['class_id'];
    $session = $_POST['session'];

    $student_id = student_details('id');

    $sql = $db->query("SELECT r.*, s.name as subject FROM ".DB_PREFIX."results r INNER JOIN ".DB_PREFIX."offering_subjects o_s ON r.subject_id = o_s.id INNER JOIN ".DB_PREFIX."subjects s ON o_s.subject_id = s.id WHERE r.term='$term' and r.class_id='$class_id' and r.academic_session='$session' and r.student_id='$student_id'");


    if ($sql->rowCount() == 0){
        set_flash("No result found","danger");
    }else{
        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_result[] = $rs;
        }
        $sqls = $db->query("SELECT * FROM ".DB_PREFIX."student_position WHERE student_id ='$student_id' and class_id='$class_id' and term='$term' and academic_session='$session'");

        $position_data = $sqls->fetch(PDO::FETCH_ASSOC);
    }

    $results = array(
        'data_result' => $data_result,
        'position_data'=>$position_data
    );
}
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

                    <?php flash() ?>

                    <form action="" method="post">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Term</label>
                                    <select name="term" id="" class="form-control">
                                        <option value="" disabled selected>Select</option>
                                        <?php
                                        foreach (array(1,2,3) as $value){
                                            ?>
                                            <option value="<?= $value ?>" <?= ($value == student_details('term')) ? 'selected' : '' ?>><?= term($value) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Academic Session</label>
                                    <select name="session" class="form-control" required id="">
                                        <option value="" disabled selected>Select</option>
                                        <?php
                                        foreach (range('2021',date('Y')) as $value){
                                            $start = $value-1;
                                            ?>
                                            <option value="<?= $start.'-'.$value ?>" <?= (student_details('academic_session') == $start.'-'.$value) ? 'selected' : '' ?>><?= $start.'-'.$value ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Class</label>
                                    <select name="class_id" class="form-control" required id="">
                                        <option value="<?= student_details('class_id') ?>"><?= ucwords(student_class(student_details('class_id'),'name')) ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger" value="Submit" name="check-result" id="">
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Subject</th>
                                <th>Score</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>SN</th>
                                <th>Subject</th>
                                <th>Score</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $i =1;
                            if (is_array($results) && count($results) > 0){
                                foreach ($results['data_result'] as $value){
                                    ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= ucwords($value['subject']) ?></td>
                                        <td><?= $value['score'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        if (is_array($results) && count($results) > 0){
                            ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Position</th>
                                    <td><?= $results['position_data']['position'] ?></td>
                                </tr>
                                <tr>
                                    <th>Comment</th>
                                    <td><?= $results['position_data']['comment'] ?></td>
                                </tr>
                            </table>
                            <?php
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'assets/foot.php';?>
