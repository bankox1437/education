var $table = $("#table");

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
