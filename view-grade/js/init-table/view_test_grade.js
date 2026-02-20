var $table = $("#table");

window.icons = {
  refresh: "fa-refresh",
};

function formatButtonView(data, row) {
  let html = `<a href="uploads/test_grade_pdf/${row.file_name}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  return html;
}

function formatTestType(data) {
  let html = `<span class="badge badge-success">สอบปกติ</span>`;
  if (data == 1) {
    html = `<span class="badge badge-warning">สอบซ่อม</span>`;
  }
  return html;
}

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
          field: "test_type",
          title: "ประเภทการสอบ",
          align: "center",
          width: "100px",
          formatter: formatTestType,
        },
        {
          title: "ดูไฟล์",
          align: "center",
          width: "100px",
          formatter: formatButtonView,
        },
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    if (name == 'load-success.bs.table') {
      console.log(args);
      const result = args[0]
      const formatSTD = parseInt(result.formatSTD) ?? 0;
      if (formatSTD) {
        $("#format").val(1)
      } else {
        $("#format").val(0)
      }
    }
  });
}
