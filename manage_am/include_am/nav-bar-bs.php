<?php $routeName =  basename($_SERVER["SCRIPT_FILENAME"], '.php'); ?>

<nav class="navbar navbar-default navbar-fixed-top" style="background-color: #5949d6;width: 100vw;">
    <div class="nav-content">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="" style="display: flex;align-items: center;">
                <img src="manage_am/images/khokpho/logo.png" alt="logo" style="width: 60px;height: 60px;margin-right: 10px;">
                สกร.ระดับอำเภอโคกโพธิ์
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php foreach ($links as $link) { ?>
                    <li class="<?php echo $routeName == $link['link'] ? 'active' : '' ?>">
                        <a class="page-scroll" href="<?php echo $link['link'] ?>"><?php echo $link["title"] ?></a>
                    </li>
                <?php } ?>
                <!-- Dropdown submenu -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        กราฟสถิติข้อมูล <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($linksChart as $link) {
                            // Extract iframe attributes
                            preg_match_all('/(\w+)=["\']([^"\']+)["\']/', $link['chart_url'], $matches);
                            $attributes = array_combine($matches[1], $matches[2]);

                            // Convert attributes to JSON for use in data-chart-url
                            $dataChartUrl = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8');
                        ?>
                            <li class="list-group-item" data-chart-url="<?php echo $dataChartUrl; ?>" style="cursor: pointer;"><a>จำนวน นศ.แบ่งตามระดับชั้น</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- End Dropdown -->
            </ul>
        </div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>