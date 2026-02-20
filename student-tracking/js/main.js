function validateFrom(type = "add") {
  if ($("#role_select").val() == 0) {
    alert("โปรดกรอกสิทธิ์ผู้ใช้งาน");
    $("#role_select").focus();
    return false;
  }

  if ($("#role_select").val() != 1) {
    if ($("input[name=radio]:checked").val() == "edu") {
      if ($("#pro_name").val() == "0") {
        alert("โปรดเลือกจังหวัด");
        return false;
      }

      if ($("#dis_name").val() == "0") {
        alert("โปรดเลือกอำเภอ");
        return false;
      }

      console.log($("#role_select").val());
      if ($("#role_select").val() != 2) {
        if ($("#sub_name").val() == "0") {
          alert("โปรดเลือกตำบล");
          return false;
        }

        if ($("#check_new").val() == "new") {
          if ($("#new_edu_code").val() == "") {
            alert("โปรดกรอกรหัสสถานศึกษา");
            $("#new_edu_code").focus();
            return false;
          }
          if ($("#new_edu_name").val() == "") {
            alert("โปรดกรอกชื่อสถานศึกษา");
            $("#new_edu_name").focus();
            return false;
          }
        } else {
          if ($("#edu_select").val() == "0") {
            alert("โปรดเลือกสถานศึกษา");
            return false;
          }
        }
      }
    } else if ($("input[name=radio]:checked").val() == "edu_other") {
      if ($("#edu_other_select").val() == "0") {
        alert("โปรดเลือกสถานศึกษา");
        return false;
      }
    }
  }
  if (!$("#name").val()) {
    alert("โปรดกรอกชื่อ");
    $("#name").focus();
    return false;
  }
  if (!$("#surname").val()) {
    alert("โปรดกรอกนามสกุล");
    $("#surname").focus();
    return false;
  }
  if (!$("#username").val()) {
    alert("โปรดกรอกชื่อผู้ใช้");
    $("#username").focus();
    return false;
  }
  if (!verifyUsername($("#username").val())) {
    alert("ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษและไม่มีเว้นวรรคหรืออักษรพิเศษ");
    $("#username").focus();
    return false;
  }
  if (type != "edit") {
    if ($("#password").val() == "") {
      alert("โปรดกรอกรหัสผ่าน");
      $("#password").focus();
      return false;
    }
    if ($("#password").val().length < 8) {
      alert("โปรดกรอกรหัสผ่าน 8 ตัวขึ้นไป");
      return false;
    }
  }

  return true;
}

function verifyPassword(password) {
  // Check if password contains at least one lowercase letter and one digit
  const lowercaseRegex = /[a-z]/;
  const digitRegex = /\d/;
  const hasLowercase = lowercaseRegex.test(password);
  const hasDigit = digitRegex.test(password);

  // Check if password length is greater than or equal to 8
  const hasValidLength = password.length >= 8;
  const labelCheckPassword = document.getElementById("checkPassword");
  if (!hasLowercase) {
    //alert("รูปแบบรหัสผ่านต้องเป็นตัวพิมพ์เล็ก");
    labelCheckPassword.innerHTML = "รูปแบบรหัสผ่านต้องเป็นตัวพิมพ์เล็ก";
    labelCheckPassword.style.display = "block";
    return false;
  }
  if (!hasDigit) {
    labelCheckPassword.innerHTML = "รูปแบบรหัสผ่านต้องมีตัวเลข";
    labelCheckPassword.style.display = "block";
    return false;
  }
  if (!hasValidLength) {
    labelCheckPassword.innerHTML = "รูปแบบรหัสผ่านต้องมีอ่างน้อย 8 ตัว";
    labelCheckPassword.style.display = "block";
    return false;
  }
  labelCheckPassword.style.display = "none";
  return hasLowercase && hasDigit && hasValidLength;
}

function verifyUsername(username) {
  // Check if username contains only English letters
  const englishLettersRegex = /^[a-zA-Z]+$/;
  return englishLettersRegex.test(username);
}

function parse_query_string(query) {
  var vars = query.split("&");
  var query_string = {};
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    var key = decodeURIComponent(pair.shift());
    var value = decodeURIComponent(pair.join("="));
    // If first entry with this name
    if (typeof query_string[key] === "undefined") {
      query_string[key] = value;
      // If second entry with this name
    } else if (typeof query_string[key] === "string") {
      var arr = [query_string[key], value];
      query_string[key] = arr;
      // If third or later entry with this name
    } else {
      query_string[key].push(value);
    }
  }
  return query_string;
}

function checkBehaviorChecked(check_status, mode = "add") {
  let arr = [];
  let arr_sum_score = [];
  let sum_score1 = 0;
  let sum_score2 = 0;
  let sum_score3 = 0;
  let sum_score4 = 0;
  let sum_score5 = 0;

  const body_behavior = document.getElementById("body-behavior");
  const body_childen = body_behavior.children;
  for (const tr_body of body_childen) {
    let check = false;
    const tr = tr_body.children;
    for (let tr_i = 0; tr_i < tr.length; tr_i++) {
      if (tr_i > 1) {
        const td_tr = tr[tr_i].children;
        const radio_check = td_tr[0].checked;
        if (radio_check) {
          check = radio_check;
          let side = td_tr[0].getAttribute("data-side");
          let score = td_tr[0].getAttribute("data-score");
          if (mode == 'add') {
            arr.push({
              behavior_status: td_tr[0].value,
              id: td_tr[0].getAttribute("data-id"),
            });
          } else {
            arr.push({
              behavior_status: td_tr[0].value,
              id: td_tr[0].getAttribute("data-id"),
              form_det_id: td_tr[0].getAttribute("data-form_det_id")
            });
          }
          if (side == 1) {
            sum_score1 = sum_score1 + parseInt(score);
          }
          if (side == 2) {
            sum_score2 = sum_score2 + parseInt(score);
          }
          if (side == 3) {
            sum_score3 = sum_score3 + parseInt(score);
          }
          if (side == 4) {
            sum_score4 = sum_score4 + parseInt(score);
          }
          if (side == 5) {
            sum_score5 = sum_score5 + parseInt(score);
          }
        }
      }
    }

    if (!check) {
      tr_body.children[2].children[0].focus();
      alert("โปรดประเมินให้ครบทุกข้อ");
      return;
    }
  }
  const sum_score = sum_score1 + sum_score2 + sum_score3 + sum_score4;

  $("#score_1").val(sum_score1);
  $("#score_2").val(sum_score2);
  $("#score_3").val(sum_score3);
  $("#score_4").val(sum_score4);
  $("#sum_score").val(sum_score);
  $("#score_5").val(sum_score5);

  $("#result_1").html(
    sum_score1 <= 5
      ? `<span class="badge badge-pill badge-success">ปกติ</span>`
      : `<span class="badge badge-pill badge-danger">เสี่ยง/มีปัญหา</span>`
  );
  $("#result_2").html(
    sum_score2 <= 4
      ? `<span class="badge badge-pill badge-success">ปกติ</span>`
      : `<span class="badge badge-pill badge-danger">เสี่ยง/มีปัญหา</span>`
  );
  $("#result_3").html(
    sum_score3 <= 5
      ? `<span class="badge badge-pill badge-success">ปกติ</span>`
      : `<span class="badge badge-pill badge-danger">เสี่ยง/มีปัญหา</span>`
  );
  $("#result_4").html(
    sum_score4 <= 3
      ? `<span class="badge badge-pill badge-success">ปกติ</span>`
      : `<span class="badge badge-pill badge-danger">เสี่ยง/มีปัญหา</span>`
  );
  $("#result_sum").html(
    sum_score <= 16
      ? `<span class="badge badge-pill badge-success">ปกติ</span>`
      : `<span class="badge badge-pill badge-danger">เสี่ยง/มีปัญหา</span>`
  );
  $("#result_5").html(
    sum_score5 <= 3
      ? `<span class="badge badge-pill badge-danger">ไม่มีจุดแข็ง</span>`
      : `<span class="badge badge-pill badge-success">เป็นจุดแข็ง</span>`
  );

  document.getElementById("div_result").style.display = "block";
  document.getElementById("footer_btn").style.display = "block";
  document.getElementById("btn-submit").focus();
  if (check_status != "cal_score") {
    return arr;
  }
}

function validateDataEmpty() {
  const std_id = document.getElementById("std_select");
  if (std_id.value == "0") {
    alert("โปรดเลือกนักศึกษา");
    std_id.focus();
    return false;
  }
  return true;
}

function ConvertToThaiDate(date) {
  date = date.split("-");
  date = date[0] - 543 + "-" + date[1] + "-" + date[2];
  date = new Date(date);
  const options = {
    year: "numeric",
    month: "numeric",
    day: "numeric",
    calendar: "buddhist",
  };
  const thaiDate = date.toLocaleDateString("th-TH", options);
  return thaiDate;
}

function getDataStd(std_class = "") {
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
      json_res.data.forEach((element, i) => {
        std_select.innerHTML += `<option data-father="${element.std_father_name}" 
                                          data-father-job="${element.std_father_job}"
                                          data-mather="${element.std_mather_name}"
                                          data-mather-job="${element.std_mather_job}"  
                                value="${element.std_id}">${element.std_code} - ${element.std_prename}${element.std_name}</option>`;
      });
    },
  });
}

function getClassInDropdown(
  key = "getClassInDropdown",
  url = "controllers/form_screening_controller",
  id = "class_dropdown"
) {
  const obj = {};
  obj[key] = true;
  $.ajax({
    type: "POST",
    url: url,
    data: obj,
    dataType: "json",
    success: function (json_data) {
      const drop_class = document.getElementById(id);
      drop_class.innerHTML = "";
      drop_class.innerHTML = `
                  <option value="0">ชั้นทั้งหมด</option>
              `;
      json_data.data.forEach((element) => {
        drop_class.innerHTML += `
                  <option value="${element.std_class}">${element.std_class}</option>
              `;
      });
    },
  });
}

function getSubDistrict(
  key = "getSubDistrict",
  url = "controllers/form_screening_controller",
  id = "subdistrict_select"
) {
  const obj = {};
  obj[key] = true;
  $.ajax({
    type: "POST",
    url: url,
    data: obj,
    dataType: "json",
    success: function (json_data) {
      const drop_class = document.getElementById(id);
      drop_class.innerHTML = "";
      drop_class.innerHTML = `
                  <option value="0">ตำบลทั้งหมด</option>
              `;
      json_data.data.forEach((element) => {
        drop_class.innerHTML += `
                  <option value="${element.sub_district_id}">${element.sub_district_name}</option>
              `;
      });
    },
  });
}
