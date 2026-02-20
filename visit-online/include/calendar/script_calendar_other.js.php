 <script>
$(document).ready(async function() {
    getDataCalenderOther();
    getDataProDistSub();
    if (role_id == 2) {
        $('#subdistrict_select').select2()
    }
    if (role_id == 1) {
        $('#province_select').select2()
        $('#district_select').select2()
        $('#subdistrict_select').select2()
    }
});

function getDataCalenderOther() {
    $.ajax({
        type: "POST",
        url: "controllers/calendar_controller",
        data: {
            getDataCalenderOther: true,
        },
        dataType: "json",
        success: function(json_res) {
            genHtmlTable(json_res.data);
        },
    });
}

function genHtmlTable(data) {
    const Tbody = document.getElementById("body-calender");
    Tbody.innerHTML = "";
    if (data.length == 0) {
        Tbody.innerHTML += `
            <tr>
                <td colspan="6" class="text-center">
                    ไม่มีข้อมูล
                </td>
            </tr>
        `;
        return;
    }
    data.forEach((element, i) => {
        Tbody.innerHTML += `
                            <tr>
                                <td>${element.name} ${element.surname}</td>
                                <td>${element.edu_name}</td>
                                <td>${element.sub_district}</td>
                                <td>${element.district}</td>
                                <td>${element.province}</td>
                                <td class="text-center">
                                    <a href="manage_calendar?user_id=${element.id}&name=${element.name} ${element.surname}">
                                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye"></i></button>
                                    </a>
                                </td>
                            </tr>
                `;
    });
}
async function getDataProDistSub() {
    $.ajax({
        type: "POST",
        url: "controllers/user_controller",
        data: {
            getDataProDistSub: true
        },
        dataType: "json",
        success: async function(json_data) {
            main_provinces = json_data.data.provinces;
            main_district = json_data.data.district;
            main_sub_district_id = json_data.data.sub_district;
            let role_id = '<?php echo $_SESSION['user_data']->role_id; ?>';
            if (role_id == 1) {
                const province_select = document.getElementById('province_select');
                main_provinces.forEach((element, id) => {
                    province_select.innerHTML +=
                        ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                });
            }

            if (role_id == 2) {
                const sub_name = document.getElementById('subdistrict_select');
                sub_name.innerHTML = "";
                sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;

                const sub_district = main_sub_district_id.filter((sub) => {
                    return sub.district_id ==
                        '<?php echo $_SESSION['user_data']->district_am_id ?>';
                })
                sub_district.forEach((element, id) => {
                    sub_name.innerHTML +=
                        ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
                });
            }
        },
    });
}

$('#province_select').change((e) => {
    getDistrictByProvince(e.target.value)
})

function getDistrictByProvince(pro_id) {
    const district_select = document.getElementById('district_select');
    district_select.innerHTML = "";
    district_select.innerHTML += ` <option value="0">เลือกอำเภอ</option>`;
    const sub_name = document.getElementById('subdistrict_select');
    sub_name.innerHTML = "";
    sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
    const district = main_district.filter((dist) => {
        return dist.province_id == pro_id
    })
    district.forEach((element) => {
        district_select.innerHTML +=
            ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
    });
}
$('#district_select').change((e) => {
    getSubDistrictByDistrict(e.target.value)
})
async function getSubDistrictByDistrict(dist_id) {
    const sub_name = document.getElementById('subdistrict_select');
    sub_name.innerHTML = "";
    sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`;
    const sub_district = main_sub_district_id.filter((sub) => {
        return sub.district_id == dist_id
    })
    sub_district.forEach((element, id) => {
        sub_name.innerHTML +=
            ` <option value="${element.id}" data-value="${element.name_th}">${element.name_th}</option>`
    });
}

 function searchSubDis() {
        let role_id = '<?php echo $_SESSION['user_data']->role_id ?>';
        let pro_id = '0';
        let dis_id = '0';
        let sub_id = '0';
        if (role_id == 1) {
            pro_id = $('#province_select').val();
            dis_id = $('#district_select').val();
            sub_id = $('#subdistrict_select').val();
        }
        if (role_id == 2) {
            sub_id = $('#subdistrict_select').val();
        }

        $.ajax({
            type: "POST",
            url: "controllers/calendar_controller",
            data: {
                getDatacalendarOtherWhere: true,
                pro_id: pro_id,
                dis_id: dis_id,
                sub_id: sub_id
            },
            dataType: "json",
            success: function(json_res) {
                genHtmlTable(json_res.data);
            },
        });
    }

    function showAll() {
        $('#province_select').val(0).change();;
        $('#district_select').val(0).change();;
        $('#subdistrict_select').val(0).change();;
        getDataCalenderOther();
    }
 </script>