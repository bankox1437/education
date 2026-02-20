var $table = $("#table");

function formatButtonMapHome(data, row) {
    let html = "";
        html = `<a href="${row.location == ""
        ? "https://www.google.co.th/maps/"
        : row.location
      }" target="_blank"><i class="ti-map-alt" style="font-size:20px"></i></a>`;

    return html;
}

function formatButtonPrint(data, row) {
    let html = ` <a href="pdf/แบบบันทึกการเยี่ยมบ้าน?form_id=${row.form_visit_id}" target="_blank">
                        <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-printer"></i></button>
                    </a>`;
    return html;
}
function formatButtonEdit(data, row) {
    let html = ` <a href="form1_2_edit.php?form_visit_id=${row.form_visit_id}&std_name=${row.std_prename}${row.std_name}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                  </a>`;
    return html;
}
function formatButtonAdditionalVisitHome(data, row) {
     let html = "";
   
    html = (row.form_status == 1 ? 
    `   <a href="form1_3_new_edit.php?form_visit_id=${row.form_visit_id}&std_name=${row.std_prename}${row.std_name}">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                        </a>`
    :
 `    <a href="form1_3_add_new.php?form_visit_id=${row.form_visit_id}&std_name=${row.std_prename}${row.std_name}">
                            <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-plus"></i></button>
                        </a>`
        )
    return html;
}
function formatButtonDelete(data, row) {
    html = ` <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteDataForm(${row.form_visit_id},'${row.std_name}','${row.home_img}')"><i class="ti-trash"></i></button>`;
    return html;
}

window.icons = {
    refresh: "fa-refresh",
};

function initTable() {
    $table.bootstrapTable("destroy").bootstrapTable({
        locale: "th-TH",
        columns: [
            [
                {
                    title: "ลำดับ",
                    align: "center",
                    width: "50px",
                    formatter: function (value, row, index) {
                        const options = $table.bootstrapTable("getOptions");
                        const currentPage = options.pageNumber;
                        let itemsPerPage = options.pageSize;
                        if (itemsPerPage == "All") {
                            const data = $table.bootstrapTable("getData");
                            itemsPerPage = data.length;
                        }
                        const offset = (currentPage - 1) * itemsPerPage;
                        return index + 1 + offset;
                    },
                },
                {
                    field: "std_code",
                    title: "รหัสนักศึกษา",
                    align: "center",
                    width: "40px",
                },
                {
                    field: "std_name",
                    title: "ชื่อ-สกุล",
                    align: "left",
                    width: "350px",
                },
                {
                    field: "std_class",
                    title: "ชั้น",
                    align: "center",
                    width: "50px",
                },
                {
                    field: "user_create_name",
                    title: "ผู้บันทึก",
                    width: "350px",
                    visible: role_id == 1 ? true : false
                },
                 {
                    field: "edu_name",
                    title: "สถานศึกษา",
                    width: "150px",
                },
                {
                    title: "แผนที่บ้าน",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonMapHome,
                },
                {
                    field: "sub_district",
                    title: "ตำบล",
                    align: "center",
                    width: "100px",
                    visible: role_id == 1 ? true : false
                },
                {
                    field: "district",
                    title: "อำเภอ",
                    align: "center",
                    width: "100px",
                    visible: role_id == 1 ? true : false
                },
                {
                    field: "province",
                    title: "จังหวัด",
                    align: "center",
                    width: "120px",
                    visible: role_id == 1 ? true : false
                },
                {
                    title: "พิมพ์ PDF",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonPrint,
                      visible: role_id !== 2 ? true : false
                },
                {
                    title: "แก้ไข",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonEdit,
                },
                  {
                    title: "เยี่ยมบ้านเพิ่มเติม",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonAdditionalVisitHome,
                },
                {
                    title: "ลบ",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonDelete,
                },
            ],
        ],
    });
}
