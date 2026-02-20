<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>บันทึกการจัดการเรียนรู้ครั้งที่ 1 ภาคเรียนที่ 2/2566</title>
    <style>
        .detail-text {
            font-size: 18px;
            color: #475f7b;
            word-wrap: break-word;
            /* border-bottom-style: dotted; */
        }

        .box-body {
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        @media print {

            body {
                margin: 0;
                color: #000;
                background-color: #fff;
            }

        }

        #box-print {
            padding-left: 80px;
            padding-right: 80px;
        }

        @media (max-width: 768px) {
            #box-print {
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        .link_a:hover p {
            color: red;
        }

        .card img {
            border-radius: 10px;
            height: 190px;
            object-fit: cover;
        }

        /* 
        #box_saved_leadrning {
            display: none;
        } */
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" id="print_content">

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
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border  no-print">
                                    <div class="row justify-content-between align-items-center">
                                        <h4 class="box-title text-left" style="margin: 0;">
                                            <?php if ($_SESSION['user_data']->role_id != 3 && $_SESSION['user_data']->role_id != 4) { ?>
                                                <p><a href="manage_calendar?user_id=<?php echo $_GET['user_id'] ?>&name=<?php echo $_GET['name'] ?>"><i class="ti-arrow-left no-print" style="cursor: pointer;"></i></a>&nbsp;<span id="show-topic"></span> <b><?php echo $_GET['name'] ?></b></p>
                                            <?php } else { ?>
                                                <p><a href="manage_calendar"><i class="ti-arrow-left no-print" style="cursor: pointer;"></i></a>&nbsp;<span id="show-topic"></span></p>
                                            <?php   } ?>

                                        </h4>
                                        <div>
                                            <?php if (isset($_GET['learning_id']) && $_SESSION['user_data']->role_id == 3) {
                                                // echo '<a href="manage_learning_edit?learning_id=' . $_GET['learning_id'] . '&calendar_id=' . $_GET['calendar_id'] . '"><button class="btn btn-warning ml-2 no-print"><i class="ti-pencil-alt"></i>&nbsp; แก้ไขบันทึกการเรียนรู้</button></a>';
                                            } ?>

                                            <?php
                                            if ($_SESSION['user_data']->role_id == 3) {
                                                include "../config/class_database.php";
                                                $DB = new Class_Database();
                                                // $sql = "SELECT count(*) c_std_sign_in FROM `cl_sign_in_to_class` WHERE calendar_id = :calendar_id";
                                                // $data = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                                                // $data = json_decode($data);
                                                // $sign_in = 0;
                                                // if (count($data) != 0) {
                                                //     $sign_in = $data[0]->c_std_sign_in;
                                                // }

                                            ?>
                                                <!-- <span class="mr-4" style="cursor: pointer;" data-toggle="modal" data-target="#myModal"><i class="ti-user"></i> <?php echo $sign_in ?> </span> -->
                                                <button class="btn btn-success ml-2 no-print" onclick="printPage()"><i class="ti-printer"></i>&nbsp; ปริ้น</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="container" id="box-print">
                                        <div class="d-flex justify-content-center">
                                            <h3 class="m-1 box-title title-show" style="display:none">
                                                <b>บันทึกการจัดการเรียนรู้</b>
                                            </h3>
                                            <input type="hidden" id="learning_id_saved">
                                        </div>
                                        <!-- <div class="row mt-3 no-print m-0">
                                            <div class="col-md-6">
                                                
                                                <div class="show_text ">
                                                    <h4 class="mb-1 box-title"><b>ชื่อปฎิทินการพบกลุ่ม</b></h4>
                                                    <p class="detail-text" id="calendar_name"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="show_text">
                                                    <div class="show_text no-print m-0">
                                                        <a href="#" target="_blank" class="btn btn-primary" id="calendar_file" style="width: 150;">ไฟล์</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br> -->
                                        <div class="row mt-3 no-print m-0">
                                            <div class="col-md-6">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ชื่อแผนการเรียนรู้</b></h4>
                                                    <p class="detail-text" id="plan_name"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="show_text row justify-content-center">
                                                    <div class="show_text no-print m-0">
                                                        <a href="#" target="_blank" class="btn btn-primary" id="plan_file" style="width: 150;">ไฟล์</a>
                                                        <a class="btn btn-info" data-toggle="modal" data-target="#workModal" style="width: 150;">ใบงาน</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3" style="display: none;" id="kru_name">
                                            <div class="col-md-12">
                                                <h4 class="mb-1 box-title"><b>ชื่อครูผู้จัดการเรียนการสอน</b></h4>
                                                <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                    <p class="detail-text"><?php echo $_SESSION['user_data']->name . " " . $_SESSION['user_data']->surname; ?></p>
                                                <?php } else { ?>
                                                    <p class="detail-text"><?php echo $_GET['name'] ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row mt-3 m-0">
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ลิงค์การสอน 1</b></h4>
                                                    <a href="" class="link_a" id="link_a" target="_blank">
                                                        <p class="detail-text" id="link"></p>
                                                    </a>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ลิงค์การสอน 2</b></h4>
                                                    <a href="" class="link_a" id="link_a_2" target="_blank">
                                                        <p class="detail-text" id="link2"></p>
                                                    </a>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ลิงค์การสอน 3</b></h4>
                                                    <a href="" class="link_a" id="link_a_3" target="_blank">
                                                        <p class="detail-text" id="link3"></p>
                                                    </a>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="show_text">
                                                    <h4 class="mb-1 box-title"><b>ลิงค์การสอน 4</b></h4>
                                                    <a href="" class="link_a" id="link_a_4" target="_blank">
                                                        <p class="detail-text" id="link4"></p>
                                                    </a>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3" id="box_learning_file" style="display: none;">
                                            <div class="col-md-6 ml-2">
                                                <div class="show_text row justify-content-start">
                                                    <div class="show_text no-print m-0">
                                                        <a href="#" target="_blank" class="btn btn-info" id="learning_file" style="width: 250px;">ไฟล์บันทึกการเรียนการสอน</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                                            <div id="box_saved_leadrning" class="mt-4">
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="show_text">
                                                            <h4 class="mb-1 box-title"><b>1. ผลการจัดการเรียนการรู้</b></h4>
                                                            <p class="detail-text" id="side_1"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="show_text">
                                                            <h4 class="mb-1 box-title"><b>2. ปัญหาและอุปสรรค</b></h4>
                                                            <p class="detail-text" id="side_2"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="show_text">
                                                            <h4 class="mb-1 box-title"><b>3. ข้อเสนอแนะ/แนวทางแก้ไข</b></h4>
                                                            <p class="detail-text" id="side_3"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="no-print">
                                                <div class="row row-cols-1 row-cols-md-3 g-4" id="img_learn">

                                                </div>
                                            </div>
                                            <br>
                                        <?php } ?>
                                        <div class="row" id="comment-section">
                                            <div class="col-md-12">
                                                <div class="show_text">

                                                    <h4 class="mb-1 box-title">
                                                        <b>ความคิดเห็นของหัวหน้าสถานศึกษาหรือผู้ที่ได้รับมอบหมาย</b>
                                                    </h4>
                                                    <p class="detail-text" id="reason_text" style="display: block;">
                                                        ยังไม่ได้ลงความเห็น</p>
                                                    <div id="reason_form" style="display: none;">
                                                        <div class="form-group mt-2">
                                                            <textarea rows="5" class="form-control no-print" placeholder="กรอกความเห็นของหัวหน้าสถานศึกษาหรือผู้ที่ได้รับมอบหมาย" name="reason" id="reason"> </textarea>
                                                        </div>
                                                        <button class="btn btn-rounded btn-primary btn-outline no-print" onclick="save_reason()">
                                                            <i class="ti-save-alt"> </i> บันทึกความคิดเห็น
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <br>
                                    <br>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>

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

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">รายชื่อนักศึกษาที่เข้าเรียน</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($_SESSION['user_data']->role_id == 3) {
                        $sql = "SELECT\n" .
                            "	CONCAT(std.std_prename,std.std_name) std_name\n" .
                            "FROM\n" .
                            "	cl_sign_in_to_class sign\n" .
                            "	LEFT JOIN tb_students std ON sign.std_id = std.std_id WHERE calendar_id = :calendar_id";
                        $data = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                        $data = json_decode($data);

                        if (count($data) == 0) {
                            echo "<h4 class='text-center'>ยังไม่มีนักศึกษาเช็คชื่อ</h4>";
                        } else {
                            for ($i = 0; $i < count($data); $i++) {
                                echo "<h4>" . $data[$i]->std_name . "</h4>";
                            }
                        }
                    }
                    ?>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div id="workModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="workModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="workModalLabel">ใบงาน</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="media-list media-list-divided">
                        <?php
                        if ($_SESSION['user_data']->role_id != 3) {
                            include "../config/class_database.php";
                            $DB = new Class_Database();
                        }
                        $sql = "SELECT\n" .
                            "	*\n" .
                            "FROM\n" .
                            "	cl_work\n" .
                            "WHERE calendar_id = :calendar_id";
                        $data = $DB->Query($sql, ['calendar_id' => $_GET['calendar_id']]);
                        $data = json_decode($data);

                        if (count($data) == 0) {
                            echo "<h4 class='text-center'>ไม่มีใบงาน</h4>";
                        } else {
                            for ($i = 0; $i < count($data); $i++) { ?>

                                <div class="media media-single">
                                    <span class="font-size-24 text-primary"><i class="fa fa-file-text"></i></span>
                                    <span class="title"><?php echo "ใบงานที่ " . ($i + 1) ?></span>
                                    <a class="font-size-18 text-gray hover-info" href="uploads/work/<?php echo $data[$i]->file_name ?>" target="_blank"><i class="fa fa-download"></i></a>
                                </div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        $(document).ready(() => {
            getDataDetail()
            const std_id = '<?php echo $_SESSION['user_data']->edu_type ?>';
            let time_sign_in = (3 * 60) * 1000;
            if (role_id == 4) {
                setTimeout(() => {
                    $.ajax({
                        type: "POST",
                        url: "controllers/calendar_controller",
                        data: {
                            signInClass: true,
                            calendar_id: '<?php echo $_GET['calendar_id'] ?>',
                            std_id: std_id
                        },
                        dataType: "json",
                        success: function(data) {
                            if (!data.status) {
                                alert(data.msg);
                            }
                        },
                    });
                }, time_sign_in);
            }
        });

        function getDataDetail() {
            let role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
            $.ajax({
                type: "POST",
                url: "controllers/learning_controller",
                data: {
                    getDataDetail: true,
                    calendar_id: '<?php echo $_GET['calendar_id'] ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);

                    document.getElementById('learning_id_saved').value = `${json_res[0].learning_file_id}`;

                    document.getElementById('plan_name').innerHTML = `${json_res[0].plan_name}`;
                    document.getElementById('plan_file').href = `uploads/edu_plan/${json_res[0].plan_file_raw}`;

                    if (!json_res[0].l_old) {
                        $('#box_saved_leadrning').hide();
                    } else {
                        <?php if ($_SESSION['user_data']->role_id != 4) { ?>
                            document.getElementById('side_1').innerHTML =
                                `${json_res[0].side_1 == '' ? '<p>&nbsp;&nbsp;&nbsp;ยังไม่ได้บันทึกหลังสอน</p>' : json_res[0].side_1}`;
                            document.getElementById('side_2').innerHTML =
                                `${json_res[0].side_2  == '' ? '<p>&nbsp;&nbsp;&nbsp;ยังไม่ได้บันทึกหลังสอน</p>' : json_res[0].side_2} `;
                            document.getElementById('side_3').innerHTML =
                                `${json_res[0].side_3  == '' ? '<p>&nbsp;&nbsp;&nbsp;ยังไม่ได้บันทึกหลังสอน</p>' : json_res[0].side_3}`;

                            const imgNames = ['img_name_1', 'img_name_2', 'img_name_3', 'img_name_4'];

                            for (let i = 0; i < imgNames.length; i++) {
                                const imgName = json_res[0][imgNames[i]];

                                if (imgName != null && imgName !== "") {
                                    const imgElement = $(`<div class='col col-sm-3 col-md-3 col-lg-3'><div class='card'><img src='${imgName}' alt='' id='img_${i + 1}'></div></div>`);
                                    $('#img_learn').append(imgElement);
                                }
                            }

                        <?php  } ?>
                    }

                    document.getElementById('link_a').href = `${json_res[0].link}`;
                    document.getElementById('link').innerHTML = `${json_res[0].link}`;

                    document.getElementById('link_a_2').href = `${json_res[0].link2}`;
                    document.getElementById('link2').innerHTML = `${json_res[0].link2}`;

                    document.getElementById('link_a_3').href = `${json_res[0].link3}`;
                    document.getElementById('link3').innerHTML = `${json_res[0].link3}`;

                    document.getElementById('link_a_4').href = `${json_res[0].link4}`;
                    document.getElementById('link4').innerHTML = `${json_res[0].link4}`;

                    if (json_res[0].link == '') {
                        document.getElementById('link_a').parentNode.style.display = 'none'
                    }
                    if (json_res[0].link2 == '') {
                        document.getElementById('link_a_2').parentNode.style.display = 'none'
                    }
                    if (json_res[0].link3 == '') {
                        document.getElementById('link_a_3').parentNode.style.display = 'none'
                    }
                    if (json_res[0].link4 == '') {
                        document.getElementById('link_a_4').parentNode.style.display = 'none'
                    }

                    document.getElementById('show-topic').innerHTML = `<b>บันทึกการจัดการเรียนรู้ ภาคเรียนที่ ${json_res[0].term}/${json_res[0].year}</b>`;


                    if (json_res[0].learning_file_id) {
                        $('#box_learning_file').show();
                        $('#learning_file').attr('href', `uploads/learning_pdf/${json_res[0].learning_file}`)
                    }

                    if (role_id != 3 && role_id != 4) {
                        $('#reason_text').hide();
                        $('#reason_form').show();
                        if (json_res[0].learning_file_id == null) {
                            $('#reason_form').html('<h4><b>ยังไม่ได้บันทึกหลังสอน</b></h4>')
                        } else {
                            if (json_res[0].reason == null) {
                                document.getElementById('reason').innerHTML = '';
                            } else {
                                document.getElementById('reason').innerHTML = json_res[0].reason;
                                document.getElementById('reason_text').innerHTML = json_res[0].reason;
                            }
                        }

                    } else if (role_id == 4) {
                        $('#comment-section').hide();
                    } else {
                        $('#reason_text').show();
                        $('#reason_form').hide();
                        if (json_res[0].reason == null) {
                            document.getElementById('reason_text').innerHTML = '<p>ยังไม่ได้ลงความเห็น</p>';
                        } else {
                            console.log("sss");
                            document.getElementById('reason_text').innerHTML = json_res[0].reason + ` ผู้นิเทศ ${json_res[0].ur_name}`;
                        }
                    }
                },
            });
        }

        function save_reason() {
            const reason = document.getElementById('reason');
            const learning_id = document.getElementById('learning_id_saved').value;
            if (reason.value == "") {
                reason.focus()
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/learning_controller",
                data: {
                    learning_id: learning_id,
                    reason: reason.value,
                    add_reason: true
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        alert(json.msg);
                        window.location.reload();
                    } else {
                        alert(json.msg);
                        window.location.reload();
                    }
                },
            });
        }

        function printPage() {
            $('#reason_text').show();
            $('#kru_name').show()
            $('.title-show').css('display', 'block');
            if (role_id != 3) {
                $('#reason_form').hide();
            }
            window.print();
        }

        window.addEventListener("afterprint", (event) => {
            $('.title-show').css('display', 'none');
            $('#kru_name').hide();
            if (role_id != 3) {
                $('#reason_text').hide();
                $('#reason_form').show();
            }
        });
    </script>
</body>

</html>