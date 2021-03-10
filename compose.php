<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 1/29/21
 * Time: 10:43 AM
 */

$page_title = "Compose Message";
require_once 'config/core.php';
if (isset($_POST['send'])){
    @$to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $emails = array();

    if (count($to) == 0){
        $error[] = "Recipient is required";
    }

    if (empty($subject) or empty($message)){
        $error[] = "Subject and message are required";
    }

    for ($i = 0; $i < count($to); $i++){
        $emails[] = array('email'=>parent_info($to[$i],'email'));
    }

    @$parent_id_json = json_encode($to);


    $error_count = count($error);
    if ($error_count == 0){

        // send email notification
        if (is_array($emails) && count($emails) > 0){

        }

        $send_by = admin_details('id');

        $db->query("INSERT INTO ".DB_PREFIX."notifications (parent_json,subject,message,send_by)VALUES('$parent_id_json','$subject','$message','$send_by')");
        set_flash("Message was sent successfully","info");

        redirect(base_url("compose.php"));

    }else{
        $msg = ($error_count == 1) ? 'An error is occurred' : 'Some error are occured';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}
require_once 'libs/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

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

                    <?php flash(); ?>

                    <form action="" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <input type="text" class="form-control" required placeholder="Subject" name="subject" id="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Recipient</label>
                                    <select name="to[]" class="form-control select2" required multiple id="">
                                        <?php
                                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."parents ORDER BY fname");
                                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <option value="<?= $rs['id'] ?>"><?= ucwords($rs['fname']) ?> <?= !(empty($rs['email'])) ? '('.$rs['email'].')' : '' ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Message</label>
                                    <textarea name="message" id="" required class="form-control" style="resize: none; min-height: 100px;" placeholder="Message"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="send" class="btn btn-primary" value="Send" id="">
                        </div>
                    </form>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
    </div>
</section>

<?php require_once 'libs/foot.php';?>
