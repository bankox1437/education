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

function operateFormatter(value, row, index) {
  return [
    '<a class="like" href="javascript:void(0)" title="Like">',
    '<i class="fa fa-heart"></i>',
    "</a>  ",
    '<a class="remove" href="javascript:void(0)" title="Remove">',
    '<i class="fa fa-trash"></i>',
    "</a>",
  ].join("");
}

window.operateEvents = {
  "click .like": function (e, value, row, index) {
    alert("You click like action, row: " + JSON.stringify(row));
  },
  "click .remove": function (e, value, row, index) {
    $table.bootstrapTable("remove", {
      field: "id",
      values: [row.id],
    });
  },
};

function checkProvinceFormat(data, row) {
  return row.province;
}

function checkDistrictFormat(data, row) {
  return row.district;
}


function checkSubDistrictFormat(data, row) {
  if (row.role_custom_id) {
    return row.subdistrict_text;
  } else {
    return row.sub_district;
  }
}

function checkRoleFormat(data, row) {
  if (row.role_id == 1) {
    return `<span class="badge badge-pill badge-primary">${row.role_name}</span>`;
  }
  if (row.role_id == 2) {
    return `<span class="badge badge-pill badge-info">${row.role_name}</span>`;
  }
  if (row.role_id == 3) {
    if (row.role_custom_id) {
      return `<span class="badge badge-pill" style="background:#e6e6e6">${row.role_name_cus}</span>`;
    } else {
      return `<span class="badge badge-pill badge-success">${row.role_name}</span>`;
    }
  }
  if (row.role_id == 5) {
    return `<span class="badge badge-pill badge-secondary">${row.role_name}</span>`;
  }
  if (row.role_id == 6) {
    return `<span class="badge badge-pill badge-dark">${row.role_name}</span>`;
  }
  if (row.role_id == 7) {
    return `<span class="badge badge-pill" style="background-color:#619cfa;color:#fff">${row.role_name}</span>`;
  }
}

function formatButtonOperation(data, row) {
  let html = `<a onclick="gotoEdit(${row.id})">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  let deleteBtn = "";
  if (row.id != user_id) {
    deleteBtn = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteAdmin(${row.id},'${row.concat_name}',${row.edu_id})"><i class="ti-trash" style="font-size:10px"></i></button>`;
  }
  html += deleteBtn;
  return html;
}

function formatEduName(data, row) {
  const edu_type = row.edu_type;
  const edu_name = row.edu_name;
  if (edu_type == "edu_other") {
    return `${edu_name} (ทางไกล)`;
  }
  return edu_name;
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
          width: "30px",
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
          field: "concat_name",
          title: "ชื่อ-สกุล",
          align: "lefet",
        },
        {
          field: "edu_name",
          title: "สถานศึกษา",
          align: "center",
          width: "150px",
          formatter: formatEduName,
        },
        {
          field: "sub_district",
          title: "ตำบล",
          align: "center",
          width: "150px",
          formatter: checkSubDistrictFormat,
        },
        {
          field: "district",
          title: "อำเภอ",
          align: "center",
          width: "150px",
          formatter: checkDistrictFormat,
        },
        {
          field: "province",
          title: "จังหวัด",
          align: "center",
          width: "150px",
          formatter: checkProvinceFormat,
        },
        {
          field: "operate",
          title: "สิทธิ์",
          align: "center",
          width: "120px",
          formatter: checkRoleFormat,
        },
        {
          field: "operate",
          title: "แก้/ลบ",
          align: "center",
          width: "120px",
          formatter: formatButtonOperation,
        },
      ],
    ],
  });
}
