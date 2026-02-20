var $table = $("#table");

window.icons = {
  refresh: "fa-refresh",
};

function formatCounter(data, row, index) {
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

function formatToBuddhistDate(gregorianDate) {
  // Create a Date object from the Gregorian date
  const date = gregorianDate != '' ? new Date(gregorianDate) : new Date()

  // Get the day, month, and year from the Date object
  const day = String(date.getDate()).padStart(2, '0');
  const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
  const year = date.getFullYear() + 543; // Convert to Buddhist year

  // Format the date as d-m-y
  return `${day}-${month}-${year}`;
}

function formatButtonViewData(data, row) {
  let html = `<a target="_blank" href="manage_private_data?url=dashboard_index&user_id=${row.u_id}&pro=${pro}&dis=${dis}&sub=${sub}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-info mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  return html;
}

function formatButtonView(data, row) {
  let html = `<a href="../visit-online/manage_calendar?pro=0&dis=0&sub=0&page_number=1&user_id=${row.u_id}&name=${row.concat_name}">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  return html;
}

function formatButtonView1(data, row) {
  let html = `<a href="../visit-online/manage_calendar?pro=0&dis=0&sub=0&page_number=1&user_id=${row.u_id}&name=${row.concat_name}&class=1">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  if (row.role_id != 3) {
    html = '-';
  }
  return html;
}

function formatButtonView2(data, row) {
  let html = `<a href="../visit-online/manage_calendar?pro=0&dis=0&sub=0&page_number=1&user_id=${row.u_id}&name=${row.concat_name}&class=2">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  if (row.role_id != 3) {
    html = '-';
  }
  return html;
}

function formatButtonView3(data, row) {
  let html = `<a href="../visit-online/manage_calendar?pro=0&dis=0&sub=0&page_number=1&user_id=${row.u_id}&name=${row.concat_name}&class=3">
                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-primary mb-5 mt-1" style="width:30px;height:30px;"><i class="ti-eye" style="font-size:10px"></i></button>
                </a>`;
  if (row.role_id != 3) {
    html = '-';
  }
  return html;
}

function formatEndWorkDate(data, row) {
  if (row.end_work != '-') {
    let date = formatToBuddhistDate(row.end_work);
    return date;
  }
  return row.end_work;
}

function formatSumStdCount(data, row) {
  let sum = parseInt(row.pratom) + parseInt(row.mTon) + parseInt(row.mPai)
  return sum;
}