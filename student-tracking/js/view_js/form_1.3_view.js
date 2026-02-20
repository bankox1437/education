$(document).ready(function () {
  getStudentVisit();
  getClassInDropdown(
    "getClassInDropdown",
    "controllers/form_student_person_controller"
  ); // get class
  if (role_id != 3 && type_user != "edu_other") {
    getSubDistrict(
      "getSubDistrict",
      "controllers/form_student_person_controller"
    );
  }
});

function getStudentVisit() {
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
    url: "controllers/form_visit_summary_controller",
    data: {
      getStudentVisit: true,
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
                        <td class="text-center">
                            <a href="pdf/ข้อมูลนักศึกษารายบุคคล?form_std_p_id=${
                              element.form_v_sum_id
                            }" target="_blank">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-agenda"></i></button>
                            </a>
                        </td>
                          <td class="text-center">
                              <a href="form_1_1_edit.php?sid=${
                              element.form_v_sum_id
                            }">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                            </a>
                        </td>
                        <td class="text-center">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteStudent(${
                              element.form_v_sum_id
                            },'${
      element.std_name
    }')"><i class="ti-trash"></i></button>
                        </td>
                    </tr>
        `;
  });
}

function deleteStudent(id, name) {
  const confirmDelete = confirm("ต้องการลบนักศึกษาชื่อ " + name + " หรือไม่?");
  if (confirmDelete) {
    $.ajax({
      type: "POST",
      url: "controllers/form_student_person_controller",
      data: {
        delete_student: true,
        id: id,
      },
      dataType: "json",
      success: function (data) {
        if (data.status) {
          getStudentPerson();
        } else {
          alert(data.msg);
        }
      },
    });
  }
}

function getDataByWhere() {
  const std_class = $("#class_dropdown").val();
  let sub_district_id = 0;
  if (role_id != 3 && type_user != "edu_other") {
    sub_district_id = $("#subdistrict_select").val();
  }
  if (std_class == "0" && sub_district_id == "0") {
    getStudentPerson();
  } else {
    $.ajax({
      type: "POST",
      url: "controllers/form_student_person_controller",
      data: {
        getStudentPersonByClass: true,
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
