<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>การสอนเสริม</title>
    <style>
        .fixed-table-toolbar {
            padding: 0;
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
                                    <h3 class="m-0 box-title">การสอนเสริม</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row mt-3 mx-4">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>ค้นหา</label>
                                                <input type="text" class="form-control" id="search" placeholder="ค้นหาด้วยชื่อรายวิชาหรือชื่อผู้บันทึก" onkeyup="searchTeachMore()">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="mt-0">&nbsp;&nbsp;</label>
                                            <select class="form-control" id="teach_class" onchange="searchTeachMore()">
                                                <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                                                <option value="ประถม">ประถม</option>
                                                <option value="ม.ต้น">ม.ต้น</option>
                                                <option value="ม.ปลาย">ม.ปลาย</option>
                                            </select>
                                        </div>
                                        <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                            <div class="col-md-2">
                                                <div class="form-group" style="display: flex;flex-direction: column;">
                                                    <label class="mt-0">&nbsp;&nbsp;</label>
                                                    <button class="waves-effect waves-light btn btn-success btn-flat ml-2" onclick="$('.star-hide').show();clearInput();" id="show-modal" data-toggle="modal" data-target="#modal-add"><i class="ti-pencil-alt"></i>&nbsp;บันทึกการสอนเสริม</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="table" data-icons="icons" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/teach_more_controller?getTeachMore=true">
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
                    <h4 class="modal-title" id="share-title"><b>บันทึกการสอนเสริม</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form m-0" id="share-add">
                        <div class="box-body p-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>หมวดหมู่รายวิชา</label>
                                        <select class="form-control" id="cate">
                                            <option value="วิชาบังคับ">วิชาบังคับ</option>
                                            <option value="วิชาบังคับเลือก">วิชาบังคับเลือก</option>
                                            <option value="วิชาเลือกเสรี">วิชาเลือกเสรี</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>สำหรับระดับชั้น</label>
                                        <select class="form-control" id="std_class">
                                            <option value="ประถม">ประถม</option>
                                            <option value="ม.ต้น">ม.ต้น</option>
                                            <option value="ม.ปลาย">ม.ปลาย</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>รหัสรายวิชา <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control" id="subject_code" autocomplete="off" placeholder="รหัสรายวิชา">
                                        <input type="hidden" class="form-control" id="teach_m_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ชื่อรายวิชา <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control" id="subject_name" autocomplete="off" placeholder="ชื่อรายวิชา">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ปีการศึกษา <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control" id="year" autocomplete="off" placeholder="ปีการศึกษา">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ลิงก์การสอนเสริม (แนะนำใช้ลิงก์ youtube)</label>
                                        <input type="text" class="form-control" id="link" autocomplete="off" placeholder="ลิงก์การสอนเสริม">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ไฟล์การสอนเสริม <b class="text-danger star-hide">*</b></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="sh_plan_file" name="sh_plan_file" accept="application/pdf" onchange="setlabelFilename('sh_plan_file')">
                                            <input type="hidden" id="sh_plan_file_old" name="sh_plan_file_old">
                                            <label class="custom-file-label" for="sh_plan_file" id="sh_plan_file_label">เลือกไฟล์ PDF เท่านั้น</label>
                                        </div>
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

    <button id="show-modal-video" data-toggle="modal" data-target="#modal-video" style="visibility: hidden;"></button>
    <div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>การสอนเสริม</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Video iframe -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="video-iframe" class="embed-responsive-item" src="https://www.facebook.com/plugins/video.php?href=${encodeURIComponent(videoUrl)}&show_text=0&width=560" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    // Get the protocol (HTTP or HTTPS)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Get the hostname
    $host = $_SERVER['HTTP_HOST'];

    // Construct the full URL
    $fullUrl = $protocol . $host;
    $fullUrl .= "/edu"; // localhost
    $fullUrl .= "/visit-online";

    include 'include/scripts.php'; ?>

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
            const cate = $('#cate').val();
            const std_class = $('#std_class').val();
            const subject_code = $('#subject_code').val();
            const subject_name = $('#subject_name').val();
            const year = $('#year').val();
            const link = $('#link').val();
            const sh_plan_file = document.getElementById('sh_plan_file').files[0];

            const formData = new FormData();
            if (subject_code == "") {
                alert('โปรดกรอกข้อมูลรหัสรายวิชา');
                $('#subject_code').focus();
                return false;
            }

            if (subject_name == "") {
                alert('โปรดกรอกข้อมูลชื่อรายวิชา');
                $('#subject_name').focus();
                return false;
            }

            if (year == "") {
                alert('โปรดกรอกข้อมูลปีการศึกษา');
                $('#year').focus();
                return false;
            }

            if ($('#teach_m_id').val() == "" && sh_plan_file == undefined) {
                alert('โปรดแนบไฟล์การสอนเสริม');
                $('#sh_plan_file').focus();
                return false;
            }

            formData.append("updateTeachMore", true);
            formData.append("cate", cate);
            formData.append("std_class", std_class);
            formData.append("subject_code", subject_code);
            formData.append("subject_name", subject_name);
            formData.append("year", year);
            formData.append("link", link);
            formData.append("sh_plan_file", sh_plan_file);
            formData.append("teach_m_id", $('#teach_m_id').val());
            formData.append("sh_plan_file_old", $('#sh_plan_file_old').val());


            $.ajax({
                type: "POST",
                url: "controllers/teach_more_controller",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: async function(json) {
                    alert(json.msg);
                    if (json.status) {
                        $('.close').click();
                        $('#sh_plan_file_label').text("เลือกไฟล์ PDF เท่านั้น");
                        $('#subject_code').val("");
                        $('#subject_name').val("");
                        $('#year').val("");
                        document.getElementById('sh_plan_file').files[0] = undefined;
                        $table.bootstrapTable('refresh');
                    }
                },
            });
        })

        $(document).ready(async function() {
            initTable()
        });

        function clearInput() {
            $('#link').val('');
        }

        // function formatButtonEdit(data, row) {
        //     html = `<button type="button" onclick="editTeachMore(${row.teach_m_id})" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>`;
        //     html += `<button type="button" onclick="deleteTeachMore(${row.teach_m_id},'${row.teach_file}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1 ml-2" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
        //     return html;
        // }

        function formatButtonEdit(data, row) {
            let u_id = '<?php echo $_SESSION['user_data']->id ?>';
            let html = `<label style="padding:5px">-</label>`;
            if (u_id == row.u_id) {
                html = `<button type="button" onclick="editTeachMore(${row.teach_m_id})" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>`;
                html += `<button type="button" onclick="deleteTeachMore(${row.teach_m_id},'${row.teach_file}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1 ml-2" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
            }
            if (role_id == 1) {
                html = `<button type="button" onclick="deleteTeachMore(${row.teach_m_id},'${row.teach_file}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
            }

            return html;
        }

        function formatButtonLink(data, row) {
            let html = '';
            let u_id = '<?php echo $_SESSION['user_data']->id ?>';
            let isValid = isValidURL(row.teach_link);
            if (!isValid) {
                html = `<p style="margin:10px">ไม่มีลิงก์</p>`
            } else {
                html = `<button type="button" onclick="openLink('${row.teach_link}',${row.teach_m_id},${u_id == row.u_id})" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>`;
            }
            return html;
        }

        function formatButtonFile(data, row) {
            let link = `${row.teach_file}`;
            html = `<a href="${link}" target="_blank"><span class="badge badge-info">${row.teach_file_name}</span></a>`;
            return html;
        }

        function formatButtonLink2(data, row) {
            let u_id = '<?php echo $_SESSION['user_data']->id ?>';
            let link = u_id == row.u_id ? '#' : `${row.teach_file}`;
            let content = u_id == row.u_id ? '-' : `<button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-download" style="font-size:10px"></i></button>`;
            html = `<a href="${link}" download ${u_id !=  row.u_id ? `onclick="downloadUpdate(${row.teach_m_id})"` : '' }>${content}</a>`;
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
                            field: "teach_subject_code",
                            title: "รหัสรายวิชา",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "teach_subject_name",
                            title: "ชื่อรายวิชา",
                            align: "left",
                            width: "120px",
                        },
                        {
                            field: "teach_cate",
                            title: "หมวดหมู่วิชา",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "teach_class",
                            title: "ระดับชั้น",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "year",
                            title: "ปีการศึกษา",
                            align: "center",
                            width: "50px",
                        },
                        // {
                        //     field: "sh_downloads",
                        //     title: "ดาวน์โหลด",
                        //     align: "center",
                        //     width: "50px",
                        // },
                        {
                            title: "ไฟล์การสอนเสริม",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonFile
                        },
                        {
                            field: "teach_downloads",
                            title: "ยอดดาวน์โหลด",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "opsLink",
                            title: "ดาวน์โหลดไฟล์",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonLink2
                        },
                        {
                            field: "opsLink",
                            title: "ลิงก์การสอนเสริม",
                            align: "center",
                            width: "50px",
                            formatter: formatButtonLink
                        },
                        {
                            field: "teach_views",
                            title: "ยอดเข้าชมลิงก์",
                            align: "center",
                            width: "50px",
                        },
                        {
                            field: "u_name",
                            title: "ผู้บันทึก",
                            width: "120px",
                        },
                        <?php if ($_SESSION['user_data']->role_id == 3) { ?> {
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

        function editTeachMore(teach_m_id) {
            $.ajax({
                type: "POST",
                url: "controllers/teach_more_controller",
                data: {
                    getTeachMore: true,
                    teach_m_id: teach_m_id
                },
                dataType: "json",
                success: async function(json) {
                    let data = json.rows[0];
                    $('#show-modal').click();
                    $('#subject_code').val(data.teach_subject_code);
                    $('#subject_name').val(data.teach_subject_name);
                    $('#year').val(data.year);
                    $('#link').val(data.teach_link);
                    $('#sh_plan_file_old').val(data.teach_file);
                    $('#teach_m_id').val(data.teach_m_id);
                    $('#cate').val(data.teach_cate);
                    $('#std_class').val(data.teach_class);
                    document.getElementById('sh_plan_file').files[0] = undefined;
                    $('#sh_plan_file_label').text(data.sh_plan_file_name);
                    $('.star-hide').hide();
                },
            });
        }

        function isValidURL(url) {
            // Check if the URL is empty, undefined, or placeholder text
            if (!url || url === "-" || url === "undefined") {
                return false;
            }

            // Regular expression for validating a URL format
            const urlPattern = new RegExp(
                '^(https?:\\/\\/)?' + // protocol (optional)
                '((([a-zA-Z\\d]([a-zA-Z\\d-]*[a-zA-Z\\d])*)\\.)+[a-zA-Z]{2,}|' + // domain
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // or IPv4
                '(\\:\\d+)?(\\/[-a-zA-Z\\d%@_.~+&:]*)*' + // port and path
                '(\\?[;&a-zA-Z\\d%@_.,~+&:=-]*)?' + // query string
                '(\\#[-a-zA-Z\\d_]*)?$', 'i' // fragment locator
            );

            // Return true if the URL matches the pattern
            return urlPattern.test(url);
        }

        function openLink(videoUrl, teach_m_id, owner) {
            let iframeSrc = '';

            // Check if the URL is from YouTube
            if (videoUrl.includes("youtube.com") || videoUrl.includes("youtu.be")) {
                const videoId = videoUrl.split("v=")[1] || videoUrl.split("/")[3];
                iframeSrc = `https://www.youtube.com/embed/${videoId}`;
            }
            // Check if the URL is from Vimeo
            else if (videoUrl.includes("vimeo.com")) {
                const videoId = videoUrl.split(".com/")[1];
                iframeSrc = `https://player.vimeo.com/video/${videoId}`;
            }
            // Check if it's a direct video file (e.g., .mp4, .webm)
            else if (videoUrl.endsWith(".mp4") || videoUrl.endsWith(".webm")) {
                iframeSrc = videoUrl; // Direct video link
            }
            // Fallback for general URLs
            else {
                iframeSrc = videoUrl; // General video link
            }

            console.log(iframeSrc);

            // Set the iframe src
            document.getElementById('video-iframe').src = iframeSrc;

            $('#show-modal-video').click();
            console.log(owner);
            openViews(teach_m_id, link, owner);
        }

        // Clear the iframe when the modal is closed
        $('#modal-video').on('hidden.bs.modal', function() {
            $('#video-iframe').attr('src', ''); // Clear video URL when modal is closed
        });


        function deleteTeachMore(teach_m_id, teach_file) {
            if (confirm('ต้องการลบการสอนเสริมนี้หรือไม่?')) {
                $.ajax({
                    type: "POST",
                    url: "controllers/teach_more_controller",
                    data: {
                        deleteTeachMore: true,
                        teach_m_id: teach_m_id,
                        teach_file: teach_file
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
            $('#teach_class').val() != '' ? param += '&std_class=' + $('#teach_class').val() : '';
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

        function openViews(teach_m_id, link, owner) {
            if (owner) {
                return;
            }
            $.ajax({
                type: "POST",
                url: "controllers/teach_more_controller",
                data: {
                    viewsUpdate: true,
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
    </script>
</body>

</html>