<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ข้อมูลส่วนตัวครู</title>
    <style>
        /* .tooltip-custom {
            cursor: pointer;
        }

        .tooltiptext {
            display: none;
        } */

        .tooltip-custom {
            cursor: pointer;
            position: relative;
        }

        .tooltip-custom:before {
            content: attr(data-text);
            /* here's the magic */
            position: absolute;

            /* vertically center */
            top: 50%;
            transform: translateY(-50%);

            /* move to right */
            left: 100%;
            margin-left: 15px;
            /* and add a small left margin */

            /* basic styles */
            width: 200px;
            padding: 10px;
            border-radius: 10px;
            background: #5949d6;
            color: #fff;
            text-align: left;

            display: none;
            /* hide by default */
        }

        .tooltip-custom:hover:before {
            display: block;
        }

        .table thead tr th {
            padding: 3px 3px !important;
            align-content: center;
        }

        .table tbody tr td {
            padding: 3px 3px;
            align-content: center;
        }

        .fixed-table-toolbar {
            padding: unset;
        }

        .fixed-table-body {
            overflow-y: unset !important;
            overflow-x: unset !important;
        }

        .bootstrap-table .fixed-table-container.fixed-height:not(.has-footer) {
            border-bottom: 0px !important;
        }

        /* Smartphones (portrait) ----------- */
        @media only screen and (max-width : 769px) {
            .flatpickr-mobile {
                display: none;
            }
        }
    </style>
    <!-- Include Flatpickr library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <?php include 'include/scripts.php'; ?>
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
                        <?php
                        $prodissubBack = "";
                        if (isset($_GET['pro'])) {
                            $prodissubBack = "?pro=" . $_GET['pro'] . "&dis=" . $_GET['dis'] . "&sub=" . $_GET['sub'];
                        }
                        ?>
                        <h4 class="box-body text-info col-md-10 text-left" style="margin: 0;">
                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='<?php echo empty($_GET['url']) ? 'manage_admin' : $_GET['url'] . $prodissubBack; ?>'"></i>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-address-card-o mr-15"></i> <b>ข้อมูลส่วนตัวครู</b>
                        </h4>
                    </div>
                    <div class="row">

                        <?php
                        include "../config/class_database.php";
                        $DB = new Class_Database();

                        $enabledRole = [2, 6];
                        $isRead = (in_array($_SESSION['user_data']->role_id, $enabledRole) && isset($_GET['user_id']));

                        include("include/personal/info.php");
                        include("include/personal/info_training.php");
                        include("include/personal/training_scout.php");
                        include("include/personal/info_lecturer.php");
                        include("include/personal/info_academic_work.php");
                        include("include/personal/royal.php");
                        include("include/personal/info_community.php");
                        include("include/personal/info_submission.php");

                        ?>
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
    <script>
        $(document).ready(async function() {

            let dateEle = [{
                id: "birthday"
            }, {
                id: "start_work"
            }, {
                id: "training_date"
            }, {
                id: "get_royal"
            }, {
                id: "date_get_royal"
            }, {
                id: "training_scout_date"
            }, {
                id: "lecturer_date"
            }];

            for (const ele of dateEle) {
                let d = new Date();
                let toDay = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
                initFlatpickr(ele.id, toDay)
            }

            setWidthTable();
        });

        function setlabelFilename(id) {
            const file = document.getElementById(id).files[0];
            document.getElementById(id + '_label').innerText = file.name;
        }

        function hideInputDate(main, text) {
            $("#" + main).show();
            $("#" + main).focus();
            $("#" + text).hide();

            const input1 = $('.form-date-' + main).find('input').eq(1);
            const input2 = $('.form-date-' + main).find('input').eq(2);
            if (input2) {
                $(input2).show();
                $(input2).focus();
            }
        }

        function formatToBuddhistDate(gregorianDate) {
            // Create a Date object from the Gregorian date
            const date = gregorianDate != '' ? new Date(gregorianDate) : new Date()

            // Get the day, month, and year from the Date object
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const year = date.getFullYear() + 543; // Convert to Buddhist year

            // Format the date as d-m-y
            return `${day}-${month}-${year}`;
        }

        function initFlatpickr(selector, date) {
            setTimeout(() => {
                let dateObj = date != '' ? new Date(date) : new Date();
                let fp = flatpickr("#" + selector, {
                    enableTime: true,
                    dateFormat: "Y-m-d",
                    time_24hr: true,
                    locale: "th",
                    onClose: function(selectedDates, dateStr, instance) {
                        $("#" + selector + 'Text').show();
                        $("#" + selector).hide();
                        const buddhistDate = formatToBuddhistDate(dateStr);
                        $("#" + selector + 'Text').val(buddhistDate);

                        const input2 = $('.form-date-' + selector).find('input').eq(2);
                        if (input2) {
                            $(input2).hide();
                        }
                    }
                });

                fp.setDate(dateObj);
                const buddhistDate = formatToBuddhistDate(date);
                $("#" + selector + 'Text').val(buddhistDate);
                $("#" + selector).removeAttr('readonly');
            }, 200);
        }


        function setWidthTable() {
            setTimeout(() => {
                $('.fixed-table-container').each(function() {
                    // Get the .fixed-table-loading width within this box
                    let bodyWidth = $(this).find('.fixed-table-body .fixed-table-loading').width();

                    // Set the .fixed-table-header table width to match the .fixed-table-loading width
                    $(this).find('.fixed-table-header table').css('width', bodyWidth + 'px');
                });
            }, 2000);
        }
    </script>
</body>

</html>