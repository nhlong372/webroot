<?php
$countNotify = 0;

/* Contact */
$contactNotify = $d->rawQuery("select id from #_contact where status = ''");
$countNotify += count($contactNotify);

/* Newsletter */
if (isset($config['newsletter'])) {
    $newsletterNotify = array();
    foreach ($config['newsletter'] as $k => $v) {
        $emailNotify = $d->rawQuery("select id from #_newsletter where type = ? and status = ''", array($k));
        $newsletterNotify[$k] = array();
        $newsletterNotify[$k]['title'] = $v['title_main'];
        $newsletterNotify[$k]['notify'] = count($emailNotify);
        $countNotify += $newsletterNotify[$k]['notify'];
    }
}

/* Order */
if (isset($config['order']['active']) && $config['order']['active'] == true) {
    $orderNotify = $d->rawQuery("select id from #_order where order_status = 1");
    $countNotify += count($orderNotify);
}

/* Comment: Product */
if (isset($config['product'])) {
    $commentProductNotify = array();
    foreach ($config['product'] as $k => $v) {
        if (!empty($config['product'][$k]['comment'])) {
            $commentNotify = $d->rawQuery("select id from #_comment where type = ? and find_in_set('new-admin',status)", array($k));
            $commentProductNotify[$k] = array();
            $commentProductNotify[$k]['title'] = $v['title_main'];
            $commentProductNotify[$k]['notify'] = count($commentNotify);
            $countNotify += $commentProductNotify[$k]['notify'];
        }
    }
}

/* Comment: News */
if (isset($config['news'])) {
    $commentNewsNotify = array();
    foreach ($config['news'] as $k => $v) {
        if (!empty($config['news'][$k]['comment'])) {
            $commentNotify = $d->rawQuery("select id from #_comment where type = ? and find_in_set('new-admin',status)", array($k));
            $commentNewsNotify[$k] = array();
            $commentNewsNotify[$k]['title'] = $v['title_main'];
            $commentNewsNotify[$k]['notify'] = count($commentNotify);
            $countNotify += $commentNewsNotify[$k]['notify'];
        }
    }
}
?>
<!-- Header -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center navbar-navleft">
        <li class="nav-item">
            <div class="nav-toggler" data-widget="pushmenu"><i class="fas fa-bars"></i></div>
        </li>
        <li class="nav-item nav-item-hello d-sm-inline-block">
            <div class="navbar-block" id="greeting">
                <span class="text-split">Xin chào, <?= $_SESSION[$loginAdmin]['username'] ?>!</span>
            </div>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto navbar-navright">
        <!-- Version -->
        <!-- <li class="nav-item me-2 me-xl-0">
            <a class="nav-link text-danger text-decoration-none font-weight-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-php"
                    width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#dc3545"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-10 0a10 9 0 1 0 20 0a10 9 0 1 0 -20 0" />
                    <path
                        d="M5.5 15l.395 -1.974l.605 -3.026h1.32a1 1 0 0 1 .986 1.164l-.167 1a1 1 0 0 1 -.986 .836h-1.653" />
                    <path
                        d="M15.5 15l.395 -1.974l.605 -3.026h1.32a1 1 0 0 1 .986 1.164l-.167 1a1 1 0 0 1 -.986 .836h-1.653" />
                    <path d="M12 7.5l-1 5.5" />
                    <path d="M11.6 10h2.4l-.5 3" />
                </svg>
                VERSION <?php //echo phpversion() 
                        ?>
            </a>
        </li> -->
        <li class="nav-item" id="display-clock">
            <div id="digital-clock">
                <div id="hour" class="number"></div>
                <div id="dot" class="number">:</div>
                <div id="minutes" class="number"></div>
            </div>
        </li>
        <!-- Website -->
        <li class="nav-item d-sm-inline-block">
            <a href="../" target="_blank" class="nav-link view-website" title="Xem website"><i class="fas fa-reply mr-1"></i> <span class="tooltip-view">Xem website</span></a>
        </li>
        <!-- Setting -->
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu-info" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-cogs"></i></a>
            <ul aria-labelledby="dropdownSubMenu-info" class="dropdown-menu dropdown-menu-right border-0 shadow">
                <?php if ($config['website']['debug-developer'] && count($config['website']['lang']) >= 2) { ?>
                    <li>
                        <a href="index.php?com=lang&act=man" class="dropdown-item">
                            <i class="fas fa-language"></i>
                            <span>Quản lý ngôn ngữ</span>
                        </a>
                    </li>
                    <div class="dropdown-divider"></div>
                <?php } ?>
                <li>
                    <a href="index.php?com=user&act=info_admin" class="dropdown-item">
                        <i class="fas fa-user-cog"></i>
                        <span>Thông tin admin</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="index.php?com=user&act=info_admin&changepass=1" class="dropdown-item">
                        <i class="fas fa-key"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="index.php?com=cache&act=delete" class="dropdown-item">
                        <i class="far fa-trash-alt"></i>
                        <span>Xóa bộ nhớ tạm</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Notification -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="badge badge-danger"><?= $countNotify ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow">
                <span class="dropdown-item dropdown-header p-0">Thông báo</span>
                <div class="dropdown-divider"></div>
                <a href="index.php?com=contact&act=man" class="dropdown-item"><i class="fas fa-envelope mr-2"></i><span class="badge badge-danger mr-1"><?= count($contactNotify) ?></span> Liên hệ</a>
                <?php if (isset($config['order']['active']) && $config['order']['active'] == true) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="index.php?com=order&act=man" class="dropdown-item"><i class="fas fa-shopping-bag mr-2"></i><span class="badge badge-danger mr-1"><?= count($orderNotify) ?></span> Đơn hàng</a>
                <?php } ?>
                <?php if (!empty($commentProductNotify)) {
                    foreach ($commentProductNotify as $k => $v) { ?>
                        <div class="dropdown-divider"></div>
                        <a href="index.php?com=product&act=man&type=<?= $k ?>&comment_status=new" class="dropdown-item"><i class="fas fa-comments mr-2"></i><span class="badge badge-danger mr-1"><?= $v['notify'] ?></span> Bình luận - <?= $v['title'] ?></a>
                <?php }
                } ?>
                <?php if (!empty($commentNewsNotify)) {
                    foreach ($commentNewsNotify as $k => $v) { ?>
                        <div class="dropdown-divider"></div>
                        <a href="index.php?com=news&act=man&type=<?= $k ?>&comment_status=new" class="dropdown-item"><i class="fas fa-comments mr-2"></i><span class="badge badge-danger mr-1"><?= $v['notify'] ?></span> Bình luận - <?= $v['title'] ?></a>
                <?php }
                } ?>
                <?php if (!empty($newsletterNotify)) {
                    foreach ($newsletterNotify as $k => $v) { ?>
                        <div class="dropdown-divider"></div>
                        <a href="index.php?com=newsletter&act=man&type=<?= $k ?>" class="dropdown-item"><i class="fas fa-mail-bulk mr-2"></i><span class="badge badge-danger mr-1"><?= $v['notify'] ?></span> <?= $v['title'] ?></a>
                <?php }
                } ?>
            </div>
        </li>
        <!-- Logout -->
        <li class="nav-item d-sm-inline-block">
            <a href="index.php?com=user&act=logout" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Đăng xuất</a>
        </li>
    </ul>
</nav>