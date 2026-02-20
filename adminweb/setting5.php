<?php
include "../config/class_database.php";
$DB = new Class_Database();

function sanitizeLinkOrIframe($input)
{
    // ตรวจสอบว่าเป็น iframe ที่อนุญาต (Google Docs / YouTube)
    if (preg_match('/<iframe[^>]+src="https:\/\/(docs\.google\.com|www\.youtube\.com)[^"]+"[^>]*><\/iframe>/i', $input)) {
        return $input; // iframe ถูกต้อง
    }

    // ถ้าเป็นลิงก์ธรรมดา ตรวจสอบว่าเป็น URL ที่ปลอดภัย
    if (filter_var($input, FILTER_VALIDATE_URL)) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // escape ป้องกัน XSS
    }

    return '#'; // ถ้าไม่ผ่านเงื่อนไขใดเลย
}

if (isset($_POST['mode']) && $_POST['mode'] === 'setting_menu') {
    $menu_id = $_POST['menu_id'];
    $menu_name = $_POST['menu_name'];

    $link_raw = $_POST['link'];
    $link = sanitizeLinkOrIframe($link_raw);
    $sub_menu = $_POST['sub_menu'];

    $menu_color = $_POST['menu_color'];

    // ตรวจสอบความถูกต้องเบื้องต้น
    if (empty($menu_name)) {
        echo json_encode([
            'success' => false,
            'msg' => 'กรุณากรอกชื่อเมนูให้ครบถ้วน'
        ]);
        exit;
    }

    if ($menu_id == 0) {
        $sql = "SELECT count(*) c FROM am_menu_left";
        $countMenu = $DB->Query($sql, []);
        $countMenu = json_decode($countMenu, true);
        $countMenu = $countMenu[0];
        $countMenu = $countMenu['c'];

        // เตรียม SQL สำหรับเพิ่ม
        $sql = "INSERT INTO am_menu_left (menu_name, link, menu_color, `sub_menu`, menu_order) VALUES (?, ?, ?, ?, ?)";
        // รันคำสั่ง update
        $result = $DB->Insert($sql, [
            $menu_name,
            $link,
            $menu_color,
            $sub_menu,
            $countMenu + 1
        ]);
    } else {
        // เตรียม SQL สำหรับอัปเดต
        $sql = "UPDATE am_menu_left 
            SET menu_name = ?, link = ?, menu_color = ?, sub_menu = ?
            WHERE menu_id = ?";

        // รันคำสั่ง update
        $result = $DB->Update($sql, [
            $menu_name,
            $link,
            $menu_color,
            $sub_menu,
            $menu_id
        ]);
    }
    // ตรวจสอบผลลัพธ์
    echo json_encode([
        'success' => $result == 1,
        'msg' => $result == 1 ? 'อัปเดตเมนูสำเร็จ' : 'ไม่สามารถอัปเดตเมนูได้'
    ]);

    exit;
}

if (isset($_POST['mode']) && $_POST['mode'] === 'getMenuById') {
    $menu_id = $_POST['menu_id'];
    $sql = "SELECT * FROM am_menu_left WHERE `menu_id` = :menu_id";
    $menuList = $DB->Query($sql, ["menu_id" => $menu_id]);
    echo $menuList;
    exit();
}


if (isset($_POST['mode']) && $_POST['mode'] === 'deleteMenu') {
    $menu_id = $_POST['menu_id'];
    $stmt = $DB->Delete("DELETE FROM am_menu_left WHERE menu_id = :menu_id", ["menu_id" => $menu_id]);
    echo "ลบเมนูสำเร็จ";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode']) && $_POST['mode'] === 'updateOrder') {

    $menu_order = $_POST['menu_order'];
    foreach ($menu_order as $index => $menu) {
        $result = $DB->Update("UPDATE am_menu_left SET menu_order = ? WHERE menu_id = ?", [
            $menu['order'],
            $menu['menu_id']
        ]);
    }

    echo json_encode(['status' => 'success']);
}

?>

<?php include 'include/check_login.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ตั้งค่าเมนู</title>
    <style>
        .video-container video {
            /* Makes video responsive */
            height: 15rem;
            /* Maintains aspect ratio */
            display: block;
            /* Prevents extra spacing issues */
            border-radius: 10px;
            /* Optional: Adds rounded corners */
        }

        input[type="color"] {
            height: 33px;
        }

        .sortable-placeholder {
            background: #f0f0f0;
            height: 50px;
        }

        .ui-sortable-helper {
            background: #e9ecef;
        }

        .table tbody tr td {
            padding: 0 5px;
            align-content: center;
        }
    </style>
    <?php include 'include/scripts.php'; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
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
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h4 class="box-title">ตั้งค่าเมนู</h4>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <?php
                                    $sql = "SELECT * FROM am_menu_left WHERE sub_menu = 0 ORDER BY menu_id ASC";
                                    $menuListNoSub = $DB->Query($sql, []);
                                    $menuListNoSub = json_decode($menuListNoSub, true);
                                    $menuListNoSub = $menuListNoSub;

                                    $sql = "SELECT m.*, mm.menu_name as sub_menu_name FROM am_menu_left m LEFT JOIN am_menu_left mm ON m.sub_menu = mm.menu_id ORDER BY menu_order ASC";
                                    $menuList = $DB->Query($sql, []);
                                    $menuList = json_decode($menuList, true);
                                    $menuList = $menuList;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12" id="menuForm" style="margin-bottom: 15px;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="hidden" name="menu_id" id="menu_id" value="0">
                                                        <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="ชื่อเมนูใหม่">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="link" id="link" placeholder="ลิงค์">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control" id="sub_menu" name="sub_menu">
                                                            <option value="0">ไม่อยู่ในเมนู</option>
                                                            <?php foreach ($menuListNoSub as $index => $menu_item) { ?>
                                                                <option value="<?php echo $menu_item['menu_id']; ?>"><?php echo $menu_item['menu_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <input type="color" class="form-control" name="menu_color" id="menu_color">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-rounded btn-primary btn-outline"
                                                        style="width: 100%;height: 33px;padding-top: 5px;"
                                                        onclick="updateMenu(this)">
                                                        <i class="ti-save-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 no-padding">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover sortable-table" style="font-size: 14px;">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th style="width: 10px;">ย้าย</th>
                                                            <th style="width: 150px;">ชื่อเมนู</th>
                                                            <th style="width: 300px;">ลิงค์</th>
                                                            <th style="width: 150px;">อยู่ภายใต้เมนู</th>
                                                            <th style="width: 10px;">สี</th>
                                                            <th style="width: 10px;" class="text-center">จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="menuTableBody">
                                                        <?php foreach ($menuList as $index => $menu_item) { ?>
                                                            <tr data-menu_id="<?php echo $menu_item['menu_id']; ?>">
                                                                <td class="text-center"><i class="fa fa-bars handle" style="cursor: grab;"></i></td>
                                                                <td>
                                                                    <?php echo $menu_item['menu_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities(sanitizeLinkOrIframe($menu_item['link'])); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $menu_item['sub_menu_name']; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <i class="fa fa-square" style="color: <?php echo $menu_item['menu_color']; ?>;font-size: 24px"></i>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-rounded btn-warning btn-outline editMenu">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-rounded btn-danger btn-outline deleteMenu">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

</body>
<script>
    $(function() {
        $("#menuTableBody").sortable({
            handle: ".handle",
            placeholder: "sortable-placeholder",
            update: function(event, ui) {
                let orderedIds = [];
                $("#menuTableBody tr").each(function(i, ele) {
                    orderedIds.push({
                        menu_id: $(this).data("menu_id"),
                        order: i + 1
                    });
                });

                $.post('', {
                    menu_order: orderedIds,
                    mode: "updateOrder"
                }, function(res) {
                    console.log("Order updated");
                });
            }
        });
    });

    function updateMenu(buttonElement) {
        // ป้องกัน form submit ถ้ามี
        event.preventDefault();

        // หาจุดอ้างอิง element แม่ (row) ที่มี input
        const parentRow = $(buttonElement).closest(".row");

        // สร้าง FormData
        const formData = new FormData();
        formData.append("mode", "setting_menu");

        // เก็บค่าจาก input ใน parentRow
        const menuName = parentRow.find('input[name="menu_name"]').val();
        const link = parentRow.find('input[name="link"]').val();
        const menuColor = parentRow.find('input[name="menu_color"]').val();
        const sub_menu = parentRow.find('#sub_menu').val();
        const menu_id = parentRow.find('input[name="menu_id"]').val();

        formData.append("menu_id", menu_id);
        formData.append("menu_name", menuName);
        formData.append("link", link);
        formData.append("menu_color", menuColor);
        formData.append("sub_menu", sub_menu);

        // ส่ง AJAX
        $.ajax({
            type: "POST",
            url: "",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(json) {
                console.log(json);
                alert(json.msg);
                if (json.success) {
                    window.location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("เกิดข้อผิดพลาด: " + xhr.responseText);
            }
        });
    }


    $(document).on('click', '.editMenu', function() {
        let menu_id = $(this).closest('tr').data('menu_id');
        $.post('', {
            mode: 'getMenuById',
            menu_id: menu_id
        }, function(res) {
            res = JSON.parse(res);
            res = res[0];
            $('#menu_id').val(res['menu_id']);
            $('#menu_name').val(res['menu_name']);
            $('#link').val(res['link']);
            $('#menu_color').val(res['menu_color']);
            $('#sub_menu').val(res['sub_menu']);
            // Scroll to top smoothly
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    $(document).on('click', '.deleteMenu', function() {
        if (confirm('คุณต้องการลบเมนูนี้หรือไม่?')) {
            let menu_id = $(this).closest('tr').data('menu_id');
            $.post('', {
                mode: 'deleteMenu',
                menu_id: menu_id
            }, function(res) {
                alert(res);
                location.reload();
            });
        }
    });
</script>

</html>