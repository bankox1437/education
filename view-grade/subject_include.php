<div class="row justify-content-center">
    <div class="col-md-7 px-3">
        <div class="box box-bordered border-primary">
            <div class="box-body text-left">
                <div class="box-credit">

                    <?php
                    $sql = "SELECT * FROM vg_credit WHERE current = 1 AND user_create = :user_create limit 1";
                    $credit_result = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->user_create]);
                    $credit_result = json_decode($credit_result);

                    if (count($credit_result) > 0) {
                        $sql = "SELECT * FROM vg_credit_compulsory WHERE credit_id = :credit_id";
                        $credit_com = $DB->Query($sql, ["credit_id" => $credit_result[0]->credit_id]);
                        $credit_com = json_decode($credit_com);
                    }
                    ?>
                    <div class="row justify-content-between">
                        <h4><b>วิชาบังคับ</b></h4>
                    </div>
                    <div class="row justify-content-start" style="flex-direction: column;">

                        <?php if (count($credit_result) == 0) { ?>
                            <h5 class="m-0 text-danger">ครูผู้รับผิดชอบยังไม่ระบุวิชา</h5>
                            <?php } else {
                            if (count($credit_com) > 0) {
                                for ($i = 0; $i < count($credit_com); $i++) { ?>
                                    <h5 class="m-1"><?php echo $credit_com[$i]->sub_id ?>&nbsp;-&nbsp;<?php echo $credit_com[$i]->sub_name ?> </h5>
                                <?php  }
                            } else { ?>
                                <h5 class="m-0">ไม่มีวิชาบังคับ</h5>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7 px-3">
        <div class="box box-bordered border-primary">
            <div class="box-body text-left">
                <div class="box-credit">

                    <?php
                    $sql = "SELECT * FROM vg_credit WHERE current = 1 AND user_create = :user_create limit 1";
                    $credit_result = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->user_create]);
                    $credit_result = json_decode($credit_result);

                    if (count($credit_result) > 0) {
                        $sql = "SELECT * FROM vg_credit_electives WHERE credit_id = :credit_id";
                        $credit_elec = $DB->Query($sql, ["credit_id" => $credit_result[0]->credit_id]);
                        $credit_elec = json_decode($credit_elec);
                    }
                    ?>
                    <div class="row justify-content-between">
                        <h4><b>วิชาบังคับเลือก</b></h4>
                    </div>
                    <div class="row justify-content-start" style="flex-direction: column;">

                        <?php if (count($credit_result) == 0) { ?>
                            <h5 class="m-0 text-danger">ครูผู้รับผิดชอบยังไม่ระบุวิชา</h5>
                            <?php } else {
                            if (count($credit_elec) > 0) {
                                for ($i = 0; $i < count($credit_elec); $i++) { ?>
                                    <h5 class="m-1"><?php echo $credit_elec[$i]->sub_id ?>&nbsp;-&nbsp;<?php echo $credit_elec[$i]->sub_name ?> </h5>
                                <?php  }
                            } else { ?>
                                <h5 class="m-0">ไม่มีวิชาบังคับเลือก</h5>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7 px-3">
        <div class="box box-bordered border-primary">
            <div class="box-body text-left">
                <div class="box-credit">

                    <?php
                    $sql = "SELECT * FROM vg_credit WHERE current = 1 AND user_create = :user_create limit 1";
                    $credit_result = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->user_create]);
                    $credit_result = json_decode($credit_result);

                    if (count($credit_result) > 0) {
                        $sql = "SELECT * FROM vg_credit_free_electives WHERE credit_id = :credit_id";
                        $credit_free = $DB->Query($sql, ["credit_id" => $credit_result[0]->credit_id]);
                        $credit_free = json_decode($credit_free);
                    }
                    ?>
                    <div class="row justify-content-between">
                        <h4><b>วิชาเลือกเสรี</b></h4>
                    </div>
                    <div class="row justify-content-start" style="flex-direction: column;">

                        <?php if (count($credit_result) == 0) { ?>
                            <h5 class="m-0 text-danger">ครูผู้รับผิดชอบยังไม่ระบุวิชา</h5>
                            <?php } else {
                            if (count($credit_free) > 0) {
                                for ($i = 0; $i < count($credit_free); $i++) { ?>
                                    <h5 class="m-1"><?php echo $credit_free[$i]->sub_id ?>&nbsp;-&nbsp;<?php echo $credit_free[$i]->sub_name ?> </h5>
                                <?php  }
                            } else { ?>
                                <h5 class="m-0">ไม่มีวิชาเลือกเสรี</h5>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>