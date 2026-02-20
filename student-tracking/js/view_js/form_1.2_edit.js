function submitEditFormVisit2() {
    if (!getObjSide2() || !getObjSide3() || !getObjSide4()) {
        alert("โปรดกรอกข้อมูลที่กำหนด");
        return;
    }
    const side5 = $("#side_5").val();
    var query = window.location.search.substring(1);
    var params = parse_query_string(query);
    const json_obj = {
        form_visit_id: params.form_visit_id,
        side2: getObjSide2(),
        side3: getObjSide3(),
        side4: getObjSide4(),
        side5: side5,
        EditDataVisit: true,
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

function submitEditFormVisit() {
    if (!getObjSide2() || !getObjSide3() || !getObjSide4()) {
        alert("โปรดกรอกข้อมูลที่กำหนด");
        return;
    }
    const side5 = $("#side_5").val();
    var query = window.location.search.substring(1);
    var params = parse_query_string(query);

    const test_grade_file = document.getElementById('side_6').files[0];
    const side_6_old = $("#side_6_old").val();

    let formData = new FormData();
    formData.append('form_visit_id', params.form_visit_id);
    formData.append('side2', JSON.stringify(getObjSide2()));
    formData.append('side3', JSON.stringify(getObjSide3()));
    formData.append('side4', JSON.stringify(getObjSide4()));
    formData.append('side5', side5);
    formData.append('side6', test_grade_file);
    formData.append('side6_old', side_6_old);
    formData.append('father_name', $("#father").val());
    formData.append('father_job', $("#father_job").val());
    formData.append('mather_name', $("#mather").val());
    formData.append('mather_job', $("#mather_job").val());
    formData.append('std_id', $("#std_id").val());
    formData.append('EditDataVisit', true);

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