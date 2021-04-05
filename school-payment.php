<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-04-05
 * Time: 07:50
 */

$page_title = "School Fee Payment";
require_once 'config/core.php';

if (isset($_POST['add'])){
    $amount = $_POST['amount'];
    $term = $_POST['term'];
    $academic_session = $_POST['session'];
    $class_id = $_POST['class'];
    $ref = uniqid();

    $student_id = student_details('id');

    $sql_check = $db->query("SELECT * FROM ".DB_PREFIX."payment WHERE student_id='$student_id' and term_id='$term' and academic_session='$academic_session'");
    if ($sql_check->rowCount() >= 1){
        $error[] = ucwords(student_details('fname'))." has already paid for his/her ".term($term)."  school fee";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $db->query("INSERT INTO ".DB_PREFIX."payment (student_id,amount,class_id,term_id,academic_session,ref)
        VALUES('$student_id','$amount','$class_id','$term','$academic_session','$ref')");

        set_flash(ucwords(student_details('fname')).' has been paid successful','info');

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }

        set_flash($msg,'danger');
    }
}

require_once 'assets/head.php';
?>

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

                    <?php flash() ?>

                    <form action="" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Card Number</label>
                                    <input type="number" min="16" class="form-control" required placeholder="Card Number" name="card-number" id="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Card Name</label>
                                    <input type="text" class="form-control" required placeholder="Card Name" name="card-name"  id="">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">School Fee</label>
                                    <input type="text" class="form-control" readonly value="<?=student_class(student_details('class_id'),'school_fee') ?>" name="amount" id="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Class</label>
                                    <select name="class" class="form-control" required id="">
                                        <option value="<?= student_details('class_id')?>"><?= student_class(student_details('class_id'),'name') ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Academic Session</label>
                                    <input type="text" class="form-control" readonly value="<?= student_details('academic_session') ?>" name="session" id="">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Term</label>
                                    <select name="term" class="form-control" required id="">
                                        <option value="<?= student_details('term')?>"><?= term(student_details('term')) ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="add" class="btn btn-danger" value="Pay" id="">
                        </div>
                    </form>

                   <p align="center">
                       <img src="<?= image_url('remitaLogo.jpg') ?>" alt="">
                   </p>

                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'assets/foot.php';?>
