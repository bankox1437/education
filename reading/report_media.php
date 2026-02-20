<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>รายงานเกี่ยวกับสื่อการอ่าน</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wav-converter"></script>
    <style>
        /* HTML: <div class="loader"></div> */
        .loader {
            width: 30px;
            aspect-ratio: 1;
            --_c: no-repeat radial-gradient(farthest-side, #25b09b 92%, #0000);
            background:
                var(--_c) top,
                var(--_c) left,
                var(--_c) right,
                var(--_c) bottom;
            background-size: 5px 5px;
            animation: l7 1s infinite;
        }

        @keyframes l7 {
            to {
                transform: rotate(.5turn)
            }
        }

        <?php if ($_SESSION['user_data']->role_id != 3) { ?>#table td {
            padding: 10px;
        }

        <?php } ?>.audio-play {
            display: flex;
            justify-content: center;
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
                                <div class="box-body no-padding">
                                    <div id="toolbar" class="row">
                                        <div class="col-12 d-flex align-items-center">
                                            <h4 class="mt-2">รายงานเกี่ยวกับสื่อการอ่าน</h4>
                                        </div>
                                        <div class="col-md-12 row align-items-center">
                                            <?php
                                            if ($_SESSION['user_data']->role_id == 1) { ?>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="province_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกจังหวัด</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <select class="form-control select2" id="district_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกอำเภอ</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            if ($_SESSION['user_data']->role_id == 1 || $_SESSION['user_data']->role_id == 2) { ?>
                                                <div class="col-md-4 mt-2" id="sub_dis">
                                                    <select class=" form-control select2" id="subdistrict_select" style="width: 100%;" onchange="getBywhere()">
                                                        <option value="0">เลือกตำบล</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <table id="table" data-icons="icons" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server" data-url="controllers/media_controller?getDataReportMedia=true">
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
        <button type="button" class="btn btn-primary" id="click-show-modal" data-toggle="modal" data-target="#modal-fill" style="visibility: hidden;">
        </button>
        <div class="modal fade bs-example-modal-lg" id="modal-fill" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">รายชื่อผู้เข้าอ่านสื่อ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="table-responsive">
                            <table class="table table-lg table-modal">
                                <thead>
                                    <tr>
                                        <th stylw="width:10%;" class="text-center">#</th>
                                        <th stylw="width:30%;" class="text-center">ไฟล์เสียง</th>
                                        <th stylw="width:30%;">ชื่อ</th>
                                        <th stylw="width:20%;">แหล่งที่มา</th>
                                        <th stylw="width:10%;" class="text-center">ระยะเวลาที่อ่าน</th>
                                    </tr>
                                </thead>
                                <tbody id="table-time">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>
    <script src="js/init-table/report_media.js?v=<?php echo $version ?>"></script>

    <script>
        $(document).ready(async function() {
            initTable()
            await getDataProDistSub();
            if (role_id == 1) {
                $('#province_select').select2()
                $('#district_select').select2()
                $('#subdistrict_select').select2()
            }
            $('.search input').attr('placeholder', 'ค้นหาด้วยชื่อสื่อ');
            $('.select2').on('select2:open', function(e) {
                // Find the input field and focus on it
                $(this).data('select2').$dropdown.find('.select2-search__field')[0].focus();
            });
        });

        function getBywhere() {
            const pro_id = $('#province_select').val() ?? 0
            const dis_id = $('#district_select').val() ?? 0
            const sub_dis_id = $('#subdistrict_select').val() ?? 0
            const format = $('#format').val() ?? 0;
            const term_id = $('#term_name').val() ?? 0;

            var urlWithParams = $table.data('url') + `&pro_id=${pro_id}&dis_id=${dis_id}&sub_dis_id=${sub_dis_id}` +
                '&format=' + format + '&term_id=' + term_id;
            $table.bootstrapTable('refreshOptions', {
                url: urlWithParams
            });
            $table.bootstrapTable('refresh');

        }

        async function getDataProDistSub() {
            $.ajax({
                type: "POST",
                url: "controllers/user_controller",
                data: {
                    getDataProDistSub: true,
                    table: "rd_medias"
                },
                dataType: "json",
                success: async function(json_data) {
                    main_provinces = json_data.data.provinces;
                    main_district = json_data.data.district;
                    main_sub_district_id = json_data.data.sub_district;
                    if (role_id == 1) {
                        const province_select = document.getElementById('province_select');
                        main_provinces.forEach((element, id) => {
                            province_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }

                    if (role_id == 2) {
                        let dis_id = '<?php echo $_SESSION['user_data']->district_am_id ?>';
                        const sub_name = document.getElementById('subdistrict_select');
                        sub_name.innerHTML = "";
                        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
                        $('#district_select_value').val(dis_id);
                        const sub_district = main_sub_district_id.filter((sub) => {
                            return sub.district_id == dis_id
                        })
                        sub_district.forEach((element, id) => {
                            sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                        });
                    }
                },
            });
        }

        $('#province_select').change((e) => {
            getDistrictByProvince(e.target.value)
        })

        function getDistrictByProvince(pro_id) {
            const district_select = document.getElementById('district_select');
            district_select.innerHTML = "";
            district_select.innerHTML += ` <option value="0">เลือกอำเภอ</option>`;
            const sub_name = document.getElementById('subdistrict_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const district = main_district.filter((dist) => {
                return dist.province_id == pro_id
            })
            district.forEach((element) => {
                district_select.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }
        $('#district_select').change((e) => {
            getSubDistrictByDistrict(e.target.value)
        })
        async function getSubDistrictByDistrict(dist_id) {
            const sub_name = document.getElementById('subdistrict_select');
            sub_name.innerHTML = "";
            sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
            const sub_district = main_sub_district_id.filter((sub) => {
                return sub.district_id == dist_id
            })
            sub_district.forEach((element, id) => {
                sub_name.innerHTML += ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
            });
        }

        let audioElements = [];

        function openModal(media_id) {
            $('#table-time').empty();
            $.ajax({
                type: "POST",
                url: "controllers/media_controller",
                data: {
                    getDataReportTimeOfMedia: true,
                    media_id: media_id
                },
                dataType: "json",
                success: async function(json_data) {
                    const list_std_read = json_data[0];
                    if (list_std_read.length == 0) {
                        $('#table-time').append(`   <tr>
                                                        <th colspan="5" class="text-center">ยังไม่มีข้อมูล</th>
                                                    </tr>`)
                        return false;
                    }
                    list_std_read.forEach(async (element, i) => {
                        $('#table-time').append(`   <tr>
                                                        <th stylw="width:10%;" class="text-center">${i+1}</th>
                                                        <td stylw="width:20%;" class="text-center"><div class="loader"></div><div id="audioContainer${i}" class="audio-play"></div></td>
                                                        <td stylw="width:30%;">${element.std_name}</td>
                                                        <td stylw="width:20%;">${element.test_reading_name}</td>
                                                        <td stylw="width:10%;" class="text-center" id="audioDuration${i}">กำลังโหลดไฟล์บันทึกเสียง</td>
                                                    </tr>`)
                        await getAudioWav(element.file_audio_test, i, element.type)
                    });

                },
            });
            document.getElementById('click-show-modal').click();
        }

        // Function to convert audio data to WAV format
        function convertToWav(audioData) {
            const wavHeader = new ArrayBuffer(44);
            const view = new DataView(wavHeader);

            // RIFF chunk descriptor
            view.setUint32(0, 0x52494646, false); // "RIFF"
            view.setUint32(4, 36 + audioData.byteLength, true); // Chunk size
            view.setUint32(8, 0x57415645, false); // "WAVE"

            // Format chunk
            view.setUint32(12, 0x666d7420, false); // "fmt "
            view.setUint32(16, 16, true); // Subchunk1Size
            view.setUint16(20, 1, true); // Audio format (1 for PCM)
            view.setUint16(22, 2, true); // Number of channels
            view.setUint32(24, 44100, true); // Sample rate
            view.setUint32(28, 44100 * 2 * 2, true); // Byte rate
            view.setUint16(32, 4, true); // Block align
            view.setUint16(34, 16, true); // Bits per sample

            // Data chunk
            view.setUint32(36, 0x64617461, false); // "data"
            view.setUint32(40, audioData.byteLength, true); // Subchunk2Size

            const wavData = new Uint8Array(wavHeader.byteLength + audioData.byteLength);
            wavData.set(new Uint8Array(wavHeader), 0);
            wavData.set(new Uint8Array(audioData), wavHeader.byteLength);

            return wavData.buffer;
        }

        // async function getAudioFromZip(zipFile, index) {
        //     const zipFilePath = 'uploads/audio_test/' + zipFile; // Specify the path to your zip file here
        //     const response = await fetch(zipFilePath);
        //     const zipFileData = await response.arrayBuffer();

        //     const zip = new JSZip();
        //     const zipData = await zip.loadAsync(zipFileData);

        //     const audioContainer = document.getElementById('audioContainer' + index);
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
        // }

        async function getAudioWav(wavFile, index, type) {
            let folderType = "audio_test_resize";
            if (type == '1') {
                folderType = "audio_test";
            }
            const wavFilePath = 'uploads/' + folderType + '/' + wavFile;

            const audioContainer = document.getElementById('audioContainer' + index);
            audioContainer.innerHTML = '';

            try {
                const response = await fetch(wavFilePath);

                // Check if it's a ZIP archive
                if (response.headers.get('Content-Type').includes('application/zip')) {
                    const zipFileData = await response.arrayBuffer();

                    const zip = new JSZip();
                    const zipData = await zip.loadAsync(zipFileData);
                    zip.forEach(async (relativePath, zipEntry) => {
                        if (zipEntry.dir) return; // Skip directories

                        const fileData = await zip.file(zipEntry.name).async('arraybuffer');
                        const wavBlob = convertToWav(fileData);

                        createAudioElement(new Blob([wavBlob]), audioContainer, index);
                    });
                } else {
                    // Handle direct WAV file
                    const wavBlob = await response.blob();
                    createAudioElement(wavBlob, audioContainer, index)

                }
            } catch (error) {
                console.error('Error loading WAV file:', error);
                // Handle error appropriately, e.g., display a message
            }
        }

        function createAudioElement(wavBlob, audioContainer, index) {
            const audioElement = document.createElement('audio');
            audioElement.controls = true;
            audioElement.src = URL.createObjectURL(wavBlob); // No need to specify type for Blob
            audioContainer.appendChild(audioElement);
            audioElements.push(audioElement);
            audioElement.addEventListener('loadedmetadata', function() {
                const seconds = audioElement.duration.toFixed(2);
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);
                $("#audioDuration" + index).html(`${minutes}.${remainingSeconds} นาที`);
                console.log("#audioDuration" + index);
            });
            setTimeout(() => {
                $('.loader').hide();
            }, 2000);
        }

        $('.close').click((e) => {
            // Close the modal (implement your modal closing logic here)
            audioElements.forEach(audio => {
                audio.pause(); // Pause each audio element
            });
        })
    </script>
</body>

</html>