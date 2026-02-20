$(document).ready(function () {
  getStudentPerson();
  getClassInDropdown(
    "getClassInDropdown",
    "controllers/form_visit_summary_controller"
  ); // get class
  if (role_id != 3 && type_user != "edu_other") {
    getSubDistrict(
      "getSubDistrict",
      "controllers/form_visit_summary_controller"
    ); //get subdistrict
  }
});

function getDataByWhere() {
  const std_class = $("#class_dropdown").val();
  let sub_district_id = 0;
  if (role_id != 3 && type_user != "edu_other") {
    sub_district_id = $("#subdistrict_select").val();
  }

  if (std_class == "0" && sub_district_id == "0") {
    getDataVisit();
  } else {
    $.ajax({
      type: "POST",
      url: "controllers/form_visit_summary_controller",
      data: {
        getDataVisitSummaryByStdClass: true,
        std_class: std_class ?? 0,
        sub_district_id: sub_district_id ?? 0,
      },
      dataType: "json",
      success: function (json_res) {
        if (json_res.status) {
          genHtmlTable(json_res.data);
        }
      },
    });
  }
}

function getStudentPerson() {
  const Tbody = document.getElementById("data-student");
  Tbody.innerHTML = "";
  Tbody.innerHTML += `
            <tr>
                <td colspan="
        <td colspan="${
          role_id != 3 && type_user != "edu_other" ? 12 : 9
        }" class="text-center">
                    <?php include "include/loader_include.php"; ?>
                </td>
            </tr>
        `;
  $.ajax({
    type: "POST",
    url: "controllers/form_student_person_controller",
    data: {
      getStudentPerson: true,
    },
    dataType: "json",
    success: function (json_data) {
      genHtmlTable(json_data.data);
    },
  });
}

function genHtmlTable(data) {
  const Tbody = document.getElementById("data-student");
  Tbody.innerHTML = "";
  if (data.length == 0) {
    Tbody.innerHTML += `
            <tr>
                <td colspan="${
                  role_id != 3 && type_user != "edu_other" ? 12 : 9
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
                        ${
                          role_id != 3 && type_user != "edu_other"
                            ? `
                                <td>${
                                  element.sub_district != null
                                    ? element.sub_district
                                    : "-"
                                }</td>
                                <td>${
                                  element.district != null
                                    ? element.district
                                    : "-"
                                }</td>
                                <td>${
                                  element.province != null
                                    ? element.province
                                    : "-"
                                }</td>    
                            `
                            : ""
                        }
                    
                          <td class="text-center">
                              <a href="form1_3_add_new.php?sid=${
                              element.std_p_id
                            }">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-plus"></i></button>
                            </a>
                        </td>
                       
                    </tr>
        `;
  });
}

