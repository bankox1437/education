<?php
//include 'include/check_login.php'; 
session_start();
include "../config/class_database.php";
$DB = new Class_Database();
$sql = "select * from tb_setting_attribute where key_name = 'system_name'";
$data_result = $DB->Query($sql, []);
$data_result = json_decode($data_result);

$file_image_old = "";

if (count($data_result) > 0) {
    $data_result = $data_result[0]->value;
    $data_result = json_decode($data_result, true);
    $file_image_old = $data_result['file_image'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include "../include/global-header.php" ?>
    <link rel="stylesheet" href="css/main.css?v=<?php echo rand(0, 99) ?>">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">

    <link rel="icon" href="../images/<?php echo $file_image_old ?>?v=<?php echo time() ?>">
    <link rel="apple-touch-icon" href="../images/<?php echo $file_image_old ?>?v=<?php echo time() ?>">

    <title>การเรียนรู้เพื่อพัฒนาตนเอง</title>
    <style>
        .fixed-table-toolbar {
            padding: 0;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php
        if ($_SESSION['user_data']) {
            include '../include/nav-header.php';
        } ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="m-0 box-title">
                                        <?php if (!$_SESSION['user_data']) { ?>
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='../'"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php } ?>
                                        สื่อการเรียนรู้เพื่อพัฒนาตนเอง
                                    </h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row mt-3 mx-2">
                                        <?php if (!$_SESSION['user_data']) { ?>
                                            <div class="col-md-2 mt-2">
                                                <select class="form-control select2" id="province_select" style="width: 100%;" onchange="searchTeachMore()">
                                                    <option value="0">เลือกจังหวัด</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <select class="form-control select2" id="district_select" style="width: 100%;" onchange="searchTeachMore()" disabled>
                                                    <option value="0">เลือกอำเภอ</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-2  mt-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="search" placeholder="ค้นหาด้วยชื่อเรื่อง" onkeyup="searchTeachMore()">
                                            </div>
                                        </div>
                                        <?php if ($_SESSION['user_data'] && ($_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 3)) { ?>
                                            <div class="col-md-2  mt-2">
                                                <div class="form-group" style="display: flex;flex-direction: column;">
                                                    <button class="waves-effect waves-light btn btn-success btn-flat ml-2" onclick="$('.star-hide').show();clearInput();" id="show-modal" data-toggle="modal" data-target="#modal-add"><i class="ti-pencil-alt"></i>&nbsp;เพิ่มข้อมูล</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table" data-icons="icons" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server"
                                            data-page-size="20" data-url="controllers/share_controller?getShare=true">
                                        </table>
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

    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="share-title" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="share-title"><b>จัดการ การเรียนรู้เพื่อพัฒนาตนเอง</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form m-0" id="share-add">
                        <div class="box-body p-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อเรื่อง <b class="text-danger star-hide">*</b></label>
                                        <input type="text" class="form-control" id="share_name" autocomplete="off" placeholder="กรอกชื่อเรื่อง">
                                        <input type="hidden" id="share_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ลิงก์วีดีโอ <b class="text-danger star-hide">*</b></label>
                                        <input type="text" class="form-control" id="share_link" autocomplete="off" placeholder="กรอกลิงก์วีดีโอ">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-rounded btn-danger btn-outline mr-1" data-dismiss="modal">
                                        <i class="ti-close"></i> ยกเลิก
                                    </button>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                        <i class="ti-save-alt"></i> บันทึกข้อมูล
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include 'include/scripts.php'; ?>
    <script>
        const role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
    </script>
    <script>
        var $table = $("#table");

        function setlabelFilename(id) {
            const file = document.getElementById(id).files;
            let fileName = '';
            for (let i = 0; i < file.length; i++) {
                if (i == 0) {
                    fileName += file[i].name;
                } else {
                    fileName += " , " + file[i].name;
                }
            }
            document.getElementById(id + '_label').innerText = fileName;
        }
        $('#share-add').submit((e) => {
            e.preventDefault();
            const share_name = $('#share_name').val();
            const share_link = $('#share_link').val();
            const share_id = $('#share_id').val();
            const formData = new FormData();

            if (share_name == "") {
                alert('โปรดกรอกชื่อเรื่อง');
                $('#share_name').focus();
                return false;
            }

            if (share_link == "") {
                alert('โปรดกรอกลิงก์วีดีโอ');
                $('#share_link').focus();
                return false;
            }

            if (!isValidURL(share_link)) {
                alert('โปรดกรอกลิงก์วีดีโอให้ถูกต้อง');
                $('#share_link').focus();
                return false;
            }

            formData.append("updateShare", true);
            formData.append("share_name", share_name);
            formData.append("share_link", share_link);
            formData.append("share_id", share_id);

            $.ajax({
                type: "POST",
                url: "controllers/share_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    alert(json.msg);
                    if (json.status) {
                        $('#share_name').val("");
                        $('#share_link').val("");
                        $('.close').click();
                        $table.bootstrapTable('refresh');
                    }
                },
            });
        })

        $(document).ready(async function() {
            initTable();
            console.log(role_id);
            <?php if (!$_SESSION['user_data']) { ?>
                await getDataProDistSub();

                $('#province_select').select2();
                $('#district_select').select2();

                $('.select2').on('select2:open', function(e) {
                    // Find the input field and focus on it
                    $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
                });
            <?php } ?>
        });

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;

                    const province_select = document.getElementById('province_select');
                    main_provinces.forEach((element, id) => {
                        province_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                    });
                },
            });
        }

        $('#province_select').change((e) => {
            getDistrictByProvince(e.target.value)
        })

        function getDistrictByProvince(pro_id) {
            const district_select = document.getElementById('district_select');
            if (pro_id != 0) {
                district_select.removeAttribute("disabled");
            } else {
                district_select.setAttribute("disabled", true);
            }

            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="0">เลือกอำเภอ</option>`;
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            district.forEach((element) => {
                district_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }

        function clearInput() {
            $('#share_name').val('');
            $('#share_link').val('');
        }

        function formatButtonEdit(data, row) {
            let html = "";
            html = `<button type="button" onclick="editShare(${row.share_id})" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1"><i class="ti-pencil-alt"></i></button>`;
            html += `<button type="button" onclick="deleteShare(${row.share_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1 ml-2"><i class="ti-trash"></i></button>`;
            return html;
        }

        function formatButtonLink(data, row) {
            let html = '';
            html = `<button type="button" onclick="openLink('${row.share_link}',${row.share_id})" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1"><i class="ti-eye"></i></button>`;
            return html;
        }

        function initTable() {
            $table.bootstrapTable("destroy").bootstrapTable({
                locale: "th-TH",
                columns: [
                    [{
                            title: "ลำดับ",
                            align: "center",
                            width: "30px",
                            formatter: function(value, row, index) {
                                const options = $table.bootstrapTable("getOptions");
                                const currentPage = options.pageNumber;
                                let itemsPerPage = options.pageSize;
                                if (itemsPerPage == "All") {
                                    const data = $table.bootstrapTable("getData");
                                    itemsPerPage = data.length;
                                }
                                const offset = (currentPage - 1) * itemsPerPage;
                                return index + 1 + offset;
                            },
                        },
                        {
                            field: "share_name",
                            title: "ชื่อเรื่อง",
                            align: "left",
                            width: "120px",
                        },
                        {
                            field: "opsLink",
                            title: "ลิงก์วีดีโอ",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonLink
                        },
                        {
                            field: "share_views",
                            title: "ยอดเข้าชม",
                            align: "center",
                            width: "50px",
                            visible: role_id ? true : false
                        },
                        {
                            field: "u_name",
                            title: "ผู้บันทึก",
                            width: "120px",
                            align: "center",
                        },
                        {
                            field: "name_th",
                            title:  "<?php echo $_SESSION['user_data']->role_id == 2 ? "สกร.อำเภอ" : "ศกร.ตำบล" ?>",
                            width: "120px",
                            align: "center",
                        },
                        <?php if ($_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 3) { ?> {
                                field: "ops",
                                title: "จัดการ",
                                width: "50px",
                                align: "center",
                                formatter: formatButtonEdit,
                            },
                        <?php } ?>
                    ],
                ],
            });
        }

        function editShare(share_id) {
            $.ajax({
                type: "POST",
                url: "controllers/share_controller",
                data: {
                    getShare: true,
                    share_id: share_id
                },
                dataType: "json",
                success: async function(json) {
                    let data = json.rows[0];
                    $('#show-modal').click();
                    $('#share_name').val(data.share_name);
                    $('#share_link').val(data.share_link);
                    $('#share_id').val(data.share_id);
                    $('.star-hide').hide();
                },
            });
        }

        function isValidURL(text) {
            try {
                new URL(text);
                return true;
            } catch (e) {
                return false;
            }
        }

        function openLink(share_link, share_id) {
            <?php if (!@$_SESSION['user_data']) { ?>
                openViews(share_id)
            <?php } ?>

            window.open(share_link, '_blank');
        }

        // Clear the iframe when the modal is closed
        $('#modal-video').on('hidden.bs.modal', function() {
            $('#video-iframe').attr('src', ''); // Clear video URL when modal is closed
        });


        function deleteShare(share_id) {
            if (confirm('ต้องการลบการเรียนรู้เพื่อพัฒนาตนเองนี้หรือไม่?')) {
                $.ajax({
                    type: "POST",
                    url: "controllers/share_controller",
                    data: {
                        deleteShare: true,
                        share_id: share_id,
                    },
                    dataType: "json",
                    success: async function(json) {
                        if (json.status) {
                            $table.bootstrapTable('refresh');
                        }
                    },
                });
            }
        }

        function searchTeachMore() {
            let param = '';
            $('#search').val() != '' ? param += '&search=' + $('#search').val() : '';
            $('#province_select').val() != '0' ? param += '&province_select=' + $('#province_select').val() : '';
            $('#district_select').val() != '0' ? param += '&district_select=' + $('#district_select').val() : '';

            var urlWithParams = $table.data('url') + param;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
        }

        function downloadUpdate(teach_m_id) {
            $.ajax({
                type: "POST",
                url: "controllers/teach_more_controller",
                data: {
                    downloadUpdate: true,
                    teach_m_id: teach_m_id
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        $table.bootstrapTable('refresh');
                    }
                },
            });
        }

        function openViews(share_id) {
            $.ajax({
                type: "POST",
                url: "controllers/share_controller",
                data: {
                    viewsUpdate: true,
                    share_id: share_id
                },
                dataType: "json",
                success: async function(json) {
                    if (json.status) {
                        $table.bootstrapTable('refresh');
                    }
                },
            });
        }
    </script>
</body>

</html>