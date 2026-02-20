$(document).ready(async function () {
  getDataVisitHome();
  getClassInDropdown(
    "getClassInDropdown",
    "controllers/form_visit_home_controllers"
  );
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

function getDataVisitHome() {
  const Tbody = document.getElementById("body-visit");
  Tbody.innerHTML = "";
  Tbody.innerHTML += `
            <tr>
                <td colspan="${role_id != 3 && type_user != "edu_other" ? 13 : 10
    }" class="text-center">
                    <?php include "include/loader_include.php"; ?>
                </td>
            </tr>
        `;
  $.ajax({
    type: "POST",
    url: "controllers/form_visit_home_controllers",
    data: {
      getDataVisitHome: true,
    },
    dataType: "json",
    success: function (json_res) {
      genHtmlTable(json_res.data);
    },
  });
}

function genHtmlTable(data) {
  const Tbody = document.getElementById("body-visit");
  Tbody.innerHTML = "";
  if (data.length == 0) {
    Tbody.innerHTML += `
            <tr>
                <td colspan="${role_id != 3 && type_user != "edu_other" ? 13 : 10
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
                <td>${element.user_create_data}</td>
                <td>${element.edu_name}</td>
                <td class="text-center"><a href="${element.location == ""
        ? "https://www.google.co.th/maps/"
        : element.location
      }" target="_blank"><i class="ti-map-alt" style="font-size:20px"></i></a></td>
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
                    <a href="pdf/แบบบันทึกการเยี่ยมบ้าน?form_id=${element.form_visit_id
      }" target="_blank">
                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-printer"></i></button>
                    </a>
                </td>
                ${role_id == 3 ?
        `
                  <td class="text-center">
                      <a href="form1_2_edit.php?form_visit_id=${element.form_visit_id}&std_name=${element.std_prename}${element.std_name}">
                                  <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                              </a>
                  </td>
                    <td class="text-center">
                    ${element.form_status == 1 ?
          `
                               <a href="form1_3_new_edit.php?form_visit_id=${element.form_visit_id
          }&std_name=${element.std_prename}${element.std_name}">
                                  <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                              </a>
                              `
          :
          `
                                <a href="form1_3_add_new.php?form_visit_id=${element.form_visit_id
          }&std_name=${element.std_prename}${element.std_name}">
                                  <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-plus"></i></button>
                              </a>
                             
                              `
        }
                          </td>
                  <td class="text-center">
                      
                      <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteDataForm(${element.form_visit_id
        },'${element.std_name}')"><i class="ti-trash"></i></button>
                  </td>
                  ` : ''
      }
            </tr>
        `;
  });
  // <a href="manage_admin_edit?form_id=${element.form_evaluate_id}">
  //     <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
  // </a>
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

function deleteDataForm(id, name) {
  const confirmDelete = confirm("ต้องการลบข้อมูลของ " + name + " หรือไม่?");
  if (confirmDelete) {
    $.ajax({
      type: "POST",
      url: "controllers/form_visit_home_controllers",
      data: {
        delete_form_1_2: true,
        id: id,
      },
      dataType: "json",
      success: function (data) {
        if (data.status) {
          getDataVisitHome();
        } else {
          alert(data.msg);
          window.location.reload();
        }
      },
    });
  }
}

$('#filter-data').click(() => getDataByWhere())
$('#show-all').click(() => {
  getDataVisitHome()
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
    getDataVisitHome();
  } else {
    let obj = {}
    if (role_id == 1) {
      obj = {
        pro_id: pro_id,
        dis_id: dis_id,
        std_class: std_class,
        sub_district_id: sub_district_id,
        getDataVisitHomeByClass: true
      }
    }

    if (role_id == 2) {
      obj = {
        pro_id: pro_id,
        dis_id: dis_id,
        std_class: std_class,
        sub_district_id: sub_district_id,
        getDataVisitHomeByAmphur: true
      }
    }

    if (role_id == 3) {
      obj = {
        pro_id: pro_id,
        dis_id: dis_id,
        std_class: std_class,
        sub_district_id: sub_district_id,
        getDataVisitHomeByClass: true
      }
    }

    $.ajax({
      type: "POST",
      url: "controllers/form_visit_home_controllers",
      data: obj,
      dataType: "json",
      success: function (json_res) {
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
//     getDataVisitHome();
//   } else {
//     $.ajax({
//       type: "POST",
//       url: "controllers/form_visit_home_controllers",
//       data: {
//         getDataVisitHomeByClass: true,
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
