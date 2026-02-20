<?php

session_start();
include "../../config/class_database.php";

$DB = new Class_Database();

if (isset($_POST['update_noti'])) {
    try {
        $noti_id_arr = $_POST['noti_id'];
        $noti_msg_arr = $_POST['noti_msg'];
        $noti_msg_old_arr = $_POST['noti_msg_old'];

        for ($i = 0; $i < count($noti_id_arr); $i++) {
            $noti_id = $noti_id_arr[$i];

            $arr_data = array(
                'noti_msg' => $noti_msg_arr[$i],
                'user_create' => $_SESSION['user_data']->id,
                'std_class' => $_POST['std_class']
            );

            if (!empty($noti_id)) {
                unset($arr_data['user_create']);
                unset($arr_data['std_class']);

                $columnCrateDate = ", create_date = :create_date";
                if (trim($noti_msg_arr[$i]) != trim($noti_msg_old_arr[$i])) {
                    date_default_timezone_set('Asia/Bangkok');
                    $arr_data['create_date'] = date('Y-m-d H:i:s');
                }

                // Update existing record
                $sql = "UPDATE tb_notifications SET noti_msg = :noti_msg $columnCrateDate WHERE noti_id = :noti_id";
                $arr_data = array_merge($arr_data, array('noti_id' => $noti_id));
                $data = $DB->Update($sql, $arr_data);
            } else {
                // Insert new record
                $sql = "INSERT INTO tb_notifications 
                    (noti_msg, user_create, std_class) VALUES 
                    (:noti_msg, :user_create, :std_class)";
                $data = $DB->Insert($sql, $arr_data);
            }
        }

        if ($data) {
            $response = ['status' => true, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $data];
        }

        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array('status' => false, 'msg' => $e->getMessage());
        echo json_encode($response);
    }
}

if (isset($_POST['update_color'])) {
    try {
        $color_id = $_POST['color_id'] ?? '';
        $color1 = $_POST['color1'] ?? '';
        $color2 = $_POST['color2'] ?? '';
        $user_create = $_SESSION['user_data']->id;
        $std_class = $_POST['std_class'] ?? '';

        if (!empty($color_id)) {
            // Update existing record
            $sql = "UPDATE tb_colors SET color1 = :color1, color2 = :color2 WHERE color_id = :color_id";
            $arr_data = array(
                'color1' => $color1,
                'color2' => $color2,
                'color_id' => $color_id
            );
            $data = $DB->Update($sql, $arr_data);
        } else {
            // Insert new record
            $sql = "INSERT INTO tb_colors 
                (color1, color2, user_create, std_class) VALUES 
                (:color1, :color2, :user_create, :std_class)";

            $arr_data = array(
                'color1' => $color1,
                'color2' => $color2,
                'user_create' => $user_create,
                'std_class' => $std_class
            );
            $data = $DB->Insert($sql, $arr_data);
        }

        if ($data) {
            $response = ['status' => true, 'msg' => 'บันทึกข้อมูลสำเร็จ'];
        } else {
            $response = ['status' => false, 'msg' => $data];
        }

        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array('status' => false, 'msg' => $e->getMessage());
        echo json_encode($response);
    }
}
