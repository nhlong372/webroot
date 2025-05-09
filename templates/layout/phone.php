<?php /*<div class="toolbar">
    <ul>
        <li>
            <a id="goidien" href="tel:<?= $func->parsePhone($optsetting['hotline']) ?>" title="title">
                <?= $func->getImage(['size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'icon-t1.png', 'alt' => 'Phone']) ?><br>
                <span>Gọi điện</span>
            </a>
        </li>
        <li>
            <a id="nhantin" href="sms:<?= $func->parsePhone($optsetting['hotline']) ?>" title="title">
                <?= $func->getImage(['size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'icon-t2.png', 'alt' => 'Message']) ?><br>
                <span>Nhắn tin</span>
            </a>
        </li>
        <li>
            <a id="chatzalo" href="https://zalo.me/<?= $func->parsePhone($optsetting['zalo']) ?>" title="title">
                <?= $func->getImage(['size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'icon-t3.png', 'alt' => 'Zalo']) ?><br>
                <span>Chat zalo</span>
            </a>
        </li>
        <li>
            <a id="chatfb" href="<?= $optsetting['fanpage'] ?>" title="title">
                <?= $func->getImage(['size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'icon-t4.png', 'alt' => 'Facebook']) ?><br>
                <span>Chat facebook</span>
            </a>
        </li>
    </ul>
</div> */?>

<div class="toolbar-app">
    <div class="list-phone">
        <a href="tel:<?= $func->parsePhone($optsetting['hotline']) ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="256" height="256">
                <path d="M23.45 20.93a3 3 0 0 0-4.25 0l-1.45 1.45a26.14 26.14 0 0 1-4.51-3.62 26.62 26.62 0 0 1-3.62-4.51l1.45-1.45a3 3 0 0 0 0-4.25L8.24 5.73a2.93 2.93 0 0 0-2.11-.88h0A3 3 0 0 0 4 5.73L2.64 7.08A6.37 6.37 0 0 0 1 12.33c.32 3.75 2.78 8.26 6.57 12.06S15.92 30.64 19.67 31a7.87 7.87 0 0 0 .84 0 6.07 6.07 0 0 0 4.41-1.64L26.27 28a3 3 0 0 0 .88-2.13 2.93 2.93 0 0 0-.88-2.11zm1.41 5.66L23.5 27.94a4.57 4.57 0 0 1-3.66 1c-3.25-.28-7.39-2.58-10.81-6S3.31 15.41 3 12.16a4.53 4.53 0 0 1 1-3.66L5.41 7.14a1 1 0 0 1 .71-.29h0a1 1 0 0 1 .71.29L9.66 10a1 1 0 0 1 0 1.41l-2 2a1 1 0 0 0-.16 1.21 27.49 27.49 0 0 0 4.33 5.58 27.49 27.49 0 0 0 5.58 4.33 1 1 0 0 0 1.21-.16l2-2a1 1 0 0 1 1.41 0l2.83 2.83h0a1 1 0 0 1 .29.71A1 1 0 0 1 24.86 26.59zM26.6 5.39A14.92 14.92 0 0 0 16 1a1 1 0 1 0 0 2A13 13 0 0 1 29 16.11a1 1 0 0 0 1 1h0a1 1 0 0 0 1-1A14.91 14.91 0 0 0 26.6 5.39z" class="color000 svgShape"></path>
                <path d="M20.91,11.11a6,6,0,0,1,1.77,4.31,1,1,0,0,0,1,1h0a1,1,0,0,0,1-1,8,8,0,0,0-8-8.1,1,1,0,1,0,0,2A6,6,0,0,1,20.91,11.11Z" class="color000 svgShape"></path>
            </svg>
            <span><?=$optsetting['hotline']?></span>
        </a>
        <a href="tel:<?= $func->parsePhone($optsetting['phone']) ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="256" height="256">
                <path d="M23.45 20.93a3 3 0 0 0-4.25 0l-1.45 1.45a26.14 26.14 0 0 1-4.51-3.62 26.62 26.62 0 0 1-3.62-4.51l1.45-1.45a3 3 0 0 0 0-4.25L8.24 5.73a2.93 2.93 0 0 0-2.11-.88h0A3 3 0 0 0 4 5.73L2.64 7.08A6.37 6.37 0 0 0 1 12.33c.32 3.75 2.78 8.26 6.57 12.06S15.92 30.64 19.67 31a7.87 7.87 0 0 0 .84 0 6.07 6.07 0 0 0 4.41-1.64L26.27 28a3 3 0 0 0 .88-2.13 2.93 2.93 0 0 0-.88-2.11zm1.41 5.66L23.5 27.94a4.57 4.57 0 0 1-3.66 1c-3.25-.28-7.39-2.58-10.81-6S3.31 15.41 3 12.16a4.53 4.53 0 0 1 1-3.66L5.41 7.14a1 1 0 0 1 .71-.29h0a1 1 0 0 1 .71.29L9.66 10a1 1 0 0 1 0 1.41l-2 2a1 1 0 0 0-.16 1.21 27.49 27.49 0 0 0 4.33 5.58 27.49 27.49 0 0 0 5.58 4.33 1 1 0 0 0 1.21-.16l2-2a1 1 0 0 1 1.41 0l2.83 2.83h0a1 1 0 0 1 .29.71A1 1 0 0 1 24.86 26.59zM26.6 5.39A14.92 14.92 0 0 0 16 1a1 1 0 1 0 0 2A13 13 0 0 1 29 16.11a1 1 0 0 0 1 1h0a1 1 0 0 0 1-1A14.91 14.91 0 0 0 26.6 5.39z" class="color000 svgShape"></path>
                <path d="M20.91,11.11a6,6,0,0,1,1.77,4.31,1,1,0,0,0,1,1h0a1,1,0,0,0,1-1,8,8,0,0,0-8-8.1,1,1,0,1,0,0,2A6,6,0,0,1,20.91,11.11Z" class="color000 svgShape"></path>
            </svg>
            <span><?=$optsetting['phone']?></span>
        </a>
    </div>
    <div class="phone">
        <a id="goidien">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="256" height="256">
                <path d="M23.45 20.93a3 3 0 0 0-4.25 0l-1.45 1.45a26.14 26.14 0 0 1-4.51-3.62 26.62 26.62 0 0 1-3.62-4.51l1.45-1.45a3 3 0 0 0 0-4.25L8.24 5.73a2.93 2.93 0 0 0-2.11-.88h0A3 3 0 0 0 4 5.73L2.64 7.08A6.37 6.37 0 0 0 1 12.33c.32 3.75 2.78 8.26 6.57 12.06S15.92 30.64 19.67 31a7.87 7.87 0 0 0 .84 0 6.07 6.07 0 0 0 4.41-1.64L26.27 28a3 3 0 0 0 .88-2.13 2.93 2.93 0 0 0-.88-2.11zm1.41 5.66L23.5 27.94a4.57 4.57 0 0 1-3.66 1c-3.25-.28-7.39-2.58-10.81-6S3.31 15.41 3 12.16a4.53 4.53 0 0 1 1-3.66L5.41 7.14a1 1 0 0 1 .71-.29h0a1 1 0 0 1 .71.29L9.66 10a1 1 0 0 1 0 1.41l-2 2a1 1 0 0 0-.16 1.21 27.49 27.49 0 0 0 4.33 5.58 27.49 27.49 0 0 0 5.58 4.33 1 1 0 0 0 1.21-.16l2-2a1 1 0 0 1 1.41 0l2.83 2.83h0a1 1 0 0 1 .29.71A1 1 0 0 1 24.86 26.59zM26.6 5.39A14.92 14.92 0 0 0 16 1a1 1 0 1 0 0 2A13 13 0 0 1 29 16.11a1 1 0 0 0 1 1h0a1 1 0 0 0 1-1A14.91 14.91 0 0 0 26.6 5.39z" class="color000 svgShape"></path>
                <path d="M20.91,11.11a6,6,0,0,1,1.77,4.31,1,1,0,0,0,1,1h0a1,1,0,0,0,1-1,8,8,0,0,0-8-8.1,1,1,0,1,0,0,2A6,6,0,0,1,20.91,11.11Z" class="color000 svgShape"></path>
            </svg>
        </a>
    </div>
    <ul>
        <li>
            <a id="chatzalo" target="_blank" href="https://zalo.me/<?= $func->parsePhone($optsetting['zalo']) ?>" title="title">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 50 50">
                    <path d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4 z M 9 6 L 15.576172 6 C 12.118043 9.5981082 10 14.323627 10 19.5 C 10 24.861353 12.268148 29.748596 15.949219 33.388672 C 15.815412 33.261195 15.988635 33.48288 16.005859 33.875 C 16.023639 34.279773 15.962689 34.835916 15.798828 35.386719 C 15.471108 36.488324 14.785653 37.503741 13.683594 37.871094 A 1.0001 1.0001 0 0 0 13.804688 39.800781 C 16.564391 40.352722 18.51646 39.521812 19.955078 38.861328 C 21.393696 38.200845 22.171033 37.756375 23.625 38.34375 A 1.0001 1.0001 0 0 0 23.636719 38.347656 C 26.359037 39.41176 29.356235 40 32.5 40 C 36.69732 40 40.631169 38.95117 44 37.123047 L 44 41 C 44 42.668484 42.668484 44 41 44 L 9 44 C 7.3315161 44 6 42.668484 6 41 L 6 9 C 6 7.3315161 7.3315161 6 9 6 z M 18.496094 6 L 41 6 C 42.668484 6 44 7.3315161 44 9 L 44 34.804688 C 40.72689 36.812719 36.774644 38 32.5 38 C 29.610147 38 26.863646 37.459407 24.375 36.488281 C 22.261967 35.634656 20.540725 36.391201 19.121094 37.042969 C 18.352251 37.395952 17.593707 37.689389 16.736328 37.851562 C 17.160501 37.246758 17.523335 36.600775 17.714844 35.957031 C 17.941109 35.196459 18.033096 34.45168 18.003906 33.787109 C 17.974816 33.12484 17.916946 32.518297 17.357422 31.96875 L 17.355469 31.966797 C 14.016928 28.665356 12 24.298743 12 19.5 C 12 14.177406 14.48618 9.3876296 18.496094 6 z M 32.984375 14.986328 A 1.0001 1.0001 0 0 0 32 16 L 32 25 A 1.0001 1.0001 0 1 0 34 25 L 34 16 A 1.0001 1.0001 0 0 0 32.984375 14.986328 z M 18 16 A 1.0001 1.0001 0 1 0 18 18 L 21.197266 18 L 17.152344 24.470703 A 1.0001 1.0001 0 0 0 18 26 L 23 26 A 1.0001 1.0001 0 1 0 23 24 L 19.802734 24 L 23.847656 17.529297 A 1.0001 1.0001 0 0 0 23 16 L 18 16 z M 29.984375 18.986328 A 1.0001 1.0001 0 0 0 29.162109 19.443359 C 28.664523 19.170123 28.103459 19 27.5 19 C 25.578848 19 24 20.578848 24 22.5 C 24 24.421152 25.578848 26 27.5 26 C 28.10285 26 28.662926 25.829365 29.160156 25.556641 A 1.0001 1.0001 0 0 0 31 25 L 31 22.5 L 31 20 A 1.0001 1.0001 0 0 0 29.984375 18.986328 z M 38.5 19 C 36.578848 19 35 20.578848 35 22.5 C 35 24.421152 36.578848 26 38.5 26 C 40.421152 26 42 24.421152 42 22.5 C 42 20.578848 40.421152 19 38.5 19 z M 27.5 21 C 28.340272 21 29 21.659728 29 22.5 C 29 23.340272 28.340272 24 27.5 24 C 26.659728 24 26 23.340272 26 22.5 C 26 21.659728 26.659728 21 27.5 21 z M 38.5 21 C 39.340272 21 40 21.659728 40 22.5 C 40 23.340272 39.340272 24 38.5 24 C 37.659728 24 37 23.340272 37 22.5 C 37 21.659728 37.659728 21 38.5 21 z"></path>
                </svg>
            </a>
        </li>
        <li>
            <a id="baodon" href="<?=$optsetting['map']?>" title="title">
                <svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" clip-rule="evenodd" viewBox="0 0 32 32" width="256" height="256">
                    <rect width="32" height="32" y=".003" fill="none"></rect>
                    <path d="M16,2.003c-6.071,-0 -11,4.929 -11,11c0,5.925 5.16,11.892 8.23,14.858c1.548,1.488 3.992,1.487 5.538,0.001c3.072,-2.967 8.232,-8.934 8.232,-14.859c-0,-6.071 -4.929,-11 -11,-11Zm0,2c4.967,-0 9,4.032 9,9c-0,5.383 -4.831,10.725 -7.62,13.419c-0.77,0.74 -1.99,0.741 -2.763,-0.002c-2.786,-2.692 -7.617,-8.034 -7.617,-13.417c0,-4.968 4.033,-9 9,-9Zm0,5c-2.208,-0 -4,1.792 -4,4c0,2.207 1.792,4 4,4c2.208,-0 4,-1.793 4,-4c0,-2.208 -1.792,-4 -4,-4Zm0,2c1.104,-0 2,0.896 2,2c0,1.104 -0.896,2 -2,2c-1.104,-0 -2,-0.896 -2,-2c0,-1.104 0.896,-2 2,-2Z" class="color000 svgShape"></path>
                </svg>
            </a>
        </li>
        <li>
            <a id="chatfb" href="<?=$optsetting['messenger']?>" title="title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="256" height="256">
                    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.268,2.112A13,13,0,0,0,6,23.3v3.661A1.258,1.258,0,0,0,7.82,28.09l2.663-1.332a12.9,12.9,0,0,0,7.25,1.126A13,13,0,1,0,14.268,2.112Z" class="colorStroke212121 svgStroke"></path>
                    <path d="M9.049,18.163,13.64,11.63a.64.64,0,0,1,.94-.2l3.075,2.307a.641.641,0,0,0,.714.036l3.745-2.646a.64.64,0,0,1,.9.835l-3.707,6.414a.64.64,0,0,1-.9.263L14.3,16.181a.638.638,0,0,0-.615-.024l-3.794,2.9A.641.641,0,0,1,9.049,18.163Z" class="color000 svgShape"></path>
                </svg>
            </a>
        </li>
        <li class="scrollToTopMobile ex6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="256" height="256">
                <g data-name="Arrow" class="color222 svgShape">
                    <path d="M41 59H23A18 18 0 0 1 5 41V23A18 18 0 0 1 23 5h18a17.92 17.92 0 0 1 12.48 5 2 2 0 1 1-2.77 2.88A13.94 13.94 0 0 0 41 9H23A14 14 0 0 0 9 23v18a14 14 0 0 0 14 14h18a14 14 0 0 0 14-14V23a14.28 14.28 0 0 0-.29-2.85 2 2 0 1 1 3.92-.8A17.8 17.8 0 0 1 59 23v18a18 18 0 0 1-18 18Z" class="color000 svgShape"></path>
                    <path d="M32 45.74a2 2 0 0 1-2-2V20.26a2 2 0 0 1 4 0v23.48a2 2 0 0 1-2 2zm11.21-14.07a2 2 0 0 1-1.28-.47L36 26.26a2 2 0 1 1 2.57-3.07l5.89 4.95a2 2 0 0 1-1.29 3.53z" class="color000 svgShape"></path>
                    <path d="M20.79 31.67a2 2 0 0 1-1.29-3.53l11.21-9.41a2 2 0 1 1 2.58 3.06L22.07 31.2a2 2 0 0 1-1.28.47Z" class="color000 svgShape"></path>
                </g>
            </svg>
        </li>
    </ul>
</div>
<!-- <div class="check-toolbar">
    <input class="yep" id="check-toolbar" type="checkbox" checked="">
    <label for="check-toolbar"></label>
</div> -->

<?php /*
<div class="fixbar">
    <ul class="w-clear">
        <li>
            <a href="">
                <span class="icon-home-new"><i class="fa fa-home" aria-hidden="true"></i></span><span class="text-link-toolbar">Trang chủ</span>
            </a>
        </li>
        <li>
            <a href="tel:<?= $func->parsePhone($optsetting['hotline']) ?> ">
                <span class="icon-cart-new"><i class="fa fa-phone-square" aria-hidden="true"></i></span><span class="text-link-toolbar"><?= $func->parsePhone($optsetting['hotline']) ?></span>
            </a>
        </li>
        <li>
            <a href="lien-he">
                <span class="icon-hotdeal-new"><i class="fa fa-map-marker" aria-hidden="true"></i></span><span class="text-link-toolbar">Liên hệ</span>
            </a>
        </li>
        <li>
            <a href="gio-hang">
                <span class="icon-cart-mobile">
                    <span id="cart-total" class="cart-total-header cart-total-header-mobile">
                        <span class="count-cart"><?= (!empty($_SESSION['cart'])) ? count($_SESSION['cart']) : 0 ?></span>
                    </span>
                </span>
                <span class="text-link-toolbar">Giỏ hàng</span>
            </a>
        </li>
    </ul>
</div>
*/ ?>

<?php /*
<div class="plugbar">
    <ul>
        <li>
            <a href="">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li>
            <a href="lien-he">
                <i class="fas fa-map-marker-alt"></i>
            </a>
        </li>
        <li>
            <a href="//m.me/<?= $optsetting['fanpage'] ?>" target="_blank">
                <span>
                    <?= $func->getImage(['class' => 'lazy w-100', 'size-error' => '50x50x2', 'upload' => 'assets/images/', 'image' => 'MessengerIcon.png', 'alt' => 'Messenger']) ?><br>
                </span>
            </a>
        </li>
        <li>
            <a href="tel:<?= $func->parsePhone($optsetting['hotline']) ?>">
                <i class="fas fa-phone-alt"></i>
            </a>
        </li>
        <li>
            <a class="back-to-top" href="javascript:;">
                <i class="fas fa-arrow-alt-circle-up"></i>
            </a>
        </li>
    </ul>
</div>
*/ ?>

<?php /*
<div class="support-online">
    <div class="support-content" style="display: block;">
        <a target="_blank" href="tel:<?= $func->parsePhone($optsetting['hotline']) ?>" class="not-loading call-now" rel="nofollow">
            <i class="fab fa-whatsapp"></i>
            <div class="animated infinite zoomIn kenit-alo-circle"></div>
            <div class="animated infinite pulse kenit-alo-circle-fill"></div>
            <span>Hotline: <?= $func->parsePhone($optsetting['hotline']) ?></span>
        </a>
        <a class="mes not-loading" target="_blank" href="lien-he">
            <i class="fa fa-map-marker"></i>
            <span>Chỉ đường</span>
        </a>
        <a class="mes not-loading" target="_blank" href="//zalo.me/<?= $func->parsePhone($optsetting['zalo']) ?>">
            <?= $func->getImage(['class' => 'lazy w-100', 'size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'zalo-combo.png', 'alt' => 'Zalo']) ?><br>
            <span>Zalo</span>
        </a>
        <a class="sms not-loading" target="_blank" href="sms:<?= $func->parsePhone($optsetting['hotline']) ?>">
            <i class="fab fa-weixin"></i>
            <span>SMS: <?= $func->parsePhone($optsetting['hotline']) ?></span>
        </a>
    </div>
    <a class="btn-support not-loading">
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
        <i class="fa fa-user-circle"></i>
    </a>
</div>
*/ ?>

<?php /*
<div class="widget-mobile">
    <div id="my-phone-circle">
        <div class="wcircle-icon"><i class="fa fa-bell shake-anim"></i></div>
        <div class="wcircle-menu">
            <div class="wcircle-menu-item">
                <a href="tel:<?= $func->parsePhone($optsetting['hotline']) ?>"><i class="fa fa-phone"></i></a>
            </div>
            <div class="wcircle-menu-item">
                <a href="sms:<?= $func->parsePhone($optsetting['hotline']) ?>"><i class="fa fa-comments"></i></a>
            </div>
            <div class="wcircle-menu-item">
                <a href="lien-he" target="_blankl"><i class="fa fa-map"></i></a>
            </div>
            <div class="wcircle-menu-item">
                <a href="<?= $optsetting['fanpage'] ?>"><i class="fab fa-facebook-f"></i></a>
            </div>
            <div class="wcircle-menu-item">
                <a href="//zalo.me/<?= $func->parsePhone($optsetting['zalo']) ?>" target="_blank"><?= $func->getImage(['class' => 'lazy w-100', 'size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'zalo-mb.png', 'alt' => 'Zalo']) ?><br></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="assets/js/jQuery.WCircleMenu-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#my-phone-circle').WCircleMenu({
            angle_start: -Math.PI,
            delay: 50,
            distance: 70,
            angle_interval: Math.PI / 4,
            easingFuncShow: "easeOutBack",
            easingFuncHide: "easeInBack",
            step: 5,
            openCallback: false,
            closeCallback: false,
        });
        $('.support-content').hide();
        $('a.btn-support').click(function(e) {
            e.stopPropagation();
            $('.support-content').slideToggle();
        });
        $('.support-content').click(function(e) {
            e.stopPropagation();
        });
        $(document).click(function() {
            $('.support-content').slideUp();
        });
    })
</script>
*/ ?>