 <script>
     let std_class = document.getElementById('std_class').value;
     let term_name = document.getElementById('term_name').value;
     var filter_field = {
         std_class: std_class,
         term_name: term_name
     };
     $(document).ready(async function() {
         getDataCalender();
     });

     function updateTable() {
         filter_field.std_class = document.getElementById('std_class').value;
         filter_field.term_name = document.getElementById('term_name').value;
         getDataCalender();
     }

     function getDataCalender() {

         $.ajax({
             type: "POST",
             url: "controllers/calendar_new_controller",
             data: {
                 getDataCalender: true,
                 user_id: '<?php echo $_GET['user_id'] ?? '' ?>',
                 filter_field: filter_field
             },
             dataType: "json",
             success: function(json_res) {
                 console.log(json_res);
                 generateCardBox(json_res.data);
                 //  const term_select = document.getElementById('term_select');
                 //  term_select.innerHTML = `<option value="0">เลือกเทอม</option>`
                 //  json_res.term.forEach(element => {
                 //      term_select.innerHTML += ` <option value="${element.term}/${element.year}">${element.term}/${element.year}</option>`
                 //  });
             },
         });
     }

     function genHtmlTable(data) {
         const Tbody = document.getElementById("body-calender");
         Tbody.innerHTML = "";
         if (data.length == 0) {
             Tbody.innerHTML += `
            <tr>
                <td colspan="${role_id == 3 ? 10 : 5}" class="text-center">
                    ยังไม่มีข้อมูล
                </td>
            </tr>
        `;
             return;
         }
         data.forEach((element, i) => {
             Tbody.innerHTML += `
                    <tr class="text-center">
                    <td>${element.std_class != null ? element.std_class : "-"}</td>
                    <td>${element.time_step == 0 ? `<span class="text-danger">โปรดระบุครั้งที่</span>` : `ครั้งที่ ${element.time_step}`}</td>
                    <td class="text-left">${element.plan_name}</td>
                    ${role_id == 3 ? `<td><a style="cursor: pointer;color:blue" data-toggle="modal" data-target="#myModal" onclick="openModal(${element.calendar_id})"><b>${element.count_std_sign}</b></a></td>`
                    : ''}
                    <td>
                        <a href="view_plan_calender_detail_new?${element.learning_id_old != null ? `learning_id=${element.learning_id_old}&` : ''}calendar_id=${element.calendar_id}<?php echo $_SESSION['user_data']->role_id != 3 ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '' ?>">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                        </a>
                    </td>
                    ${role_id == 3 ? `
                        <td>
                           ${element.learning_id_old != null ? 
                           `<a href="manage_learning_edit?learning_id=${element.learning_id_old}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-file"></i></button>
                            </a>` : 
                            `<a href="manage_learning_add?calendar_id=${element.calendar_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-save"></i></button>
                            </a>`}
                        </td>
                        <td class="text-center">
                            <a href="manage_score?plan_name=${element.plan_name}&calendar_id=${element.calendar_id}&class=<?php echo isset($_SESSION['manage_calendar_class']) ? $_SESSION['manage_calendar_class'] : '0' ?>&std_class=<?php echo $classSession ?>">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-agenda"></i></button>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="manage_calendar_new_edit?calendar_id=${element.calendar_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteCalendar(${element.calendar_id},'${element.plan_file}',${element.learning_id},${element.learning_id_old}, '${element.content_file}')"><i class="ti-trash"></i></button>
                        </td> 
                        ` : ''
                    }
                </tr>
        `;
         });
     }

     function generateCardBox(data) {
         const CardBox = document.getElementById("row_calendar");
         CardBox.innerHTML = "";
         if (data.length == 0) {
             CardBox.innerHTML += `
            <div class="col-md-12 text-center">ยังไม่มีข้อมูล</div>
        `;
             return;
         }

         data.forEach((element, i) => {
             let statusActive = "";
             let link = `view_plan_calender_detail_new?${element.learning_id_old != null ? `learning_id=${element.learning_id_old}&` : ''}calendar_id=${element.calendar_id}<?php echo $_SESSION['user_data']->role_id != 3 ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '' ?>`;

             <?php if ($_SESSION['user_data']->role_id != 3) { ?>
                 statusActive = element.status_active == 1 ? `bg-success` : `bg-danger`;
                 if (!parseInt(element.status_active)) {
                     link = "#"
                 }
             <?php } ?>

             CardBox.innerHTML += `
                    <div class="col-12 col-md-2">
                        <a href="${link}">
                        <div class="card text-center m-0 ${statusActive}">
                                <div class="card-body" <?php if ($_SESSION['user_data']->role_id != 3) {
                                                            echo 'style="padding-top: 30px;padding-bottom: 30px"';
                                                        } ?>>
                                    <p class="card-text"><b>การพบกลุ่ม ${element.time_step == 0 ? `<span class="text-danger">โปรดระบุครั้งที่</span>` : `ครั้งที่ ${element.time_step}`}</b></p>
                                    <?php if ($_SESSION['user_data']->role_id == 3) { ?>
                                    <label class="switch switch-working-media">
                                        <input type="checkbox" class="checkbox-working-media" ${element.status_active == 1 ? `checked` : ``} onchange="checkboxChangeStatus(this.checked, ${element.calendar_id})">
                                        <span class="slider round"></span>
                                    </label>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </div>
            `
         })
     }

     function checkboxChangeStatus(value, calendar_id) {
         var statusChange = value ? 1 : 0;
         $.ajax({
             type: "POST",
             url: "controllers/calendar_new_controller",
             data: {
                 changeStatusActive: true,
                 calendar_id: calendar_id,
                 status: statusChange,
             },
             dataType: "json",
             success: function(data) {
                 alert("อัปเดตสถานะการพบกลุ่ม")
             },
         });
     }

     function deleteCalendar(id, file, l_id, l_old_id, content_file) {
         const confirmDelete = confirm('ต้องการลบแผนการสอนนี้หรือไม่?');
         if (confirmDelete) {
             $.ajax({
                 type: "POST",
                 url: "controllers/calendar_new_controller",
                 data: {
                     delete_calendar: true,
                     id: id,
                     file: file,
                     content_file: content_file,
                     l_id: l_id,
                     l_old_id: l_old_id
                 },
                 dataType: "json",
                 success: function(data) {
                     if (data.status) {
                         getDataCalender();
                     } else {
                         alert(data.msg);
                         window.location.reload();
                     }
                 },
             });
         }
     }

     function openModal(calendar_id) {
         location.href = "sign_in_list?calendar_id=" + calendar_id;
         return;
         $.ajax({
             type: "POST",
             url: "controllers/calendar_controller",
             data: {
                 getDataStdSignInClass: true,
                 calendar_id: calendar_id
             },
             dataType: "json",
             success: function(json_res) {
                 let textHtml = `
                 `;
                 if (json_res.data.length == 0) {
                     textHtml = ` <h4 class='text-center'> ยังไม่มีนักศึกษาเช็คชื่อ </h4>`
                 } else {
                     for (let i = 0; i < json_res.data.length; i++) {
                         textHtml += `<h4>${ json_res.data[i].std_name}</h4>`
                     }
                 }
                 const std_sign_in = document.getElementById('std_sign_in');
                 std_sign_in.innerHTML = textHtml;
             },
         });
     }

     function openSaveLearnFileModal(calendar_id, plan_name) {
         $('#plan_name').text(plan_name);
         $('#calendar_id_hidden').val(calendar_id);
     }

     function openEditSaveLearnFileModal(learning_id, plan_name, save_learning_file_old = "") {
         $('#plan_name').text(plan_name);
         $('#title_modal_type').text('แก้ไข');
         $('#learning_id_hidden').val(learning_id);
         $('#save_learning_file_old').val(save_learning_file_old);
     }

     function setlabelFilename(id) {
         const file = document.getElementById(id).files[0];
         document.getElementById(id + '_label').innerText = file.name;
     }

     $('#form-save-learning').submit(function(e) {
         e.preventDefault();
         const calendar_id = $('#calendar_id_hidden').val();
         const learning_id = $('#learning_id_hidden').val();
         const save_learning_file_old = $('#save_learning_file_old').val();
         const save_learning_file = document.getElementById('save_learning_file').files[0];

         let formData = new FormData();
         if (learning_id == '') {
             if (typeof save_learning_file == 'undefined') {
                 alert('โปรดเลือกไฟล์บันทึกผลการเรียนการสอน ')
                 $('#save_learning_file').focus()
                 return false;
             }
         } else {
             formData.append('learning_id', learning_id);
             formData.append('save_learning_file_old', save_learning_file_old);
         }

         formData.append('calendar_id', calendar_id);
         formData.append('save_learning_file', save_learning_file);
         formData.append('insertSaveLearning', true);

         $.ajax({
             type: "POST",
             url: "controllers/learning_controller",
             data: formData,
             dataType: "json",
             contentType: false,
             processData: false,
             success: async function(json) {
                 alert(json.msg);
                 if (json.status) {
                     $('#modalSaveLearning .close').click();
                     getDataCalender();
                 }
             },
         });
     });


     function showSummary(std_class, prodissub = "") {
         let term_name = $('#term_name').val();
         location.href = `sign_in_sum?std_class=${std_class}${prodissub != "" ? `&${prodissub}` : ''}${term_name != 0 ? `&term_name=${term_name}` : ''}`;
     }

     function showScore(std_class, prodissub = "") {
         location.href = `../view-grade/manage_sum_score?std_class=${std_class}${prodissub != "" ? `&${prodissub}` : ''}`;
     }


     function SelectPlanToUse(calendar_id) {
         let active = $('#calendar_' + calendar_id).hasClass('active-custom');
         if (!active) {
             $('#calendar_' + calendar_id).addClass('active-custom');
         } else {
             $('#calendar_' + calendar_id).removeClass('active-custom');
         }
     }

     function SubmitSelectPlan(std_class) {
         let btn_plan_select = $('.btn-plan-select')
         let calendarId = [];
         for (let i = 0; i < btn_plan_select.length; i++) {
             let active = $(btn_plan_select[i]).hasClass('active-custom');
             if (active) {
                 calendarId.push($(btn_plan_select[i]).attr('id').replace('calendar_', ''));
             }
         }

         if (calendarId.length == 0) {
             alert("โปรดเลือกการพบกลุ่ม");
             return false;
         }
         $.ajax({
             type: "POST",
             url: "controllers/calendar_new_controller",
             data: {
                 insertSelectPlan: true,
                 calendarIdArr: calendarId,
                 std_class: std_class
             },
             dataType: "json",
             success: async function(json) {
                 alert(json.msg);
                 if (json.status) {
                     $('#selectPlan .close').click();
                     getDataCalender();
                 }
             },
         });
     }
 </script>