 <nav class="navbar navbar-default mobile-navbar" role="navigation" style="margin-bottom: 0; background-color: #5949d6; border-radius: 0;">
     <div class="container" style="margin: 0;width: 100%;">
         <!-- Toggle Button -->
         <div class="navbar-header">
             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobileMenu">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar" style="background-color: white;"></span>
                 <span class="icon-bar" style="background-color: white;"></span>
                 <span class="icon-bar" style="background-color: white;"></span>
             </button>
         </div>

         <!-- Menu Links -->
         <div class="collapse navbar-collapse" id="mobileMenu">
             <ul class="nav navbar-nav text-center" style="width: 100%;">
                 <?php foreach ($links as $link) {
                        $sql = "SELECT * FROM am_menu_left WHERE sub_menu = " . $link['menu_id'] . " ORDER BY menu_id ASC";
                        $checkSubMenu = $DB->Query($sql, []);
                        $checkSubMenu = json_decode($checkSubMenu, true);
                        $checkSubMenu = $checkSubMenu;
                        if (count($checkSubMenu) == 0) { ?>
                         <li style="width: 100%;">
                             <a href="<?php echo $link['link']; ?>" style="background-color: <?php echo $link['menu_color']; ?>;" <?php echo !empty($link['target']) ? 'target="_blank"' : ''; ?>>
                                 <?php echo $link['menu_name']; ?>
                             </a>
                         </li>
                     <?php } else { ?>
                         <li class="dropdown" style="width: 100%;">
                             <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="background-color: <?php echo $link['menu_color']; ?>; color: white;cursor: pointer;">
                                 <?php echo $link['menu_name']; ?> <span class="caret"></span>
                             </a>
                             <ul class="dropdown-menu" role="menu" style="width: 100%;">
                                 <?php foreach ($checkSubMenu as $subLink) {
                                        if ($subLink['sub_menu'] == 30) {
                                            preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $subLink['link'], $matches);
                                            $attributes = array_combine($matches[1], $matches[2]);
                                            $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8'); ?>
                                         <li style="width: 100%;">
                                             <a class="chart-link" data-chart-url="<?php echo $dataChartUrl; ?>" style="color: #000000;background-color: <?php echo $subLink['menu_color']; ?>;cursor: pointer;">
                                                 <?php echo $subLink["menu_name"]; ?>
                                             </a>
                                         </li>
                                     <?php  } else { ?>
                                         <li style="width: 100%;">
                                             <a href="<?php echo $subLink['link'] ?>" style="color: #000000;background-color: <?php echo $subLink['menu_color']; ?>;cursor: pointer;">
                                                 <?php echo $subLink["menu_name"]; ?>
                                             </a>
                                         </li>
                                     <?php } ?>
                                 <?php } ?>
                             </ul>
                         </li>
                 <?php  }
                    } ?>

                 <!-- <li class="dropdown" style="width: 100%;">
                     <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="background-color: pink; color: white;cursor: pointer;">
                         กราฟสถิติข้อมูล <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu" role="menu" style="width: 100%;">
                         <?php foreach ($linksChart as $link) {
                                preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $link['link'], $matches);
                                $attributes = array_combine($matches[1], $matches[2]);
                                $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8');
                            ?>
                             <li style="width: 100%;">
                                 <a class="chart-link" data-chart-url="<?php echo $dataChartUrl; ?>" style="color: #000000;background-color: <?php echo $link['menu_color']; ?>;cursor: pointer;">
                                     <?php echo $link["menu_name"]; ?>
                                 </a>
                             </li>
                         <?php } ?>
                     </ul>
                 </li> -->

                 <!-- <li class="dropdown" style="width: 100%;">
                     <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="background-color: #0fe912; color: white;cursor: pointer;">
                         ศกร. ตำบล <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu" role="menu" style="width: 100%;">
                         <?php foreach ($linksSubDis as $link) { ?>
                             <li style="width: 100%;">
                                 <a href="<?php echo $link['link'] ?>" class="sgr" style="color: #000000;background-color: <?php echo $link['menu_color']; ?>;cursor: pointer;">
                                     <?php echo $link["menu_name"]; ?>
                                 </a>
                             </li>
                         <?php } ?>
                     </ul>
                 </li> -->
             </ul>
         </div>
     </div>
 </nav>