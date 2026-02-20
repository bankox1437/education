var $table = $("#table");

function formatButtonView(data, row) {
  let html = `<a href="${row.file_name}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonEdit(data, row) {
  let html = `<a href="manage_table_test_edit?t_test_id=${row.t_test_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonDelete(data, row) {
  let html = `<button type="button" onclick="deleteTableTest(${row.t_test_id},'${row.file_name}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
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
          width: "100px",
        },
        {
          field: "term_name",
          title: "ปีการศึกษา",
          align: "center",
          width: "100px",
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
          field: "user_create_name",
          title: "ผู้บันทึก",
          width: "180px",
          visible: role_id == 1 ? true : false
        },
        {
          field: "view_btn",
          title: "ดูไฟล์",
          align: "center",
          width: "90px",
          formatter: formatButtonView,
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
