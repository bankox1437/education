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
             url: "controllers/calendar_controller",
             data: {
                 getDataCalender: true,
                 user_id: '<?php echo $_GET['user_id'] ?? '' ?>',
                 filter_field: filter_field
             },
             dataType: "json",
             success: function(json_res) {
                 console.log(json_res);
                 genHtmlTable(json_res.data);
                 //  const term_select = document.getElementById('term_select');
                 //  term_select.innerHTML = `<option value="0">เลือกเทอม</option>`
                 //  json_res.term.forEach(element => {
                 //      term_select.innerHTML += ` <option value="${element.term}/${element.year}">${element.term}/${element.year}</option>`
                 //  });
             },
         });
     }

     //  $('#term_select').change(() => getDatacalendarwByTerm())

     function getDatacalendarwByTerm() {
         const term_select = document.getElementById('term_select').value;
         if (term_select == 0) {
             getDataCalender();
             return;
         }
         $.ajax({
             type: "POST",
             url: "controllers/calendar_controller",
             data: {
                 getDatacalendarByTerm: true,
                 term_select: term_select,
                 user_id: '<?php echo $_GET['user_id'] ?? '' ?>'
             },
             dataType: "json",
             success: function(json_res) {
                 genHtmlTable(json_res.data);
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
                    <td>ภาคเรียนที่ ${element.term}</td>
                    <td>${element.std_class != null ? element.std_class : "-"}</td>
                    <td>${element.time_step == 0 ? `<span class="text-danger">โปรดระบุครั้งที่</span>` : `ครั้งที่ ${element.time_step}`}</td>
                    <td class="text-left">${element.plan_name}</td>
                    <td>${element.year}</td>
                    ${role_id == 3 ? `<td><a style="cursor: pointer;color:blue" data-toggle="modal" data-target="#myModal" onclick="openModal(${element.calendar_id})"><b>${element.count_std_sign}</b></a></td>`
                    : ''}
                    <td>
                        <a href="view_plan_calender_detail?${element.learning_id != null ? `learning_id=${element.learning_id}&` : ''}calendar_id=${element.calendar_id}<?php echo $_SESSION['user_data']->role_id != 3 ? '&user_id=' . $_GET['user_id'] . '&name=' . $_GET['name'] : '' ?>">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                        </a>
                    </td>
                    ${role_id == 3 ? `
                        <td>
                           ${element.learning_id != null ? 
                            `<button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;" data-toggle="modal" data-target="#modalSaveLearning" onclick="openEditSaveLearnFileModal(${element.learning_id},'${element.plan_name}','${element.learning_file}')"><i class="ti-file"></i></button>` : 
                            `<button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5 mt-1" style="width:30px;height:30px;" data-toggle="modal" data-target="#modalSaveLearning" onclick="openSaveLearnFileModal(${element.calendar_id},'${element.plan_name}')"><i class="ti-save"></i></button>`
                            }
                        </td>
                        <td class="text-center">
                            <a href="manage_calendar_edit?calendar_id=${element.calendar_id}">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt"></i></button>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteCalendar(${element.calendar_id},'${element.plan_file}',${element.learning_id},${element.learning_id_old})"><i class="ti-trash"></i></button>
                        </td> 
                        ` : ''
                    }
                </tr>
        `;
         });
     }

     function deleteCalendar(id, file, l_id, l_old_id) {
         const confirmDelete = confirm('ต้องการลบแผนการสอนนี้หรือไม่?');
         if (confirmDelete) {
             $.ajax({
                 type: "POST",
                 url: "controllers/calendar_controller",
                 data: {
                     delete_calendar: true,
                     id: id,
                     file: file,
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
 </script>