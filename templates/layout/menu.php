<div class="menu">
    <div class="wrap-content">
        <ul class="menu-main">
            <li class="li-home"><a class="<?php if ($com == '' || $com == 'index') echo 'active'; ?> transition" href="" title="<?= trangchu ?>"><?= trangchu ?></a></li>
            <li class="menu-line"></li>
            <li><a class="<?php if ($com == 'gioi-thieu') echo 'active'; ?> transition" href="gioi-thieu" title="<?= gioithieu ?>"><?= gioithieu ?></a></li>
            <li class="menu-line"></li>
            <li>
                <a class="<?php if ($com == 'san-pham') echo 'active'; ?> transition" href="san-pham" title="<?= sanpham ?>"><?= sanpham ?></a>
                <?=$func->formenu('product','san-pham');?>
            </li>
            <li class="menu-line"></li>
            <li>
                <a class="<?php if ($com == 'tin-tuc') echo 'active'; ?> transition" href="tin-tuc" title="<?= tintuc ?>"><?= tintuc ?></a>
                <?=$func->formenu('news','tin-tuc');?>
            </li>
            <li class="menu-line"></li>   
            <li><a class="<?php if ($com == 'thu-vien-anh') echo 'active'; ?> transition" href="thu-vien-anh" title="<?= thuvienanh ?>"><?= thuvienanh ?></a></li>
            <li class="menu-line"></li>
            <li><a class="<?php if ($com == 'video') echo 'active'; ?> transition" href="video" title="Video">Video</a></li>
            <li class="menu-line"></li>
            <li><a class="<?php if ($com == 'lien-he') echo 'active'; ?> transition" href="lien-he" title="<?= lienhe ?>"><?= lienhe ?></a></li>
            <li class="ml-auto">
                <div class="search w-clear">
                    <input type="text" id="keyword" placeholder="Tìm kiếm sản phẩm" onkeypress="doEnter(event,'keyword');" />
                    <p onclick="onSearch('keyword');"><i class="fas fa-search"></i></p>
                    <div style="display: none;" class="keyword-autocomplete"></div>
                </div>
            </li>
            <?php /*<li>
                <div class="li-tim">
                    <a class="transition icon-search" title="<?=timkiem?>"><i class="fas fa-lg fa-search"></i></a>
                </div>
                <div class="search-input w-clear">
                    <input type="text" id="keyword" placeholder="<?= nhaptukhoatimkiem ?>" onkeypress="doEnter(event,'keyword');" />
                    <p onclick="onSearch('keyword');"><i class="fas fa-search"></i></p>
                    <div style="display: none;" class="keyword-autocomplete"></div>
                </div>
            </li> */?>
        </ul>
        <!-- <div class="menu-search"></div> -->
    </div>
</div>