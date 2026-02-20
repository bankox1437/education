var $table = $("#table");

function formatButtonLearnAnalysis(data, row) {
    let html = "";
    if (row.count_learn_analys == 0) {
        html = `<a href="learn_analysis?std_per_id=${row.std_per_id}&std_name=${row.std_name}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-plus"></i></button>
                </a>`;
} else {
        html = `<a href="learn_analysis?std_per_id=${row.std_per_id}&std_name=${row.std_name}&learn_analys_id=${row.learn_analys_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                </a>`;
    }
    return html;
}

function formatButtonPrint(data, row) {
    let html = `<a href="pdf/แบบวิเคราะห์ผู้เรียนรายบุคคล?std_per_id=${row.std_per_id}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-printer"></i></button>
                </a>`;
    return html;
}
function formatButtonEdit(data, row) {
    let html = `<a href="form1_1_new_edit.php?std_per_id=${row.std_per_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5"><i class="ti-pencil-alt"></i></button>
                </a>`;
    return html;
}
function formatButtonDelete(data, row) {
    html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteStudent(${row.std_per_id},'${row.std_name}')"><i class="ti-trash"></i></button>`;
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
                    width: "100px",
                },
                {
                    field: "std_name",
                    title: "ชื่อ-สกุล",
                    align: "left",
                    width: "150px",
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
                    width: "150px",
                    visible: role_id == 1 ? true : false
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
                    title: "วิเคราะห์ผู้เรียน",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonLearnAnalysis,
                    visible: role_id == 1 ? false : true
                },
                {
                    title: "พิมพ์ PDF",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonPrint,
                },
                {
                    title: "แก้ไข",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonEdit,
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
