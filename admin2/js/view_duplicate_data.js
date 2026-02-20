var $table = $("#table");
var $remove = $("#remove");
var selections = [];

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.id;
    });
}

function responseHandler(res) {
    $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.id, selections) !== -1;
    });
    return res;
}

function operateFormatter(value, row, index) {
    return [
        '<a class="like" href="javascript:void(0)" title="Like">',
        '<i class="fa fa-heart"></i>',
        "</a>  ",
        '<a class="remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-trash"></i>',
        "</a>",
    ].join("");
}

window.operateEvents = {
    "click .like": function (e, value, row, index) {
        alert("You click like action, row: " + JSON.stringify(row));
    },
    "click .remove": function (e, value, row, index) {
        $table.bootstrapTable("remove", {
            field: "id",
            values: [row.id],
        });
    },
};

function checkProvinceFormat(data, row) {
    return row.province;
}

function checkDistrictFormat(data, row) {
    return row.district;
}

function duplicate_format(data, row) {
    return `<span class="badge badge-pill badge-danger">${row.duplicate_data}</span>`;
}

function active_find(data, row) {
    if ($("#filter_dup").val() == 1) {
        return `<span class="text-danger">${row.username}</span>`;
    } else {
        return `<span>${row.username}</span>`;
    }
}

function active_find_name(data, row) {
    if ($("#filter_dup").val() == 2) {
        return `<span class="text-danger">${row.concat_name}</span>`;
    } else {
        return `<span>${row.concat_name}</span>`;
    }
}


function checkRoleFormat(data, row) {
    if (row.role_id == 1) {
        return `<span class="badge badge-pill badge-primary">${row.role_name}</span>`;
    }
    if (row.role_id == 2) {
        return `<span class="badge badge-pill badge-info">${row.role_name}</span>`;
    }
    if (row.role_id == 3) {
        return `<span class="badge badge-pill badge-success">${row.role_name}</span>`;
    }
}

function formatButtonOperation(data, row) {
    let deleteBtn = "";
    deleteBtn = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteDup(${row.username})"><i class="ti-trash" style="font-size:10px"></i></button>`;
    return deleteBtn;
}

function formatEduName(data, row) {
    const edu_type = row.edu_type;
    const edu_name = row.edu_name;
    if (edu_type == "edu_other") {
        return `${edu_name} (ทางไกล)`;
    }
    return edu_name;
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
                    width: "30px",
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
                    field: "username",
                    title: "เลข ปชช./ชื่อผู้ใช้",
                    align: "left",
                    width: "100px",
                    formatter: active_find,
                },
                {
                    field: "concat_name",
                    title: "ชื่อ-สกุล",
                    align: "left",
                    width: "160px",
                    formatter: active_find_name,
                },
                {
                    field: "duplicate_data",
                    title: "จำนวนรายการซ้ำ",
                    align: "center",
                    width: "80px",
                    formatter: duplicate_format,
                },
                {
                    field: "edu_name",
                    title: "สถานศึกษา",
                    align: "center",
                    width: "150px",
                    formatter: formatEduName,
                },
                {
                    field: "creator_name",
                    title: "ผู้บันทึก",
                    align: "left",
                    width: "160px"
                },
                {
                    field: "sub_district",
                    title: "ตำบล",
                    align: "center",
                    width: "110px",
                },
                {
                    field: "district",
                    title: "อำเภอ",
                    align: "center",
                    width: "110px",
                    formatter: checkDistrictFormat,
                },
                {
                    field: "province",
                    title: "จังหวัด",
                    align: "center",
                    width: "110px",
                    formatter: checkProvinceFormat,
                },
                {
                    field: "operate",
                    title: "ลบ",
                    align: "center",
                    width: "50px",
                    formatter: formatButtonOperation,
                },
            ],
        ],
    });
}
