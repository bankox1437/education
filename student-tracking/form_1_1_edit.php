<?php include 'include/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/header.php'; ?>
    <title>ฟอร์มแก้ไขข้อมูลนักศึกษารายบุคคล</title>
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary">

    <div class="wrapper">

        <?php include '../include/nav-header.php'; ?>

        <?php include 'include/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-full">

                <!-- Main content -->
                <section class="content" id="section_content">
                    <div class="row">
                        <div class="row" id="no_data" style="display: none;">
                        <div class="col-12 d-flex justify-content-center">
                            <h4>ไม่พบข้อมูล</h4>
                        </div>
                    </div>
                    <div class="row" id="row_form">
                        <div class="col-12">
                            <form id="form-edit-student">
                                <div class="box">
                                    <div class="box-body">
                                        <h6 class="box-title text-info" style="margin: 0;">
                                            <i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href='form1_1'"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="ti-user mr-15"></i> <b>ฟอร์มแก้ไขข้อมูลนักศึกษารายบุคคล</b>
                                        </h6>
                                        <hr class="my-15">
                                       
                                        <div class="row">
                                             <input type="hidden" name="std_p_id" id="std_p_id">
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label><b>4.</b> มีพี่น้อง<b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="num_siblings" id="num_siblings" autocomplete="off" placeholder="กรุณากรอกจำนวนพี่น้อง">
                                                    <input type="hidden" name="addStudentPerson">
                                                   
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label>มีน้อง <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="num_younger" id="num_younger" autocomplete="off" placeholder="กรุณากรอกจำนวนน้อง">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label>นักศึกษาเป็นบุตรคนที่ <b class="text-danger">*</b></label>
                                                    <input type="number" class="form-control height-input" name="num_son" id="num_son" autocomplete="off" placeholder="กรุณากรอกลำดับบุตร">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group row">
                                                    <label>ความสัมพันธ์ระหว่างนักศึกษากับพี่น้อง<b class="text-danger">*</b></label><br>
                                                    <input type="text" class="form-control height-input" name="relation" id="relation" autocomplete="off" placeholder="กรุณากรอกความสัมพันธ์ระหว่างนักศึกษากับพี่น้อง">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>5.</b> ชีวิตปัจจุบันอาศัยอยู่กับ<b class="text-danger">*</b></label>
                                                    <!-- <input type="text" class="form-control height-input" name="live_present" id="live_present" autocomplete="off" placeholder="กรุณากรอกชีวิตปัจจุบันอาศัยอยู่กับ"> -->
                                                    <select class="form-control" name="live_present" id="live_present">
                                                        <option value="อยู่กับพ่อแม่">อยู่กับพ่อแม่</option>
                                                        <option value="อยู่กับแม่">อยู่กับแม่</option>
                                                        <option value="อยู่กับพ่อ">อยู่กับพ่อ</option>
                                                        <option value="อยู่ลำพัง">อยู่ลำพัง</option>
                                                        <option value="อยู่กับคนอื่น">อยู่กับคนอื่น</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>6.</b> ความรู้สึกที่นักศึกษามีต่อตนเอง <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="feel_me" id="feel_me" autocomplete="off" placeholder="กรุณากรอกความรู้สึกที่นักศึกษามีต่อตนเอง">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>7.</b> เพื่อนที่สนิทที่สุดของนักศึกษา (ชื่อ-สกุล) <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="best_friend_name" id="best_friend_name" autocomplete="off" placeholder="กรุณากรอกเพื่อนที่สนิทที่สุดของนักศึกษา">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label><b>8.</b> สิ่งที่นักศึกษาอยากได้จากคนรอบข้าง (พ่อ แม่ พี่
                                                        น้อง เพื่อน
                                                        ฯลฯ)<b class="text-danger">*</b></label><br>
                                                    <input type="text" class="form-control height-input" name="want_around_people" id="want_around_people" autocomplete="off" placeholder="กรุณากรอกสิ่งที่นักศึกษาอยากได้จากคนรอบข้าง">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>9.</b> สิ่งที่นักศึกษากลัวเวลาอยู่ร่วมกับผู้อื่น<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="afraid_others" id="afraid_others" autocomplete="off" placeholder="กรุณากรอกสิ่งที่นักศึกษากลัวเวลาอยู่ร่วมกับผู้อื่น">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>10.</b> สิ่งที่นักศึกษาชอบ / พอใจเกี่ยวกับตัวเอง <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="life_myseft" id="life_myseft" autocomplete="off" placeholder="กรุณากรอกสิ่งที่นักศึกษาชอบ / พอใจเกี่ยวกับตัวเอง">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>11.</b> สิ่งที่นักศึกษาไม่ชอบที่เกี่ยวกับตัวเอง <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="not_life_myseft" id="not_life_myseft" autocomplete="off" placeholder="กรุณากรอกสิ่งที่นักศึกษาไม่ชอบที่เกี่ยวกับตัวเอง">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>12.</b> สิ่งที่นักศึกษาอยากปรับปรุง / แก้ไขตนเอง<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="want_improve" id="want_improve" autocomplete="off" placeholder="กรุณากรอกสิ่งที่นักศึกษาอยากปรับปรุง / แก้ไขตนเอง">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>13.</b> ความภาคภูมิใจ / ความสำเร็จของนักศึกษา<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="pride" id="pride" autocomplete="off" placeholder="กรุณากรอกความสำเร็จของนักศึกษา">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>14.</b> เหตุการณ์ที่นักศึกษาประทับใจมากที่สุด <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="impressive_event" id="impressive_event" autocomplete="off" placeholder="กรุณากรอกเหตุการณ์ที่นักศึกษาประทับใจมากที่สุด">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>15.</b> ขณะนี้นักศึกษาไม่สบายใจในเรื่องอะไร <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="uneasy" id="uneasy" autocomplete="off" placeholder="กรุณากรอกขณะนี้นักศึกษาไม่สบายใจในเรื่องอะไร">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>16.</b> บุคคลที่นักศึกษาวางใจอยากปรึกษาปัญหาต่างๆ<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="person_discuss_problems" id="person_discuss_problems" autocomplete="off" placeholder="กรุณากรอกบุคคลที่นักศึกษาวางใจอยากปรึกษาปัญหาต่างๆ">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>17.</b> กิจกรรมยามว่างที่นักศึกษาชอบทำ<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="activity" id="activity" autocomplete="off" placeholder="กรุณากรอกกิจกรรมยามว่างที่นักศึกษาชอบทำ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label><b>18.</b> นักศึกษาได้เงินมาโรงเรียนวันละ<b class="text-danger">*</b></label>
                                                            <input type="number" class="form-control height-input" name="money_per_day" id="money_per_day" autocomplete="off" placeholder="กรุณากรอกนักศึกษาได้เงินมาโรงเรียนวันละ">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>ส่วนใหญ่ใช้เกี่ยวกับ<b class="text-danger">*</b></label>
                                                            <input type="text" class="form-control height-input" name="use_money_per_day" id="use_money_per_day" autocomplete="off" placeholder="กรุณากรอกส่วนใหญ่ใช้เกี่ยวกับ">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>19.</b>
                                                        นักศึกษาเสียใจเกี่ยวกับการกระทำเรื่องใดมากที่สุด
                                                        <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="action_regret" id="action_regret" autocomplete="off" placeholder="กรุณากรอกเสียใจเกี่ยวกับการกระทำเรื่องใดมากที่สุด">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>20.</b> ความรู้สึกของนักศึกษาที่มีต่อโรงเรียนและครู<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="feel_for_school_and_teacher" id="feel_for_school_and_teacher" autocomplete="off" placeholder="กรุณากรอกความรู้สึกของนักศึกษาที่มีต่อโรงเรียนและครู">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label><b>21.</b> ผลการเรียนของนักศึกษา<b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="gpa" id="gpa" autocomplete="off" placeholder="กรุณากรอกผลการเรียนของนักศึกษา">

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>วิชาที่ชอบ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="favorite_subject" id="favorite_subject" autocomplete="off" placeholder="กรุณากรอกวิชาที่ชอบ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>วิชาที่ไม่ชอบ <b class="text-danger">*</b></label>
                                                    <input type="text" class="form-control height-input" name="not_favorite_subject" id="not_favorite_subject" autocomplete="off" placeholder="กรุณากรอกวิชาที่ไม่ชอบ">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label>เหตุผล (วิชาที่ไม่ชอบ)<b class="text-danger">*</b></label><br>
                                                    <textarea type="text" class="form-control height-input" name="reason_not_favorite_subject" id="reason_not_favorite_subject" autocomplete="off" placeholder="กรุณากรอกเหตุผลวิชาที่ไม่ชอบ"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><b>22.</b> ปัญหาด้านสุขภาพ<b class="text-danger">*</b></label>
                                                    <textarea type="text" class="form-control height-input" name="health_problems" id="health_problems" autocomplete="off" rows="2" placeholder="กรุณากรอกปัญหาด้านสุขภาพ"></textarea>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                            <i class="ti-save-alt"></i> บันทึกข้อมูล
                                        </button>
                                    </div>
                                </div>
                            </form>

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

    </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include '../include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <?php include 'include/scripts.php'; ?>

    <script type = "text/javascript" src="assets/js/view_js/form_1.1_edit.js"></script>
</body>

</html>