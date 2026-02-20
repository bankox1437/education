var $table = $("#table");

function formatButtonView(data, row) {
  let html = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;" onclick="openModal(${row.media_id})"><i class="ti-eye" style="font-size:10px"></i></button>`;
  return html;
}

function formatShowSum(data, row) {
  // return `${((parseFloat(row.sum_duration) + parseFloat(row.sum_duration_view)) % 60).toFixed(2)} นาที`;
  const seconds = (parseFloat(row.sum_duration) + parseFloat(row.sum_duration_view));
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.round(seconds % 60); // Round to 2 decimal places
  return `${minutes}.${remainingSeconds.toFixed(0)} นาที`;
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
          field: "media_name",
          title: "สื่อการอ่านเรื่อง",
          align: "left",
          width: "300px",
        },
        {
          field: "sum_duration",
          title: "เวลาการอ่านสื่อทั้งหมด",
          align: "center",
          width: "50px",
          formatter: formatShowSum,
        },
        {
          field: "view_media",
          title: "จำนวนครั้งที่เข้าอ่าน",
          align: "center",
          width: "50px",
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
          title: "รายชื่อผู้เข้าอ่านสื่อ",
          align: "center",
          width: "90px",
          formatter: formatButtonView,
          visible: role_id == 3 ? true : false
        }
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log(name, args);
  });
}
