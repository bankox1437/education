$(document).ready(function () {
  getDataVisit();
});



function getDataVisit() {
  const Tbody = document.getElementById("data-visit");
  Tbody.innerHTML = "";
  Tbody.innerHTML += `
            <tr>
                <td colspan="8" class="text-center">
                    <?php include "include/loader_include.php"; ?>
                </td>
            </tr>
        `;
  $.ajax({
    type: "POST",
    url: "controllers/form_visit_summary_controller",
    data: {
      getDataVisit: true,
    },
    success: function (data) {
      const json_data = JSON.parse(data);
      genHtmlTable(json_data.data);
    },
  });
}

function genHtmlTable(data) {
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
  let check_radio;
  data.forEach((element, i) => {
    if (check_topic == element.title_detail) {
      topic_check = "";
    } else {
      topic_check = element.title_detail;
      check_topic = element.title_detail;
    }

    if (check_topic_id == element.title_id) {
      topic_check_id = "";
      check_radio = "";
    } else {
      topic_check_id = element.title_id;
      check_topic_id = element.title_id;
      check_radio = "checked";
    }

    if (check_sub == element.title_id) {
      index_sub = index_sub + 1;
    } else {
      check_sub = element.title_id;
      index_sub = 1;
    }




    Tbody.innerHTML += `
           <tr>
              <td>${topic_check_id}. ${topic_check}</td>
              <td>
                ${element.title_id}.${index_sub} ${element.sub_title_detail}
              </td>
              <td onclick="checkedbehavior('${element.title_id}_${element.sub_title_id}')">
                 <div class="form-group text-center">
                      <div class="c-inputs-stacked">
                          <input name="${element.title_id}" type="radio" id="${element.title_id}_${element.sub_title_id}" class="with-gap radio-col-info input-vid" value="${element.sub_title_id}" ${check_radio}>
                          <label for="${element.title_id}_${element.sub_title_id}"></label>
                          
                      </div>
                      
                  </div>
              </td>
                      
          </tr>
                                  
        `;

    //   saveData(element.form_visit_summary_id,index_sub);
  });
}

function checkedbehavior(id) {
  document.getElementById(id).setAttribute("checked", true);
}

$("#saveVisit").click(function () {
  saveData();
});

function saveData() {
  let radio_checked = $("input[type=radio]");
  var query = window.location.search.substring(1);
  var params = parse_query_string(query);
  const object_v = [];
  for (var i = 0; i < radio_checked.length; i++) {
    let object = {}
    if (radio_checked[i].checked) {
      object = {
        checked: true,
        sub_title_id: radio_checked[i].value
      }
    } else {
      object = {
        checked: false,
        sub_title_id: radio_checked[i].value
      }
    }
    object_v.push(object);
  }
  $.ajax({
    type: "POST",
    url: "controllers/form_visit_summary_controller",
    data: {
      form_visit_id: params.form_visit_id,
      summary_checked: JSON.stringify(object_v),
      addVisitData: true,
    },
    dataType: "json",
    success: async function (json) {
      if (json.status) {
        alert("บันทึกข้อมูลสำเร็จ");
        window.location.href = "form1_2";
      } else {
        alert(json.msg);
      }
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
}

// function inputPeople(sum_people, id) {
//   const all = document.getElementById("quan_sum").value;
//   let a = (sum_people.value / all) * 100;
//   document.getElementById("p_" + id).value = a.toFixed(0);
// }

// function checksumpeople() {
//     const count_std = document.querySelectorAll(".input-count-std");
//     const all = document.getElementById("quan_sum").value;
//     for (var i = 0; i < count_std.length; i++) {
//         if (count_std[i].value > all) {
//             alert("จำนวนที่กรอกเกินจำนวนนักศึกษาที่มี");
//             return;
//         }
//     }

// }
