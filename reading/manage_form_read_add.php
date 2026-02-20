<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกรักการอ่าน</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php
        if (isset($_GET['id'])) {
            include "../config/class_database.php";
            $DB = new Class_Database();
            $sql = "SELECT * FROM rd_read_books WHERE id = :id";
            $data = $DB->Query($sql, ['id' => $_GET['id']]);
            $read_book_data = json_decode($data);
            if (count($read_book_data) == 0) {
                echo "<script>location.href = manage_form_read</script>";
            }
            $read_book_data = $read_book_data[0]; ?>
            <input type="hidden" name="id" id="id" value="<?php echo $read_book_data->id; ?>">
        <?php } ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_form_read'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-book mr-15"></i>
                                            ฟอร์ม<?php echo isset($_GET['id']) ? 'แก้ไข' : '' ?>บันทึกรักการอ่าน
                                        </h4>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="container my-5">
                                        <h2 class="text-center">บันทึกรักการอ่าน</h2>
                                        <h5 class="text-center text-secondary">My Reading Journal</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-4 mt-1">
                                                <label for="date" class="form-label">วันที่ (Date) <b class="text-danger">*</b></label>
                                                <input type="text" class="form-control" id="date" name="date" placeholder="วันที่" value="<?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->date) : ''; ?>">
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <div class="form-group">
                                                    <label for="monthSelect">เดือน (Month) <b class="text-danger">*</b></label>
                                                    <select class="form-control" id="month" name="month">
                                                        <option value="">เลือกเดือน</option>
                                                        <?php
                                                        $months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                                                        foreach ($months as $key => $monthName) {
                                                            $selected = ($read_book_data->month == $key + 1) ? 'selected' : '';
                                                            echo "<option value='" . ($key + 1) . "' $selected>$monthName</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <label for="year" class="form-label">ปี (Year) <b class="text-danger">*</b></label>
                                                <input type="text" class="form-control" id="year" name="year" placeholder="ปี" value="<?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->year) : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="title" class="form-label">ชื่อหนังสือ/สื่อ (Title/Media) <b class="text-danger">*</b></label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="ชื่อหนังสือ/สื่อ" value="<?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->title) : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="author" class="form-label">ชื่อผู้แต่ง/ผู้เขียน/ผู้แปล (Author/Writer/Translator) <b class="text-danger">*</b></label>
                                            <input type="text" class="form-control" id="author" name="author" placeholder="ชื่อผู้แต่ง/ผู้เขียน" value="<?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->author) : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="publisher" class="form-label">สำนักพิมพ์ (Publisher) <b class="text-danger">*</b></label>
                                            <input type="text" class="form-control" id="publisher" name="publisher" placeholder="สำนักพิมพ์" value="<?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->publisher) : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">ประเภท (Type) <b class="text-danger">*</b></label><br>
                                            <?php
                                            $types = [
                                                1 => "หนังสือ (Book)",
                                                2 => "บทความ (Article)",
                                                3 => "เรื่องสั้น (Short Story)",
                                                4 => "อื่น ๆ (Others)"
                                            ];
                                            foreach ($types as $value => $label) {
                                                $checked = "";
                                                if (isset($_GET['id'])) {
                                                    $checked = ($read_book_data->book_type == $value) ? 'checked' : '';
                                                }
                                                echo "<div class='form-check form-check-inline'>
                                                        <input class='form-check-input' type='radio' name='type' id='type_$value' value='$value' $checked>
                                                        <label class='form-check-label' for='type_$value'>$label</label>
                                                    </div>";
                                            }
                                            ?>
                                        </div>

                                        <div class="form-section">
                                            <label for="summary" class="form-label">เนื้อหาโดยสรุป (Summary) <b class="text-danger">*</b></label>
                                            <?php if (!isset($_GET['id'])) { ?><i class="ti-microphone text-info" style="font-size: 24px;cursor: pointer;" data-toggle="modal" data-target="#modal_speech" data-backdrop="static" data-keyboard="false"></i> <?php } ?>
                                            <textarea class="form-control" id="summary" name="summary" rows="6" placeholder="สรุปเนื้อหา"><?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->summary) : ''; ?></textarea>
                                        </div>

                                        <div class="form-section form-group mt-3">
                                            <label>อัปโหลดรูปภาพหน้าปก</label>
                                            <!-- <span class="text-danger"><?php echo !isset($_GET['id']) ? '*' : ''; ?></span> -->
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image" accept=".png, .gif, .jpeg, .jpg" onchange="setlabelFilename('image')">
                                                <input type="hidden" id="image_old" value="<?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->image) : ''; ?>">
                                                <label class="custom-file-label" for="image" id="image_label">เลือกไฟล์รูปภาพ .png, .jpeg, .jpg เท่านั้น</label>
                                            </div>
                                        </div>

                                        <div class="form-section mt-3">
                                            <label for="analysis" class="form-label">ข้อคิด / ประโยชน์ที่ได้รับ (Analysis) <b class="text-danger">*</b></label>
                                            <textarea class="form-control" id="analysis" name="analysis" rows="3" placeholder="ข้อคิด / ประโยชน์ที่ได้รับ"><?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->analysis) : ''; ?></textarea>
                                        </div>

                                        <div class="form-section mt-3">
                                            <label for="reference" class="form-label">แหล่งอ้างอิง / บรรณานุกรม (Reference) <b class="text-danger">*</b></label>
                                            <textarea class="form-control" id="reference" name="reference" rows="3" placeholder="แหล่งอ้างอิง / บรรณานุกรม"><?php echo isset($_GET['id']) ? htmlspecialchars($read_book_data->reference) : ''; ?></textarea>
                                        </div>

                                        <div class="row text-center">
                                            <div class="col-md-12">
                                                <button class="col-md-2 btn btn-rounded btn-primary btn-outline mt-4" style="width: 100%;" onclick="submitForm();">
                                                    <i class="ti-save-alt"></i> บันทึก
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include ".//include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <!-- Modal -->
        <div class="modal center-modal fade" id="modal_speech" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แปรงเสียงเป็นข้อความสรุปเนื้อหา</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <i class="ti-microphone" id="start-button" style="font-size: 64px;cursor: pointer;"></i>
                                <p class="mt-2" id="text-display-status">กดปุ่มไมค์เพื่อบันทึกเสียง</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }

        document.addEventListener("DOMContentLoaded", () => {
            const startButton = document.getElementById("start-button");
            const outputText = document.getElementById("summary");
            const textDisplayStatus = document.getElementById("text-display-status");

            let recognition;
            if (window.webkitSpeechRecognition) {
                recognition = new webkitSpeechRecognition();
            } else if (window.SpeechRecognition) {
                recognition = new SpeechRecognition();
            } else {
                alert("เบราว์เซอร์ของคุณไม่รองรับการรู้จำเสียง");
                return;
            }

            recognition.continuous = false;
            recognition.lang = "th-TH";

            let isRecording = false;
            let isConfirmed = false;

            const updateUI = (recording) => {
                startButton.style.color = recording ? "red" : "#7792b1";
                textDisplayStatus.innerHTML = recording ?
                    "กำลังบันทึก . . ." :
                    "กดปุ่มไมค์เพื่อบันทึกเสียง";
            };

            const startRecording = () => {
                updateUI(true);
                recognition.start();
                isRecording = true;
            };

            const stopRecording = () => {
                updateUI(false);
                recognition.stop();
                isRecording = false;
            };

            const requestPermissionAndStart = () => {
                navigator.mediaDevices.getUserMedia({
                        audio: true
                    })
                    .then(() => {
                        if (!isConfirmed) {
                            isConfirmed = confirm("คุณต้องการเริ่มบันทึกเสียงหรือไม่?");
                        }
                        if (isConfirmed) {
                            startRecording();
                        }
                    })
                    .catch((error) => {
                        console.error("ไม่สามารถเข้าถึงไมโครโฟนได้:", error);
                        alert("การเข้าถึงไมโครโฟนถูกปฏิเสธ หรือมีปัญหาในการเข้าถึงไมโครโฟน");
                    });
            };

            startButton.addEventListener("click", () => {
                if (isRecording) {
                    stopRecording();
                } else {
                    requestPermissionAndStart();
                }
            });

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                outputText.textContent += ` ${transcript}`;
            };

            recognition.onerror = (event) => {
                console.error("เกิดข้อผิดพลาดในการรับฟัง:", event.error);
            };

            recognition.onend = () => {
                if (isRecording) stopRecording();
            };
        });

        function validateForm() {
            // ข้อความแปลไทยสำหรับฟิลด์ต่างๆ
            let fieldNames = {
                date: "วันที่",
                month: "เดือน",
                year: "ปี",
                title: "ชื่อหนังสือ/สื่อ",
                author: "ชื่อผู้แต่ง/ผู้เขียน",
                publisher: "สำนักพิมพ์",
                type: "ประเภท",
                summary: "เนื้อหาโดยสรุป",
                analysis: "ข้อคิด / ประโยชน์ที่ได้รับ",
                reference: "แหล่งอ้างอิง / บรรณานุกรม"
            };

            // สร้าง formData จากฟิลด์ในฟอร์ม
            let formData = {
                date: $('#date').val().trim(),
                month: $('#month').val().trim(),
                year: $('#year').val().trim(),
                title: $('#title').val().trim(),
                author: $('#author').val().trim(),
                publisher: $('#publisher').val().trim(),
                type: $('input[name="type"]:checked').val(),
                summary: $('#summary').val().trim(),
                analysis: $('#analysis').val().trim(),
                reference: $('#reference').val().trim()
            };

            // ตรวจสอบฟิลด์ที่จำเป็น
            for (var key in formData) {
                if (!formData[key] && key !== 'id' && key !== 'updateRead') {
                    alert("กรุณากรอก " + fieldNames[key]);
                    $('#' + key).focus();
                    return false; // หยุดการทำงานถ้ามีฟิลด์ที่ว่าง
                }
            }

            // ตรวจสอบไฟล์รูปภาพถ้ามีการอัปโหลด
            console.log($('#id').val());
            if (typeof $('#id').val() == 'undefined') {
                const fileInput = document.getElementById('image');
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                    // ตรวจสอบชนิดไฟล์
                    if (!allowedTypes.includes(file.type)) {
                        alert("กรุณาอัปโหลดไฟล์รูปภาพที่เป็นชนิด JPG, PNG หรือ GIF เท่านั้น");
                        return false;
                    }

                    // ตรวจสอบขนาดไฟล์ (เช่น ไม่เกิน 2MB)
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (file.size > maxSize) {
                        alert("ขนาดไฟล์ต้องไม่เกิน 2MB");
                        return false;
                    }
                } 
                // else {
                //     alert("กรุณาอัปโหลดไฟล์รูปภาพ");
                //     $('#image').focus();
                //     return false;
                // }
            }

            return true;
        }

        function submitForm() {

            <?php if (!isset($_GET['test'])) { ?>
                if (!validateForm()) {
                    return; // ถ้าฟอร์มไม่ถูกต้องให้หยุดการทำงานที่นี่
                }
            <?php } ?>

            // สร้าง FormData
            let formData = new FormData();

            // เพิ่มข้อมูลฟิลด์ต่างๆ ลงใน formData
            formData.append('date', $('#date').val());
            formData.append('month', $('#month').val());
            formData.append('year', $('#year').val());
            formData.append('title', $('#title').val());
            formData.append('author', $('#author').val());
            formData.append('publisher', $('#publisher').val());
            formData.append('type', $('input[name="type"]:checked').val());
            formData.append('summary', $('#summary').val());
            formData.append('analysis', $('#analysis').val());
            formData.append('reference', $('#reference').val());
            formData.append('image_old', $('#image_old').val());
            formData.append('id', $('#id').val());
            formData.append('updateRead', true);

            // เพิ่มไฟล์รูปภาพลงใน formData
            let fileInput = document.getElementById('image');
            if (fileInput.files.length > 0) {
                formData.append('image', fileInput.files[0]);
            }
            // ถ้าข้อมูลถูกต้อง ส่งข้อมูลไปยังเซิร์ฟเวอร์
            $.ajax({
                url: 'controllers/read_controller', // URL ของไฟล์ PHP ที่จะบันทึกข้อมูล
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // แสดงข้อความสำเร็จเมื่อบันทึกข้อมูลเรียบร้อย
                    alert("บันทึกข้อมูลสำเร็จ!");
                    location.href = 'manage_form_read';
                }
            });
        }
    </script>
</body>

</html>