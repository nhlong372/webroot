<?php
$counter = $statistic->getCounter();
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
$browser = $cache->get("select browser from #_counter where browser <> '' group by browser", null, 'result', 7200);
$countBrowser = $cache->get("select count(*) from #_counter where browser <> ''", null, 'result', 7200);
$topIp = $cache->get("select ip, count(*) as visits from #_counter group by ip order by visits desc limit 0,5", null, 'result', 7200);
$device = $cache->get("select device from #_counter where device <> '' group by device", null, 'result', 7200);
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
            <div class="clearfix hidden-md-up"></div>
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
    </div>
</section>