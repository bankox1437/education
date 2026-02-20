<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-จัดการปฎิทินการพบกลุ่ม</title>
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

        <?php
        $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
        $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
        $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
        $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';

        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <?php if (isset($_GET['user_id'])) {
                                        echo '<h4 class="box-title"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href=`teacher_list?' . $pro . $dis . $sub .  $page_number . '`"></i>
                                        &nbsp;ข้อมูลเอกสารการประเมินพนักงานราชการ ' . $_GET['name'] . '</h4>';
                                    } else {
                                        echo '<h4 class="box-title">ข้อมูลเอกสารการประเมินพนักงานราชการ</h4>';
                                        echo '<a class="waves-effect waves-light btn btn-success btn-flat ml-2" href="manage_index_add"><i class="ti-plus"></i>&nbsp;เพิ่มเอกสาร</a>';
                                    } ?>

                                </div>
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 100px;">ครั้งที่</th>
                                                    <th class="text-center">หัวข้อ</th>
                                                    <th class="text-center" style="width: 100px;">ปีการศึกษา</th>
                                                    <th style="width: 200px;" class="text-center">ลิงค์วิดีโอ</th>
                                                    <th style="width: 200px;" class="text-center">ผลการประเมิน</th>
                                                    <th>ข้อเสนอแนะ</th>
                                                    <th style="width: 150px;" class="text-center">ดูรายละเอียด</th>
                                                    <?php if (!isset($_GET['user_id'])) { ?>
                                                        <th style="width: 70px;" class="text-center">แก้ไข</th>
                                                        <th style="width: 70px;" class="text-center">ลบ</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody id="data-main-calendar">
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <?php include "include/loader_include.php"; ?>
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
            getDataIndex()
        });

        function getDataIndex() {
            $.ajax({
                type: "POST",
                url: "controllers/index_controller",
                data: {
                    getDataIndex: true,
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
                                            <td colspan="5" class="text-center">
                                                ยังไม่มีข้อมูล
                                            </td>
                                        </tr>`
                return;
            }
            data.forEach((element, index) => {
                main_calendar.innerHTML += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-left">${element.title_index}</td>
                        <td class="text-center">${element.term}</td>
                        <td class="text-center">${(element.video != "" && element.video != null) ? `<a class="text-info" href="${element.video}" target="_blank">วิดีโอ</a>` : '-'}</td>
                        <td class="text-center">${element.evaluation_results ? 
                            element.evaluation_results == 1 ? 
                            `<span class="badge badge-success">ผ่าน</span>` : `<span class="badge badge-danger">ไม่ผ่าน</span>` 
                            : 'ยังไม่ประเมิน'
                        }</td>
                        <td>${element.suggestions ? element.suggestions.length > 75 ? element.suggestions.substring(0, 75) + '. . .' : element.suggestions : '-'}</td>
                        <td class="text-center">
                            <a href="manage_index_detail?index_id=${element.index_id}<?php echo isset($_GET['user_id']) ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '' ?>">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                            </a>
                        </td>
                        ${role_id == 3 ? 
                            `<td class="text-center">    
                            <a href="manage_index_edit?index_id=${element.index_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                            </a>
                            </td>
                            <td class="text-center">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteIndex(${element.index_id})"><i class="ti-trash"></i></button>
                            </td>` : ''
                        }
                    </tr>`;
            });
        }

        function deleteIndex(index_id) {
            const confirmDelete = confirm('ต้องการลบข้อมูลเอกสารการประเมินพนักงานราชการนี้หรือไม่?');
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/index_controller",
                    data: {
                        deleteIndex: true,
                        index_id: index_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataIndex()
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