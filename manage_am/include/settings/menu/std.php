<?php

$sql = "SELECT * FROM tb_menus WHERE type = 'std' ORDER BY order_number ASC";
$data_result = $DB->Query($sql, []);
$data_result = json_decode($data_result, true);
$menu_list = $data_result;

?>
<form class="form" id="setting_menu_std" enctype="multipart/form-data">
    <div class="row mt-3">
        <?php foreach ($menu_list as $index => $menu_item) { ?>
            <div class="col-md-6 mt-4" style="border-bottom: 1px #eeeeee solid;">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" class="form-control" name="menu[<?php echo $menu_item['menu_id'] ?>][menu_name]" value="<?php echo $menu_item['menu_name']; ?>" placeholder="<?php echo $menu_item['menu_name']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4 row">
                        <div class="form-group col-10 col-md-10">
                            <input type="hidden" class="form-control" id="icon_old<?php echo $menu_item['menu_id'] ?>" name="menu[<?php echo $menu_item['menu_id'] ?>][icon_old]" value="<?php echo $menu_item['menu_icon']; ?>">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="icon_image_<?php echo $menu_item['menu_id'] ?>" name="icon_image[<?php echo $menu_item['menu_id'] ?>]" accept="image/png, image/gif, image/jpeg" onchange="setlabelFilename('icon_image_<?php echo $menu_item['menu_id'] ?>')">
                                <label class="custom-file-label" for="icon_image_<?php echo $menu_item['menu_id'] ?>" id="icon_image_<?php echo $menu_item['menu_id'] ?>_label" style="overflow: hidden;">เลือกไฟล์ไอคอน</label>
                            </div>
                        </div>
                        <div class="form-group col-2 col-md-2 text-center">
                            <img src="../<?php echo $menu_item['menu_icon']; ?>" alt="<?php echo $menu_item['menu_icon']; ?>" width="20px" class="pt-2" id="icon_image_<?php echo $menu_item['menu_id'] ?>_preview">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="color" class="form-control" id="color_name_<?php echo $menu_item['menu_id'] ?>" name="menu[<?php echo $menu_item['menu_id'] ?>][menu_color]" value="<?php echo $menu_item['menu_color']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                <i class="ti-save-alt"></i> บันทึก
            </button>
        </div>
    </div>
</form>


<script>
    $("#setting_menu_std").submit(function(e) {
        e.preventDefault();

        // Create a new FormData object with form data
        let formData = new FormData(this);
        formData.append("mode", "setting_menu");

        $.ajax({
            type: "POST",
            url: "controllers/setting_controller",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(json) {
                alert(json.msg);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("An error occurred: " + xhr.responseText);
            }
        });
    });
</script>