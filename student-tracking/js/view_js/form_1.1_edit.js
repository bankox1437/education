
$("#form-edit-student-data").submit((e) => {
  e.preventDefault();
  // if (!validateInput()) {
  //   return false;
  // }
  // if (!$('#expectations').val()) {
  //   alert($('#expectations').attr('placeholder'))
  //   $('#expectations').focus();
  //   return false;
  // }
  let param_data = $("#form-edit-student-data").serialize();
  param_data = param_data + `&edit_std_data_new=true`;

  $.ajax({
    type: "POST",
    url: "controllers/form_student_person_controller",
    data: param_data,
    dataType: "json",
    success: async function (json) {
      alert(json.msg);
      if (json.status) {
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
  $("#form-edit-student-data input:not(:disabled):visible").each((index, element) => {
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
  $("#form-edit-student-data input:not(:disabled):visible").each((index, element) => {
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