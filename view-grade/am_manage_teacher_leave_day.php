<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มบันทึกการลา</title>
    <style>
        /* .tooltip-custom {
            cursor: pointer;
        }

        .tooltiptext {
            display: none;
        } */

        .tooltip-custom {
            cursor: pointer;
            position: relative;
        }

        .tooltip-custom:before {
            content: attr(data-text);
            /* here's the magic */
            position: absolute;

            /* vertically center */
            top: 50%;
            transform: translateY(-50%);

            /* move to right */
            left: 100%;
            margin-left: 15px;
            /* and add a small left margin */

            /* basic styles */
            width: 200px;
            padding: 10px;
            border-radius: 10px;
            background: #5949d6;
            color: #fff;
            text-align: left;

            display: none;
            /* hide by default */
        }

        .tooltip-custom:hover:before {
            display: block;
        }

        .table thead tr th {
            padding: 3px 3px !important;
            align-content: center;
        }

        .table tbody tr td {
            padding: 3px 3px;
            align-content: center;
        }

        .fixed-table-toolbar {
            padding: unset;
        }

        .fixed-table-body {
            overflow-y: unset !important;
            overflow-x: unset !important;
        }

        .bootstrap-table .fixed-table-container.fixed-height:not(.has-footer) {
            border-bottom: 0px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

                <?php $user_id = $_GET['user_id'] ?>
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='am_manage_teacher?pro=<?php echo $_GET['pro'] ?>&dis=<?php echo $_GET['dis'] ?>&sub=<?php echo $_GET['sub'] ?>&page_number=<?php echo $_GET['page_number'] ?>'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-time mr-15"></i> <b>บันทึกการลา</b>
                                        </h4>
                                    </div>
                                    <form id="form-add-leave-day">
                                        <hr class="my-15">
                                        <div id="form-container">
                                            <div class="row" id="data-section">
                                                <input type="hidden" name="update_leave" value="1">
                                                <input type="hidden" name="user_id" value="<?php echo  $user_id ?>">
                                                <input type="hidden" name="leave_id" id="leave_id" value="">
                                                <div class="col-md-3">
                                                    <label>ประเภทการลา</label>
                                                    <select class="form-control" id="leave_type" name="leave_type">
                                                        <option value="1">ลาพักผ่อน</option>
                                                        <option value="2">ลากิจ</option>
                                                        <option value="3">ลาป่วย</option>
                                                        <option value="4">ลาอุปสมบท</option>
                                                        <option value="5">ลาคลอดบุตร</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>จำนวนวันลา <b class="text-danger">*</b></label>
                                                        <input type="number" class="form-control" id="leave_day" name="leave_day" min="1" autocomplete="off" placeholder="กรอกจำนวนวันลา">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>ลาวันที่ <b class="text-danger">*</b></label>
                                                        <input type="text" class="form-control" id="leave_date" name="leave_date" placeholder="เลือกลาวันที่">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group" style="margin-top: 24px;">
                                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                                            <i class="ti-save-alt"></i> บันทึกข้อมูลการลา
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr class="my-15">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul id="leave_data">

                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table id="leaveTable" data-height="400" data-toggle="table" data-minimum-count-columns="2" data-locale="th-TH">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="leave_type" data-valign="middle" data-align="center" data-width="200px" data-formatter="formatLeaveType">ประเภทการลา</th>
                                                            <th data-field="leave_day" data-valign="middle" data-align="center" data-width="200px">จำนวนวันลา</th>
                                                            <th data-field="leave_date" data-valign="middle" data-align="center" data-width="200px">ลาวันที่</th>
                                                            <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonEditLeave">แก้ไข</th>
                                                            <th data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonDeleteLeave">ลบ</th>
                                                        </tr>
                                                    </thead>
                                                </table>
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
                    <?php include "../include/loader_include.php"; ?>
                </div>

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

    <script>
        $(document).ready(async function() {
            flatpickr("#leave_date", {
                enableTime: true,
                dateFormat: "Y-m-d",
                defaultDate: new Date(),
                time_24hr: true,
                locale: "th",
            });

            setTimeout(() => {
                $("#leave_date").removeAttr('readonly');
            }, 500);

            getLeave()
        });


        const $leaveTable = $("#leaveTable");

        function formatButtonDeleteLeave(data, row) {
            let html = `<button type="button" onclick="deleteLeave(${row.leave_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
            return html;
        }

        function formatButtonEditLeave(data, row) {
            let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"
            onclick="editLeave(${row.leave_id},${row.leave_type},'${row.leave_day}','${row.leave_date}')"><i class="ti-pencil-alt" style="font-size:10px"></i></button>`;
            return html;
        }

        function formatLeaveType(data, row) {
            switch (row.leave_type) {
                case "1":
                    return `ลาพักผ่อน`;
                    break;
                case "2":
                    return `ลากิจ`;
                    break;
                case "3":
                    return `ลาป่วย`;
                    break;
                case "4":
                    return `ลาอุปสมบท`;
                    break;
                case "5":
                    return `ลาคลอดบุตร`;
                    break;
            }

        }

        $('#form-add-leave-day').submit((e) => {
            e.preventDefault();

            if ($('#leave_day').val() == '') {
                alert('โปรดกรอกจำนวนวันลา');
                $('#leave_day').focus();
                return false;
            }
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: $('#form-add-leave-day').serialize(),
                dataType: "json",
                success: async function(json) {
                    if (json) {
                        alert('บันทึกการลาสำเร็จ');
                        getLeave()
                        openTable($('#leave_type').val())
                        resetLeaveInput()
                    }
                },
            });
        });

        function openTable(type) {
            var urlWithParams = "controllers/info_controller?getLeaveDataByType=true&user_id=<?php echo $user_id ?>&type=" + type;
            $leaveTable.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function deleteLeave(leave_id) {
            if (confirm('ต้องการลบข้อมูลการลานี้หรือไม่?')) {
                $.ajax({
                    type: "POST",
                    url: "controllers/info_controller",
                    data: {
                        deleteLeave: true,
                        leave_id: leave_id
                    },
                    success: async function(response) {
                        if (response == 1) {
                            alert("ลบการข้อมูลการลาสำเร็จ");
                            $leaveTable.bootstrapTable('refresh');
                            getLeave();
                        }
                    },
                });
            }
        }

        function editLeave(leave_id, leave_type, leave_day, leave_date) {
            $('#leave_id').val(leave_id);
            $('#leave_day').val(leave_day)
            $('#leave_type').val(leave_type).change();
            let customDate = new Date(leave_date); // Set your custom date here
            let fp = flatpickr('#leave_date', {
                enableTime: true,
                dateFormat: "Y-m-d",
                time_24hr: true,
                locale: "th",
            });
            fp.setDate(customDate);
            $('#leave_date').removeAttr('readonly');
        }

        function resetLeaveInput() {
            $('#leave_id').val('');
            $('#leave_day').val('')
            $('#leave_type').val('1').change();
            let customDate = new Date(); // Set your custom date here
            let fp = flatpickr('#leave_date', {
                enableTime: true,
                dateFormat: "Y-m-d",
                time_24hr: true,
                locale: "th",
            });
            fp.setDate(customDate);
            $('#leave_date').removeAttr('readonly');
        }

        function getLeave() {
            $.ajax({
                type: "POST",
                url: "controllers/info_controller",
                data: {
                    getLeave: true,
                    user_id: '<?php echo $user_id ?>'
                },
                success: async function(response) {
                    console.log(response);
                    let data = JSON.parse(response);
                    let html = `
                        <li class="mb-4">
                            <h4>ลาพักผ่อน <span class="text-info"><b>${data[1]?.count_type ?? 0}</b></span> ครั้ง รวม <span class="text-info"><b>${data[1]?.leave_day ?? 0}</b></span> วัน <span onclick="openTable(1)" style="cursor: pointer;color: blue;margin-left: 10px;font-size: 14px;">ดูประวัติ</span></h4>
                        </li>
                        <li class="mb-4">
                            <h4>ลากิจ <span class="text-info"><b>${data[2]?.count_type ?? 0}</b></span> ครั้ง รวม <span class="text-info"><b>${data[2]?.leave_day ?? 0}</b></span> วัน <span onclick="openTable(2)" style="cursor: pointer;color: blue;margin-left: 10px;font-size: 14px;">ดูประวัติ</span></h4>
                        </li>
                        <li class="mb-4">
                            <h4>ลาป่วย <span class="text-info"><b>${data[3]?.count_type ?? 0}</b></span> ครั้ง รวม <span class="text-info"><b>${data[3]?.leave_day ?? 0}</b></span> วัน <span onclick="openTable(3)" style="cursor: pointer;color: blue;margin-left: 10px;font-size: 14px;">ดูประวัติ</span></h4>
                        </li>
                        <li class="mb-4">
                            <h4>ลาอุปสมบท <span class="text-info"><b>${data[4]?.count_type ?? 0}</b></span> ครั้ง รวม <span class="text-info"><b>${data[4]?.leave_day ?? 0}</b></span> วัน <span onclick="openTable(4)" style="cursor: pointer;color: blue;margin-left: 10px;font-size: 14px;">ดูประวัติ</span></h4>
                        </li>
                        <li class="mb-4">
                            <h4>ลาคลอดบุตร <span class="text-info"><b>${data[5]?.count_type ?? 0}</b></span> ครั้ง รวม <span class="text-info"><b>${data[5]?.leave_day ?? 0}</b></span> วัน <span onclick="openTable(5)" style="cursor: pointer;color: blue;margin-left: 10px;font-size: 14px;">ดูประวัติ</span></h4>
                        </li>
                    `;
                    $('#leave_data').html(html);
                },
            });
        }
    </script>
</body>

</html>