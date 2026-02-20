var $table = $("#table");

function formatButtonEdit(data, row) {
  let html = `<a href="manage_list_name_edit?edit=${row.list_name_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonDelete(data, row) {
  let html = `<button type="button" onclick="deleteListName(${row.list_name_id})" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
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
          field: "name1",
          title: "เจ้าหน้าที่การศึกษาขั้นพื้นฐาน",
          align: "left",
          width: "300px",
        },
        {
          field: "name2",
          title: "นายทะเบียน",
          align: "left",
          width: "300px",
        },
        {
          field: "name3",
          title: "ชื่อครูผู้รับผิดชอบ",
          align: "left",
          width: "300px",
        },
        {
          field: "name4",
          title: "ประเภทครูผู้รับผิดชอบ",
          align: "left",
          width: "300px",
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

}
