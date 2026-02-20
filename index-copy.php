<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="images/logo-do-el.jpg">
    <link rel="apple-touch-icon" href="images/logo-do-el.jpg">

    <title>เมนูหลักระบบ</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="assets/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skin_color.css">
    <link rel="stylesheet" href="view-grade/css/main_std.css">
    <style>
        .admin-use {
            position: fixed;
            bottom: 5px;
            right: 5px;
            z-index: 9999;
        }

        .admin-use i {
            font-size: 36px;
        }

        .col-border {
            font-size: 30px;
        }

        .box-title-text {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            flex-direction: column;
        }

        .box-title-text h4 {
            font-size: 25px;
        }

        .content-header h3 {
            font-size: 2rem;
        }

        .icon-menu {
            width: 60px;
            height: 60px;
        }

        @media screen and (max-width: 365px) {
            .box-title-text h4 {
                font-size: 8px;
            }

            .box-title-text h6 {
                font-size: 6px;
            }
        }

        @media screen and (max-width: 600px) {
            .box-title-text h4 {
                font-size: 12px;
            }

            .box-title-text h6 {
                font-size: 10px;
            }

            .box-title-text {
                align-items: center;
                text-align: center;
                margin-left: 5px;
            }

            .content-header h3 {
                font-size: 14px;
            }

            .icon i {
                width: 30px;
                line-height: 30px;
            }

            .icon-menu {
                width: 30px;
                height: 30px;
            }
        }

        .main-footer {
            width: 100%;
            margin: 5px;
            padding-top: 5px;
            padding-bottom: 5px;
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translate(-50%, 0);
        }

        .flex-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 20px;
        }

        .flex-container>a {
            width: 500px;
        }
    </style>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary" style="position: relative;">

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0">
            <div class="container-full">
                <!-- Main content -->
                <div class="content-header pt-3">
                    <h3 class="text-center m-0 text-primary"><b>ระบบช่วยเหลือ</b></h3>
                    <h3 class="text-center m-0 text-primary"><b>ผู้เรียน ผู้สอน ผู้บริหาร</b></h3>
                    <h3 class="text-center m-0 text-primary"><b>กรมส่งเสริมการเรียนรู้</b></h3>
                </div>
                <section class="content">
                    <div class="container">
                        <div class="flex-container">
                            <a href="view-grade/login?system=visit-online">
                                <div class="box overflow-hidden" style="box-shadow: #ff6f00 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color: #ff6f00;">
                                            <i class="mr-0 font-size-20 fa fa-caret-square-o-right"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #ff6f00;"><b>ห้องเรียนออนไลน์</b></h4>
                                            <h6 class="m-0"><b>สำหรับนักศึกษา</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="view-grade/login?system=view-grade">
                                <div class="box overflow-hidden" style="box-shadow: blue 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color: blue;">
                                            <i class="mr-0 font-size-20 fa fa fa-bar-chart"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: blue;"><b>สืบค้นผลการเรียน</b></h4>
                                            <h6 class="m-0"><b>สำหรับนักศึกษา</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="flex-container">
                            <a href="view-grade/login?system=view-grade">
                                <div class="box overflow-hidden" style="box-shadow: #e50102 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color: #e50102;">
                                            <i class="mr-0 font-size-20 fa fa-floppy-o"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #e50102;"><b>บันทึกการเข้าร่วมกิจกรรม</b></h4>
                                            <h6 class="m-0"><b>สำหรับนักศึกษา</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="view-grade/login?system=visit-online">
                                <div class="box overflow-hidden" style="box-shadow: #dfa700 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color: #dfa700;">
                                            <i class="mr-0 font-size-20 fa fa-file-text"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #dfa700;"><b>บันทึกรายงานการสอน</b></h4>
                                            <h6 class="m-0"><b>สำหรับครูผู้สอน</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="flex-container">
                            <a href="view-grade/login?system=visit-online">
                                <div class="box overflow-hidden" style="box-shadow: #03a9f5 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color: #03a9f5;">
                                            <i class="mr-0 font-size-20 fa fa-file-text-o"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #03a9f5;"><b>บันทึกรายงานผลการปฏิบัติงาน</b></h4>
                                            <h6 class="m-0"><b>สำหรับครูผู้สอน</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="view-grade/login?system=visit-online">
                                <div class="box overflow-hidden" style="box-shadow: #9c28af 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color: #9c28af;">
                                            <i class="mr-0 font-size-20 fa fa-calendar"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #9c28af;"><b>นิเทศการสอน ติดตามการปฏิบัติงาน</b></h4>
                                            <h6 class="m-0"><b>สำหรับผู้บริหาร</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="flex-container">
                            <a href="view-grade/login?system=student-tracking">
                                <div class="box overflow-hidden" style="box-shadow: #4caf52 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color:  #4caf52;">
                                            <i class="mr-0 font-size-20 fa fa-address-book"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #4caf52;"><b>ระบบฐานข้อมูลนักศึกษา</b></h4>
                                            <h6 class="m-0"><b>สำหรับครูผู้สอน</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="view-grade/login?system=view-grade">
                                <div class="box overflow-hidden" style="box-shadow: #0277bd 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color:  #0277bd;">
                                            <i class="mr-0 font-size-20 fa fa-mortar-board"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #0277bd;"><b>แบบติดตามผู้สำเร็จการศึกษา</b></h4>
                                            <h6 class="m-0"><b>สำหรับครูผู้สอน</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="flex-container">
                            <a href="view-grade/login?system=student_list">
                                <div class="box overflow-hidden" style="box-shadow: #C70039 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color:  #C70039;">
                                            <i class="mr-0 font-size-20 fa fa-group (alias)"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #C70039;"><b>ข้อมูลและการนำเข้านักศึกษา</b></h4>
                                            <h6 class="m-0"><b>สำหรับครูผู้สอน</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="view-grade/login?system=visit-online">
                                <div class="box overflow-hidden" style="box-shadow: #8bc34a 0px 3px 8px;">
                                    <div class="box-body d-flex p-2">
                                        <div class="icon rounded-circle icon-menu" style="background-color:  #8bc34a;">
                                            <i class="mr-0 font-size-20 fa fa-bookmark"></i>
                                        </div>
                                        <div class="box-title-text">
                                            <h4 class="m-0" style="color: #8bc34a;"><b>ประเมินพนักงานราชการ</b></h4>
                                            <h6 class="m-0"><b>สำหรับผู้บริหาร</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- /.content -->

            </div>
        </div>
        <!-- /.content-wrapper -->

        <?php include "include/footer.php"; ?>
        <!-- /.control-sidebar -->
        <!-- Histats.com  (div with counter) -->
        <div class="row mt-4">
            <div class="col-md-12  text-center">
                <p>จำนวนผู้เข้าชม</p>
                <div id="histats_counter"></div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    <div class="admin-use">
        <a href="admin/login" title="แอดมินระบบ" onclick="alert('แจ้งเตือน\nเมนูนี้สำหรับผู้ดูแลระบบใช้งานเท่านั้น')"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
    </div>

    <!-- Vendor JS -->
    <script src="assets/js/vendors.min.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>

    <!-- Florence Admin App -->
    <script src="assets/js/template.js"></script>
    <script src="assets/js/demo.js"></script>

    <!-- Histats.com  START  (aync)-->
    <!-- <script type="text/javascript">
        var _Hasync = _Hasync || [];
        _Hasync.push(['Histats.start', '1,4797130,4,1032,150,25,00001000']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
            var hs = document.createElement('script');
            hs.type = 'text/javascript';
            hs.async = true;
            hs.src = ('//s10.histats.com/js15_as.js');
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();
    </script>
    <noscript>
        <a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?4797130&101" alt="free stats" border="0"></a>
    </noscript> -->
    <!-- Histats.com  END  -->

    <!-- Histats.com  START  (aync)-->
    <script type="text/javascript">
        var _Hasync = _Hasync || [];
        _Hasync.push(['Histats.start', '1,4797130,4,601,110,30,00001000']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
            var hs = document.createElement('script');
            hs.type = 'text/javascript';
            hs.async = true;
            hs.src = ('//s10.histats.com/js15_as.js');
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();
    </script>
    <noscript><a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?4797130&101" alt="" border="0"></a></noscript>
    <!-- Histats.com  END  -->
</body>

</html>