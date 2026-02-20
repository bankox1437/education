<h5><b>1. ความสามารถด้านการเรียน</b></h5>
<div class="row mt-2 ml-4">
    <div class="col-md-12">
        <div class="demo-radio-button">
            <input name="side_learning" type="radio" value="ปกติ" id="normal_learning" class="with-gap radio-col-primary" checked="">
            <label for="normal_learning">ปกติ</label>
            <input name="side_learning" type="radio" value="เสี่ยง" id="risk_learning" class="with-gap radio-col-primary">
            <label for="risk_learning">เสี่ยง</label>
            <input name="side_learning" type="radio" value="มีปัญหา" id="problem_learning" class="with-gap radio-col-primary">
            <label for="problem_learning">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_1" class="learning filled-in chk-col-primary">
                    <label for="learning_1">ผลการเรียนเฉลี่ย 1.00 – 2.00</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_2" class="learning filled-in chk-col-primary">
                    <label for="learning_2">มาโรงเรียนสาย 3 ครั้ง/สัปดาห์</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_3" class="learning filled-in chk-col-primary">
                    <label for="learning_3">ติด 0 , ร , มส 1 – 2 วิชาใน 1 ภาคเรียน</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_4" class="learning filled-in chk-col-primary">
                    <label for="learning_4">อ่านหนังสือไม่คล่อง</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_5" class="learning filled-in chk-col-primary">
                    <label for="learning_5">ไม่เข้าเรียนหลายครั้งโดยไม่มีเหตุจำเป็น</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="learning_6" class="learning filled-in chk-col-primary" onchange="showInput('learning_6')">
                    <label for="learning_6" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: none;" id="learning_6_input">
                    <input style="width: 200px;" type="text" class="form-control height-input" name="learning_6_other" id="learning_6_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_7" class="learning filled-in chk-col-primary">
                    <label for="learning_7">ผลการเรียนเฉลี่ยต่ำกว่า 1.50</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_8" class="learning filled-in chk-col-primary">
                    <label for="learning_8">อ่านหนังสือไม่ออก</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_9" class="learning filled-in chk-col-primary">
                    <label for="learning_9">ติด 0 , ร , มส , มผ 3 วิชาขึ้นไป</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_10" class="learning filled-in chk-col-primary">
                    <label for="learning_10">ไม่ส่งงานหลายวิชา</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="learning_11" class="learning filled-in chk-col-primary">
                    <label for="learning_11">เขียนหนังสือไม่ถูกต้อง สะกดคำผิดแม้แต่คำง่ายๆ</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="learning_12" class="learning filled-in chk-col-primary" onchange="showInput('learning_12')">
                    <label for="learning_12" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: none;" id="learning_12_input">
                    <input style="width: 200px;" type="text" class="form-control height-input" name="learning_12_other" id="learning_12_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ml-4">
    <div class="col-md-12">
        <h5><b>1.1 ด้านความสามารถอื่นๆ</b></h5>
    </div>
    <div class="col-md-6 d-flex align-items-center">
        <div class="demo-radio-button" style="max-width: 90px;">
            <input name="side_learning_other" type="radio" value="มี" id="have_other" class="with-gap radio-col-primary" onchange="showInputDisable('have_other')">
            <label for="have_other" style="min-width: 80px;margin-right: 5px;">มีระบุ </label>
        </div>
        <div class="form-group" id="side_learning_other_input" style="width: 100%;">
            <input type="text" class="form-control" name="have_other_input" id="have_other_input" autocomplete="off" placeholder="ระบุอื่น ๆ" disabled>
        </div>
    </div>
    <div class="col-md-6">
        <input name="side_learning_other" type="radio" value="ไม่มี" id="not_other" class="with-gap radio-col-primary" onchange="showInputDisable('not_other')" checked>
        <label for="not_other">ไม่มี (ไม่ชัดเจนในความสามารถด้านอื่น นอกจากด้านการเรียน)</label>
    </div>
</div>