<?php
session_start();

include "../config/class_database.php";

$DB = new Class_Database();

if (isset($_POST['mode']) && $_POST['mode'] === 'save_personal') {
    include "../config/main_function.php";
    $mainFunc = new ClassMainFunctions();

    $file_old = $_POST['personal_image_old'];

    if (count($_FILES) > 0 && isset($_FILES['personal_image']) && !empty($_FILES['personal_image']['name'])) {
        $uploadDir = '../manage_am/images/am_personals/';
        $resizeDir = 'upload/';

        $file_response = $mainFunc->UploadFileImage($_FILES['personal_image'], $uploadDir, $resizeDir);
        if (!$file_response['status']) {
            $response = array('status' => false, 'msg' => $file_response['message']);
            echo json_encode($response);
            exit();
        }
        if (!empty($file_old) && file_exists($uploadDir . $file_old)) {
            unlink($uploadDir . $file_old);
        }

        $file_old = $file_response['result'];
    }

    $per_id = $_POST['per_id'];
    $name = $_POST['name'];
    $work = $_POST['work'];
    $po_id = $_POST['po_id'];

    if (!empty($per_id)) {
        $stmt = $DB->Update(
            "UPDATE am_personals SET name=:name, image=:image, work=:work, po_id=:po_id WHERE per_id=:per_id",
            [
                'name' => $name,
                'image' => $file_old,
                'work' => $work,
                'po_id' => $po_id,
                'per_id' => $per_id
            ]
        );
        echo "แก้ไขบุคลากรสำเร็จ";
    } else {
        $stmt = $DB->Insert(
            "INSERT INTO am_personals (name, work, po_id, image) VALUES (:name, :work, :po_id, :image)",
            [
                'name' => $name,
                'work' => $work,
                'po_id' => $po_id,
                'image' => $file_old
            ]
        );
        echo "บันทึกบุคลากรสำเร็จ";
    }
    exit;
}

if (isset($_POST['mode']) && $_POST['mode'] === 'position') {

    $po_id = $_POST['position_id'];
    $position = $_POST['position'];

    if (!empty($po_id)) {
        $stmt = $DB->Update("UPDATE am_position_parent SET name = :name WHERE po_id = :po_id", ["name" => $position, "po_id" => $po_id]);
        echo "แก้ไขตำแหน่งสำเร็จ";
    } else {
        $stmt = $DB->Insert("INSERT INTO am_position_parent (name) VALUES (:name)", ["name" => $position]);
        echo "บันทึกตำแหน่งสำเร็จ";
    }
    exit();
}

if (isset($_POST['mode']) && $_POST['mode'] === 'delete_position') {
    $po_id = $_POST['po_id'];
    $stmt = $DB->Delete("DELETE FROM am_position_parent WHERE po_id = :po_id", ["po_id" => $po_id]);
    $stmt = $DB->Delete("DELETE FROM am_personals WHERE po_id = :po_id", ["po_id" => $po_id]);
    echo "ลบตำแหน่งสำเร็จ";
    exit();
}

if (isset($_POST['mode']) && $_POST['mode'] === 'deletePerson') {
    $per_id = $_POST['per_id'];
    $stmt = $DB->Delete("DELETE FROM am_personals WHERE per_id = :per_id", ["per_id" => $per_id]);
    echo "ลบตำแหน่งสำเร็จ";
    exit();
}
?>

<?php include 'include/check_login.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าบุคลากร</title>
    <style>
        .video-container video {
            /* Makes video responsive */
            height: 15rem;
            /* Maintains aspect ratio */
            display: block;
            /* Prevents extra spacing issues */
            border-radius: 10px;
            /* Optional: Adds rounded corners */
        }

        input[type="color"] {
            height: 33px;
        }
    </style>
    <?php include 'include/scripts.php'; ?>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include 'include/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">ตั้งค่าบุคลากร</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <?php
                                    $sql = "SELECT * FROM am_position_parent";
                                    $am_position_parent = $DB->Query($sql, []);
                                    $am_position_parent = json_decode($am_position_parent, true);
                                    $am_position_parent = $am_position_parent;

                                    $sql = "SELECT am_personals.*, am_position_parent.name as po_name FROM am_personals LEFT JOIN am_position_parent ON am_personals.po_id = am_position_parent.po_id";
                                    $am_personals = $DB->Query($sql, []);
                                    $am_personals = json_decode($am_personals, true);
                                    $am_personals = $am_personals;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <form id="personForm" class="col-md-12">
                                                    <input type="hidden" name="per_id" id="per_id">
                                                    <input type="hidden" name="mode" value="save_personal">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-2">
                                                            <label>รูปภาพบุคลากร</label>
                                                            <input type="hidden" class="form-control" id="personal_image_old" name="personal_image_old" value="<?php echo $data_result[0]['value'] ?>">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="personal_image" name="personal_image" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('personal_image')">
                                                                <label class="custom-file-label" for="personal_image" id="personal_image_label" style="overflow: hidden;">เลือกไฟล์รูปภาพ</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="name">ชื่อ-สกุล</label>
                                                            <input type="text" class="form-control" id="name" name="name" placeholder="กรุณากรอกชื่อ-สกุล">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="work">งานที่รับผิดชอบ</label>
                                                            <input type="text" class="form-control" id="work" name="work" placeholder="กรุณากรอกงานที่รับผิดชอบ">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="po_id">ตำแหน่ง</label>
                                                            <select class="form-control" id="po_id" name="po_id">
                                                                <option value="0">เลือกตำแหน่ง</option>
                                                                <?php
                                                                foreach ($am_position_parent as $key => $value) { ?>
                                                                    <option value="<?php echo $value['po_id'] ?>"><?php echo $value['name'] ?></option>

                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="" class="m-0">&nbsp;&nbsp;</label>
                                                            <button type="submit" class="form-control btn btn-primary">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 table-responsive">
                                                    <table class="table table-bordered table-hover" style="font-size: 14px;">
                                                        <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <td>ชื่อ-สกุล</td>
                                                                <td>งานที่รับผิดชอบ</td>
                                                                <td>ตำแหน่ง</td>
                                                                <td>รูปภาพ</td>
                                                                <td class="text-center">จัดการ</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($am_personals as $key => $value) { ?>
                                                                <tr data-per_id="<?php echo $value['per_id'] ?>">
                                                                    <td><?php echo $i ?></td>
                                                                    <td><span class="name"><?php echo $value['name'] ?></span></td>
                                                                    <td><span class="work"><?php echo $value['work'] ?></span></td>
                                                                    <td><span><?php echo $value['po_name'] ?></span></td>
                                                                    <td style="display: none;"><span class="image"><?php echo $value['image'] ?></span></td>
                                                                    <td style="display: none;"><span class="po_id"><?php echo $value['po_id'] ?></span></td>
                                                                    <td><img src="../manage_am/images/am_personals/<?php echo $value['image'] ?>" style="height: 50px;"></td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-sm btn-warning editPersonBtn">แก้ไข</button>
                                                                        <button class="btn btn-sm btn-danger deletePersonBtn">ลบ</button>
                                                                    </td>
                                                                </tr>
                                                            <?php $i++;
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <form id="positionForm" class="col-md-12">
                                                    <input type="hidden" name="position_id" id="position_id">
                                                    <div class="form-row">
                                                        <input type="hidden" name="mode" value="position">
                                                        <div class="form-group col-md-9">
                                                            <label for="position">ตำแหน่ง</label>
                                                            <input type="text" class="form-control" id="position" name="position" placeholder="กรุณากรอกตำแหน่ง">
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="" class="m-0">&nbsp;&nbsp;</label>
                                                            <button type="submit" class="form-control btn btn-primary">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover" style="font-size: 14px;">
                                                        <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <td>ตำแหน่ง</td>
                                                                <td class="text-center">จัดการ</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($am_position_parent as $key => $value) { ?>
                                                                <tr data-position_id="<?php echo $value['po_id'] ?>">
                                                                    <td><?php echo $i ?></td>
                                                                    <td><span class="position"><?php echo $value['name'] ?></span></td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-sm btn-warning editPositionBtn">แก้ไข</button>
                                                                        <button class="btn btn-sm btn-danger deletePositionBtn">ลบ</button>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                $i++;
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include "../include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

</body>
<script>
    function setlabelFilename(id) {
        const file = document.getElementById(id).files;
        let fileName = '';
        for (let i = 0; i < file.length; i++) {
            if (i == 0) {
                fileName += file[i].name;
            } else {
                fileName += " , " + file[i].name;
            }
        }
        document.getElementById(id + '_label').innerText = fileName;
    }

    $('#positionForm').on('submit', function(e) {
        e.preventDefault();
        const position = $('#position').val().trim();

        if (position === '') {
            alert('โปรดกรอกข้อมูลตำแหน่ง');
            return;
        }

        $.post('', $(this).serialize(), function(response) {
            alert(response);
            $('#positionForm')[0].reset();
            $('#po_id').val('');
            location.reload();
        });
    });

    // ฟังก์ชัน submit
    $('#personForm').on('submit', function(e) {
        e.preventDefault();

        const name = $('#name').val().trim();
        const work = $('#work').val().trim();
        const po_id = $('#po_id').val();
        const per_id = $('#per_id').val();

        let fileimage = document.getElementById("personal_image").files[0];
        if (!fileimage && per_id == '') {
            alert('กรุณาเลือกไฟล์ก่อน');
            return;
        }

        if (name === '') {
            alert('กรุณากรอกชื่อ-สกุล');
            return;
        }

        if (work === '') {
            alert('กรุณากรอกงานที่รับผิดชอบ');
            return;
        }

        if (po_id === '0') {
            alert('กรุณาเลือกตำแหน่ง');
            return;
        }

        const formData = new FormData(this);

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                $('#personForm')[0].reset();
                $('#personal_image_label').text('เลือกไฟล์รูปภาพ');
                location.reload();
            }
        });
    });

    $(document).on('click', '.editPersonBtn', function() {
        let row = $(this).closest('tr');
        $('#per_id').val(row.data('per_id'));
        $('#name').val(row.find('.name').text());
        $('#work').val(row.find('.work').text());
        $('#po_id').val(row.find('.po_id').text());
        $('#personal_image_old').val(row.find('.image').text());
    });

    $(document).on('click', '.deletePersonBtn', function() {
        if (confirm('คุณต้องการลบบุคลากรคนนี้ใช่หรือไม่?')) {
            let id = $(this).closest('tr').data('per_id');
            $.post('', {
                mode: 'deletePerson',
                per_id: id
            }, function(res) {
                alert(res);
                loadPersons();
            });
        }
    });

    $(document).on('click', '.editPositionBtn', function() {
        let row = $(this).closest('tr');
        $('#position_id').val(row.data('position_id'));
        $('#position').val(row.find('.position').text());
    });

    $(document).on('click', '.deletePositionBtn', function() {
        if (confirm('หากลบตำแหน่งนี้ข้อมูลบุคลากรในตำแหน่งทั้งหมดจะถูกลบด้วย\nคุณต้องการลบตำแหน่งนี้หรือไม่?')) {
            let id = $(this).closest('tr').data('position_id');
            $.post('', {
                mode: 'delete_position',
                po_id: id
            }, function(res) {
                alert(res);
                location.reload();
            });
        }
    });
</script>

</html>