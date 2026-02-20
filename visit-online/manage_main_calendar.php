<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการปฏิทินการพบกลุ่ม</title>
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
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #04b318;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #04b318;
        }

        input:not(:checked)+.slider {
            background-color: #d9534f;
            /* สีแดง */
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
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
                                    <h4 class="box-title">จัดการปฏิทินการพบกลุ่ม</h4>
                                    <a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_main_calender_add"><i class="ti-plus"></i>&nbsp;เพิ่มปฎิทินการพบกลุ่ม</a>
                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th>ปฏิทินการพบกลุ่ม</th>
                                                    <th class="text-center">ระดับชั้น</th>
                                                    <th class="text-center">ปีการศึกษา</th>
                                                    <th class="text-center">สถานะ</th>
                                                    <th style="width: 70px;" class="text-center">ดูไฟล์</th>
                                                    <th style="width: 70px;" class="text-center">แก้ไข</th>
                                                    <th style="width: 70px;" class="text-center">ลบ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-main-calendar">
                                                <tr>
                                                    <td colspan="8" class="text-center">
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
            getDataMainCalendar()
        });

        function getDataMainCalendar() {
            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: {
                    getDataMainCalendar: true,
                    user_id: '<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : 0 ?>'
                },
                dataType: "json",
                success: function(json_res) {
                    console.log(json_res);
                    getHtmlData(json_res.data);
                },
            });
        }

        function getHtmlData(data) {
            const main_calendar = document.getElementById('data-main-calendar');
            main_calendar.innerHTML = "";
            if (data.length == 0) {
                main_calendar.innerHTML += `<tr>
                                            <td colspan="8" class="text-center">
                                                ยังไม่มีข้อมูล
                                            </td>
                                        </tr>`
                return;
            }
            data.forEach(element => {
                main_calendar.innerHTML += `
                    <tr>
                        <td>${element.m_calendar_name == "" ? `ปฎิทินการพบกลุ่ม ${element.term}/${element.year}` : element.m_calendar_name}</td>
                        <td class="text-center">${element.std_class != null ? element.std_class : "<span class='text-danger'>ยังไม่ระบุชั้น</span>"}</td>
                        <td class="text-center">${element.term}/${element.year}</td>
                        <td class="text-center">
                            <label class="switch switch-working-media">
                                <input type="checkbox" class="checkbox-working-media" onchange="checkboxChangeStatus(this.checked, ${element.m_calendar_id})" ${element.enabled == 1 ? "checked" : ""}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <a href="uploads/calendar/${element.m_calendar_file}" target="_blank">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                            </a>
                        </td>
                        <td class="text-center">    
                            <a href="manage_main_calendar_edit?m_calendar_id=${element.m_calendar_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                            </a>
                        </td>
                        <td class="text-center">
                        
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteMainCalendar(${element.m_calendar_id}, '${element.std_class}')"><i class="ti-trash"></i></button>
                        </td>
                    </tr>`;
            });
        }

        // <td>${element.enabled == 1 ? `<span class="badge badge-pill badge-success">ปัจจุบัน</span>` : 
        //                     `<span class="badge badge-pill badge-danger">หมดอายุ</span>`}
        //                 </td>

        function checkboxChangeStatus(value, m_calendar_id) {
            var statusChange = value ? 1 : 0;
            $.ajax({
                type: "POST",
                url: "controllers/calendar_controller",
                data: {
                    updateStatusMainCalendar: true,
                    m_calendar_id: m_calendar_id,
                    status: statusChange,
                },
                dataType: "json",
                success: function(data) {
                    alert("อัปเดตสถานะปฏิทินการพบกลุ่มสำเร็จ")
                },
            });
        }

        function deleteMainCalendar(m_calendar_id, std_class) {
            const confirmDelete = confirm('ต้องการลบปฏิทินการพบกลุ่มนี้หรือไม่? \nหากลบ ข้อมูลของปฏิทินการพบกลุ่มนี้จะหายไปทั้งหมด');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/calendar_controller",
                    data: {
                        delete_main_calendar: true,
                        id: m_calendar_id,
                        std_class: std_class
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataMainCalendar()
                        } else {
                            alert(data.msg);
                            window.location.reload();
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>