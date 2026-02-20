$(document).ready(function () {
  getDataVisit();
});

function getDataVisit() {
  const Tbody = document.getElementById("data-visit");
  Tbody.innerHTML = "";
  Tbody.innerHTML += `
            <tr>
                <td colspan="8" class="text-center">
                    <?php include "../include/loader_include.php"; ?>
                </td>
            </tr>
        `;
  let std_class_change = document.getElementById('std_class').value;
  $.ajax({
    type: "POST",
    url: "controllers/form_visit_summary_controller",
    data: {
      std_class_change: std_class_change,
      getDataVisitSum: true,
    },
    dataType: "json",
    success: function (json_data) {
      if (std_class_change == 0) {
        genHtmlTable(json_data.data);
      } else {
        genHtmlTable(json_data.data, 'change');
      }

    },
  });
}


$('#std_class').change(() => getDataVisit())

function genHtmlTable(data, mode = '') {
  const Tbody = document.getElementById("data-visit");
  Tbody.innerHTML = "";
  if (data.length == 0) {
    Tbody.innerHTML += `
            <tr>
                <td colspan="4" class="text-center">
                    ไม่มีข้อมูล
                </td>
            </tr>
        `;
    return;
  }

  let check_topic = "";
  let topic_check = "";
  let check_topic_id = "";
  let topic_check_id = "";
  let check_sub;
  let index_sub = 0;
  $('#count_std').val(data[0].count_std);
  data.forEach((element, i) => {
    if (check_topic == element.title_detail) {
      topic_check = "";
    } else {
      topic_check = element.title_detail;
      check_topic = element.title_detail;
    }

    if (check_topic_id == element.title_id) {
      topic_check_id = "";
    } else {
      topic_check_id = element.title_id;
      check_topic_id = element.title_id;
    }

    if (check_sub == element.title_id) {
      index_sub = index_sub + 1;
    } else {
      check_sub = element.title_id;
      index_sub = 1;
    }
    let percent = 0;
    if (mode != '') {
      percent = (parseInt(element.sum) / parseInt(element.count_std)) * 100
    }


    Tbody.innerHTML += `
           <tr>
              <td>${topic_check_id}. ${topic_check}</td>
              <td>
                ${element.title_id}.${index_sub} ${element.sub_title_detail}
              </td>
              <td>
                <input type="number" disabled class="form-control input-sm input-count-std" name="sum_people" value="${mode == '' ? '0' : element.sum}" id="${element.sub_title_id
      }">
              </td>
              <td>
              <input type="number" class="form-control input-sm input-count-per" name="persen" value="${percent.toFixed(1)}"
                      id="p_${element.title_id + "" + index_sub}" disabled value="${percent.toFixed(1)}">
                      <input type="hidden" value="${element.sub_title_id}" class="input-sm input-vid">
                      </td>
                      
          </tr>
                                  
        `;

    //   saveData(element.form_visit_summary_id,index_sub);
  });
}

$("#saveVisit").click(function () {
  saveData();
});

function saveData() {
  const count_std = document.querySelectorAll(".input-count-std");
  const count_per = document.querySelectorAll(".input-count-per");
  const sub_id = document.querySelectorAll(".input-vid");
  const std_class = document.getElementById("std_class").value;
  const year = document.getElementById("year").value;

  if (std_class == 0) {
    document.getElementById("std_class").focus();
    alert("โปรดกรอกชั้น/ห้อง");
    return;
  }
  if (year == "") {
    document.getElementById("year").focus();
    alert("โปรดกรอกปีการศึกษา");
    return;
  }

  const object_std = [];
  for (var i = 0; i < count_std.length; i++) {
    if (count_std[i].value == "") {
      count_std[i].focus();
      alert("โปรดกรอกจำนวนให้ครบ");
      return;
    }

    const object_per = {
      sub_id: sub_id[i].value,
      counts_d: count_std[i].value,
      counts_per: count_per[i].value,
    };
    object_std.push(object_per);
  }

  $.ajax({
    type: "POST",
    url: "controllers/form_visit_summary_controller",
    data: {
      year: year,
      std_class: std_class,
      count_std: $('#count_std').val(),
      summary_detail: JSON.stringify(object_std),
      addVisitSum: true,
    },
    dataType: "json",
    success: async function (json) {
      if (json.status) {
        alert("บันทึกข้อมูลสำเร็จ");
        window.location.href = "form1_3";
      } else {
        alert(json.msg);
      }
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
}