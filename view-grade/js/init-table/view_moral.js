var $table = $("#table");

window.icons = {
  refresh: "fa-refresh",
};

function formatScore(data, row) {
  let html = `<strong class="text-info">${row.score}</strong>`;
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
          field: "score",
          title: "คะแนน",
          align: "center",
          width: "100px",
          formatter: formatScore
        },
        {
          field: "std_code",
          title: "รหัสนักศึกษา",
          sortable: true,
          align: "lefet",
          width: "170px",
        },
        {
          field: "std_name",
          title: "ชื่อ-สกุล",
          align: "lefet",
          width: "250px",
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
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log("==> ", name, args);
  });
}
