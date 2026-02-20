$(document).ready(function () {
  // getDataAdmin(0)
  if (role_id != 4) {
    $("#std_select").select2();
    getDataStd_new();
  }
});

let data_std = null;

function getDataStd_new(std_class = "") {
  $.ajax({
    type: "POST",
    url: "controllers/student_controller",
    data: {
      getDataStudent: true,
      std_class: std_class
    },
    dataType: "json",
    success: function (json_res) {
      const std_select = document.getElementById("std_select");
      std_select.innerHTML = "";
      std_select.innerHTML += `<option value="0">เลือกนักศึกษา</option>`;
      data_std = json_res.data
      data_std.forEach((element, i) => {
        std_select.innerHTML += `<option value="${element.std_id}">${element.std_code} - ${element.std_prename}${element.std_name}</option>`;
      });
    },
  });
}

function getDataStdbtStdId(std_id) {
  let std_data = data_std.filter((std) => std.std_id == std_id);
  std_data = std_data[0];
  $("#std_name").val(`${std_data.std_prename}${std_data.std_name}`)
  $("#std_birthday").val(std_data.std_birthday)
  $("#age_show").val(calculateAge(std_data.std_birthday.trim()))
  $("#age").val(calculateAge(std_data.std_birthday.trim()))
}

function convertThaiDateToJS(thaiDate) {
  const thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
  const dateParts = thaiDate.split(" ");
  const day = parseInt(dateParts[0]); // Day component, not used for age calculation
  const monthIndex = thaiMonths.indexOf(dateParts[1]);
  const year = parseInt(dateParts[2]) - 543; // Convert Thai year to Western year
  return new Date(year, monthIndex, day);
}

function calculateAge(birthday) {
  let birthdayC = convertThaiDateToJS(birthday);
  console.log(birthdayC);

  const today = new Date();
  let age = today.getFullYear() - birthdayC.getFullYear();

  // Adjust age if the birthday month hasn't occurred yet this year
  if (today.getMonth() < birthdayC.getMonth() ||
    (today.getMonth() === birthdayC.getMonth() && today.getDate() < birthdayC.getDate())) {
    age--;
  }

  return age;
}

$("#form-add-student-data").submit((e) => {
  e.preventDefault();
  console.log($('#std_select').val());
  if (role_id != 4 && $('#std_select').val() == 0) {
    alert("โปรดเลือกนักศึกษา")
    $('#std_select').focus();
    return false;
  }
  // if (!validateInput()) {
  //   return false;
  // }
  // if (!$('#expectations').val()) {
  //   alert($('#expectations').attr('placeholder'))
  //   $('#expectations').focus();
  //   return false;
  // }

  let param_data = $("#form-add-student-data").serialize();
  const std_id = $("#std_select").val();
  param_data = param_data + `&std_id=${std_id}&add_std_data_new=true`;

  $.ajax({
    type: "POST",
    url: "controllers/form_student_person_controller",
    data: param_data,
    dataType: "json",
    success: async function (json) {
      alert(json.msg);
      if (json.status) {
        // window.location.href = role_id == 4 ? 'students_data' : "form1_1_new";
        window.location.href = role_id == 4 ? '../main_menu?list=1' : "form1_1_new";
      }
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
});

function validateInput() {
  let returnValue = false;
  $("#form-add-student-data input:not(:disabled):visible").each((index, element) => {
    if ((element.type == "text" || element.type == "number") && $(element).hasClass("required")) {
      if (element.value == "") {
        alert(element.placeholder)
        element.focus();
        returnValue = false;
        return false;
      }
    } else if (element.type == "checkbox") {
      const parentEle = $(element).parent();
      const listChil = $(parentEle).children();
      let countcheckboxCheck = 0;
      for (let i = 0; i < listChil.length; i++) {
        if (listChil[i].type == "checkbox" && listChil[i].checked) {
          countcheckboxCheck++;
        }
      }
      if (!countcheckboxCheck) {
        alert(`${element.placeholder}`);
        element.focus();
        returnValue = false;
        return false;
      }
    } else if (element.type == "radio") {
      const groupName = $(element).attr("name");
      const group = $(`input[name='${groupName}']`);
      const checked = group.filter(":checked").length > 0;

      if (!checked && $(element).hasClass("required")) {
        alert(`${element.placeholder}`);
        element.focus();
        returnValue = false;
        return false;
      }
    }
    returnValue = true;
  })
  return returnValue;
}

function addValue() {
  $("#form-add-student-data input:not(:disabled):visible").each((index, element) => {
    if (element.type == "text" && $(element).hasClass("required")) {
      if (element.value == "") {
        element.value = "Test data";
      }
    } else if (element.type == "number" && $(element).hasClass("required")) {
      if (element.value == "") {
        element.value = "1234";
      }
    } else if (element.type == "checkbox") {
      const parentEle = $(element).parent();
      const listChil = $(parentEle).children();
      let countcheckboxCheck = 0;
      for (let i = 0; i < listChil.length; i++) {
        if (listChil[i].type == "checkbox" && listChil[i].checked) {
          countcheckboxCheck++;
        }
      }
      if (!countcheckboxCheck) {
        element.checked = true
      }
    } else if (element.type == "radio") {
      const groupName = $(element).attr("name");
      const group = $(`input[name='${groupName}']`);
      const checked = group.filter(":checked").length > 0;

      if (!checked && $(element).hasClass("required")) {
        element.checked = true
      }
    }
  })
}

$('input[name=reason_learning_format]').change((e) => {
  const radio_val = $('input[name=reason_learning_format]:checked').val();
  if (radio_val == 6) {
    $('#reason_learning_format_other_text_display').show()
  } else {
    $('#reason_learning_format_other_text').val("")
    $('#reason_learning_format_other_text_display').hide()
  }
})