<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>นิเทศออนไลน์-จัดการแอดมินครู</title>
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
                                    <input type="hidden" id="role_value" value="0">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <h4 class="box-title">ตารางข้อมูลแอดมินครูตำบล</h4>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control" id="edu_select" onchange="getDataAdmin(this.value)">
                                            </select>
                                        </div>

                                        <a class="col-md-2 waves-effect waves-light btn btn-success btn-flat ml-2" href="am_manage_teacher_add?p=<?php echo base64_encode($_SESSION['user_data']->province_am_id) ?>&d=<?php echo base64_encode($_SESSION['user_data']->district_am_id) ?>"><i class="ti-plus"></i>&nbsp;เพิ่มแอดมิน</a>
                                        <div class="col-md"></div>
                                        <!-- <input class="col-md-2 form-control" type="text" name="search_admin" placeholder="ค้นหาชื่อสถานศึกษา" oninput="searchUser(this)"> -->
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="font-size: 14px;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ลำดับ</th>
                                                    <th>ชื่อ - สกุล</th>
                                                    <th>สถานศึกษา</th>
                                                    <th>ตำบล</th>
                                                    <th>อำเภอ</th>
                                                    <th>จังหวัด</th>
                                                    <th>สิทธิ์</th>
                                                    <th class="text-center">แก้ไข / ลบ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-user">
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        <?php include "../include/loader_include.php"; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="m-3 d-flex justify-content-center">
                                        <button id="btn-load-more" type="button" class="waves-effect waves-light btn btn-outline btn-primary mb-5">โหลดเพิ่มเติม</button>
                                    </div>
                                </div>
                                <!-- /.box-body -->
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

    <?php include 'include/scripts.php'; ?>

    <script>
        $(document).ready(function() {
            getDataAdmin()
        });

        function getDataAdmin(edu_id = 0, page = 1, limit = 100) {
            const Tbody = document.getElementById('data-user');
            console.log(edu_id);
            $.ajax({
                type: "POST",
                url: "controllers/am_controller",
                data: {
                    getDataUsers: true,
                    edu_id: edu_id,
                    page: page,
                    limit: limit
                },
                dataType: 'json',
                success: function(json_data) {
                    let number_continue = 0;
                    if (page == 1) {
                        Tbody.innerHTML = "";
                    } else {
                        number_continue = Tbody.children.length
                    }
                    let mode = 'S';
                    if (edu_id == 0) {
                        mode = 'G';
                    }
                    genHtmlTable(json_data.data, number_continue, mode)
                    const btn_load = document.getElementById('btn-load-more');
                    if (parseInt(json_data.count) > limit && Tbody.children.length != parseInt(json_data.count)) {
                        btn_load.style.display = 'block';
                        btn_load.setAttribute('data-page', page)
                    } else {
                        btn_load.style.display = 'none';
                    }
                    if (edu_id == 0) {
                        const select_edu = document.getElementById('edu_select');
                        select_edu.innerHTML = '';
                        select_edu.innerHTML += `<option value="0">สถานศึกษาทั้งหมด</option>`
                        json_data.edu_all.forEach(element => {
                            select_edu.innerHTML += `<option value="${element.edu_id}">${element.edu_name}</option>`
                        });
                    }
                },
            });
        }

        function genHtmlTable(data, number_continue, mode = 'G') {
            const Tbody = document.getElementById('data-user');
            if (mode == 'S') {
                Tbody.innerHTML = "";
            }
            if (data.length == 0) {
                Tbody.innerHTML += `
                    <tr>
                        <td colspan="8" class="text-center">
                            ไม่มีข้อมูล
                        </td>
                    </tr>
                `
                return;
            }
            data.forEach((element, i) => {
                let test_district = "-"
                let test_province = "-"
                if (element.district != null && element.role_id != 2) {
                    test_district = element.district
                }
                if (element.district == null && element.role_id == 2) {
                    test_district = element.district_am
                }

                if (element.province != null && element.role_id != 2) {
                    test_province = element.province
                }
                if (element.province == null && element.role_id == 2) {
                    test_province = element.province_am
                }
                Tbody.innerHTML += `
                            <tr>
                                <td class="text-center">${(i + 1) + number_continue}</td>
                                <td>${element.name} ${element.surname}</td>
                                <td>${element.edu_name != null ? element.edu_name : '-'}</td>
                                <td>${element.sub_district != null ? element.sub_district : '-'}</td>
                                <td>${test_district}</td>
                                <td>${test_province}</td>
                                <td>${element.role_id == 1 ? `<span class="badge badge-pill badge-primary">${element.role_name}</span>` :
                                    element.role_id == 2 ? `<span class="badge badge-pill badge-info">${element.role_name}</span>` : 
                                    `<span class="badge badge-pill badge-success">${element.role_name}</span>`
                                }</td>
                                <td class="text-center">
                                    <a href="am_manage_teacher_edit?user_id=${element.id}">
                                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                                    </a>
                                   ${element.id == parseInt('<?php echo $_SESSION['user_data']->id; ?>') ? '' : `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteAdmin(${element.id},'${element.name} ${element.surname}',${element.edu_id})"><i class="ti-trash"></i></button>`}
                                </td>
                            </tr>
                `;
            });
        }

        // loadmore
        document.getElementById('btn-load-more').addEventListener('click', function(e) {
            let page = e.target.getAttribute('data-page');
            page = parseInt(page) + 1;
            const edu_id = document.getElementById('edu_select').value;
            getDataAdmin(edu_id, page)
        })

        function deleteAdmin(id, name, edu_id_del) {
            const confirmDelete = confirm('ต้องการลบแอดมิน ' + name + ' หรือไม่?');
            const edu_id = document.getElementById('edu_select').value;
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "controllers/user_controller",
                    data: {
                        delete_admin: true,
                        id: id,
                        edu_id: edu_id_del
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            getDataAdmin(edu_id)
                        } else {
                            alert(data.msg)
                        }
                    },
                });
            }
        }

        function searchUser(input) {
            if (input.value == "") {
                getDataAdmin()
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    searchDataUsers: true,
                    keyword: input.value,
                    role_id: 3
                },
                dataType: "json",
                success: function(data) {
                    genHtmlTable(data.data, 0, 'S')
                },
            });
        }
    </script>
</body>

</html>