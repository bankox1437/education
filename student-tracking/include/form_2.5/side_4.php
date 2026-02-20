<h5><b>4. ด้านครอบครัว</b></h5>
<h5 class="ml-4"><b>4.1 ด้านเศรษฐกิจ</b></h5>
<div class="row ml-4">
    <div class="col-md-12">
        <div class="demo-radio-button">
            <input name="side_economy" type="radio" value="ปกติ" id="normal_economy" class="with-gap radio-col-primary" checked="">
            <label for="normal_economy">ปกติ</label>
            <input name="side_economy" type="radio" value="เสี่ยง" id="risk_economy" class="with-gap radio-col-primary">
            <label for="risk_economy">เสี่ยง</label>
            <input name="side_economy" type="radio" value="มีปัญหา" id="problem_economy" class="with-gap radio-col-primary">
            <label for="problem_economy">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_1" class="side_economy filled-in chk-col-primary">
                    <label for="economy_1">รายได้ครอบครัวต่อเดือนต่ำกว่า 10,000 บาท</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_2" class="side_economy filled-in chk-col-primary">
                    <label for="economy_2">บิดาหรือมารดาตกงาน</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_3" class="side_economy filled-in chk-col-primary">
                    <label for="economy_3">ใช้จ่ายฟุ่มเฟือย</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_4" class="side_economy filled-in chk-col-primary">
                    <label for="economy_4">ไม่มีเงินซื้ออุปกรณ์การเรียน</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_5" class="side_economy filled-in chk-col-primary">
                    <label for="economy_5">ยังไม่ได้ชำระค่าธรรมเนียมการเรียน 1 ภาคเรียนขึ้นไป</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_6" class="side_economy filled-in chk-col-primary">
                    <label for="economy_6">มีภาระหนี้สินจำนวนมาก</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="economy_7" class="side_economy filled-in chk-col-primary">
                    <label for="economy_7">ไม่มีเงินพอรับประทานอาหารกลางวัน</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="economy_8" class="side_economy filled-in chk-col-primary" onchange="showInput('economy_8')">
                    <label for="economy_8" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: none;" id="economy_8_input">
                    <input style="width: 200px;" type="text" class="form-control height-input" name="economy_8_other" id="economy_8_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>
</div>
<h5 class="ml-4"><b>4.2 การคุ้มครองนักศึกษา</b></h5>
<div class="row ml-4">
    <div class="col-md-12">
        <div class="demo-radio-button">
            <input name="protect_students" type="radio" value="ปกติ" id="normal_protect_students" class="with-gap radio-col-primary" checked="">
            <label for="normal_protect_students">ปกติ</label>
            <input name="protect_students" type="radio" value="เสี่ยง" id="risk_protect_students" class="with-gap radio-col-primary">
            <label for="risk_protect_students">เสี่ยง</label>
            <input name="protect_students" type="radio" value="มีปัญหา" id="problem_protect_students" class="with-gap radio-col-primary">
            <label for="problem_protect_students">มีปัญหา</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_1" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_1">พ่อแม่แยกทางกันหรือแต่งงานใหม่</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_2" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_2">ที่พักอาศัยอยู่ใกล้แหล่งมั่วสุม/สถานที่เริงรมย์ที่เสี่ยงต่อสวัสดิภาพ</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_3" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_3">อยู่หอพัก</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_4" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_4">มีบุคคลในครอบครัวเจ็บป่วยด้วยโรคร้ายแรง</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_5" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_5">บุคคลในครอบครัวติดสารเสพติด หรือเล่นการพนัน</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_6" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_6">มีความขัดแย้ง/ทะเลาะกันในครอบครัว</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="protect_students_7" class="protect_students filled-in chk-col-primary" onchange="showInput('protect_students_7')">
                    <label for="protect_students_7" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: none;" id="protect_students_7_input">
                    <input style="width: 200px;" type="text" class="form-control height-input" name="protect_students_7_other" id="protect_students_7_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_8" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_8">มีความขัดแย้งและมีการใช้ความรุนแรงในครอบครัว</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_9" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_9">นักศึกษาถูกทารุณ /ทำร้ายจากบุคคลในครอบครัวผู้อื่น</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_10" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_10">ถูกล่วงละเมิดทางเพศ</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_11" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_11">ถูกรังแก/ข่มขู่/รีดไถ เงินหรือสิ่งของ</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_12" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_12">ไม่มีผู้ดูแล</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="demo-checkbox">
                    <input type="checkbox" id="protect_students_13" class="protect_students filled-in chk-col-primary">
                    <label for="protect_students_13">ได้รับผลกระทบจากโรคร้ายแรง</label>
                </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="demo-checkbox" style="max-width: 90px;">
                    <input type="checkbox" id="protect_students_14" class="protect_students filled-in chk-col-primary" onchange="showInput('protect_students_14')">
                    <label for="protect_students_14" style="min-width: 60px;margin-right: 5px;">อื่นๆระบุ</label>
                </div>
                <div class="form-group" style="display: none;" id="protect_students_14_input">
                    <input style="width: 200px;" type="text" class="form-control height-input" name="protect_students_14_other" id="protect_students_14_other" autocomplete="off" placeholder="ระบุอื่น ๆ">
                </div>
            </div>
        </div>
    </div>
</div>