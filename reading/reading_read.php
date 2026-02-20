<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <?php include 'include/header.php'; ?>
    <title>ทดสอบอ่านออกเสียง</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .frame_media {
            height: <?php echo isset($_GET['test_read_id']) ? '70vh' : '100vh' ?>;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wav-converter"></script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">

                    <?php
                    include "../config/class_database.php";

                    $DB = new Class_Database();
                    $sql = "SELECT * FROM rd_medias rm\n" .
                        "WHERE\n" .
                        "rm.media_id = :media_id ";
                    $data = $DB->Query($sql, ['media_id' => $_GET['media_id']]);
                    $media_data = json_decode($data);
                    if (count($media_data) == 0) {
                        // echo "<script>location.href = '../404'</script>";
                    }
                    $media_data = $media_data[0];

                    // echo '<pre>';
                    // print_r($media_data);

                    // print_r($_SERVER['HTTP_HOST']);
                    // echo '</pre>';
                    ?>

                    <input type="hidden" id="test_read_id" name="test_read_id" value="<?php echo  isset($_GET['test_read_id']) ? $_GET['test_read_id'] : '' ?>">
                    <input type="hidden" id="media_id" name="media_id" value="<?php echo  $_GET['media_id'] ?>">

                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='index'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-book mr-15"></i>
                                            <b><?php echo isset($_GET['test_read_id']) ? 'ทดสอบอ่านออกเสียง' : 'สื่อการอ่าน ' . $media_data->media_name ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row" style="display: <?php echo isset($_GET['test_read_id']) ? 'flex' : 'none' ?>;">
                                        <div class="col-md-12">
                                            <h3><?php echo $media_data->test_reading_name ?></h3>
                                            <h4><?php echo $media_data->description ?></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-<?php echo isset($_GET['test_read_id']) ? '8' : '12' ?>">
                                            <button type="button" onclick="hardRefresh()" class="waves-effect waves-light btn btn-outline btn-warning mb-5" style="width: 100%;">รีโหลดสื่อ</button>
                                            <div class="frame_media">
                                                <!-- <iframe id="theFrame" src="https://docs.google.com/viewerng/viewer?url=<?php echo $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/reading/uploads/media/202403072670765e9f9be9e0ef.pdf" ?>&embedded=true" type="application/pdf" scrolling="auto" frameborder="1" width="100%" height="100%"></iframe> -->
                                                <iframe id="theFrame" src="uploads/media/<?php echo $media_data->media_file_name ?>" type="application/pdf" scrolling="auto" frameborder="1" width="100%" height="100%"></iframe>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-4" style="display: <?php echo isset($_GET['test_read_id']) ? 'block' : 'none' ?>;">
                                            <div class="row justify-content-center">
                                                <button class="waves-effect waves-light btn btn-app col-md-3 mx-1 btn-primary" id="recordButton">
                                                    <i class="fa fa-play"></i> บันทึก
                                                </button>
                                                <button class="waves-effect waves-light btn btn-app col-md-3 mx-1 btn-danger" id="stopButton">
                                                    <i class="fa fa-stop"></i> หยุด
                                                </button>
                                                <button class="waves-effect waves-light btn btn-app col-md-3 mx-1 btn-success" id="uploadAudio">
                                                    <i class="fa fa-save"></i> ส่งการสอบอ่าน
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="recordingsList">

                                                </div>
                                                <div class="col-md-12" id="durationDisplay" style="display: none;">

                                                </div>
                                                <input type="hidden" id="duration_time">
                                            </div>
                                            <button id="extractButton">Extract and Play</button>
                                            <div id="audioContainer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <!-- /.content -->
                <div class="preloader">
                    <?php include "../include/loader_include.php"; ?>
                </div>
                <?php include '../include/footer.php'; ?>
            </div>
        </div>
        <!-- /.content-wrapper -->


    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>

    <script>
        $(document).ready(async function() {
            setInterval(() => {
                sendToAddDuration()
            }, 5000);
        });

        function hardRefresh() {
            location.reload(true); // Reload the page, ignoring the cache
        }

        function sendToAddDuration() {
            $.ajax({
                type: "POST",
                url: "controllers/media_controller",
                data: {
                    addDurationView: true,
                    media_id: '<?php echo $_GET['media_id'] ?>',
                    mode: 'duration'
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                },
            });
        }
    </script>
</body>

</html>