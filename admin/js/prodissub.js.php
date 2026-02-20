<script>
    async function getDataProDistSub() {
        $.ajax({
            type: "POST",
            url: "controllers/user_controller",
            data: {
                getDataProDistSub: true,
                table:'tb_users'
            },
            dataType: "json",
            success: async function(json_data) {
                main_provinces = json_data.data.provinces;
                main_district = json_data.data.district;
                main_sub_district = json_data.data.sub_district;
                const pro_name = document.getElementById('pro_name');
                main_provinces.forEach((element, id) => {
                    pro_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
                });
            },
        });
    }

    function getDistrictByProvince(pro_id, callback) {
        callback()
        const pro_name = $('#pro_name').find(':selected')[0].innerText
        $('#pro_name_text').val(pro_name)
        const dis_name = document.getElementById('dis_name');
        dis_name.innerHTML = "";
        dis_name.innerHTML += ` <option value="0">เลือกอำเภอ</option>`
        const sub_name = document.getElementById('sub_name');
        sub_name.innerHTML = "";
        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`
        sub_name.setAttribute("disabled", true)
        // $('#edu_select').attr('disabled', true)
        //$('#new_edu').hide();
        //newEdu(false)
        if (pro_id == 0) {
            dis_name.setAttribute("disabled", true)
            return;
        }
        const district = main_district.filter((dist) => {
            return dist.province_id == pro_id
        })
        dis_name.removeAttribute("disabled");
        district.forEach((element, id) => {
            dis_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
        });
    }

    async function getSubDistrictByDistrict(dist_id, callback) {
        callback()
        const dis_name = $('#dis_name').find(':selected')[0].innerText;
        $('#dis_name_text').val(dis_name)
        const sub_name = document.getElementById('sub_name');
        sub_name.innerHTML = "";
        sub_name.innerHTML += ` <option value="0">เลือกตำบล</option>`
        if (dist_id == 0) {
            sub_name.setAttribute("disabled", true)
            // $('#edu_select').attr('disabled', true)
            //$('#new_edu').hide();
            //newEdu(false)
            return;
        }
        const sub_district = main_sub_district.filter((sub) => {
            return sub.district_id == dist_id
        })
        sub_name.removeAttribute("disabled");
        sub_district.forEach((element, id) => {
            sub_name.innerHTML += ` <option value="${element.id}">${element.name_th}</option>`
        });
        console.log("dis");
    }
</script>