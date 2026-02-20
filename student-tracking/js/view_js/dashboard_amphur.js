async function getdatacountAmphur(sub_id = "") {
    console.log("sub_dis_value=>", $('#sub_dis_value').val());
    $.ajax({
        type: "POST",
        url: "controllers/dashboard_controller",
        data: {
            getdatacountAmphur: true,
            sub_district_id: sub_id,
            district_id: $('#sub_dis_value').val()
        },
        dataType: 'json',
        success: function (json_res) {
            let count_std = parseInt(json_res.data[0].count_std)
            document.getElementById('count_std').innerHTML = count_std
            document.getElementById('visit_home').innerHTML = json_res.data[1].visit_home
            document.getElementById('from_evoluate').innerHTML = json_res.data[2].from_evoluate
            document.getElementById('std_person').innerHTML = json_res.data[9].std_person
            document.getElementById('visit_sum').innerHTML = json_res.data[10].visit_sum
            document.getElementById('screening').innerHTML = json_res.data[11].screening

            document.getElementById('std_gender1').innerHTML = json_res.data[3].std_gender1
            document.getElementById('std_gender2').innerHTML = json_res.data[4].std_gender2
            document.getElementById('std_gender3').innerHTML = json_res.data[5].std_gender3
            document.getElementById('std_gender4').innerHTML = json_res.data[6].std_gender4
            document.getElementById('std_gender5').innerHTML = json_res.data[7].std_gender5
            document.getElementById('std_gender6').innerHTML = json_res.data[8].std_gender6

            document.getElementById('std_gender1per').innerHTML = calculate_percent(count_std, json_res.data[3].std_gender1)
            document.getElementById('std_gender2per').innerHTML = calculate_percent(count_std, json_res.data[4].std_gender2)
            document.getElementById('std_gender3per').innerHTML = calculate_percent(count_std, json_res.data[5].std_gender3)
            document.getElementById('std_gender4per').innerHTML = calculate_percent(count_std, json_res.data[6].std_gender4)
            document.getElementById('std_gender5per').innerHTML = calculate_percent(count_std, json_res.data[7].std_gender5)
            document.getElementById('std_gender6per').innerHTML = calculate_percent(count_std, json_res.data[8].std_gender6)

            document.getElementById('p_parent_fm').innerHTML = json_res.data[12].parent_fm
            document.getElementById('p_parent_m').innerHTML = json_res.data[13].parent_m
            document.getElementById('p_parent_f').innerHTML = json_res.data[14].parent_f
            document.getElementById('p_parent_alone').innerHTML = json_res.data[15].parent_alone
            document.getElementById('p_parent_other').innerHTML = json_res.data[16].parent_other

            document.getElementById('p_parent_fm_per').innerHTML = calculate_percent(count_std, json_res.data[12].parent_fm)
            document.getElementById('p_parent_m_per').innerHTML = calculate_percent(count_std, json_res.data[13].parent_m)
            document.getElementById('p_parent_f_per').innerHTML = calculate_percent(count_std, json_res.data[14].parent_f)
            document.getElementById('p_parent_alone_per').innerHTML = calculate_percent(count_std, json_res.data[15].parent_alone)
            document.getElementById('p_parent_other_per').innerHTML = calculate_percent(count_std, json_res.data[16].parent_other)

            document.getElementById('m_s_parent_fm').innerHTML = json_res.data[17].parent_fm
            document.getElementById('m_s_parent_m').innerHTML = json_res.data[18].parent_m
            document.getElementById('m_s_parent_f').innerHTML = json_res.data[19].parent_f
            document.getElementById('m_s_parent_alone').innerHTML = json_res.data[20].parent_alone
            document.getElementById('m_s_parent_other').innerHTML = json_res.data[21].parent_other

            document.getElementById('m_s_parent_fm_per').innerHTML = calculate_percent(count_std, json_res.data[17].parent_fm)
            document.getElementById('m_s_parent_m_per').innerHTML = calculate_percent(count_std, json_res.data[18].parent_m)
            document.getElementById('m_s_parent_f_per').innerHTML = calculate_percent(count_std, json_res.data[19].parent_f)
            document.getElementById('m_s_parent_alone_per').innerHTML = calculate_percent(count_std, json_res.data[20].parent_alone)
            document.getElementById('m_s_parent_other_per').innerHTML = calculate_percent(count_std, json_res.data[21].parent_other)

            document.getElementById('m_e_parent_fm').innerHTML = json_res.data[22].parent_fm
            document.getElementById('m_e_parent_m').innerHTML = json_res.data[23].parent_m
            document.getElementById('m_e_parent_f').innerHTML = json_res.data[24].parent_f
            document.getElementById('m_e_parent_alone').innerHTML = json_res.data[25].parent_alone
            document.getElementById('m_e_parent_other').innerHTML = json_res.data[26].parent_other

            document.getElementById('m_e_parent_fm_per').innerHTML = calculate_percent(count_std, json_res.data[22].parent_fm)
            document.getElementById('m_e_parent_m_per').innerHTML = calculate_percent(count_std, json_res.data[23].parent_m)
            document.getElementById('m_e_parent_f_per').innerHTML = calculate_percent(count_std, json_res.data[24].parent_f)
            document.getElementById('m_e_parent_alone_per').innerHTML = calculate_percent(count_std, json_res.data[25].parent_alone)
            document.getElementById('m_e_parent_other_per').innerHTML = calculate_percent(count_std, json_res.data[26].parent_other)

        },
    });
}

async function getDistrictDataAmphur() {
    return Promise.resolve($.ajax({
        type: "POST",
        url: "controllers/dashboard_controller",
        data: {
            getDistrictDataAmphur: true,
        },
        dataType: "json",
    }));
}

$("#view_all").click(() => {
    $("#sub_district_select").val("").change();
    getdatacountAmphur()
})

async function getBySubDistrict() {
    const sub_value = $('#sub_district_select').find(':selected').attr('data-value')
    $('#dist_value').val(sub_value)
    getdatacountAmphur(sub_value)
}