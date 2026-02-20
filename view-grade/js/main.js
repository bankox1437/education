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

      if ($('input[name="role_id"]:checked').val() != 2 && $('input[name="role_id"]:checked').val() != 5) {
        if ($("#sub_name").val() == "0") {
          alert("โปรดเลือกตำบล");
          return false;
        }

        if ($("#check_new").val() == "new") {
          // if ($("#new_edu_code").val() == "") {
          //   alert("โปรดกรอกรหัสสถานศึกษา");
          //   $("#new_edu_code").focus();
          //   return false;
          // }
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

  if ($('input[name="role_id"]:checked').val() == 'custom') {
    if (!$("#custom_role_name").val()) {
      alert("โปรดกรอกชื่อสิทธิ์");
      $("#custom_role_name").focus();
      return false;
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