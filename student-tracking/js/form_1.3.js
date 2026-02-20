var $table = $("#table");

function formatButtonPrint(data, row) {
    let html = `    <a href="pdf/แบบสรุปการเยี่ยมบ้าน?form_visit_sum_id=${row.v_sum_id}" target="_blank">
                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-success mb-5"><i class="ti-printer"></i></button>
                            </a>`;
    return html;
}

function formatButtonDelete(data, row) {
    html = ` <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5" onclick="deleteVisitCon(${row.v_sum_id},'${row.std_class}')"><i class="ti-trash"></i></button>`;
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
                    field: "std_class",
                    title: "ชั้น/ห้อง",
                    align: "center",
                    width: "10px",
                },
                {
                    field: "year",
                    title: "ปีการศึกษา",
                    align: "center",
                    width: "10px",
                },
                {
                    field: "edu_name",
                    title: "สถานศึกษา",
                    align: "center",
                    width: "50px",
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
                },
                {
                    title: "ลบ",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonDelete,
                    visible: role_id != 2 ? true : false
                },
            ],
        ],
    });
}
