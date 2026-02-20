<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-จัดการปฎิทินกิจกรรม</title>
    <style>
        .input-group-text {
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group-text:hover {
            cursor: pointer;
            background-color: #5949d6;
            color: #fff;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="row align-items-center">
                                        <h4 class="box-title">ปฏิทินกิจกรรมสถานศึกษา</h4>
                                        <div class="col-md-2" style="display: <?php echo $_SESSION['user_data']->role_id == 4 ? 'none' : 'block'; ?>">
                                            <select class="form-control" id="term_name" onchange="getDataWhereTerm(this)">
                                                <?php foreach ($_SESSION['term_data'] as $value) { ?>
                                                    <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                                                    <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                                                    <option value="<?php echo $value->term_id ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_calendar_activity_add"><i class="ti-plus"></i>&nbsp;เพิ่มปฎิทินกิจกรรม</a>
                                        <?php } ?>

                                    </div>
                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0" style="font-size: 14px;width: 110%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;" class="text-center">#</th>
                                                    <th style="width: 105px;" class="text-center">วันที่</th>
                                                    <th style="width: 150px;">ชื่อกิจกรรม</th>
                                                    <th style="width: 200px;">หมายเหตุ</th>
                                                    <th style="width: 100px;">ผู้รับผิดชอบ</th>
                                                    <th style="width: 50px;">ผู้เข้าร่วม</th>
                                                    <th style="width: 50px;" class="text-center">ดูไฟล์</th>
                                                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                                        <th style="width: 50px;" class="text-center">แก้ไข</th>
                                                        <th style="width: 50px;" class="text-center">ลบ</th>
                                                    <?php } ?>
                                                    <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                                                        <th style="width: 50px;" class="text-center">เข้าร่วม</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="data-avtivity-calendar">
                                                <tr>
                                                    <td colspan="9" class="text-center">
                                                        <?php include "../include/loader_include.php"; ?>
                                                    </td>
                                                </tr>
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
        $(document).ready(() => {
            getDataCalendarActivity()
        });

        function getDataCalendarActivity(term_id = 0) {
            $.ajax({
                type: "POST",
                url: "controllers/activity_controller",
                data: {
                    getDataCalendarActivity: true,
                    term_id: term_id,
                    user_create: '<?php echo $_SESSION['user_data']->role_id == 4 ? $_SESSION['user_data']->user_create : 0 ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    getHtmlData(json_res.data);
                },
            });
        }

        function getDataWhereTerm(ele) {
            let term_id = ele.value;
            getDataCalendarActivity(term_id)
        }

        function getHtmlData(data) {
            const main_calendar = document.getElementById('data-avtivity-calendar');
            main_calendar.innerHTML = "";
            if (data.length == 0) {
                main_calendar.innerHTML += `<tr>
                                            <td colspan="9" class="text-center">
                                                ยังไม่มีข้อมูล
                                            </td>
                                        </tr>`
                return;
            }
            data.forEach((element, index) => {
                main_calendar.innerHTML += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${element.date_time}</td>
                        <td>${element.act_name}</td>
                        <td>${element.note}</td>
                        <td>${element.take_response}</td>
                        <td class="text-center"><a href="manage_calendar_activity_std?act_id=${element.act_id}&act_name=${element.act_name}" style="cursor: pointer;color:blue"><b>${element.count_join}</b></a></td>
                        <td class="text-center">
                        ${element.act_file_name != '' ? `
                            <a href="uploads/activity_calendar/${element.act_file_name}" target="_blank">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mt-1 mb-5" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                            </a>` : `ไม่มีไฟล์`}
                        </td>
                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                            <td class="text-center">    
                                <a href="manage_calendar_activity_edit?act_id=${element.act_id}">
                                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mt-1 mb-5" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                                </a>
                            </td>
                            <td class="text-center">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mt-1 mb-5" style="width:30px;height:30px;" 
                                onclick="deleteCalendarActivity(${element.act_id},'${element.act_file_name}')"><i class="ti-trash"></i></button>
                            </td>
                        <?php } ?>
                        <?php if ($_SESSION['user_data']->role_id == 4) { ?>
                            ${element.joined == 0 ? 
                                `<td class="text-center">
                                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-info mt-1 mb-5" style="width:30px;height:30px;" 
                                    onclick="joinActivity(${element.act_id})"><i class="ti-hand-open"></i></button>
                                </td>` : 
                                `<td class="text-center" style="padding:8px">
                                    เข้าร่วมแล้ว
                                </td>`} 
                        <?php } ?>
                    </tr>`;
            });
        }

        // <td>${element.enabled == 1 ? `<span class="badge badge-pill badge-success">ปัจจุบัน</span>` : 
        //                     `<span class="badge badge-pill badge-danger">หมดอายุ</span>`}
        //                 </td>

        function deleteCalendarActivity(act_id, act_file_name) {
            const confirmDelete = confirm('ต้องการลบปฏิทินกิจกรรมนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/activity_controller",
                    data: {
                        delete_calendar_activity: true,
                        act_id: act_id,
                        act_file_name: act_file_name
                    },
                    dataType: "json",
                    success: function(data) {
                        alert(data.msg);
                        if (data.status) {
                            getDataCalendarActivity()
                        }
                    },
                });
            }
        }

        function joinActivity(act_id) {
            const confirmDelete = confirm('ต้องการบอกว่าจะเข้าร่วมกิจกรรมนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/activity_controller",
                    data: {
                        joinActivity: true,
                        act_id: act_id,
                    },
                    dataType: "json",
                    success: function(data) {
                        alert(data.msg);
                        if (data.status) {
                            getDataCalendarActivity()
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>