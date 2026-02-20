<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลบุคลากร</title>
    <style>
        .fixed-table-toolbar .bs-bars {
            width: 70%;
        }

        @media only screen and (max-width: 600px) {
            .pagination-detail .pagination {
                margin-left: 100px;
            }
        }

        <?php if ($_SESSION['user_data']->role_id == 7) { ?>.table tbody tr td {
            padding: 10px;
        }

        <?php } ?>
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
                                <input type="hidden" id="role_value" value="0">
                                <div class="row align-items-center mt-4">
                                    <div class="col-md-2">
                                        <h4 class="mt-2 ml-3">ข้อมูลบุคลากร </h4>
                                    </div>
                                    <?php if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 7) { ?>
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="pro_name" id="pro_name" style="width: 100%;">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 6 || $_SESSION['user_data']->role_id == 7) { ?>
                                        <input type="hidden" id="pro_name" value="<?php echo $_SESSION['user_data']->province_am_id ?>">
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="dis_name" <?php if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 7) {
                                                                                                            echo "disabled";
                                                                                                        } ?> id="dis_name" style="width: 100%;">
                                                    <option value="0">เลือกอำเภอ</option>
                                                </select>
                                                <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <?php if ($_SESSION['user_data']->role_id == 2) { ?>
                                                <input type="hidden" id="pro_name" value="<?php echo $_SESSION['user_data']->province_am_id ?>">
                                                <input type="hidden" id="dis_name" value="0">
                                            <?php } ?>
                                            <select class="form-control select2" name="sub_name" <?php if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 6 || $_SESSION['user_data']->role_id == 7) {
                                                                                                        echo "disabled";
                                                                                                    } ?> id="sub_name" style="width: 100%;">
                                                <option value="0">เลือกตำบล</option>
                                            </select>
                                            <!-- <input type="text" class="form-control height-input" name="sub_name" id="sub_name" placeholder="กศน. ตำบล"> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <?php
                                    $pro_id = $_SESSION['user_data']->province_am_id;
                                    $dis_id = $_SESSION['user_data']->district_am_id;

                                    $status = json_decode($_SESSION['user_data']->status);
                                    $calendar_new = isset($status->calendar_new) && !empty($status->calendar_new) ? true : false;

                                    $paramPlus = "";
                                    if ($pro_id != 0) {
                                        $paramPlus .= '&province_id=' . $pro_id;
                                    }
                                    if ($dis_id != 0) {
                                        $paramPlus .= '&district_id=' . $dis_id;
                                    }
                                    ?>
                                    <table data-toggle="table" id="table" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/am_controller?getDataDashboard=true<?php echo $paramPlus; ?>" data-locale="th-TH">
                                        <thead>
                                            <tr>
                                                <th <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="center" data-width="20px" data-formatter="formatCounter">ลำดับ</th>
                                                <th data-field="concat_name" <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="left" data-width="170px">ชื่อ-สกุล</th>
                                                <th data-field="age" <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="center" data-width="50px">อายุ(ปี)</th>
                                                <th data-field="end_work" <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="center" data-width="50px" data-formatter="formatEndWorkDate">ปีที่เกษียณ</th>
                                                <th data-field="start_work" <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="center" data-width="50px">อายุงาน(ปี)</th>
                                                <th data-field="class_royal" <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="center" data-width="50px">เครื่องราช</th>
                                                <th data-field="scout_rank" <?php echo $_SESSION['user_data']->role_id != 7 ? 'rowspan="2"' : '' ?> data-valign="middle" data-align="center" data-width="50px">ขั้นลูกเสือ</th>
                                                <?php if ($_SESSION['user_data']->role_id != 7) { ?>
                                                    <th colspan="4" data-valign="middle" data-align="center">ข้อมูล นศ.</th>
                                                    <th colspan="3" data-valign="middle" data-align="center">วันลา</th>
                                                    <?php if (!empty($calendar_new)) { ?>
                                                        <th rowspan="2" data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonView1">งานสอน ประถม</th>
                                                        <th rowspan="2" data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonView2">งานสอน ม.ต้น</th>
                                                        <th rowspan="2" data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonView3">งานสอน ม.ปลาย</th>
                                                    <?php } else { ?>
                                                        <th rowspan="2" data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonView">งานสอน</th>
                                                    <?php } ?>
                                                    <th rowspan="2" data-valign="middle" data-align="center" data-width="50px" data-formatter="formatButtonViewData">ข้อมูลอื่น</th>
                                                <?php } else { ?>
                                                    <th data-field="royal_name" data-valign="middle" data-align="center" data-width="100px">โล่/เข็ม/เกียรติบัตร</th>
                                                    <th data-field="submission_name" data-valign="middle" data-align="center" data-width="100px">การประกวด/ส่งผลงาน</th>
                                                <?php } ?>
                                            </tr>
                                            <?php if ($_SESSION['user_data']->role_id != 7) { ?>
                                                <tr>
                                                    <th data-field="pratom" data-valign="middle" data-align="center" data-width="50px">ประถม</th>
                                                    <th data-field="mTon" data-valign="middle" data-align="center" data-width="50px">ม.ต้น</th>
                                                    <th data-field="mPai" data-valign="middle" data-align="center" data-width="50px">ม.ปลาย</th>
                                                    <th data-field="price" data-valign="middle" data-align="center" data-width="50px" data-formatter="formatSumStdCount">รวม</th>

                                                    <th data-field="l2" data-valign="middle" data-align="center" data-width="50px">ลากิจ</th>
                                                    <th data-field="l3" data-valign="middle" data-align="center" data-width="50px">ลาป่วย</th>
                                                    <th data-field="l1" data-valign="middle" data-align="center" data-width="50px">ลาพักผ่อน</th>
                                                </tr>
                                            <?php } ?>
                                        </thead>
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
    <script>
        let pro = "0"
        let dis = "0"
        let sub = "0"
    </script>

    <?php include 'include/scripts.php'; ?>
    <script src="js/am_dashboard.js?v=<?php echo $version ?>"></script>
    <?php include '../admin/js/prodissub.js.php'; ?>
    <script>
        let pro_id = "<?php echo $pro_id ?>";
        let dis_id = "<?php echo $dis_id ?>";
        $(document).ready(async function() {
            // initTable()

            await getDataProDistSub();

            let pro_active = '<?php echo isset($_GET['pro']) ? $_GET['pro'] : '0' ?>'
            let dis_active = '<?php echo isset($_GET['dis']) ? $_GET['dis'] : '0' ?>'
            let sub_active = '<?php echo isset($_GET['sub']) ? $_GET['sub'] : '0' ?>'

            let page_number = '<?php echo isset($_GET['page_number']) ? $_GET['page_number'] : '0' ?>'

            if (role_id == 1 || role_id == 7) {
                $('#pro_name').select2()
            }
            if (role_id == 1 || role_id == 6 || role_id == 7) {
                $('#dis_name').select2()
            }

            $('#sub_name').select2()

            setTimeout(() => {
                if (pro_active != '0') {
                    $('#pro_name').val(pro_active).trigger('change');
                }
                if (dis_active != '0') {
                    $('#dis_name').val(dis_active).trigger('change');
                }
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
                    getDataProDistSub: true,
                    table: 'tb_users'
                },
                dataType: "json",
                success: async function(json_data) {
                    console.log(json_data);
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;
                    const province_select = document.getElementById('pro_name');
                    if (role_id == 1 || role_id == 7) {
                        main_provinces.forEach((element, id) => {
                            province_select.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
                        });
                    }
                    if (role_id == 6) {
                        const dis_name = document.getElementById('dis_name');
                        dis_name.innerHTML = "";
                        dis_name.innerHTML += ` <option value="">เลือกอำเภอ</option>`;
                        const district = main_district.filter((dis) => {
                            return dis.province_id == pro_id
                        })
                        district.forEach((element, id) => {
                            dis_name.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
                        });
                    }
                    if (role_id == 2) {
                        const sub_name = document.getElementById('sub_name');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="">เลือกตำบล</option>`;
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        function getDistrictByProvince() {
            const pro_id = $('#pro_name').val()
            const district_select = document.getElementById('dis_name');
            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="">เลือกอำเภอ</option>`;
            const sub_name = document.getElementById('sub_name');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="">เลือกตำบล</option>`;
            if (!pro_id) {
                district_select.setAttribute("disabled", true)
                sub_name.setAttribute("disabled", true)
                return;
            }
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            district_select.removeAttribute("disabled");
            district.forEach((element, id) => {
                district_select.innerHTML += ` <option value="${element.id}" data-value="${element.id}">${element.name_th}</option>`
            });
        }

        $('#pro_name').on('change', (e) => getDistrictByProvince(e.target.value, getDatauserByProDisSub));
        $('#dis_name').on('change', (e) => getSubDistrictByDistrict(e.target.value, getDatauserByProDisSub));
        $('#sub_name').on('change', () => getDatauserByProDisSub());

        function getDistrictByProvince(pro_id, callback) {
            callback()
            const pro_name = $('#pro_name').find(':selected')[0].innerText
            $('#pro_name_text').val(pro_name)
            const dis_name = document.getElementById('dis_name');
            dis_name.innerHTML = "";
            dis_name.innerHTML += ` <option value="0">เลือกอำเภอ</option>`
            const sub_name = document.getElementById('sub_name');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`
            sub_name.setAttribute("disabled", true)
            // $('#edu_select').attr('disabled', true)
            //$('#new_edu').hide();
            //newEdu(false)
            if (pro_id == 0) {
                dis_name.setAttribute("disabled", true)
                return;
            }
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            dis_name.removeAttribute("disabled");
            district.forEach((element, id) => {
                dis_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
            });
        }

        async function getSubDistrictByDistrict(dist_id, callback) {
            callback()
            const dis_name = $('#dis_name').find(':selected')[0].innerText;
            $('#dis_name_text').val(dis_name)
            const sub_name = document.getElementById('sub_name');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`
            if (dist_id == 0) {
                sub_name.setAttribute("disabled", true)
                // $('#edu_select').attr('disabled', true)
                //$('#new_edu').hide();
                //newEdu(false)
                return;
            }
            const sub_district = main_sub_district_id.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_name.removeAttribute("disabled");
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
            });
        }

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
    </script>
</body>

</html>