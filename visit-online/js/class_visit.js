// function validateFormAddEduPlan(mode = 0, file_name = '') {
//     const time = $('#time').val();
//     const term = $('#term').val();
//     const year = $('#year').val();
//     const plan_name = $('#plan_name').val();
//     const file = document.getElementById('plan_file').files[0];
//     let formData = new FormData();
//     if (time == 0) {
//         alert('โปรดระบุครั้งที่สอน')
//         $('#time').focus()
//         return false;
//     }
//     if (!term) {
//         alert('โปรดกรอกภาคเรียน')
//         $('#term').focus()
//         return false;
//     }
//     if (!year) {
//         alert('โปรดกรอกปีการศึกษา')
//         $('#year').focus()
//         return false;
//     }
//     if (!plan_name) {
//         alert('โปรดชื่อแผนการเรียนรู้')
//         $('#plan_name').focus()
//         return false;
//     }
//     if (mode == 0) {
//         if (typeof file == 'undefined') {
//             alert('โปรดเลือกไฟล์แผนการเรียนรู้')
//             $('#plan_file').focus()
//             return false;
//         }
//     }
//     formData.append('file', file);
//     formData.append('time', time);
//     formData.append('term', term);
//     formData.append('year', year);
//     formData.append('plan_name', plan_name);
//     if (mode == 0) {
//         formData.append('insertEduPlan', true);
//     } else {
//         formData.append('updateEduPlan', true);
//         formData.append('edu_plan_id', mode);
//         formData.append('file_name_old', file_name);
//     }
//     return formData;
// }

function validateFormAddCalendar(mode = 0, file_name = "", work_file_old = [], other_file_old = []) {
    console.log(mode, file_name);
    // const time = $('#time').val();
    // const term = $('#term').val();
    // const year = $('#year').val();
    const time_step = $('#time_step').val();
    const link = $('#link').val();
    const link2 = $('#link2').val();
    const link3 = $('#link3').val();
    const link4 = $('#link4').val();
    const plan_name = $('#plan_name').val();
    const std_class = $('#std_class').val();
    // const calendar_name = $('#calendar_name').val();
    // const file = document.getElementById('calendar_file').files[0];
    const plan_file = document.getElementById('plan_file').files[0];
    // if (!time) {
    //     alert('โปรดกรอกครั้งที่')
    //     $('#time').focus()
    //     return false;
    // }
    // if (!term) {
    //     alert('โปรดกรอกภาคเรียน')
    //     $('#term').focus()
    //     return false;
    // }
    // if (!year) {
    //     alert('โปรดกรอกปีการศึกษา')
    //     $('#year').focus()
    //     return false;
    // }
    // if (!calendar_name) {
    //     alert('โปรดชื่อปฎิทินการพบกลุ่ม')
    //     $('#calendar_name').focus()
    //     return false;
    // }
    // if (mode == 0) {
    //     if (typeof file == 'undefined') {
    //         alert('โปรดเลือกไฟล์ปฎิทินการพบกลุ่ม')
    //         $('#calendar_file').focus()
    //         return false;
    //     }
    // }
    if (!time_step) {
        alert('โปรดกรอกครั้งที่')
        $('#time_step').focus()
        return false;
    }
    if (!plan_name) {
        alert('โปรดกรอกชื่อแผนการจัดการเรียนรู้')
        $('#plan_name').focus()
        return false;
    }
    if (mode == 0) {
        if (typeof plan_file == 'undefined') {
            alert('โปรดเลือกไฟล์แผนการจัดการเรียนรู้')
            $('#plan_file').focus()
            return false;
        }
    }

    // if (!link) {
    //     alert('โปรดกรอกลิงค์การสอน')
    //     $('#link').focus()
    //     return false;
    // }

    let formData = new FormData();
    formData.append('plan_file', plan_file);
    formData.append('time_step', time_step);
    formData.append('link', link);
    formData.append('link2', link2);
    formData.append('link3', link3);
    formData.append('link4', link4);
    formData.append('plan_name', plan_name);
    formData.append('std_class', std_class);

    if (mode == 0) {
        const work_file = document.getElementById('work_file').files;
        for (let i = 0; i < work_file.length; i++) {
            formData.append('work_file[]', work_file[i]);
        }

        const other_file = document.getElementById('other_file').files;
        for (let i = 0; i < other_file.length; i++) {
            formData.append('other_file[]', other_file[i]);
        }

        formData.append('insertCalendar', true);

    } else {
        formData.append('editCalendar', true);
        formData.append('calendar_id', mode);
        formData.append('plan_file_old', file_name);

        for (let i = 0; i < work_file_old.length; i++) {
            if (typeof work_file_old[i].fileName != 'undefined') {
                formData.append('work_id[]', work_file_old[i].work_id);
                formData.append('fileName_old[]', work_file_old[i].fileName_old);
                formData.append('work_file_old[]', work_file_old[i].fileName);
            }
        }

        const work_file_add = document.getElementById('work_file_add').files;
        console.log(work_file_add);
        for (let i = 0; i < work_file_add.length; i++) {
            formData.append('work_file[]', work_file_add[i]);
        }

        for (let i = 0; i < other_file_old.length; i++) {
            if (typeof other_file_old[i].fileName != 'undefined') {
                formData.append('other_id[]', other_file_old[i].other_id);
                formData.append('other_fileName_old[]', other_file_old[i].fileName_old);
                formData.append('other_file_old[]', other_file_old[i].fileName);
            }
        }

        const other_file_add = document.getElementById('other_file_add').files;
        for (let i = 0; i < other_file_add.length; i++) {
            formData.append('other_file[]', other_file_add[i]);
        }

    }
    return formData;
}


function validateFormAddCalendarNew(mode = 0, work_file_old = []) {
    // const time = $('#time').val();
    // const term = $('#term').val();
    // const year = $('#year').val();
    const std_class = $('#std_class').val();
    const time_step = $('#time_step').val();
    const plan_name = $('#plan_name').val();

    const test_before_link = $('#test_before_link').val();
    const test_after_link = $('#test_after_link').val();

    const content_link = $('#content_link').val();

    const work_sheet = $('#work_sheet').val();

    if (!time_step) {
        alert('โปรดกรอกครั้งที่')
        $('#time_step').focus()
        return false;
    }
    if (!plan_name) {
        alert('โปรดกรอกชื่อแผนการจัดการเรียนรู้')
        $('#plan_name').focus()
        return false;
    }

    let formData = new FormData();
    formData.append('std_class', std_class);
    formData.append('time_step', time_step);
    formData.append('plan_name', plan_name);

    formData.append('test_before_link', test_before_link);
    formData.append('test_after_link', test_after_link);

    formData.append('content_link', content_link);

    formData.append('work_sheet', work_sheet);

    if (mode == 0) {
        const work_file = document.getElementById('work_file').files;
        for (let i = 0; i < work_file.length; i++) {
            formData.append('work_file[]', work_file[i]);
        }

        const content_file = document.getElementById('content_file').files;
        for (let i = 0; i < content_file.length; i++) {
            formData.append('content_file', content_file[i]);
        }

        const plan_file = document.getElementById('plan_file').files;
        for (let i = 0; i < plan_file.length; i++) {
            formData.append('plan_file', plan_file[i]);
        }

        formData.append('insertCalendarNew', true);

    } else {
        formData.append('editCalendar', true);
        formData.append('calendar_id', mode);
        formData.append('content_file_old_name', $('#content_file_old_name').val());
        formData.append('plan_file_old', $('#plan_file_old').val());

        console.log(work_file_old);
        for (let i = 0; i < work_file_old.length; i++) {
            if (typeof work_file_old[i].fileName != 'undefined') {
                formData.append('work_id[]', work_file_old[i].work_id);
                formData.append('fileName_old[]', work_file_old[i].fileName_old);
                formData.append('work_file_old[]', work_file_old[i].fileName);
            }
        }

        const work_file_add = document.getElementById('work_file_add').files;
        for (let i = 0; i < work_file_add.length; i++) {
            formData.append('work_file[]', work_file_add[i]);
        }

        const content_file = document.getElementById('content_file').files;
        for (let i = 0; i < content_file.length; i++) {
            formData.append('content_file', content_file[i]);
        }

        const plan_file = document.getElementById('plan_file').files;
        for (let i = 0; i < plan_file.length; i++) {
            formData.append('plan_file', plan_file[i]);
        }
    }
    return formData;
}


function validateDataLearning_bk(mode = 0) {
    // Required field names
    var required = ['calendar_id', 'side_1', 'side_2', 'side_3'];
    var alert_msg = ['โปรดเลือกปฏิทินพบกลุ่ม', 'กรอกข้อมูลผลการจัดการเรียนการสอน', 'กรอกข้อมูลปัญหาและอุปสรรค', 'กรอกข้อมูลข้อเสนอแนะ/แนวทางการแก้ไข']; //,'โปรดเลือกรูปภาพ 4 ภาพ'

    let formData = new FormData();
    if (mode == 0) {
        formData.append('insertLearning', true);
    } else {
        formData.append('learning_id', mode);
        formData.append('updateLearning', true);
    }

    for (let i = 0; i < required.length; i++) {
        let ele = document.getElementById(required[i]);
        console.log(ele.value);
        if (ele.value == "") {
            alert(alert_msg[i])
            ele.focus();
            return false;
        } else {
            formData.append(required[i], ele.value);
        }
    }
    const image_file = $('#image_file')[0].files;
    if (image_file.length != 4) {
        alert('โปรดเลือกรูปภาพ 4 ภาพ')
        document.getElementById('id').focus();
        return false;
    }


    return formData;
}
function validateDataLearning(mode = 0, file_old = "") {
    //const time = $('#time').val();

    return formData;
}

function validateFormAddMainCalendar(mode = 0, file_name = "") {
    //const time = $('#time').val();
    const term = $('#term').val();
    const year = $('#year').val();
    const main_calendar_name = $('#main_calendar_name').val();
    const main_calendar_file = document.getElementById('main_calendar_file').files[0];
    // if (!time) {
    //     alert('โปรดกรอกครั้งที่')
    //     $('#time').focus()
    //     return false;
    // }
    if (!term) {
        alert('โปรดกรอกภาคเรียน')
        $('#term').focus()
        return false;
    }
    if (!year) {
        alert('โปรดกรอกปีการศึกษา')
        $('#year').focus()
        return false;
    }
    if (!main_calendar_name) {
        alert('โปรดชื่อปฎิทินการพบกลุ่ม')
        $('#main_calendar_name').focus()
        return false;
    }
    if (mode == 0) {
        if (typeof main_calendar_file == 'undefined') {
            alert('โปรดเลือกไฟล์ปฎิทินการพบกลุ่ม')
            $('#main_calendar_file').focus()
            return false;
        }
    }

    let formData = new FormData();
    // formData.append('file', file);
    formData.append('main_calendar_file', main_calendar_file);
    formData.append('term', term);
    formData.append('year', year);
    formData.append('time', 1);
    formData.append('main_calendar_name', main_calendar_name);
    if (mode == 0) {
        formData.append('insertMainCalendar', true);
    } else {
        formData.append('editMainCalendar', true);
        formData.append('main_calendar_id', mode);
        formData.append('main_calendar_file_old', file_name);
    }
    return formData;
}