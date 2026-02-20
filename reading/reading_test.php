<?php //include 'include/check_login.php'; ?>
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

        <?php include '../include/nav-header.php'; ?>

        <!-- Left side column. contains the logo and sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin: 0;">
            <div class="container-full">
                <!-- Main content -->
                <section class="content" id="section_content" style="display: none;">

                    <?php
                    include "../config/class_database.php";

                    $whereTestId = "";

                    if (isset($_GET['test_read_id'])) {
                        $whereTestId = " AND rt.test_read_id = " . $_GET['test_read_id'];
                    }

                    $DB = new Class_Database();
                    $sql = "SELECT * FROM rd_medias rm\n" .
                        "WHERE\n" .
                        "media_id = :media_id " . $whereTestId;
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
                                        <h4 class="box-title text-info col-md-10 text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='manage_test_reading'"></i>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="ti-book mr-15"></i>
                                            <b><?php echo isset($_GET['test_read_id']) ? 'ทดสอบอ่านออกเสียง' : 'สื่อการอ่าน ' . $media_data->media_name ?></b>
                                        </h4>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row" style="display: <?php echo isset($_GET['test_read_id']) ? 'flex' : 'none' ?>;">
                                        <div class="col-md-12">
                                            <h3><?php echo $media_data->media_name ?></h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-<?php echo isset($_GET['read']) && $_GET['read'] == 0 ? '8' : '12' ?>">
                                            <button type="button" onclick="hardRefresh()" class="waves-effect waves-light btn btn-outline btn-warning mb-5" style="width: 100%;">รีโหลดสื่อ</button>
                                            <div class="frame_media">
                                                <!-- <iframe id="theFrame" src="https://docs.google.com/viewerng/viewer?url=<?php echo $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/reading/uploads/media/" . $media_data->media_file_name ?>&embedded=true" type="application/pdf" scrolling="auto" frameborder="1" width="100%" height="100%"></iframe> -->
                                                <iframe id="theFrame" src="uploads/media/<?php echo $media_data->media_file_name ?>" type="application/pdf" scrolling="auto" frameborder="1" width="100%" height="100%"></iframe>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-4" style="display: <?php echo isset($_GET['read']) && $_GET['read'] == 0 ? 'block' : 'none' ?>;">
                                            <div class="row justify-content-center">
                                                <button class="waves-effect waves-light btn btn-app col-md-3 mx-1 btn-primary" id="recordButton">
                                                    <i class="fa fa-play"></i> บันทึก
                                                </button>
                                                <button class="waves-effect waves-light btn btn-app col-md-3 mx-1 btn-danger" id="stopButton">
                                                    <i class="fa fa-stop"></i> หยุด
                                                </button>
                                                <button class="waves-effect waves-light btn btn-app col-md-3 mx-1 btn-success" id="uploadAudio">
                                                    <i class="fa fa-save"></i> ส่งผลการอ่าน
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="recordingsList">

                                                </div>
                                                <div class="col-md-12" id="durationDisplay" style="display: none;">

                                                </div>
                                                <input type="hidden" id="duration_time">
                                            </div>
                                            <!-- <button id="extractButton">Extract and Play</button>
                                            <div id="audioContainer"></div> -->
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

        <button type="button" class="btn btn-primary" id="loading-upload" data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false" style="visibility: hidden;"></button>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Small modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div> -->
                    <div class="modal-body text-center">
                        <p> กำลังอัปโหลดไฟล์เสียง </p>
                        <p> และบันทึกการสอบอ่านออกเสียง </p>
                        <p> กรุณารอสักครู่ . . . </p>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>

    <script src="js/WebAudioRecorder.min.js?v=<?php echo $version ?>"></script>
    <script src="js/app.js?v=<?php echo $version ?>"></script>

    <script>
        <?php if (isset($_GET['read']) && $_GET['read'] != 0) { ?>
            $(document).ready(async function() {
                setInterval(() => {
                    sendToAddDuration()
                }, 5000);
            });
        <?php } ?>

        function hardRefresh() {
            location.reload(true); // Reload the page, ignoring the cache
        }

        $('#uploadAudio').click(function() {
            const confirmation = window.confirm("ต้องการบันทึกการสอบอ่านออกเสียงหรือไม่?");
            if (confirmation) {
                const test_read_id = $('#test_read_id').val();
                const media_id = $('#media_id').val();
                const duration = $('#duration_time').val();

                const formData = new FormData();
                if (!audioBlob) {
                    alert('โปรดบันทึกเสียงของคุณก่อนส่ง');
                    return;
                }
                formData.append('audio', audioBlob, 'audio.wav');
                formData.append('test_read_id', test_read_id);
                formData.append('media_id', media_id);
                formData.append('duration', duration);
                formData.append('upload_audio_test', true);
                $('#loading-upload').click();
                $.ajax({
                    url: 'controllers/media_controller',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        // alert('Audio uploaded successfully!');
                        console.log(data);
                        alert(data.msg);
                        if (data.status) {
                            location.href = 'manage_test_reading';
                        }
                    }
                });
            }
        });

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


        // // Function to convert audio data to WAV format
        // function convertToWav(audioData) {
        //     const wavHeader = new ArrayBuffer(44);
        //     const view = new DataView(wavHeader);

        //     // RIFF chunk descriptor
        //     view.setUint32(0, 0x52494646, false); // "RIFF"
        //     view.setUint32(4, 36 + audioData.byteLength, true); // Chunk size
        //     view.setUint32(8, 0x57415645, false); // "WAVE"

        //     // Format chunk
        //     view.setUint32(12, 0x666d7420, false); // "fmt "
        //     view.setUint32(16, 16, true); // Subchunk1Size
        //     view.setUint16(20, 1, true); // Audio format (1 for PCM)
        //     view.setUint16(22, 2, true); // Number of channels
        //     view.setUint32(24, 44100, true); // Sample rate
        //     view.setUint32(28, 44100 * 2 * 2, true); // Byte rate
        //     view.setUint16(32, 4, true); // Block align
        //     view.setUint16(34, 16, true); // Bits per sample

        //     // Data chunk
        //     view.setUint32(36, 0x64617461, false); // "data"
        //     view.setUint32(40, audioData.byteLength, true); // Subchunk2Size

        //     const wavData = new Uint8Array(wavHeader.byteLength + audioData.byteLength);
        //     wavData.set(new Uint8Array(wavHeader), 0);
        //     wavData.set(new Uint8Array(audioData), wavHeader.byteLength);

        //     return wavData.buffer;
        // }

        // document.getElementById('extractButton').addEventListener('click', async () => {
        //     const zipFilePath = 'uploads/audio_test_resize/202403092668565ecbaf7697c3.wav.zip'; // Specify the path to your zip file here
        //     const response = await fetch(zipFilePath);
        //     const zipFileData = await response.arrayBuffer();

        //     const zip = new JSZip();
        //     const zipData = await zip.loadAsync(zipFileData);

        //     const audioContainer = document.getElementById('audioContainer');
        //     audioContainer.innerHTML = '';

        //     zip.forEach(async (relativePath, zipEntry) => {
        //         if (zipEntry.dir) return; // Skip directories

        //         const fileData = await zip.file(zipEntry.name).async('arraybuffer');
        //         const wavBlob = convertToWav(fileData);

        //         const audioElement = document.createElement('audio');
        //         audioElement.controls = true;
        //         audioElement.src = URL.createObjectURL(new Blob([wavBlob], {
        //             type: 'audio/wav'
        //         }));

        //         audioContainer.appendChild(audioElement);
        //     });
        // });
    </script>
</body>

</html>