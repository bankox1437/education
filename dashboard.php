<?php session_start();
include "config/main_function.php";
include "config/class_database.php";

$mainFunc = new ClassMainFunctions();
$DB = new Class_Database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="images?v=1">
    <link rel="apple-touch-icon" href="images?v=1">

    <title>สถิติ</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .container {
            max-width: 1400px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">

    <div class="wrapper" style="overflow: scroll;">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-fluid">
                <section class="content">
                    <div class="container">
                        <h3 class="page-title text-dark text-center mb-0">ข้อมูลแสดงหน้าแดชบอร์ดสถิติ</h3>
                        <h3 class="page-title text-dark text-center mt-0"><?php echo $_SESSION['user_data']->role_id == 6 ? 'ระดับจังหวัด' . $_SESSION['user_data']->province_am : 'ระดับอำเภอ' . $_SESSION['user_data']->district_am ?></h3>
                        <div class="row align-items-center mt-4">
                            <?php if ($_SESSION['user_data']->role_id == 6) { ?>
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <select class="form-control select2" name="dis_name" <?php if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 7) {
                                                                                                    echo "disabled";
                                                                                                } ?> id="dis_name" style="width: 100%;" onchange="getDataDashbord();getSubDistrictByDistrict(this.value);getTeacherList()">
                                            <option value="0">เลือกอำเภอ</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-3">
                                <div class="form-group mb-0 mt-1">
                                    <select class="form-control select2" name="sub_name" id="sub_name" style="width: 100%;" onchange="getDataDashbord();getTeacherList()">
                                        <option value="0">เลือกตำบล</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0 mt-2">
                                    <select class="form-control select2" id="teacher_select" style="width: 100%;" onchange="getDataDashbord()">
                                        <option value="0">เลือกครู</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="main_menu">
                                    <h5 class="text-info mb-1 mt-1"><b>เข้าสู่หน้าเมนูหลัก</b></h5>
                                </a>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 50px;">
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #dc3545" id="total_student">0</h3>
                                                <p class="text-mute mb-0">นักศึกษาทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #f8d7da;">
                                                <i class="mr-0 font-size-20 fa fa-users" style="color: #dc3545;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #0d6efd;" id="total_std_test">0</h3>
                                                <p class="text-mute mb-0">ผู้มีสิทธิ์สอบ (ภาคเรียนปัจจุบัน) ทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #cfe2ff;">
                                                <i class="mr-0 font-size-20 fa fa fa-vcard" style="color: #0d6efd;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #35b653;" id="total_std_end">0</h3>
                                                <p class="text-mute mb-0">นักศึกษาที่คาดว่าจะจบการศึกษาทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #d7f0dd;">
                                                <i class="mr-0 font-size-20 fa fa-mortar-board" style="color: #35b653;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #4650dd;" id="total_std_finish">0</h3>
                                                <p class="text-mute mb-0">นักศึกษาที่จบการศึกษา (ภาคเรียนปัจจุบัน) ทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #dadcf8;">
                                                <i class="mr-0 font-size-20 fa fa-mortar-board" style="color: #4650dd;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #ffb300;" id="credit_count">0</h3>
                                                <p class="text-mute mb-0">บันทึกผลการเรียนทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #ffecb3;">
                                                <i class="mr-0 font-size-20 fa fa-file-text" style="color: #ffb300;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #e91e63;" id="n_net_count">0</h3>
                                                <p class="text-mute mb-0">ผลสอบ N NET (ภาคเรียนปัจจุบัน) ทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #f8bbd0;">
                                                <i class="mr-0 font-size-20 fa fa-file-text" style="color: #e91e63;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #9c27b0;" id="kpc_count">0</h3>
                                                <p class="text-mute mb-0">กพช. สะสมทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #e1bee7;">
                                                <i class="mr-0 font-size-20 fa fa-file-text-o" style="color: #9c27b0;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="box">
                                    <div class="box-body pt-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h3 class="mb-0 font-weight-900" style="color: #673ab7;" id="table_test_count">0</h3>
                                                <p class="text-mute mb-0">ตารางสอบทั้งหมด</p>
                                            </div>
                                            <div class="icon rounded-circle" style="background: #d1c4e9;">
                                                <i class="mr-0 font-size-20 fa fa-calendar" style="color: #673ab7;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="page-title text-dark mb-3 ml-1" style="margin-top: 50px;">สถิติข้อมูลนักศึกษา แบ่งตามเพศ และ ช่วงอายุ</h4>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #dc3545;color: #ffffff;">
                                                <tr>
                                                    <th>เพศ</th>
                                                    <th>ชาย</th>
                                                    <th>หญิง</th>
                                                    <th>ยังไม่ระบุเพศ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountGender">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #dc3545;color: #ffffff;">
                                                <tr>
                                                    <th>อายุ</th>
                                                    <th>61-79 ปี</th>
                                                    <th>45-60 ปี</th>
                                                    <th>29-44 ปี</th>
                                                    <th>13-28 ปี</th>
                                                    <th>ยังไม่ระบุอายุ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountAge">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="page-title text-dark mb-3 ml-1" style="margin-top: 50px;">ผู้มีสิทธิ์สอบ (ภาคเรียนปัจจุบัน) แบ่งตามเพศ และ ช่วงอายุ</h4>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #0d6efd;color: #ffffff;">
                                                <tr>
                                                    <th>เพศ</th>
                                                    <th>ชาย</th>
                                                    <th>หญิง</th>
                                                    <th>ยังไม่ระบุเพศ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountGender2">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #0d6efd;color: #ffffff;">
                                                <tr>
                                                    <th>อายุ</th>
                                                    <th>61-79 ปี</th>
                                                    <th>45-60 ปี</th>
                                                    <th>29-44 ปี</th>
                                                    <th>13-28 ปี</th>
                                                    <th>ยังไม่ระบุอายุ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountAge2">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="page-title text-dark mb-3 ml-1" style="margin-top: 50px;">นักศึกษาที่คาดว่าจะจบการศึกษา แบ่งตามเพศ และ ช่วงอายุ</h4>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #35b653;color: #ffffff;">
                                                <tr>
                                                    <th>เพศ</th>
                                                    <th>ชาย</th>
                                                    <th>หญิง</th>
                                                    <th>ยังไม่ระบุเพศ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountGender3">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #35b653;color: #ffffff;">
                                                <tr>
                                                    <th>อายุ</th>
                                                    <th>61-79 ปี</th>
                                                    <th>45-60 ปี</th>
                                                    <th>29-44 ปี</th>
                                                    <th>13-28 ปี</th>
                                                    <th>ยังไม่ระบุอายุ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountAge3">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="page-title text-dark mb-3 ml-1" style="margin-top: 50px;">นักศึกษาที่จบการศึกษา แบ่งตามเพศ และ ช่วงอายุ</h4>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #4650dd;color: #ffffff;">
                                                <tr>
                                                    <th>เพศ</th>
                                                    <th>ชาย</th>
                                                    <th>หญิง</th>
                                                    <th>ยังไม่ระบุเพศ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountGender4">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="box">
                                    <div class="box-body p-0 table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center" style="background: #4650dd;color: #ffffff;">
                                                <tr>
                                                    <th>อายุ</th>
                                                    <th>61-79 ปี</th>
                                                    <th>45-60 ปี</th>
                                                    <th>29-44 ปี</th>
                                                    <th>13-28 ปี</th>
                                                    <th>ยังไม่ระบุอายุ</th>
                                                    <th>รวม</th>
                                                </tr>
                                            </thead>
                                            <tbody id="CountAge4">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
            <!-- /.content -->
            <?php if (isset($_SESSION['user_data']) && $_SESSION['user_data']->role_id != 4) {
                include 'include/footer.php';
            } ?>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <!-- ./wrapper -->
    <?php if (!isset($_GET['index_menu'])  && !isset($_SESSION['index_menu'])) { ?>
        <div class="admin-use">
            <a href="admin/login" title="แอดมินระบบ" onclick="alert('แจ้งเตือน\nเมนูนี้สำหรับผู้ดูแลระบบใช้งานเท่านั้น')"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </div>
    <?php } ?>
    </div>


    <!-- Vendor JS -->
    <script src="assets/js/vendors.min.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>
    <script src="assets/vendor_components/select2/dist/js/select2.full.js"></script>
    <script>
        let role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
        $(document).ready(function() {
            getDataProDistSub()
            getTeacherList()

            if (role_id == 6) {
                $('#dis_name').select2()
            }

            $('#sub_name').select2()

            $('#teacher_select').select2()
            getDataDashbord();

        });

        function getDataDashbord() {
            document.getElementById("CountGender").innerHTML = `<tr><td colspan="5" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;
            document.getElementById("CountAge").innerHTML = `<tr><td colspan="7" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;

            document.getElementById("CountGender2").innerHTML = `<tr><td colspan="5" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;
            document.getElementById("CountAge2").innerHTML = `<tr><td colspan="7" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;

            document.getElementById("CountGender3").innerHTML = `<tr><td colspan="5" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;
            document.getElementById("CountAge3").innerHTML = `<tr><td colspan="7" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;

            document.getElementById("CountGender4").innerHTML = `<tr><td colspan="5" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;
            document.getElementById("CountAge4").innerHTML = `<tr><td colspan="7" class="text-center">กำลังโหลดข้อมูล...</td></tr>`;

            $.ajax({
                type: "POST",
                url: "view-grade/controllers/dashboard_controller",
                data: {
                    getDataDashbord: true,
                    subdistrict_id: $('#sub_name').val(),
                    district_id: $('#dis_name').val() ?? 0,
                    teacherId: $('#teacher_select').val(),
                },
                dataType: "json",
                success: function(json_data) {
                    console.log(json_data);
                    const SummaryCount = json_data.SummaryCount;
                    $('#total_student').text(parseInt(SummaryCount.std_count).toLocaleString());
                    $('#total_std_test').text(parseInt(SummaryCount.test_result_count).toLocaleString());
                    $('#total_std_end').text(parseInt(SummaryCount.graduate_count).toLocaleString());
                    $('#total_std_finish').text(parseInt(SummaryCount.finish_count).toLocaleString());

                    $('#credit_count').text(parseInt(SummaryCount.credit_count).toLocaleString());
                    $('#n_net_count').text(parseInt(SummaryCount.n_net_count).toLocaleString());
                    $('#kpc_count').text(parseInt(SummaryCount.kpc_count).toLocaleString());
                    $('#table_test_count').text(parseInt(SummaryCount.table_test_count).toLocaleString());


                    const CountGender = json_data.CountGender;
                    const CountAge = json_data.CountAge;
                    generateBodyCountGender("CountGender", CountGender, "#f8d7da")
                    generateBodyCountAge("CountAge", CountAge, "#f8d7da")


                    const CountTestResGender = json_data.CountTestResGender;
                    const CountTestResAge = json_data.CountTestResAge;
                    generateBodyCountGender("CountGender2", CountTestResGender, "#cfe2ff")
                    generateBodyCountAge("CountAge2", CountTestResAge, "#cfe2ff")


                    const CountGradiateResGender = json_data.CountGradiateResGender;
                    const CountGradiateResAge = json_data.CountGradiateResAge;
                    generateBodyCountGender("CountGender3", CountGradiateResGender, "#d7f0dd")
                    generateBodyCountAge("CountAge3", CountGradiateResAge, "#d7f0dd")


                    const CountFinishResGender = json_data.CountFinishResGender;
                    const CountFinishResAge = json_data.CountFinishResAge;
                    generateBodyCountGender("CountGender4", CountFinishResGender, "#dadcf8")
                    generateBodyCountAge("CountAge4", CountFinishResAge, "#dadcf8")
                },
            });
        }

        const CountGenderRowList = [
            "ระดับประถมศึกษา",
            "ระดับมัธยมศึกษาตอนต้น",
            "ระดับมัธยมศึกษาตอนปลาย",
            "รวม"
        ];


        function generateBodyCountGender(id, CountGender, color = "") {
            let rows = [];
            let CountGenderRowListLength = CountGenderRowList.length;

            document.getElementById(id).innerHTML = "";

            if (CountGender == 0) {
                document.getElementById(id).innerHTML = `<tr><td colspan="5">ไม่พบข้อมูล...</td></tr>`;
                return false;
            }

            CountGenderRowList.forEach((tr, index) => {
                let genders = CountGender?.[index]?.genders ?? {};
                let male = parseInt(genders.male ?? 0)
                let female = parseInt(genders.female ?? 0)
                let genderUnknown = parseInt(genders.gender_unknown ?? 0)
                let sumRow = male + female + genderUnknown;
                rows.push(
                    `<tr>
                        <td>${tr}</td>
                        <td class="text-center">${male.toLocaleString()}</td>
                        <td class="text-center">${female.toLocaleString()}</td>
                        <td class="text-center">${genderUnknown.toLocaleString()}</td>
                        <td class="text-center" ${index === CountGenderRowListLength - 1 ? `style="background-color: ${color};font-weight: bold"` : ``}>${sumRow.toLocaleString()}</td>
                    </tr>`
                );
            });

            document.getElementById(id).innerHTML = rows.join("");
        }

        function generateBodyCountAge(id, CountAge, color = "") {
            let rows = [];
            let isSingleEntry = CountAge.length === 1; // Check if CountAge has only 1 entry
            let CountGenderRowListLength = CountGenderRowList.length;

            document.getElementById(id).innerHTML = "";

            if (CountGenderRowListLength == 0) {
                document.getElementById(id).innerHTML = `<tr><td colspan="7">ไม่พบข้อมูล...</td></tr>`;
                return false;
            }

            CountGenderRowList.forEach((tr, index) => {
                let ageData = CountAge?.[index]?.ages ?? {}; // Ensure CountAge[index] exists
                let age_61_79 = isSingleEntry ? 0 : parseInt(ageData.age_61_79 ?? 0);
                let age_45_60 = isSingleEntry ? 0 : parseInt(ageData.age_45_60 ?? 0);
                let age_29_44 = isSingleEntry ? 0 : parseInt(ageData.age_29_44 ?? 0);
                let age_13_28 = isSingleEntry ? 0 : parseInt(ageData.age_13_28 ?? 0);
                let age_unknown = isSingleEntry ? 0 : parseInt(ageData.age_unknown ?? 0);
                let sumRow = age_61_79 + age_45_60 + age_29_44 + age_13_28 + age_unknown;


                rows.push(
                    `<tr>
                        <td>${tr}</td>
                        <td class="text-center">${age_61_79.toLocaleString()}</td>
                        <td class="text-center">${age_45_60.toLocaleString()}</td>
                        <td class="text-center">${age_29_44.toLocaleString()}</td>
                        <td class="text-center">${age_13_28.toLocaleString()}</td>
                        <td class="text-center">${age_unknown.toLocaleString()}</td>
                        <td class="text-center" ${index === CountGenderRowListLength - 1 ? `style="background-color: ${color};font-weight: bold"` : ``}>${sumRow.toLocaleString()}</td>
                    </tr>`
                );
            });

            document.getElementById(id).innerHTML = rows.join("");
        }

        let main_provinces = null;
        let main_district = null;
        let main_sub_district_id = null;

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "student-tracking/controllers/user_controller",
                data: {
                    getDataProDistSub: true
                },
                dataType: "json",
                success: async function(json_data) {
                    console.log(json_data);
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;

                    if (parseInt(role_id) == 6) {
                        let pro_id = '<?php echo $_SESSION['user_data']->province_am_id ?>';
                        const dis_name = document.getElementById('dis_name');
                        dis_name.innerHTML = "";
                        dis_name.innerHTML += ` <option value="0">เลือกอำเภอ</option>`;
                        const district = main_district.filter((dis) => {
                            return dis.province_id == pro_id
                        })
                        district.forEach((element, id) => {
                            dis_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }

                    if (parseInt(role_id) == 2) {
                        let dis_data;
                        await getDistrictDataAmphur().then((result) => {
                            dis_data = result.data[0]
                        })
                        const sub_name = document.getElementById('sub_name');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
                        $('#dis_name').val(dis_data.dis_id);
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_data.dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        async function getDistrictDataAmphur() {
            return Promise.resolve($.ajax({
                type: "POST",
                url: "student-tracking/controllers/dashboard_controller",
                data: {
                    getDistrictDataAmphur: true,
                },
                dataType: "json",
            }));
        }

        async function getTeacherList() {
            $.ajax({
                type: "POST",
                url: "view-grade/controllers/user_controller",
                data: {
                    getTeacherList: true,
                    province_id: '<?php echo $_SESSION['user_data']->province_am_id ?>',
                    district_id: parseInt(role_id) == 6 ? $('#dis_name').val() : '<?php echo $_SESSION['user_data']->district_am_id ?>',
                    subdistrict_id: $('#sub_name').val()
                },
                dataType: "json",
                success: async function(json) {
                    const data = json.data;
                    $('#teacher_select').empty();
                    $('#teacher_select').append(`<option value="0">เลือกครู</option>`);
                    data.forEach((element) => {
                        $('#teacher_select').append(`<option value="${element.id}">${element.concat_name}</option>`);
                    });
                },
            });
        }

        async function getSubDistrictByDistrict(dist_id) {
            const sub_name = document.getElementById('sub_name');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const sub_district = main_sub_district_id.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }
    </script>
</body>

</html>