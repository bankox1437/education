  <?php
    $pro = isset($_GET['pro']) ? "pro=" . $_GET['pro'] . "&" : '';
    $dis = isset($_GET['dis']) ? "dis=" . $_GET['dis'] . "&" : '';
    $sub = isset($_GET['sub']) ? "sub=" . $_GET['sub'] . "&" : '';
    $page_number = isset($_GET['page_number']) ? "page_number=" . $_GET['page_number'] : '';

    ?>
  <div class="box-header">

      <div class="row align-items-center">
          <?php if (!isset($_GET['user_id'])) {
                echo '<h4 class="box-title">ตารางการพบกลุ่ม ปีการศึกษา ' . $_SESSION['term_active']->term_name . '</h4>';
            } else {
                if ($_SESSION['user_data']->role_id == 6) {
                    echo ' <h4 class="box-title text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href=\'../view-grade/dashboard_index\'"></i>
                                &nbsp;<b>ตารางการพบกลุ่ม ' . $_GET['name'] . '</b>
                            </h4>';
                } else {
                    echo ' <h4 class="box-title text-left" style="margin: 0;"><i class="ti-arrow-left" style="cursor: pointer;" onclick="window.location.href=\'teacher_list?' . $pro . $dis . $sub .  $page_number . '\'"></i>
                        &nbsp;<b>ตารางการพบกลุ่ม ' . $_GET['name'] . '</b>
                    </h4>';
                }
            } ?>

          <?php if (!isset($_SESSION['manage_calendar_class']) || $_SESSION['manage_calendar_class'] == '0') { ?>
              <div class="col-md-2" style="display: <?php echo $_SESSION['user_data']->role_id == 4 ? 'none' : 'block'; ?>">
                  <select class="form-control" id="std_class" onchange="updateTable()">
                      <option value="">ชั้นทั้งหมด &nbsp;&nbsp;</option>
                      <option value="ประถม">ประถม</option>
                      <option value="ม.ต้น">ม.ต้น</option>
                      <option value="ม.ปลาย">ม.ปลาย</option>
                  </select>
              </div>
          <?php } else { ?>
              <input type="hidden" id="std_class" value="<?php echo $classSession ?>">
          <?php } ?>

          <div class="col-md-2" style="display: <?php echo $_SESSION['user_data']->role_id == 4 ? 'none' : 'block'; ?>">
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

            $sql = "SELECT * FROM cl_main_calendar WHERE user_create = :user_create AND enabled = 1";
            $data = $DB->Query($sql, ["user_create" => $_SESSION['user_data']->id]);
            $data = json_decode($data);
            if ($_SESSION['user_data']->role_id == 3 && count($data) != 0) {
                $file_add = "manage_calendar_add";
                if (isset($_SESSION['manage_calendar_class']) && $_SESSION['manage_calendar_class'] != '0') {
                    $file_add = "manage_calendar_new_add";
                }
                echo ' <a class="waves-effect waves-light btn btn-success btn-flat ml-2"
                                            href="' . $file_add . '"><i
                                                class="ti-plus"></i>&nbsp;เพิ่มข้อมูลการพบกลุ่ม</a>';
            } ?>
      </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
      <div class="table-responsive">
          <table class="table table-bordered table-hover" style="font-size: 14px;">
              <thead>
                  <tr class="text-center">
                      <th style="width: 110px;">ภาคเรียนที่</th>
                      <th>ระดับชั้น</th>
                      <th>ครั้งที่</th>
                      <th>แผนการสอน</th>
                      <th>ปีการศึกษา</th>
                      <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                          <th style="width: 70px;" class="text-center">ผู้เข้าเรียน</th>
                      <?php  } ?>

                      <th style="width: 70px;" class="text-center">ดูรายละเอียด</th>
                      <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                          <th style="width: 70px;" class="text-center">บันทึกผลการเรียน</th>
                          <th style="width: 70px;" class="text-center">แก้ไข</th>
                          <th style="width: 70px;" class="text-center">ลบ</th>
                      <?php  } ?>
                  </tr>
              </thead>
              <tbody id="body-calender">
                  <tr>
                      <td colspan="<?php echo $_SESSION['user_data']->role_id == 3 ? 7 : 5 ?>" class="text-center">
                          <?php include "../include/loader_include.php"; ?>
                      </td>
                  </tr>
              </tbody>
          </table>
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