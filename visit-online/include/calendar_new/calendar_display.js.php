  <?php
    $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
    $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
    $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
    $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';

    $urlBack = "";
    if ($_SESSION['user_data']->role_id == 2 || $_SESSION['user_data']->role_id == 6 || $_SESSION['user_data']->role_id == 1) {
        $urlBack = $pro . $dis . $sub .  $page_number . '&name=' . urlencode($_GET['name']) . "&user_id=" . $_GET['user_id'];
    }
    ?>
  <div class="box-header">

      <div class="row align-items-center">
          <?php if (!isset($_GET['user_id'])) {
                echo '<h4 class="box-title">ตารางการพบกลุ่ม ปีการศึกษา ' . $_SESSION['term_active']->term_name . '</h4>';
            } else {
                if ($_SESSION['user_data']->role_id == 6) {
                    echo ' <h4 class="box-title text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href=\'../view-grade/dashboard_index\'"></i>
                        &nbsp;<b>ตารางการพบกลุ่ม  ชั้น ' . $classSession . " " . $_GET['name'] . '</b>
                    </h4>';
                } else {
                    echo ' <h4 class="box-title text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href=\'teacher_list?' . $pro . $dis . $sub .  $page_number . '\'"></i>
                        &nbsp;<b>ตารางการพบกลุ่ม  ชั้น ' . $classSession . " " . $_GET['name'] . '</b>
                    </h4>';
                }
            } ?>

          <?php if (empty($_SESSION['manage_calendar_class']) || $_SESSION['manage_calendar_class'] == '0') {
                if ($_SESSION['user_data']->role_id != 4) { ?>
                  <div class="col-md-2" style="display: <?php echo $_SESSION['user_data']->role_id == 4 ? 'none' : 'block'; ?>">
                      <select class="form-control" id="std_class" onchange="updateTable()">
                          <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                          <option value="ประถม">ประถม</option>
                          <option value="ม.ต้น">ม.ต้น</option>
                          <option value="ม.ปลาย">ม.ปลาย</option>
                      </select>
                  </div>
              <?php  } else { ?>
                  <input type="hidden" id="std_class" value="<?php echo $classSession ?>">
              <?php }
            } else { ?>
              <input type="hidden" id="std_class" value="<?php echo $classSession ?>">
          <?php } ?>

          <div class="col-md-2">
              <select class="form-control" id="term_name" onchange="updateTable()">
                  <option value="0">ปีการศึกษาทั้งหมด &nbsp;&nbsp;</option>
                  <?php foreach ($_SESSION['term_data'] as $value) { ?>
                      <?php $selected = ($value->term_id == $_SESSION['term_active']->term_id) ? 'selected' : ''; ?>
                      <?php $current = ($value->term_id == $_SESSION['term_active']->term_id) ? ' (ปัจจุบัน)' : ''; ?>
                      <option value="<?php echo $value->term_name ?>" <?php echo $selected ?>><?php echo $value->term_name . $current ?></option>
                  <?php } ?>
              </select>
          </div>

          <?php

            if ($_SESSION['user_data']->role_id == 4) {
                echo '<input type="hidden" id="term_name_active" value="' . $_SESSION['term_active']->term_name . '">';
            }

            $sql = "SELECT * FROM cl_main_calendar WHERE std_class = :std_class AND user_create = :user_create AND enabled = 1";
            $data = $DB->Query($sql, ["std_class" => $classSession, "user_create" => $_SESSION['user_data']->id]);
            $data = json_decode($data);
            if ($_SESSION['user_data']->role_id == 3 && count($data) != 0) {
                $file_add = "manage_calendar_add";
                if ($_SESSION['manage_calendar_class'] != '0') {
                    $file_add = "manage_calendar_new_add";
                }
                echo ' <a class="waves-effect waves-light btn btn-success btn-flat ml-2"
                                            href="' . $file_add . '"><i
                                                class="ti-plus"></i>&nbsp;เพิ่มข้อมูลการพบกลุ่ม</a>';
            } else {
                if ($_SESSION['user_data']->role_id == 3) {
                    echo 'ยังไม่ได้เพิ่มปฏิทินการพบกลุ่มระดับ' . $classSession;
                }
            }

            if ($_SESSION['manage_calendar_class'] != '0' && $_SESSION['user_data']->role_id != 4) { ?>
              <a class="waves-effect waves-light btn btn-info btn-flat ml-2" onclick="showSummary('<?php echo $classSession ?>','<?php echo $urlBack ?>')" href="javascript:void(0);">
                  <i class="ti-write"></i>&nbsp;สรุปผลการเข้าเรียน
              </a>

              <?php if ($_SESSION['user_data']->role_id != 1) {
                    if ($_SESSION['user_data']->role_id == 3 && count($data) != 0) { ?>
                      <button type="button" class="waves-effect waves-light btn btn-warning btn-flat ml-2" id="btn-selectPlan" data-toggle="modal" data-target="#selectPlan">เลือกการพบกลุ่มจากอำเภอ</button>
                  <?php } ?>
                  <a class="waves-effect waves-light btn btn-info btn-flat ml-2" href="manage_testing">
                      <i class="ti-write"></i>&nbsp;แบบทดสอบ <?php echo $classSession ?>
                  </a>
              <?php } ?>
          <?php } ?>
      </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row" id="row_calendar">
      </div>
  </div>


  <div id="modalSaveLearning" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalSaveLearningLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <div>
                      <h4 class="modal-title" id="modalSaveLearningLabel"><span id="title_modal_type"></span>บันทึกผลการเรียนการสอน</h4>
                      <h4 class="modal-title mt-0" id="plan_name"></h4>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></button>
              </div>
              <div class="modal-body" id="std_sign_in">
                  <form id="form-save-learning">
                      <div class="row ">
                          <div class="col-md-3">
                              <input type="hidden" value="" id="calendar_id_hidden">
                              <input type="hidden" value="" id="learning_id_hidden">
                              <input type="hidden" value="" id="save_learning_file_old">
                          </div>
                          <div class="col-md-6 text-center">
                              <div class="form-group">
                                  <label>อัปโหลดไฟล์บันทึกผลการเรียนการสอน <b class="text-danger">*</b></label>
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="save_learning_file" name="save_learning_file" accept="application/pdf" onchange="setlabelFilename('save_learning_file')">
                                      <label class="custom-file-label" for="save_learning_file" id="save_learning_file_label">เลือกไฟล์
                                          PDF เท่านั้น</label>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3"></div>
                      </div>
                      <div class="row">
                          <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                                  <i class="ti-save-alt"></i> บันทึกไฟล์
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <div id="selectPlan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="selectPlanLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <div>
                      <h4 class="modal-title" id="selectPlanLabel"><span id="title_modal_type"></span>การพบกลุ่ม <?php echo $classSession ?></h4>
                      <span class="text-danger">เลือกการพบกลุ่มที่ต้องการ</span>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></button>
              </div>
              <div class="modal-body" id="std_sign_in">
                  <style>
                      .btn-custom {
                          background-color: #ffffff !important;
                          border-color: #1e613b !important;
                          color: #000000 !important;
                          width: 100%;
                          text-align: center;
                      }

                      .btn-custom:hover {
                          background-color: #1e613b !important;
                      }

                      .active-custom {
                          background-color: #1e613b !important;
                          color: #ffffff !important;
                      }
                  </style>
                  <div class="row">
                      <?php
                        $sqluserProvince = "SELECT province_id FROM tbl_non_education WHERE id = :id";
                        $userProvince = $DB->Query($sqluserProvince, ["id" => $_SESSION['user_data']->edu_id]);
                        $userProvince = json_decode($userProvince);
                        $userProvince = $userProvince[0];

                        $dataCalendarFromAm = "SELECT * FROM cl_calendar_new_am WHERE province_id = :province_id AND std_class = :std_class";
                        $dataCalendarFromAm = $DB->Query($dataCalendarFromAm, ["province_id" =>  $userProvince->province_id, "std_class" => $classSession]);
                        $dataCalendarFromAm = json_decode($dataCalendarFromAm);

                        foreach ($dataCalendarFromAm as $key => $calendar) { ?>

                          <div class="col-lg-3 col-6 mb-3"> <button onclick="SelectPlanToUse(<?php echo $calendar->calendar_id; ?>)" type="button" class="btn-plan-select waves-effect waves-light btn btn-outline btn-custom mb-5"
                                  id="calendar_<?php echo $calendar->calendar_id; ?>" style="width: 100%;" data-calendar_id="<?php echo $calendar->calendar_id; ?>">การพบกลุ่มครั้งที่ <?php echo $calendar->time_step ?></button></div>

                      <?php   }   ?>
                  </div>

                  <div class="row">
                      <div class="col-md-12 text-center">
                          <button type="button" class="btn btn-rounded btn-primary btn-outline" onclick="SubmitSelectPlan('<?php echo $classSession ?>')">
                              <i class=" ti-save-alt"></i> บันทึกข้อมูลการพบกลุ่มที่เลือก
                          </button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>