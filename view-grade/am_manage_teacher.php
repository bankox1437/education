<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>จัดการผู้ใช้งาน</title>
    <style>
        .fixed-table-toolbar .bs-bars {
            width: 70%;
        }

        @media only screen and (max-width: 600px) {
            .pagination-detail .pagination {
                margin-left: 100px;
            }
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
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-3">
                                        <h4 class="mt-2 ml-3">ตารางข้อมูลผู้ใช้งานทั้งหมด</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <input type="hidden" id="pro_name" value="<?php echo $_SESSION['user_data']->province_am_id ?>">
                                            <input type="hidden" id="dis_name" value="0">
                                            <select class="form-control select2" name="sub_name" id="sub_name" data-placeholder="เลือกตำบล" style="width: 100%;">
                                                <option value="0">เลือกตำบล</option>
                                            </select>
                                            <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                        </div>
                                    </div>
                                    <a class="col-md-2 waves-effect waves-light btn btn-success btn-flat ml-2" onclick="gotoAdd()"><i class="ti-plus"></i>&nbsp;เพิ่มแอดมิน</a>
                                </div>
                                <div class="box-body no-padding">
                                    <?php
                                    $pro_id = $_SESSION['user_data']->province_am_id;
                                    $dis_id = $_SESSION['user_data']->district_am_id;
                                    ?>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="../admin/controllers/user_controller?getDataUsers=true&role_id=3&province_id=<?php echo $pro_id; ?>&district_id=<?php echo $dis_id ?>" data-response-handler="responseHandler">
                                    </table>
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
    <script src="js/manage_admin_table.js?v=<?php echo $version ?>"></script>
    <?php include '../admin/js/prodissub.js.php'; ?>
    <script>
        let pro = "0"
        let dis = "0"
        let sub = "0"
        $(document).ready(async function() {
            initTable()

            await getDataProDistSub();

            let sub_active = '<?php echo isset($_GET['sub']) ? $_GET['sub'] : '0' ?>'
            let page_number = '<?php echo isset($_GET['page_number']) ? $_GET['page_number'] : '0' ?>'

            $('#sub_name').select2()

            setTimeout(() => {
                if (sub_active != '0') {
                    $('#sub_name').val(sub_active).trigger('change');
                }
                if (page_number != '0') {
                    $table.bootstrapTable('refreshOptions', {
                        pageNumber: parseInt(page_number)
                    });
                }
            }, 1000)
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        async function getDistrictDataAmphur() {
            return Promise.resolve($.ajax({
                type: "POST",
                url: "../student-tracking/controllers/dashboard_controller",
                data: {
                    getDistrictDataAmphur: true,
                },
                dataType: "json",
            }));
        }

        let main_provinces = null;
        let main_district = null;
        let main_sub_district_id = null;

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "../student-tracking/controllers/user_controller",
                data: {
                    getDataProDistSub: true
                },
                dataType: "json",
                success: async function(json_data) {
                    console.log(json_data);
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;

                    if (role_id == 2) {
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

        $('#sub_name').on('change', () => getDatauserByProDisSub());

        function gotoAdd() {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `am_manage_teacher_add?pro=<?php echo $pro_id ?>&dis=<?php echo $dis_id ?>&sub=${sub}&page_number=${currentPageNumber}`;
        }

        function gotoEdit(id) {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `am_manage_teacher_edit?user_id=${id}&pro=<?php echo $pro_id ?>&dis=<?php echo $dis_id ?>&sub=${sub}&page_number=${currentPageNumber}`;
        }

        function gotoAddLeave(id) {
            var options = $table.bootstrapTable('getOptions');
            var currentPageNumber = options.pageNumber;
            location.href = `am_manage_teacher_leave_day?user_id=${id}&pro=<?php echo $pro_id ?>&dis=<?php echo $dis_id ?>&sub=${sub}&page_number=${currentPageNumber}`;
        }

        const getDatauserByProDisSub = () => {
            let paramPlus = "";
            pro = $('#pro_name').val()
            dis = $('#dis_name').val()
            sub = $('#sub_name').val()
            let role_id = 3;
            paramPlus += '&role_id=' + role_id;
            if (role_id == 1) {
                closeSelectOption(true)
            } else {
                closeSelectOption()
            }

            if (pro != 0) {
                paramPlus += '&province_id=' + pro;
            }
            if (dis != 0) {
                paramPlus += '&district_id=' + dis;
            }
            if (sub != 0) {
                paramPlus += '&subdistrict_id=' + sub;
            }
            var urlWithParams = $table.data('url') + paramPlus;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function closeSelectOption(status = false) {
            if (status) {
                $('#sub_name').val(0).trigger('change.select2');
                sub_name.setAttribute("disabled", status)
            }
        }

        function deleteAdmin(id, name, edu_id_del) {
            const confirmDelete = confirm('ต้องการลบแอดมิน ' + name + ' หรือไม่?');
            const role_value = $('#role_value').val()
            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "../admin/controllers/user_controller",
                    data: {
                        delete_admin: true,
                        id: id,
                        edu_id: edu_id_del
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status) {
                            $table.bootstrapTable('refresh');
                        } else {
                            alert(data.msg)
                        }
                    },
                });
            }
        }
    </script>
</body>

</html>