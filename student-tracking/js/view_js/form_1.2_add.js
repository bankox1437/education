$(document).ready(function () {
  $("#std_select").select2();
  getDataStd();
});

function submitFormVisit2() {
  const std_id = $("#std_select").val();
  if (std_id == 0) {
    alert("โปรดระบุนักศึกษา");
    $("#std_select").focus();
    return;
  }
  if (!getObjSide2() || !getObjSide3() || !getObjSide4()) {
    alert("โปรดกรอกข้อมูลที่กำหนด");
    return;
  }
  const side5 = $("#side_5").val();
  const json_obj = {
    std_id: std_id,
    side2: getObjSide2(),
    side3: getObjSide3(),
    side4: getObjSide4(),
    side5: side5,
    AddDataVisit: true,
  };
  $.ajax({
    type: "POST",
    url: "controllers/form_visit_home_controllers",
    data: json_obj,
    dataType: "json",
    success: async function (json_res) {
      if (json_res.status) {
        alert(json_res.msg);
        window.location.href = "form1_2";
      } else {
        alert(json_res.msg);
        window.location.reload();
      }
    },
  });
}

function submitFormVisit() {
  const std_id = $("#std_select").val();
  if (std_id == 0) {
    alert("โปรดระบุนักศึกษา");
    $("#std_select").focus();
    return;
  }
  if (!getObjSide2() || !getObjSide3() || !getObjSide4()) {
    alert("โปรดกรอกข้อมูลที่กำหนด");
    return;
  }
  const side5 = $("#side_5").val();
  const test_grade_file = document.getElementById('side_6').files[0];

  if (typeof test_grade_file == 'undefined') {
    alert('โปรดแนบรูปภาพบ้านนักศึกษา')
    $('#side_6').focus()
    return false;
  }

  let formData = new FormData();
  formData.append('std_id', std_id);
  formData.append('side2', JSON.stringify(getObjSide2()));
  formData.append('side3', JSON.stringify(getObjSide3()));
  formData.append('side4', JSON.stringify(getObjSide4()));
  formData.append('father_name', $("#father").val());
  formData.append('father_job', $("#father_job").val());
  formData.append('mather_name', $("#mather").val());
  formData.append('mather_job', $("#mather_job").val());
  formData.append('side5', side5);
  formData.append('side6', test_grade_file);
  formData.append('AddDataVisit', true);

  $.ajax({
    type: "POST",
    url: "controllers/form_visit_home_controllers",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    success: async function (json) {
      if (json.status) {
        alert(json.msg);
        window.location.href = 'form1_2';
      } else {
        alert(json.msg);
      }
    },
  });
}