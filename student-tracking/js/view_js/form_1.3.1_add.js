$(document).ready(function () {
  $("#std_select").select2();
  getDataStd();
});

function checkedbehavior(id) {
  document.getElementById(id).setAttribute("checked", true);
}

$("#form-add-evaluate").submit((e) => {
  e.preventDefault();
  if (!validateDataEmpty()) {
    return;
  }
  const arr_data = checkBehaviorChecked("submit");
  const json_object = {
    add_evaluate_std: true,
    behavior_data: JSON.stringify(arr_data),
    std_id: $("#std_select").val(),
    note: $("#note").val(),
    score_1: $("#score_1").val(),
    score_2: $("#score_2").val(),
    score_3: $("#score_3").val(),
    score_4: $("#score_4").val(),
    sum_score: $("#sum_score").val(),
    score_5: $("#score_5").val(),
  };
  $.ajax({
    type: "POST",
    url: "controllers/form_evaluate_controller",
    data: json_object,
    dataType: "json",
    success: async function (json_res) {
      if (json_res.status) {
        alert("บันทึกแบบประเมินสำเร็จ");
        window.location.href = "form1_3_1";
      } else {
        alert(json_res.msg);
        window.location.reload();
      }
    },
  });
});
