var $table = $("#table");

function formatButtonOpenRead(data, row) {
  let iconStatus = (row.status_working == 1 ? "check" : "close");
  let statusChange = (row.status_working == 1 ? 0 : 1)
  // let html = `<button type="button" onclick="changeWorkingMedia(${row.media_id},'${row.media_name}',${statusChange})" class="waves-effect waves-circle btn btn-circle btn-${row.status_working == 1 ? 'success' : 'danger'} mb-5 mt-1" style="width:30px;height:30px;"><i class="fa fa-${iconStatus}" style="font-size:10px"></i></button>`;'
  let html = `<label class="switch switch-working-media">
                  <input type="checkbox" class="checkbox-working-media" ${row.status_working == 1 ? 'checked' : ''} data-media-id="${row.media_id}" data-media-name="${row.media_name}" data-status-change="${statusChange}">
                  <span class="slider round"></span>
              </label>

              `;
  return html;
}

function formatButtonView(data, row) {
  if (!row.media_file_name) {
    return "-";
  }
  let html = `<a href="uploads/media/${row.media_file_name}" target="_blank">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
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
  let html = `<button type="button" onclick="deleteMedia(${row.media_id},'${row.media_file_name}','${row.media_file_name_cover_raw}')" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-trash" style="font-size:10px"></i></button>`;
  return html;
}

function formatLinkEBook(data, row) {
  if (!row.link_e_book) {
    return "-";
  }
  let html = `<a href="${row.link_e_book}" target="_blank"><span class="badge badge-info">E-Book <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkTest(data, row) {
  if (!row.link_test) {
    return "-";
  }
  let html = `<a href="${row.link_test}" target="_blank"><span class="badge badge-primary">แบบทดสอบ <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkKnowTest(data, row) {
  if (!row.link_know_test) {
    return "-";
  }
  let html = `<a href="${row.link_know_test}" target="_blank"><span class="badge badge-secondary">ใบวัดความรู้ <i class="ti-link"></i></span></a>`;
  return html;
}

function formatLinkmediaCover(data, row) {
  if (!row.media_file_name_cover) {
    return "-";
  }
  let html = `<a href="${row.media_file_name_cover}" target="_blank"><span class="badge badge-success">หน้าปก <i class="ti-link"></i></span></a>`;
  return html;
}


function formatStdClass(data, row) {
  let classStd = row.std_class == 0 ? 'ชั้นทั้งหมด' : row.std_class;
  return classStd;
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
        // {
        //   field: "std_class",
        //   title: "ชั้น",
        //   align: "center",
        //   width: "60px",
        //   formatter: formatStdClass,
        // },
        {
          title: "เวลาการอ่านสื่อทั้งหมด",
          align: "center",
          width: "60px",
          formatter: formatShowSum,
        },
        {
          field: "view_media",
          title: "จำนวนครั้งที่เข้าอ่าน",
          align: "center",
          width: "60px",
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
          title: "ลิงค์แบบบันทึกหลังอ่าน",
          align: "center",
          width: "100px",
          formatter: formatLinkKnowTest,
        },
        {
          field: "status_working",
          title: "การใช้งาน",
          align: "center",
          width: "90px",
          formatter: formatButtonOpenRead,
          visible: (role_id == 3 || role_id == 5) ? true : false
        },
        {
          field: "view_btn",
          title: "ดูไฟล์ PDF",
          align: "center",
          width: "50px",
          formatter: formatButtonView,
        },
        {
          field: "edit_opr",
          title: "แก้ไข",
          align: "center",
          width: "50px",
          formatter: formatButtonEdit,
          visible: role_id == 3 || role_id == 5 ? true : false
        },
        {
          field: "del_opr",
          title: "ลบ",
          align: "center",
          width: "50px",
          formatter: formatButtonDelete,
          visible: role_id == 3 || role_id == 5 ? true : false
        },
      ],
    ],
  });
  $table.on("all.bs.table", function (e, name, args) {
    console.log(name, args);
  });
}
