 <script>
     $(document).ready(async function() {
         getDataCalender();
     });

     function getDataCalender() {
         let term_name = document.getElementById('term_name').value;
         var filter_field = {
             term_name: term_name
         };
         $.ajax({
             type: "POST",
             url: "controllers/calendar_controller",
             data: {
                 getDataCalender: true,
                 user_id: '<?php echo $_SESSION['user_data']->user_create ?? '' ?>',
                 std_id: '<?php echo $_SESSION['user_data']->edu_type ?>',
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

     function genHtmlTable(data) {
         const Tbody = document.getElementById("body-calender");
         Tbody.innerHTML = "";
         if (data.length == 0) {
             Tbody.innerHTML += `
            <tr>
                <td colspan="${role_id == 3 ? 7 : 5}" class="text-center">
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
                    <td>${element.time_step == 0 ? `<span class="text-danger">ยังไม่ระบุครั้งที่</span>` : `ครั้งที่ ${element.time_step}`}</td>
                    <td class="text-left">${element.plan_name}</td>
                    <td>${element.year}</td>
                    <td>
                    ${element.sign_in_status > 0 ? `
                        <a href="view_plan_calender_detail?${element.learning_id != null ? `learning_id=${element.learning_id}&` : ''}calendar_id=${element.calendar_id}">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                        </a>
                        `: 
                        `
                        <a title="เช็คชื่อ" onclick="SignInToClass('${element.calendar_id}',${element.learning_id})">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-hand-open"></i></button>
                        </a>`
                    }
                    </td>
                </tr>
        `;
         });
     }

     function deleteCalendar(id) {
         const confirmDelete = confirm('ต้องการลบหรือไม่?');
         if (confirmDelete) {
             $.ajax({
                 type: "POST",
                 url: "controllers/calendar_controller",
                 data: {
                     delete_calendar: true,
                     id: id
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

     function SignInToClass(calendar_id, learning_id) {
         const confirmSignIn = confirm('คุณต้องอยู่ภายในหน้าเพื่อเข้าเรียนอย่างน้อย 3 นาที \n ต้องการเช็คชื่อในแผนการสอนนี้หรือไม่?');
         if (confirmSignIn) {
             location.href = `view_plan_calender_detail?${learning_id != null ? `learning_id=${learning_id}&` : ''}calendar_id=${calendar_id}`;
         }
     }
 </script>