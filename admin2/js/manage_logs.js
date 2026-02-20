var $table = $("#table");
var $remove = $("#remove");

function jsonParseData(data, row) {
  return JSON.stringify(row.param_data);
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
          field: "mode",
          title: "สถานะ",
          align: "center",
        },
        {
          field: "sql_detail",
          title: "รายละเอียด",
        },
        {
          field: "param_data",
          title: "ข้อมูล",
          formatter: jsonParseData,
        },
        {
          field: "client_ip",
          title: "client_ip",
          align: "center",
        },
        {
          field: "username",
          title: "บัญชี",
          align: "center",
        },
        {
          field: "user_create",
          title: "รหัสบัญชี",
          align: "center",
        },
        {
          field: "create_date",
          title: "วันที่สร้าง",
          align: "center",
        },
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log(name, args);
  });
}
