var $table = $("#table");
const selections = [];

function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
    console.log("row====", row);
    return row.id
  })
}

function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.id, selections) !== -1
  })
  return res
}

function checkLenghtFormat(data, row) {
  let eventDetail = row.event_detail;

  if (eventDetail.length > 60) {
    let str = eventDetail.substring(1, 60)
    str = str + "...";
    return str;
  } else {
    return eventDetail;
  }
}
function formatButtonView(data, row) {
  const std_id = document.getElementById('std_id').value;
  let html = `<a href="view_save_event?event_id=${row.event_id}&name=${row.std_name}&std_id=${std_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonEdit(data, row) {
  let html = `<a href="manage_save_event_edit?event_id=${row.event_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonDelete(data, row) {
  console.log(row);
  let html = `<button type="button" onclick="deleteSaveEvent(${row.event_id},'${row.event_name}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
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
          field: "term_name",
          title: "ปีการศึกษา",
          align: "center",
          width: "100px",
        },
        {
          field: "std_name",
          title: "ชื่อ-สกุล",
          align: "left",
          width: "250px",
        },
        {
          field: "event_name",
          title: "หัวข้อ",
          width: "100px",
        },
        {
          field: "event_detail",
          title: "รายละเอียด",
          width: "300px",
          formatter: checkLenghtFormat
        },
        {
          field: "create_date",
          title: "วันที่บันทึก",
          width: "120px",
          align: "center",
        },
        {
          field: "view_btn",
          title: "ดูเพิ่มเติม",
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
        },
        {
          field: "del_opr",
          title: "ลบ",
          align: "center",
          width: "90px",
          formatter: formatButtonDelete,
        },
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log(name, args);
  });
}
