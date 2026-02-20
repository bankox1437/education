<?php session_start();
if (isset($_SESSION['user_data'])) {
    if ($_SESSION['user_data']->role_id != 1) {
        header('location: ../');
        exit();
    }
    header('location: manage_admin');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>เข้าสู่ระบบ</title>

</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(images/bg-1.jpg)" data-overlay="5">

    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100">

            <div class="col-12">
                <div class="row justify-content-center no-gutters">
                    <div class="col-lg-6 col-md-5 col-12">
                        <div class="bg-white rounded30 shadow-lg">
                            <div class="content-top-agile p-20 pb-0">
                                <h4 class="text-primary"><?php echo isset($_SESSION['std_import']) ? 'ข้อมูลและการนำเข้านักศึกษา' : '' ?></h4>
                                <h4 class="mb-0">เข้าสู่ระบบ</h4>
                            </div>
                            <div class="p-40">
                                <form id="loginForm" action="index.html" method="post">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent">ชื่อผู้ใช้ &nbsp;</span>
                                            </div>
                                            <input type="text" id="username" class="form-control pl-15 bg-transparent" autocomplete="off" placeholder="Username" style="height: 50px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent">รหัสผ่าน</span>
                                            </div>
                                            <input type="password" id="password" class="form-control pl-15 bg-transparent" placeholder="Password" style="height: 50px;" maxlength="8">
                                        </div>
                                    </div>

                                    <!-- Checkbox จดจำ -->
                                    <div class="form-group form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">จดจำชื่อผู้ใช้และรหัสผ่าน</label>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-info mt-10" style="width: 80%;">เข้าสู่ระบบ</button>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <a href="<?php echo isset($_GET['system']) && $_GET['system'] == 'reading' ? '../reading/index' : '../main_menu' ?>">
                                                <p class="text-center"><i class="ti-arrow-left"></i> กลับหน้าหลัก</p>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script>
        const [form] = document.getElementsByTagName("form");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            console.log($("#username").val());
            const username = $("#username").val();
            const password = $("#password").val();
            $.ajax({
                type: "POST",
                url: "controllers/login_controller",
                data: {
                    login_method: true,
                    username: username,
                    password: password,
                },
                success: function(data) {
                    const json_data = JSON.parse(data);
                    alert(json_data.msg);
                    const rememberMe = document.getElementById("rememberMe").checked;

                    if (rememberMe) {
                        // เก็บข้อมูลลง localStorage
                        localStorage.setItem("username", username);
                        localStorage.setItem("password", password);
                        localStorage.setItem("rememberMe", true);
                    } else {
                        // ลบข้อมูลออก
                        localStorage.removeItem("username");
                        localStorage.removeItem("password");
                        localStorage.setItem("rememberMe", false);
                    }
                    
                    if (json_data.status) {
                        if (json_data.role_id == 0) {
                            location.href = "../";
                            return;
                        }
                        if (json_data.type == "adminweb") {
                            location.href = "../adminweb/settings_am";
                            return;
                        }
                        location.href = "manage_admin";
                    }
                },
            });
        });
    </script>
    <script>
        // โหลดข้อมูลจาก localStorage เมื่อเปิดหน้า
        window.onload = function() {
            const savedUsername = localStorage.getItem("username");
            const savedPassword = localStorage.getItem("password");
            const remember = localStorage.getItem("rememberMe");

            if (remember === "true") {
                document.getElementById("username").value = savedUsername || "";
                document.getElementById("password").value = savedPassword || "";
                document.getElementById("rememberMe").checked = true;
            }
        };
    </script>
</body>

</html>