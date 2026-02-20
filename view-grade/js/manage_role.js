var $table = $("#table");
var $remove = $("#remove");
var selections = [];

let allRowCheck = 0;
const allRoleCounts = {
  checkbox_th_1: 0,
  checkbox_th_2: 0,
  checkbox_th_3: 0,
  checkbox_th_4: 0,
  checkbox_th_5: 0,
  checkbox_th_6: 0,
  checkbox_th_7: 0,
  checkbox_th_8: 0,
  checkbox_th_9: 0,
  checkbox_th_10: 0,
  checkbox_th_11: 0,
  checkbox_th_12: 0,
};

function resetData() {
  allRoleCounts['checkbox_th_1'] = 0;
  allRoleCounts['checkbox_th_2'] = 0;
  allRoleCounts['checkbox_th_3'] = 0;
  allRoleCounts['checkbox_th_4'] = 0;
  allRoleCounts['checkbox_th_5'] = 0;
  allRoleCounts['checkbox_th_6'] = 0;
  allRoleCounts['checkbox_th_7'] = 0;
  allRoleCounts['checkbox_th_8'] = 0;
  allRoleCounts['checkbox_th_9'] = 0;
  allRoleCounts['checkbox_th_10'] = 0;
  allRoleCounts['checkbox_th_11'] = 0;
  allRoleCounts['checkbox_th_12'] = 0;
}
$table.on('page-change.bs.table', function (e, number, size) {
  resetData()
  allRowCheck = size;

  setCheckedSekectedAll()
});

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

function checkProvinceFormat(data, row) {
  return row.province;
}

function checkDistrictFormat(data, row) {
  return row.district;
}

function checkRoleFormat(data, row) {
  if (row.role_id == 1) {
    return `<span class="badge badge-pill badge-primary">${row.role_name}</span>`;
  }
  if (row.role_id == 2) {
    return `<span class="badge badge-pill badge-info">${row.role_name}</span>`;
  }
  if (row.role_id == 3) {
    return `<span class="badge badge-pill badge-success">${row.role_name}</span>`;
  }
  if (row.role_id == 5) {
    return `<span class="badge badge-pill badge-secondary">${row.role_name}</span>`;
  }
}

function formatButtonOperation(data, row) {
  let html = `<a onclick="gotoEdit(${row.id})">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-warning mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-pencil-alt" style="font-size:10px"></i></button>
                </a>`;
  // if (row.id != user_id) {
  //   deleteBtn = `<button type="button" class="waves-effect waves-circle btn btn-circle btn-danger mb-5 mt-1" style="width:30px;height:30px;" onclick="deleteAdmin(${row.id},'${row.concat_name}',${row.edu_id})"><i class="ti-trash" style="font-size:10px"></i></button>`;
  // }
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


function inputCheckboxFormatter1(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_1_${row.id}" class="filled-in role_1" ${role_json.view_grade == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'view_grade',this.checked,this)">
										<label for="checkbox_role_1_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.view_grade == 1) {
    allRoleCounts['checkbox_th_1'] = allRoleCounts['checkbox_th_1'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter2(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_2_${row.id}" class="filled-in role_2" ${role_json.std_tracking == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'std_tracking',this.checked,this)">
										<label for="checkbox_role_2_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.std_tracking == 1) {
    allRoleCounts['checkbox_th_2'] = allRoleCounts['checkbox_th_2'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter3(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_3_${row.id}" class="filled-in role_3" ${role_json.visit_online == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'visit_online',this.checked,this)">
										<label for="checkbox_role_3_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.visit_online == 1) {
    allRoleCounts['checkbox_th_3'] = allRoleCounts['checkbox_th_3'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter4(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_4_${row.id}" class="filled-in role_4" ${role_json.reading == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'reading',this.checked,this)">
										<label for="checkbox_role_4_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.reading == 1) {
    allRoleCounts['checkbox_th_4'] = allRoleCounts['checkbox_th_4'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter5(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_5_${row.id}" class="filled-in role_5" ${role_json.search == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'search',this.checked,this)">
										<label for="checkbox_role_5_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.search == 1) {
    allRoleCounts['checkbox_th_5'] = allRoleCounts['checkbox_th_5'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter6(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_6_${row.id}" class="filled-in role_6" ${role_json.see_people == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'see_people',this.checked,this)">
										<label for="checkbox_role_6_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.see_people == 1) {
    allRoleCounts['checkbox_th_6'] = allRoleCounts['checkbox_th_6'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter7(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_7_${row.id}" class="filled-in role_7" ${role_json.after == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'after',this.checked,this)">
										<label for="checkbox_role_7_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.after == 1) {
    allRoleCounts['checkbox_th_7'] = allRoleCounts['checkbox_th_7'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter8(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_8_${row.id}" class="filled-in role_8" ${role_json.estimate == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'estimate',this.checked,this)">
										<label for="checkbox_role_8_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.estimate == 1) {
    allRoleCounts['checkbox_th_8'] = allRoleCounts['checkbox_th_8'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter9(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_9_${row.id}" class="filled-in role_9" ${role_json.dashboard == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'dashboard',this.checked,this)">
										<label for="checkbox_role_9_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.dashboard == 1) {
    allRoleCounts['checkbox_th_9'] = allRoleCounts['checkbox_th_9'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter10(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_10_${row.id}" class="filled-in role_10" ${role_json.calendar_new == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'calendar_new',this.checked,this)">
										<label for="checkbox_role_10_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.calendar_new == 1) {
    allRoleCounts['checkbox_th_10'] = allRoleCounts['checkbox_th_10'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter11(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_11_${row.id}" class="filled-in role_11" ${role_json.teach_more == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'teach_more',this.checked,this)">
										<label for="checkbox_role_11_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.teach_more == 1) {
    allRoleCounts['checkbox_th_11'] = allRoleCounts['checkbox_th_11'] + 1;
  }
  return inputHtml;
}

function inputCheckboxFormatter12(data, row) {
  let role_json = row.status;
  role_json = JSON.parse(role_json);
  let inputHtml = `
                  <div class="c-inputs-stacked">
										<input type="checkbox" data-id="${row.id}" id="checkbox_role_12_${row.id}" class="filled-in role_12" ${role_json.guide == 1 ? 'checked' : ''} onchange="updateRole(${row.id}, 'guide',this.checked,this)">
										<label for="checkbox_role_12_${row.id}" class="block"></label>
									</div>
                  `;
  if (role_json.guide == 1) {
    allRoleCounts['checkbox_th_12'] = allRoleCounts['checkbox_th_12'] + 1;
  }
  return inputHtml;
}

function autoNumberRow(value, row, index) {
  const options = $table.bootstrapTable("getOptions");
  const currentPage = options.pageNumber;
  let itemsPerPage = options.pageSize;
  if (itemsPerPage == "All") {
    const data = $table.bootstrapTable("getData");
    itemsPerPage = data.length;
  }
  const offset = (currentPage - 1) * itemsPerPage;
  return index + 1 + offset;
}


window.icons = {
  refresh: "fa-refresh",
};

let tableReloaded = false;

function initTable() {

  let arr_col = [{
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
  }, {
    field: "concat_name",
    title: "ชื่อ-สกุล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
    align: "left",
  },
  {
    field: "edu_name",
    title: "สถานศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
    align: "left",
    formatter: formatEduName,
  },
  {
    field: "operate",
    title: "สิทธิ์",
    align: "center",
    formatter: checkRoleFormat,
  }];

  if (role_of_am.view_grade) {
    arr_col.push({
      field: "role_1",
      title: "ระบบสืบค้นผลการเรียน",
      align: "center",
      formatter: inputCheckboxFormatter1,
    })
  }

  if (role_of_am.std_tracking) {
    arr_col.push({
      field: "role_2",
      title: "ระบบฐานข้อมูลนักศึกษา",
      align: "center",
      formatter: inputCheckboxFormatter2,
    })
  }

  if (role_of_am.visit_online) {
    arr_col.push({
      field: "role_3",
      title: "ระบบนิเทศการสอน",
      align: "center",
      formatter: inputCheckboxFormatter3,
    })
  }

  if (role_of_am.reading) {
    arr_col.push({
      field: "role_4",
      title: "ระบบส่งเสริมการอ่าน",
      align: "center",
      formatter: inputCheckboxFormatter4,
    })
  }

  if (role_of_am.search) {
    arr_col.push({
      field: "role_5",
      title: "ทะเบียนผู้จบการศึกษา",
      align: "center",
      formatter: inputCheckboxFormatter5,
    })
  }

  if (role_of_am.see_people) {
    arr_col.push({
      field: "role_6",
      title: "ฐานข้อมูลประชากรด้านการศึกษา",
      align: "center",
      formatter: inputCheckboxFormatter6,
    })
  }

  if (role_of_am.after) {
    arr_col.push({
      field: "role_7",
      title: "แบบติดตามหลังจบการศึกษา",
      align: "center",
      formatter: inputCheckboxFormatter7,
    })
  }
  if (role_of_am.estimate) {
    arr_col.push({
      field: "role_8",
      title: "ประเมินคุณธรรมนักศึกษา",
      align: "center",
      formatter: inputCheckboxFormatter8,
    })
  }

  if (role_of_am.dashboard) {
    arr_col.push({
      field: "role_9",
      title: "แดชบอร์ดภาพรวมข้อมูล",
      align: "center",
      formatter: inputCheckboxFormatter9,
    })
  }

  if (role_of_am.calendar_new) {
    arr_col.push({
      field: "role_10",
      title: "Smart Coach Room",
      align: "center",
      formatter: inputCheckboxFormatter10,
    })
  }

  if (role_of_am.teach_more) {
    arr_col.push({
      field: "role_11",
      title: "การสอนเสริม",
      align: "center",
      formatter: inputCheckboxFormatter11,
    })
  }

  arr_col.push({
    field: "operate",
    title: "แก้ไข",
    align: "center",
    width: "50px",
    formatter: formatButtonOperation,
  })

  $table.bootstrapTable("destroy").bootstrapTable({
    locale: "th-TH",
    width: "100%",
    columns: [arr_col],
  })
}
