$("input[name=side_2_1]").change(function (e) {
  if (e.target.value == "unsure") {
    $("#input_unsure_2_1").show();
    $("#side_2_2").addClass("mt-4");
  } else {
    $("#input_unsure_2_1").hide();
    $("#side_2_2").removeClass("mt-4");
  }
});

$("input[name=side_2_2]").change(function (e) {
  if (e.target.value == "unsure") {
    $("#input_unsure_2_2").show();
    $("#side_2_3").addClass("mt-4");
  } else {
    $("#input_unsure_2_2").hide();
    $("#side_2_3").removeClass("mt-4");
  }
});

$("input[name=side_2_3]").change(function (e) {
  if (e.target.value == "unsure") {
    $("#input_unsure_2_3").show();
    $("#side_2_4").addClass("mt-4");
  } else {
    $("#input_unsure_2_3").hide();
    $("#side_2_4").removeClass("mt-4");
  }
});

$("input[name=side_4]").change(function (e) {
  if (e.target.value == "promote" || e.target.value == "help") {
    $("#text_4").show();
  } else {
    $("#text_4").hide();
  }
});

function getObjSide2() {
  let side_2_1_val = $("input[name=side_2_1]:checked").val();
  let side_2_2_val = $("input[name=side_2_2]:checked").val();
  let side_2_3_val = $("input[name=side_2_3]:checked").val();
  let side_2_4_val = $("#another_2_4").val();

  if (side_2_1_val == "unsure") {
    if ($("#input_unsure_2_1").val() == "") {
      $("#input_unsure_2_1").focus();
      return false;
    }
    side_2_1_val = $("#input_unsure_2_1").val();
  }

  if (side_2_2_val == "unsure") {
    if ($("#input_unsure_2_2").val() == "") {
      $("#input_unsure_2_2").focus();
      return false;
    }
    side_2_2_val = $("#input_unsure_2_2").val();
  }

  if (side_2_3_val == "unsure") {
    if ($("#input_unsure_2_3").val() == "") {
      $("#input_unsure_2_3").focus();
      return false;
    }
    side_2_3_val = $("#input_unsure_2_3").val();
  }
  const side2 = {
    side_2_1: side_2_1_val,
    side_2_2: side_2_2_val,
    side_2_3: side_2_3_val,
    side_2_4: side_2_4_val,
  };
  return side2;
}

function getObjSide3() {
  let text_3_1 = $("#text_3_1").val();
  let text_3_2 = $("#text_3_2").val();
  let text_3_3 = $("#text_3_3").val();
  let side_3_5 = $("#side_3_5").val();

  if (text_3_1 == "") {
    $("#text_3_1").focus();
    return false;
  }

  if (text_3_2 == "") {
    $("#text_3_2").focus();
    return false;
  }

  if (text_3_3 == "") {
    $("#text_3_3").focus();
    return false;
  }

  const side3 = {
    text_3_1: text_3_1,
    side_3_1: $("input[name=side_3_1]:checked").val(),
    text_3_2: text_3_2,
    side_3_2: $("input[name=side_3_2]:checked").val(),
    text_3_3: text_3_3,
    side_3_3: $("input[name=side_3_3]:checked").val(),
    side_3_4: $("input[name=side_3_4]:checked").val(),
    side_3_5: side_3_5,
  };

  return side3;
}

function getObjSide4() {
  if ($("input[name=side_4]:checked").val() != "very_good") {
    if ($("#text_4").val() == "") {
      $("#text_4").focus();
      return false;
    }
  }
  const side4 = {
    text: $("#text_4").val(),
    status: $("input[name=side_4]:checked").val(),
  };
  return side4;
}

function changeInputFile(inputFile) {
  if (typeof inputFile.files == undefined) {
      //alert("ต้องเลือกรูปภาพ 4 ภาพ");
      return;
  }
  let file_label = "";
  file_label += inputFile.files[0].name + ", ";
  const file_src = URL.createObjectURL(inputFile.files[0]);
  $('#preview').attr('src', file_src);
  $('#preview').show();
}