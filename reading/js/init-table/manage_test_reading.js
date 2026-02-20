var $table = $("#table");

function formatButtonEdit(data, row) {
  let html = `<a href="manage_test_reading_edit?test_read_id=${row.test_read_id}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1"><i class="ti-pencil-alt"></i></button>
                </a>`;
  return html;
}
function formatButtonDelete(data, row) {
  let html = `<button type="button" onclick="deleteTestReading(${row.test_read_id},'${row.file_test}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1"><i class="ti-trash"></i></button>`;
  if(role_id == 1) {
    html = `<button type="button" onclick="deleteMedia(${row.media_id}, '${row.media_file_name}', '${row.media_file_name_cover}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1"><i class="ti-trash"></i></button>`;
  }
  return html;
}

function formatLinkTest(data, row) {
  let html = `<p style="padding-top: 13px;padding-bottom: 13px;" class="m-0">-</p>`;
  let statusRead = parseInt(row.count_test) != 0 ? 1 : 0;
  if (!role_id) {
    statusRead = 1;
  }
  if (row.media_file_name) {
    html = `<a href="#">
            <button type="button" class="waves-effect waves-circle btn btn-circle btn-success  mb-5 mt-1" onclick="addCountRead(${statusRead},${row.media_id})"><i class="ti-book"></i></button>
          </a>`;
  }
  return html;
}

function formatLinkEBook(data, row) {
  let html = "-";
  if (isValidLink(row.link_e_book)) {
    if (role_id) {
      html = `<a href="${row.link_e_book}" target="_blank"><span class="badge badge-info">E-Book <i class="ti-link"></i></span></a>`;
    } else {
      html = `<a href="#" onclick="addCountRead(0,${row.media_id}, '${row.link_e_book}')"><span class="badge badge-info">E-Book <i class="ti-link"></i></span></a>`;
    }
  }
  return html;
}

function isValidLink(text) {
  try {
    new URL(text);
    return true;
  } catch (e) {
    return false;
  }
}


function formatLinkTest2(data, row) {
  let html = `<a href="${row.link_test}" target="_blank"><span class="badge badge-primary">แบบทดสอบ <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkKnowTest(data, row) {
  let html = `<a href="${row.link_know_test.trim()}" target="_blank"><span class="badge badge-secondary">ใบวัดความรู้ <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkmediaCover(data, row) {
  let html = `<a href="uploads/media_cover/${row.media_file_name_cover}" target="_blank"><span class="badge badge-success">หน้าปก <i class="ti-link"></i></span></a>`;
  return html;
}

function formatMediaName(data, row) {
  let lengthText = row.media_name.trim().length;
  let html = `<p class="p-0 m-0" title="${row.media_name}">${lengthText > 70 ? row.media_name.substring(0, 70) + '...' : row.media_name}</p>`;
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
          field: "media_name_short",
          title: "ชื่อเรื่อง",
          align: "left",
          width: "150px",
          formatter: formatMediaName,
        },
        {
          field: "author_name",
          title: "ชื่อผู้แต่ง",
          align: "left",
          width: "150px",
          visible: (role_id == 1 || role_id == 3 || role_id == 5) || !role_id ? true : false
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
          visible: (role_id && role_id != 1 && role_id != 3 )? true : false
        },
        {
          title: "ลิงค์แบบทดสอบ",
          align: "center",
          width: "100px",
          formatter: formatLinkTest2,
          visible: role_id && role_id != 1 && role_id != 3 ? true : false
        },
        {
          title: "ลิงค์แบบบันทึกหลังอ่าน",
          align: "center",
          width: "100px",
          formatter: formatLinkKnowTest,
          visible: role_id && role_id != 1 && role_id != 3 ? true : false
        },
        {
          field: "user_create_name",
          title: "ผู้บันทึก",
          align: "center",
          width: "120px",
          visible: (role_id == 1 || !role_id) ? true : false
        },
        {
          field: "sub_district",
          title: "ตำบล",
          align: "center",
          width: "100px",
          visible: ((role_id != 4 && role_id != 1)) ? true : false
        },
        {
          field: "district",
          title: "สกร.อำเภอ",
          align: "center",
          width: "100px",
          visible: (role_id != 4 || !role_id) ? true : false
        },
        {
          field: "province",
          title: "จังหวัด",
          align: "center",
          width: "120px",
          visible: false
        },
        // {
        //   field: "date_test",
        //   title: "วันที่สอบ",
        //   align: "center",
        //   width: "100px",
        // },
        // {
        //   field: "date_out_test",
        //   title: "วันที่หมดเขตสอบ",
        //   align: "center",
        //   width: "100px",
        // },
        // {
        //   field: "description",
        //   title: "รายละเอียด",
        //   align: "center",
        //   width: "200px",
        // },
        {
          field: "testing",
          title: "เข้าอ่าน",
          align: "center",
          width: "90px",
          formatter: formatLinkTest,
          visible: role_id && role_id == 4 ? true : false
        },
        {
          field: "edit_opr",
          title: "แก้ไข",
          align: "center",
          width: "90px",
          formatter: formatButtonEdit,
          visible: false
        },
        {
          field: "del_opr",
          title: "ลบ",
          align: "center",
          width: "90px",
          formatter: formatButtonDelete,
          visible: (role_id && role_id == 1) ? true : false
        },
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log(name, args);
  });
}
