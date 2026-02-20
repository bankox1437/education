<script>
    getTeacherList()
    $('#teacher_select').select2()
    async function getTeacherList(pro = 0, dis = 0, sub = 0) {
        $.ajax({
            type: "POST",
            url: "../view-grade/controllers/user_controller",
            data: {
                getTeacherList: true,
                province_id: pro,
                district_id: dis,
                subdistrict_id: sub
            },
            dataType: "json",
            success: async function(json) {
                console.log("json data ===> ", json);
                const data = json.data;
                $('#teacher_select').empty();
                $('#teacher_select').append(`<option value="0">เลือกครู</option>`);
                data.forEach((element) => {
                    console.log();
                    $('#teacher_select').append(`<option value="${element.id}">${element.concat_name}</option>`);
                });
            },
        });
    }
</script>