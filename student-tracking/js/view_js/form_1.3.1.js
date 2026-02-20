$(document).ready(async function () {
  getDataEvaluate();
  getClassInDropdown(
    "getClassInDropdown",
    "controllers/form_evaluate_controller"
  ); // get class
  // if (role_id != 3 && type_user != "edu_other") {
  //   getSubDistrict("getSubDistrict", "controllers/form_evaluate_controller"); //get subdistrict
  // }
  await getDataProDistSub();
  if (role_id == 2) {
    $('#subdistrict_select').select2()
  }
  if (role_id == 1) {
    $('#province_select').select2()
    $('#district_select').select2()
    $('#subdistrict_select').select2()
  }
});

function getDataEvaluate() {
  const Tbody = document.getElementById("body-evaluate");
  Tbody.innerHTML = "";
  Tbody.innerHTML += `
            <tr>
                <td colspan="${role_id != 3 && type_user != "edu_other" ? 12 : 9
    }" class="text-center">
                    <?php include "include/loader_include.php"; ?>
                </td>
            </tr>
        `;
  $.ajax({
    type: "POST",
    url: "controllers/form_evaluate_controller",
    data: {
      getDataEvaluate: true,
    },
    dataType: "json",
    success: function (json_res) {
      genHtmlTable(json_res.data);
    },
  });
}

function genHtmlTable(data) {
  const Tbody = document.getElementById("body-evaluate");
  Tbody.innerHTML = "";
  if (data.length == 0) {
    Tbody.innerHTML += `
            <tr>
                <td colspan="${role_id != 3 && type_user != "edu_other" ? 11 : 8
      }" class="text-center">
                    ไม่มีข้อมูล
                </td>
            </tr>
        `;
    return;
  }
  data.forEach((element, i) => {
    Tbody.innerHTML += `
            <tr>
                <td class="text-center">${i + 1}</td>
                <td>${element.std_code}</td>
                <td>${element.std_prename}${element.std_name}</td>
                <td>${element.std_class}</td>
                <td>${element.edu_name}</td>
                <td>${element.user_create_data}</td>
                ${role_id != 3 && type_user != "edu_other"
        ? `
                    <td>${element.sub_district != null ? element.sub_district : "-"
        }</td>
                    <td>${element.district != null ? element.district : "-"
        }</td>
                    <td>${element.province != null ? element.province : "-"
        }</td>    
                `
        : ""
      }
                <td class="text-center">
                    <a href="pdf/แบบประเมินนักศึกษา?form_id=${element.form_evaluate_id
      }" target="_blank" >
                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-printer"></i></button>
                    </a>
                </td>

               ${role_id == 3 ? `
               <td class="text-center">
               <a href="form1_3_1_edit?form_id=${element.form_evaluate_id}&std_name=${element.std_prename}${element.std_name}">
               <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
               </a>
           </td>

               <td class="text-center">
                   <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteDataForm(${element.form_evaluate_id
        })"><i class="ti-trash"></i></button>
               </td>
               ` : ''}
            </tr>
        `;
  });
}

function deleteDataForm(id) {
  const confirmDelete = confirm("ต้องการลบข้อมูลนี้หรือไม่?");
  if (confirmDelete) {
    $.ajax({
      type: "POST",
      url: "controllers/form_evaluate_controller",
      data: {
        delete_form_evaluate: true,
        form_eva_id: id,
      },
      dataType: "json",
      success: function (data) {
        if (data.status) {
          getDataEvaluate();
        } else {
          alert(data.msg);
        }
      },
    });
  }
}

async function getDistrictDataAmphur() {
  return Promise.resolve($.ajax({
    type: "POST",
    url: "controllers/dashboard_controller",
    data: {
      getDistrictDataAmphur: true,
    },
    dataType: "json",
  }));
}
async function getDataProDistSub() {
  $.ajax({
    type: "POST",
    url: "controllers/user_controller",
    data: {
      getDataProDistSub: true
    },
    dataType: "json",
    success: async function (json_data) {
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
        let dis_data;
        await getDistrictDataAmphur().then((result) => {
          dis_data = result.data[0]
        })
        const sub_name = document.getElementById('subdistrict_select');
        sub_name.innerHTML = "";
        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
        $('#district_select_value').val(dis_data.dis_id);
        const sub_district = main_sub_district_id.filter((sub) => {
          return sub.district_id == dis_data.dis_id
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

$('#filter-data').click(() => getDataByWhere())
$('#show-all').click(() => {
  getDataEvaluate()
  $("#province_select").val(0).change();
  $("#district_select").val(0).change();
  $("#subdistrict_select").val(0).change();
});

function getDataByWhere() {
  const pro_id = $('#province_select').val() ?? 0
  const dis_id = $('#district_select').val() ?? 0
  const sub_district_id = $('#subdistrict_select').val() ?? 0
  const std_class = $("#class_dropdown").val() ?? 0
  console.log("pro_id=>", pro_id, "dis_id", dis_id, "sub_district_id", sub_district_id, "std_class", std_class);
  if (pro_id == '0' && dis_id == '0' && sub_district_id == '0' && std_class == "0") {
    getDataEvaluate();
  } else {
    let obj = {}
    if (role_id == 1) {
      obj = {
        pro_id: pro_id,
        dis_id: dis_id,
        std_class: std_class,
        sub_district_id: sub_district_id,
        getDataEvaluateByWhere: true
      }
    }

    if (role_id == 2) {
      obj = {
        pro_id: pro_id,
        dis_id: dis_id,
        std_class: std_class,
        sub_district_id: sub_district_id,
        getDataEvaluateByAmphur: true
      }
    }

    if (role_id == 3) {
      obj = {
        pro_id: pro_id,
        dis_id: dis_id,
        std_class: std_class,
        sub_district_id: sub_district_id,
        getDataEvaluateByWhere: true
      }
    }

    console.log(obj);
    $.ajax({
      type: "POST",
      url: "controllers/form_evaluate_controller",
      data: obj,
      dataType: "json",
      success: function (json_res) {
        console.log(json_res);
        if (json_res.status) {
          genHtmlTable(json_res.data);
        }
      },
    });
  }
}

// function getDataByWhere() {
//   const std_class = $("#class_dropdown").val();
//   let sub_district_id = 0;
//   if (role_id != 3 && type_user != "edu_other") {
//     sub_district_id = $("#subdistrict_select").val();
//   }
//   if (std_class == "0" && sub_district_id == "0") {
//     getDataEvaluate();
//   } else {
//     $.ajax({
//       type: "POST",
//       url: "controllers/form_evaluate_controller",
//       data: {
//         getDataEvaluateByClass: true,
//         std_class: std_class ?? 0,
//         sub_district_id: sub_district_id ?? 0,
//       },
//       dataType: "json",
//       success: function (json_res) {
//         if (json_res.status) {
//           genHtmlTable(json_res.data);
//         }
//       },
//     });
//   }
// }
