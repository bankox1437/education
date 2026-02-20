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

function statusFormat(data, row) {
  if (row.status == 1) {
    return `<span class="badge badge-pill badge-success">อยู่ระหว่างเทอม</span>`;
  }
  if (row.status == 0) {
    return `<span class="badge badge-pill badge-danger">สิ้นเทอมแล้ว</span>`;
  }
}

function formatButtonOperation(data, row) {
  let html = `<a href="manage_terms_edit?term_id=${row.term_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  if (row.status != 1) {
    html += `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteTerm(${row.term_id},'${row.term_name}')"><i class="ti-trash" style="font-size:10px"></i></button>`;
  }
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
          width: "100px",
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
          sortable: true,
          align: "center",
        },
        {
          field: "status",
          title: "สถานะ",
          align: "center",
          width: "300px",
          formatter: statusFormat,
        },
        {
          field: "operate",
          title: "แก้ไข/ลบ",
          align: "center",
          width: "200px",
          formatter: formatButtonOperation,
        },
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log(name, args);
  });
}
