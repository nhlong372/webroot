<?php
if ((isset($_GET['month']) && $_GET['month'] != '') && (isset($_GET['year']) && $_GET['year'] != '')) {
    $time = $_GET['year'] . '-' . $_GET['month'] . '-1';
    $date = strtotime($time);
} else {
    $date = strtotime(date('y-m-d'));
}

$day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);
$firstDay = mktime(0, 0, 0, $month, 1, $year);
$dayOfWeek = date('D', $firstDay);
$daysInMonth = cal_days_in_month(0, $month, $year);
$timestamp = strtotime('next Sunday');
$weekDays = array();

/* Make data for js chart */
$charts = array();
$charts['month'] = $month;

for ($i = 1; $i <= $daysInMonth; $i++) {
    $k = $i + 1;
    $begin = strtotime($year . '-' . $month . '-' . $i);

    if ($k == 32) {
        $month = $month;
        if ($month == 13) {
            $year = $year + 1;
            $month = 1;
        }
        $k = 1;
    }

    $end = strtotime($year . '-' . $month . '-' . $k);
    $todayrc = $d->rawQueryOne("select count(*) as todayrecord from #_counter where tm >= ? and tm < ?", array($begin, $end));
    $today_visitors = $todayrc['todayrecord'];
    $charts['series'][] = $today_visitors;
    $charts['labels'][] = 'D' . $i;
}
$browser = $d->rawQuery("select browser from #_counter where browser <> '' group by browser", array());
$countBrowser = $d->rawQueryOne("select count(*) as total from #_counter where browser <> '' or browser is not null", array());
// $topIp = $d->rawQuery("select ip, count(*) as visits from #_counter group by ip order by visits desc limit 0,5", array());
$device = $d->rawQuery("select device from #_counter where device <> '' group by device", array());
$countDevice = $d->rawQueryOne("select count(*) as total from #_counter where device <> '' and device is not null", array());
$Booked = $d->rawQueryOne("select count(*) as total from #_order where order_status = 1", array());
$Confirmed = $d->rawQueryOne("select count(*) as total from #_order where order_status = 2", array());
$Delivered = $d->rawQueryOne("select count(*) as total from #_order where order_status = 4", array());
$Cancelled = $d->rawQueryOne("select count(*) as total from #_order where order_status = 5", array());
$piecharts = array(
    'data' => array($Booked['total'], $Confirmed['total'], $Delivered['total'], $Cancelled['total'])
);
?>
<!-- Main content -->
<section class="content mb-3">
    <div class="container-fluid">
        <h5 class="pt-3 pb-2">Dashboard</h5>
        <div class="row mb-2 text-sm">
            <div class="col-12 col-sm-6 col-md-3">
                <a class="my-info-box info-box" href="index.php?com=setting&act=update" title="Cấu hình website">
                    <span class="my-info-box-icon info-box-icon bg-primary"><i class="fas fa-cogs"></i></span>
                    <div class="info-box-content text-dark">
                        <span class="info-box-text text-capitalize">Cấu hình website</span>
                        <span class="info-box-number">View more</span>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a class="my-info-box info-box" href="index.php?com=user&act=info_admin" title="Tài khoản">
                    <span class="my-info-box-icon info-box-icon bg-danger"><i class="fas fa-user-cog"></i></span>
                    <div class="info-box-content text-dark">
                        <span class="info-box-text text-capitalize">Tài khoản</span>
                        <span class="info-box-number">View more</span>
                    </div>
                </a>
            </div>
            <div class="clearfix hidden-md-up d-none"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <a class="my-info-box info-box" href="index.php?com=user&act=info_admin&changepass=1" title="Đổi mật khẩu">
                    <span class="my-info-box-icon info-box-icon bg-success"><i class="fas fa-key"></i></span>
                    <div class="info-box-content text-dark">
                        <span class="info-box-text text-capitalize">Đổi mật khẩu</span>
                        <span class="info-box-number">View more</span>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a class="my-info-box info-box" href="index.php?com=contact&act=man" title="Thư liên hệ">
                    <span class="my-info-box-icon info-box-icon bg-info"><i class="fas fa-address-book"></i></span>
                    <div class="info-box-content text-dark">
                        <span class="info-box-text text-capitalize">Thư liên hệ</span>
                        <span class="info-box-number">View more</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content pb-4">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thống kê truy cập tháng <?= $month ?>/<?= $year ?></h5>
            </div>
            <div class="card-body">
                <form class="form-filter-charts row align-items-center mb-1" action="index.php" method="get" name="form-thongke" accept-charset="utf-8">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control select2" name="month" id="month">
                                <option value="">Chọn tháng</option>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <?php
                                    if (isset($_GET['year'])) $selected = ($i == $_GET['month']) ? 'selected' : '';
                                    else $selected = ($i == date('m')) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $i ?>" <?= $selected ?>>Tháng <?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control select2" name="year" id="year">
                                <option value="">Chọn năm</option>
                                <?php for ($i = 2000; $i <= date('Y') + 20; $i++) { ?>
                                    <?php
                                    if (isset($_GET['year'])) $selected = ($i == $_GET['year']) ? 'selected' : '';
                                    else $selected = ($i == date('Y')) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $i ?>" <?= $selected ?>>Năm <?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><button type="submit" class="btn btn-success">Thống Kê</button></div>
                    </div>
                </form>
                <div id="apexMixedChart"></div>
            </div>
        </div>
        <div class="card-statistics">
            <!-- Browser Statistics -->
            <div class="<?= (CARTSITE) ? "col-xl-4" : "col-xl-6 " ?> col-md-12 card-browser">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title m-0 me-2">
                            <h5 class="m-0 me-2">Danh sách trình duyệt truy cập</h5>
                            <small class="text-muted">Thống kê đến ngày <?= date('d/m/Y', time()) ?></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-browser">
                            <?php foreach ($browser ?? [] as $k => $value) { ?>
                                <li class="mb-3 pb-1 d-flex">
                                    <div class="d-flex w-50 align-items-center mr-3">
                                        <img onerror="this.src='./assets/images/noimage.png';" src="./assets/images/browser/<?= $func->getBrowserStatistic($value['browser'], $countBrowser['total'])['img'] ?>.png"
                                            alt="<?= $func->getBrowserStatistic($value['browser'], $countBrowser['total'])['name'] ?>"
                                            class="mr-3 img-browser" width="35" />
                                        <div class="name-browser">
                                            <h6 class="mb-0">
                                                <?= $func->getBrowserStatistic($value['browser'], $countBrowser['total'])['name'] ?>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <div class="progress w-100 mr-3 rounded" style="height: 8px">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: <?= $func->getBrowserStatistic($value['browser'], $countBrowser['total'])['figure'] ?>%"
                                                aria-valuenow="<?= $func->getBrowserStatistic($value['browser'], $countBrowser['total'])['figure'] ?>"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-muted"><?= $func->getBrowserStatistic($value['browser'], $countBrowser['total'])['figure'] ?>%</span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Device Statistics -->
            <div class="<?= (CARTSITE) ? "col-xl-4" : "col-xl-6 card-device" ?> col-md-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title m-0 me-2">
                            <h5 class="m-0 me-2">Danh sách thiết bị truy cập</h5>
                            <small class="text-muted">Thống kê đến ngày <?= date('d/m/Y', time()) ?></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-device">
                            <?php foreach ($device ?? [] as $k => $value) { ?>
                                <li class="mb-3 pb-1 d-flex">
                                    <div class="d-flex w-50 align-items-center mr-3">
                                        <img onerror="this.src='./assets/images/noimage.png';" src="./assets/images/device/<?= $func->getDeviceStatistic($value['device'], $countDevice['total'])['img'] ?>.png"
                                            alt="<?= $func->getDeviceStatistic($value['device'], $countDevice['total'])['name'] ?>"
                                            class="mr-3 img-browser" width="35" />
                                        <div class="name-device">
                                            <h6 class="mb-0">
                                                <?= $func->getDeviceStatistic($value['device'], $countDevice['total'])['name'] ?>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <div class="progress w-100 mr-3 rounded" style="height: 8px">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: <?= $func->getDeviceStatistic($value['device'], $countDevice['total'])['figure'] ?>%"
                                                aria-valuenow="<?= $func->getDeviceStatistic($value['device'], $countDevice['total'])['figure'] ?>"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-muted"><?= $func->getDeviceStatistic($value['device'], $countDevice['total'])['figure'] ?>%</span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Order Statistics -->
            <?php if (CARTSITE) { ?>
                <div class="col-xl-4 col-md-12 card-order">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title m-0 me-2">
                                <h5 class="m-0 me-2">Danh sách thống kê đơn hàng</h5>
                                <small class="text-muted">Thống kê đến ngày <?= date('d/m/Y', time()) ?></small>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <div class="col-md-3">
                                <ul class="chart-legend clearfix">
                                    <li class="mb-4"><i class="fas fa-circle text-primary"></i> <span class="text-capitalize font-weight-bold">Mới đặt</span></li>
                                    <li class="mb-4"><i class="fas fa-circle text-info"></i> <span class="text-capitalize font-weight-bold">Đã xác nhận</span></li>
                                    <li class="mb-4"><i class="fas fa-circle text-success"></i> <span class="text-capitalize font-weight-bold">Đã Giao</span></li>
                                    <li class="mb-0"><i class="fas fa-circle text-danger"></i> <span class="text-capitalize font-weight-bold">Đã hủy</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>