var $table = $("#table");

function formatLinkRead(data, row) {
  let html = `<a href="#">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-success  mb-5 mt-1" style="width:40px;height:40px;" onclick="addCountRead(${row.media_id})"><i class="ti-book" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonEdit(data, row) {
  let html = `<a href="manage_media_reading_edit?media_id=${row.media_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  return html;
}
function formatButtonDelete(data, row) {
  let html = `<button type="button" onclick="deleteMedia(${row.media_id},'${row.media_file_name}','${row.media_file_name_cover}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
  return html;
}

function formatLinkEBook(data, row) {
  let html = `<a href="${row.link_e_book}" target="_blank"><span class="badge badge-info">E-Book <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkTest(data, row) {
  let html = `<a href="${row.link_test}" target="_blank"><span class="badge badge-primary">แบบทดสอบ <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkKnowTest(data, row) {
  let html = `<a href="${row.link_know_test}" target="_blank"><span class="badge badge-secondary">ใบวัดความรู้ <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkmediaCover(data, row) {
  let html = `<a href="uploads/media_cover/${row.media_file_name_cover}" target="_blank"><span class="badge badge-success">หน้าปก <i class="ti-link"></i></span></a>`;
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
          field: "media_name",
          title: "สื่อการอ่านเรื่อง",
          align: "left",
          width: "300px",
        },
        {
          title: "ลิงค์ E-book",
          align: "center",
          width: "100px",
          formatter: formatLinkEBook,
        },
        {
          title: "หน้าปกสื่อ",
          align: "center",
          width: "100px",
          formatter: formatLinkmediaCover,
        },
        {
          title: "ลิงค์แบบทดสอบ",
          align: "center",
          width: "100px",
          formatter: formatLinkTest,
        },
        {
          title: "ลิงค์ใบวัดความรู้หลังอ่าน",
          align: "center",
          width: "100px",
          formatter: formatLinkKnowTest,
        },
        {
          title: "อ่าน",
          align: "center",
          width: "90px",
          formatter: formatLinkRead,
        }
      ],
    ],
  });
}
