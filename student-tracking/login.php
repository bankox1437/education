<?php session_start();
if (isset($_SESSION['user_data'])) header('location: dashboard'); ?>
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
                                <h2 class="text-primary">ระบบฐานข้อมูลนักศึกษา</h2>
                                <h2 class="mb-0">เข้าสู่ระบบ</h2>
                            </div>
                            <div class="p-40">
                                <form action="index.html" method="post">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <!-- <span class="input-group-text bg-transparent"><i class="ti-user"></i></span> -->
                                                <span class="input-group-text  bg-transparent">ชื่อผู้ใช้ &nbsp;</span>
                                            </div>
                                            <input type="text" id="username" value="" class="form-control pl-15 bg-transparent" autocomplete="off" placeholder="Username" style="height: 50px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <!-- <span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span> -->
                                                <span class="input-group-text  bg-transparent">รหัสผ่าน</span>
                                            </div>
                                            <input type="text" id="password" value="" class="form-control pl-15 bg-transparent" placeholder="Password" style="height: 50px;" maxlength="8">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-info mt-10" style="width: 80%;">เข้าสู่ระบบ</button>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <a href="../"><p class="text-center"><i class="ti-arrow-left"></i> กลับหน้าหลัก</p></a>
                                        </div>
                                        <!-- /.col -->
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
    <script src="js/view_js/login.js"></script>
</body>

</html>