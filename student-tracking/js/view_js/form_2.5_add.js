$(document).ready(function () {
  $("#std_select").select2();
  getDataStd();
});

$("#form_add_screening_std").submit((e) => {
  e.preventDefault();
  if ($("#std_select").val() == "0") {
    alert("โปรดระบุนักศึกษา");
    $("#std_select").focus();
    return false;
  }
  const ObjJson = {
    add_screening: true,
    std_id: $("#std_select").val(),
    side_1: JSON.stringify(getValueSide1()),
    side_2: JSON.stringify(getValueSide2()),
    side_3: JSON.stringify(getValueSide3()),
    side_4: JSON.stringify(getValueSide4()),
    side_5: JSON.stringify(getValueSide5()),
  };
  $.ajax({
    type: "POST",
    url: "controllers/form_screening_controller",
    data: ObjJson,
    dataType: "json",
    success: async function (json_res) {
      if (json_res.status) {
        alert(json_res.msg);
        window.location.href = "form2_5";
      } else {
        alert(json_res.msg);
        window.location.reload();
      }
    },
  });
});
