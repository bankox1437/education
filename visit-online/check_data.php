<?php include 'include/check_login.php'; ?>

<?php
include "../config/class_database.php";
$DB = new Class_Database();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ห้องเรียนออนไลน์-ตรวจสอบ/แก้ไขข้อมูลพบกลุ่ม</title>
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
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">
                                        <b id="title-b">ตรวจสอบ/แก้ไขข้อมูลพบกลุ่ม</b>
                                    </h4>
                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">

                                        <?php
                                        $termObj = explode("/", $_SESSION['term_active']->term_name);
                                        $term = $termObj[0];
                                        $year = $termObj[1];

                                        $sql = "SELECT C.calendar_id, C.time_step, C.plan_name, C.std_class c_std_class, 
                                                    M.m_calendar_id, M.m_calendar_name, M.std_class m_std_class, M.term, M.year
                                                FROM cl_calendar_new C
                                                LEFT JOIN cl_main_calendar M ON C.m_calendar_id = M.m_calendar_id
                                                WHERE C.user_create = :user_create
                                                ORDER BY C.time_step ASC, C.m_calendar_id DESC";

                                        $data = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
                                        $data = json_decode($data);

                                        // โหลดปฏิทินทั้งหมดสำหรับ dropdown
                                        $calendar = $DB->Query(
                                            "SELECT m_calendar_id, m_calendar_name, `term` , `year` FROM cl_main_calendar WHERE user_create = :user_create AND enabled = 1",
                                            [
                                                "user_create" => $_SESSION['user_data']->id
                                            ]
                                        );
                                        $calendar = json_decode($calendar);
                                        ?>

                                        <table class="table table-bordered table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;" class="text-center">ครั้งที่</th>
                                                    <th style="width: 30%;">ชื่อแผนการเรียนรู้</th>
                                                    <th style="width: 300px;" class="text-center">ระดับชั้น</th>
                                                    <th style="width: 300px;" class="text-center">ปฏิทินระดับชั้น</th>
                                                    <th style="width: 300px;" class="text-center">แก้ไขปฏิทินการพบกลุ่ม</th>
                                                </tr>
                                            </thead>

                                            <tbody id="body_sign">

                                                <?php foreach ($data as $key => $value) { ?>
                                                    <tr>
                                                        <td class="text-center"><?= $value->time_step ?></td>
                                                        <td><?= $value->plan_name ?></td>
                                                        <td class="text-center"><?= $value->c_std_class ?></td>

                                                        <td class="text-center">
                                                            <?= $value->m_calendar_name ?> <?php echo !empty($value->m_calendar_name) ? ($value->term . "/" . $value->year) : '<span class="text-danger">ไม่ได้ระบุปฏิทินการพบกลุ่ม</span>' ?>
                                                        </td>

                                                        <td class="text-center">

                                                            <select class="form-control"
                                                                onchange="updateCalendar(<?= $value->calendar_id ?>, this.value)">
                                                                <option value="">-- เลือกปฏิทิน --</option>

                                                                <?php foreach ($calendar as $cal) { ?>
                                                                    <option value="<?= $cal->m_calendar_id ?>"
                                                                        <?= ($cal->m_calendar_id == $value->m_calendar_id ? "selected" : "") ?>>
                                                                        <?= $cal->m_calendar_name . " (" . $cal->term . "/" . $cal->year . ")" ?>
                                                                    </option>
                                                                <?php } ?>

                                                            </select>

                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
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

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script>
        function updateCalendar(calendarId, m_calendarId) {

            if (m_calendarId === "") return;

            $.ajax({
                url: "controllers/calendar_controller",
                type: "POST",
                data: {
                    calendarId: calendarId,
                    m_calendarId: m_calendarId,
                    updateCalendarNew: true
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        alert("อัปเดทข้อมูลเรียบร้อย");
                    } else {
                        alert("เกิดข้อผิดพลาด: " + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert("Ajax Error: " + error);
                }
            });
        }
    </script>

</body>

</html>