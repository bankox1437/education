const $table = $('#table')
const checkboxAll = `<div class="demo-checkbox" style="width:20px;height: 20px;">				
                    <input type="checkbox" id="md_checkbox_all" class="filled-in chk-col-danger" onchange="selectAll(this)">
                    <label for="md_checkbox_all" style="margin:0;padding:0"></label>						
                </div>`;

window.icons = {
    refresh: "fa-refresh",
};

function formatCheckBox(data, row) {
    let html = `<div class="demo-checkbox" style="width:20px;height: 20px;margin:5px">				
                    <input type="checkbox" id="md_checkbox_delete_${row.std_id}" class="filled-in chk-col-danger delete_multi_std" onchange="check_cancel()" value="${row.std_id}">
                    <label for="md_checkbox_delete_${row.std_id}" style="margin:0;padding:0"></label>						
                </div>`;
    return html;
}

function formatGender(data, row) {
    return `${row.std_gender == "" ? "-" : row.std_gender == 'ชาย' ?
        `<i class="fa fa-male" style="font-size:14px;color:#2BA8E2" aria-hidden="true"></i>` :
        `<i class="fa fa-female" style="font-size:14px;color:#F17AA8" aria-hidden="true"></i>`}`;
}

function formatStdName(data, row) {
    return `${row.std_prename}${row.std_name}`;
}

function formatMoveStd(data, row) {
    let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1" style="width:30px;height:30px;" onclick="openModal(${row.std_id},'${row.std_prename}${row.std_name}')"><i class="fa fa-retweet" style="font-size:10px"></i></button>`;
    return html;
}

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        locale: "th-TH",
        columns: [
            // {
            //     field: 'std_id',
            //     title: checkboxAll,
            //     align: 'center',
            //     formatter: formatCheckBox,
            //     width: "20px",
            // },
            {
                field: 'std_code',
                title: 'รหัสนักศึกษา',
                align: 'center',
                width: "200px",
            },
            {
                field: 'std_name',
                title: 'ชื่อ-สกุล',
                align: 'left',
                formatter: formatStdName,
                width: "250px"
            },
            {
                field: 'std_class',
                title: 'ชั้น',
                align: 'center',
                width: "90px",
            },
            {
                field: 'std_birthday',
                title: 'ว/ด/ป เกิด',
                align: 'center',
                width: "200px"
            },
            {
                field: 'national_id',
                title: 'เลข ปชช.',
                align: 'center',
                 width: "200px"
            },
            // {
            //     field: 'std_gender',
            //     title: 'เพศ',
            //     align: 'center',
            //     formatter: formatGender
            // },
            {
                field: 'user_create_name',
                title: 'ผู้บันทึก',
                align: 'left',
                width: "160px"
            },
            {
                field: 'opsmovement',
                title: 'ย้าย นศ.',
                align: 'center',
                width: "60px",
                formatter: formatMoveStd
            }
        ]
    })

    $table.on('page-change.bs.table', function (e, number, size) {
        changeBox = 0;
        $('#md_checkbox_all').prop('checked', false);
    });
}