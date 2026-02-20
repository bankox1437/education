function showInput(id) {
  const checkBox = document.getElementById(id);
  if (checkBox.checked) {
    document.getElementById(id + "_input").style.display = "block";
  } else {
    document.getElementById(id + "_input").style.display = "none";
  }
}

function showInputDisable(name) {
  console.log(name + "_input");
  if (name != "have_other") {
    document.getElementById("have_other_input").setAttribute("disabled", true);
  } else {
    document.getElementById("have_other_input").removeAttribute("disabled");
  }
}

function getValueSide1() {
  const objSide1 = {
    status: $("input[name=side_learning]:checked").val(),
  };
  const Arr_Side1 = [];
  const checkboxInput = document.querySelectorAll(".learning");
  for (let i = 0; i < checkboxInput.length; i++) {
    if (i == 5 || i == 11) {
      if (checkboxInput[i].checked) {
        Arr_Side1.push($("#learning_" + (i + 1) + "_other").val());
      } else {
        Arr_Side1.push(checkboxInput[i].checked);
      }
    } else {
      Arr_Side1.push(checkboxInput[i].checked);
    }
  }
  objSide1["arr_side1"] = Arr_Side1;

  if ($("input[name=side_learning_other]:checked").val() == "มี") {
    objSide1["arr_side1_1"] = $("#have_other_input").val();
  } else {
    objSide1["arr_side1_1"] = $(
      "input[name=side_learning_other]:checked"
    ).val();
  }

  return objSide1;
}

function getValueSide2() {
  const objSide2 = {
    status: $("input[name=side_health]:checked").val(),
  };
  const Arr_Side2 = [];
  const checkboxInput = document.querySelectorAll(".health");
  for (let i = 0; i < checkboxInput.length; i++) {
    if (i == 11 || i == 23) {
      if (checkboxInput[i].checked) {
        Arr_Side2.push($("#health_" + (i + 1) + "_other").val());
      } else {
        Arr_Side2.push(checkboxInput[i].checked);
      }
    } else {
      Arr_Side2.push(checkboxInput[i].checked);
    }
  }
  objSide2["arr_side2"] = Arr_Side2;
  return objSide2;
}

function getValueSide3() {
  const objSide3 = {
    side_3_1: $("input[name=mind_1]:checked").val(),
    side_3_2: $("input[name=mind_2]:checked").val(),
    side_3_3: $("input[name=mind_3]:checked").val(),
    side_3_4: $("input[name=mind_4]:checked").val(),
    side_3_summary: $("input[name=summary_4]:checked").val(),
  };
  return objSide3;
}

function getValueSide4() {
  const objSide4 = {
    status4_1: $("input[name=side_economy]:checked").val(),
  };
  const Arr_Side4_1 = [];
  const checkboxInput4_1 = document.querySelectorAll(".side_economy");
  for (let i = 0; i < checkboxInput4_1.length; i++) {
    if (i == 7) {
      if (checkboxInput4_1[i].checked) {
        Arr_Side4_1.push($("#economy_" + (i + 1) + "_other").val());
      } else {
        Arr_Side4_1.push(checkboxInput4_1[i].checked);
      }
    } else {
      Arr_Side4_1.push(checkboxInput4_1[i].checked);
    }
  }
  objSide4["arr_side4_1"] = Arr_Side4_1;
  objSide4["status4_2"] = $("input[name=protect_students]:checked").val();

  const Arr_Side4_2 = [];
  const checkboxInput4_2 = document.querySelectorAll(".protect_students");
  for (let i = 0; i < checkboxInput4_2.length; i++) {
    if (i == 6 || i == 13) {
      if (checkboxInput4_2[i].checked) {
        Arr_Side4_2.push($("#protect_students_" + (i + 1) + "_other").val());
      } else {
        Arr_Side4_2.push(checkboxInput4_2[i].checked);
      }
    } else {
      Arr_Side4_2.push(checkboxInput4_2[i].checked);
    }
  }
  objSide4["arr_side4_2"] = Arr_Side4_2;
  return objSide4;
}

function getValueSide5() {
  const objSide5 = {
    side_5_1: $("input[name=addictive]:checked").val(),
    side_5_2: $("input[name=sexual]:checked").val(),
    side_5_3: $("input[name=security]:checked").val(),
  };
  return objSide5;
}
