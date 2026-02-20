var $table = $("#table");

function formatButtonEdit(data, row) {
    let html = `<a href="manage_credit_set_edit?set_id=${row.set_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
    return html;
}
function formatButtonDelete(data, row) {
    let html = `<button type="button" onclick="deleteCreditSet(${row.set_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
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
                    field: "set_name",
                    title: "ชื่อกลุ่มวิชา",
                    align: "lefet",
                    width: "170px",
                },
                {
                    field: "edit_opr",
                    title: "แก้ไข",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonEdit,
                    visible: role_id == 1 ? false : true
                },
                {
                    field: "del_opr",
                    title: "ลบ",
                    align: "center",
                    width: "90px",
                    formatter: formatButtonDelete,
                    visible: role_id == 1 ? false : true
                },
            ],
        ],
    });
    $table.on("all.bs.table", function (e, name, args) {
        console.log(name, args);
    });
}
