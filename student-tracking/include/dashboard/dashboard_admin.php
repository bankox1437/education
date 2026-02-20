<?php include "include/form_prodissub.php"; ?>
<div class="row">
    <div class="col-xl-4">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon rounded-circle" style="background-color: #022C9C;">
                        <i class="mr-0 font-size-20 fa fa-user-circle-o" style="color: #FFFFFF ;"></i>
                    </div>
                    <div>
                        <h3 class="text-dark text-right mb-0 font-weight-500 " id="count_std">0</h3>
                        <p class="text-mute mb-0">จำนวนนักศึกษา</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon bg-#640084-light rounded-circle" style="background-color: #640084 ;">
                        <i class="mr-0 font-size-20 fa fa-server" style="color:#FFFFFF;"></i>
                    </div>
                    <div>
                        <h3 class="text-dark text-right mb-0 font-weight-500" id="std_person">0</h3>
                        <p class="text-mute mb-0">จำนวนข้อมูลนักศึกษา</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon bg-#24C407-light rounded-circle" style="background-color: #24C407;">
                        <i class="mr-0 font-size-20 fa fa-home" style="color: #FFFFFF;"></i>
                    </div>
                    <div>
                        <h3 class="text-dark text-right mb-0 font-weight-500" id="visit_home">0</h3>
                        <p class="text-mute mb-0">จำนวนการเยี่ยมบ้านนักศึกษา</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon bg-#FC0505 -light rounded-circle" style="background-color: #FC0505 ;">
                        <i class="mr-0 font-size-20 fa fa-pie-chart" style="color: #FFFFFF ;"></i>
                    </div>
                    <div>
                        <h3 class="text-dark text-right mb-0 font-weight-500" id="visit_sum">0</h3>
                        <p class="text-mute mb-0">จำนวนสรุปการเยี่ยมบ้าน</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon bg-#FAAB00 -light rounded-circle" style="background-color: #FAAB00 ;">
                        <i class="mr-0 font-size-20 fa fa-address-book" style="color: #FFFFFF;"></i>
                    </div>
                    <div>
                        <h3 class="text-dark text-right mb-0 font-weight-500" id="from_evoluate">0</h3>
                        <p class="text-mute mb-0">จำนวนแบบประเมินนักศึกษา</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="box">
            <div class="box-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon bg-#FE5092-light rounded-circle" style="background-color:#FE5092 ;">
                        <i class="mr-0 font-size-20 fa fa-child" style="color:#FFFFFF;"></i>
                    </div>
                    <div>
                        <h3 class="text-dark text-right mb-0 font-weight-500" id="screening">0</h3>
                        <p class="text-mute mb-0">จำนวนการคัดกรองนักศึกษา</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <h3 class="mb-2 mt-0">ตารางสรุปสถิติ</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-12" id="table_sum">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th class="text-left">รายละเอียด</th>
                                    <th>ชาย</th>
                                    <th>%</th>
                                    <th>หญิง</th>
                                    <th>%</th>
                                    <th>อยู่กับพ่อแม่</th>
                                    <th>%</th>
                                    <th>อยู่กับแม่</th>
                                    <th>%</th>
                                    <th>อยู่กับพ่อ</th>
                                    <th>%</th>
                                    <th>อยู่ลำพัง</th>
                                    <th>%</th>
                                    <th>อยู่กับคนอื่น</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-left">
                                    <td>ประถมศึกษา</td>
                                    <td class="text-center font-weight-500" id="std_gender1"></td>
                                    <td class="text-center font-weight-500" id="std_gender1per"></td>
                                    <td class="text-center font-weight-500" id="std_gender4"></td>
                                    <td class="text-center font-weight-500" id="std_gender4per"></td>
                                    <td class="text-center font-weight-500" id="p_parent_fm"></td>
                                    <td class="text-center font-weight-500" id="p_parent_fm_per"></td>
                                    <td class="text-center font-weight-500" id="p_parent_m"></td>
                                    <td class="text-center font-weight-500" id="p_parent_m_per"></td>
                                    <td class="text-center font-weight-500" id="p_parent_f"></td>
                                    <td class="text-center font-weight-500" id="p_parent_f_per"></td>
                                    <td class="text-center font-weight-500" id="p_parent_alone"></td>
                                    <td class="text-center font-weight-500" id="p_parent_alone_per"></td>
                                    <td class="text-center font-weight-500" id="p_parent_other"></td>
                                    <td class="text-center font-weight-500" id="p_parent_other_per"></td>
                                </tr>
                                <tr class="text-left">
                                    <td>มัธยมศึกษาตอนต้น</td>
                                    <td class="text-center font-weight-500" id="std_gender2"></td>
                                    <td class="text-center font-weight-500" id="std_gender2per"></td>
                                    <td class="text-center font-weight-500" id="std_gender5"></td>
                                    <td class="text-center font-weight-500" id="std_gender5per"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_fm"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_fm_per"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_m"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_m_per"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_f"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_f_per"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_alone"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_alone_per"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_other"></td>
                                    <td class="text-center font-weight-500" id="m_s_parent_other_per"></td>
                                </tr>
                                <tr class="text-left">
                                    <td>มัธยมศึกษาตอนปลาย</td>
                                    <td class="text-center font-weight-500" id="std_gender3"></td>
                                    <td class="text-center font-weight-500" id="std_gender3per"></td>
                                    <td class="text-center font-weight-500" id="std_gender6"></td>
                                    <td class="text-center font-weight-500" id="std_gender6per"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_fm"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_fm_per"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_m"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_m_per"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_f"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_f_per"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_alone"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_alone_per"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_other"></td>
                                    <td class="text-center font-weight-500" id="m_e_parent_other_per"></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>