<?php 
    $linkMan = "index.php?com=birthday&act=man_birthday";
?>

<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý mã ưu đãi</li>
            </ol>
        </div>
    </div>
</section>
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?=(isset($_GET['keyword'])) ? $_GET['keyword'] : ''?>" onkeypress="doEnter(event,'keyword','<?=$linkMan?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?=$linkMan?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách tài khoản khách</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <th class="align-middle text-center" width="10%">STT</th>
                        <th class="align-middle">Tài khoản</th>
                        <th class="align-middle">Họ tên</th>
                        <th class="align-middle">Email</th>
                        <th class="align-middle">Sinh nhật</th>
                    </tr>
                </thead>
                <?php if(empty($items)) { ?>
                    <tbody><tr><td colspan="100" class="text-center">Không có dữ liệu</td></tr></tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for($i=0;$i<count($items);$i++) { 
                            $day_expire = 5;
                            $time = time();
                            $for_date = date("d-m-Y",$time);
                            $day_1 = date("d-m", strtotime($for_date) + ($day_expire * 86400));
                            if($day_1 == date("d-m",$items[$i]['birthday'])) {  
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?=$items[$i]['id']?>" value="<?=$items[$i]['id']?>">
                                        <label for="select-checkbox-<?=$items[$i]['id']?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-numb" min="0" value="<?=$items[$i]['numb']?>" data-id="<?=$items[$i]['id']?>" data-table="member">
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" title="<?=$items[$i]['username']?>"><?=$items[$i]['username']?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" title="<?=$items[$i]['fullname']?>"><?=$items[$i]['fullname']?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" title="<?=$items[$i]['email']?>"><?=$items[$i]['email']?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-dark text-break" title="<?=$items[$i]['birthday']?>"><?=date("d-m-Y",$items[$i]['birthday'])?></a>
                                </td>
                            </tr>
                        <?php }} ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if($paging) { ?>
        <div class="card-footer text-sm pb-0">
            <?=$paging?>
        </div>
    <?php } ?>
    <div class="card card-primary card-outline text-sm mb-0 <?=(!$paging)?'mt-3':'';?>">
        <form name="frmsendemail" method="post" action="<?=$linkMan?>" enctype="multipart/form-data">
            <div class="card-header">
                <h3 class="card-title">Gửi email đến danh sách được chọn</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="subject">Tiêu đề:</label>
                    <input type="text" class="form-control text-sm" name="subject" id="subject" placeholder="Tiêu đề">
                </div>
                <div class="form-group">
                    <label for="content">Nội dung thông tin:</label>
                    <textarea class="form-control form-control-ckeditor" name="content" id="content" rows="5" placeholder="Nội dung thông tin"></textarea>
                </div>
                <input type="hidden" name="listemail" id="listemail">
            </div>
        </form>
    </div>
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-success text-white" id="send-email" title="Gửi email"><i class="fas fa-paper-plane mr-2"></i>Gửi email</a>
    </div>
</section>