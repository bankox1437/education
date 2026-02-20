<?php

$sql = "SELECT * FROM am_menu_left WHERE sub_menu = 0 ORDER BY menu_order ASC";
$links = $DB->Query($sql, []);
$links = json_decode($links, true);
$links = $links;