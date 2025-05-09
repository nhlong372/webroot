<?php 
	function updateCounponStatus($id,$status)
	{
		global $d;

		$data['tinhtrang'] = $status;
		$d->where('id',$id);
		$d->update('coupon',$data);
	}

	$linkMan = "index.php?com=coupon&act=man&p=".$curPage;
    $linkAdd = "index.php?com=coupon&act=add&p=".$curPage;
    $linkEdit = "index.php?com=coupon&act=edit&p=".$curPage;
    $linkDelete = "index.php?com=coupon&act=delete&p=".$curPage;
    // $linkMem = "index.php?com=coupon&act=man1&p=".$curPage;
?>
<!-- Content Header -->
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

<!-- Main content -->
<section class="content">
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?=$linkAdd?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?=$linkDelete?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?=$_GET['keyword']?>" onkeypress="doEnter(event,'keyword','<?=$linkMan?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?=$linkMan?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- <a class="btn btn-sm bg-gradient-success text-white" href="<?=$linkMem?>">Tặng mã ưu đãi</a> -->
    </div>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title">Danh sách mã ưu đãi</h3>
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
                        <th class="align-middle">Mã ưu đãi</th>
                        <th class="align-middle">Chiết khấu</th>
                        <th class="align-middle">Ngày bắt đầu</th>
                        <th class="align-middle">Ngày kết thúc</th>
                        <th class="align-middle">Tình trạng</th>
                        <th class="align-middle text-center">Thao tác</th>
                    </tr>
                </thead>
                <?php if(empty($items)) { ?>
                    <tbody><tr><td colspan="100" class="text-center">Không có dữ liệu</td></tr></tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for($i=0;$i<count($items);$i++) { ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?=$items[$i]['id']?>" value="<?=$items[$i]['id']?>">
                                        <label for="select-checkbox-<?=$items[$i]['id']?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="<?=$items[$i]['stt']?>" data-id="<?=$items[$i]['id']?>" data-table="coupon">
                                </td>
                                <td class="align-middle">
                                    <a class="text-primary" href="<?=$linkEdit?>&id=<?=$items[$i]['id']?>" title="<?=$items[$i]['ma']?>"><?=$items[$i]['ma']?></a>
                                </td>
                                <td class="align-middle">
                                	<?php
                                		if($items[$i]['ngayketthuc']<time())
                                		{
                                			updateCounponStatus($items[$i]['id'],3);
                                		}

						    			if($items[$i]['loai']==1)
						    			{
						    				echo $items[$i]['chietkhau'].'%';	
						    			}
						    			else if($items[$i]['loai']==2)
						    			{
						    				echo number_format($items[$i]['chietkhau'],0,'',',').' VNĐ';
						    			}
						    		?>
                                </td>
                                <td class="align-middle"><?=date('d-m-Y',$items[$i]['ngaybatdau'])?></td>
                                <td class="align-middle"><?=date('d-m-Y',$items[$i]['ngayketthuc'])?></td>
                                <td class="align-middle">
                                	<?php
										if($items[$i]['tinhtrang']==0) echo 'Chưa sử dụng';
										elseif($items[$i]['tinhtrang']==1) echo 'Đã sử dụng';
										elseif($items[$i]['tinhtrang']==2) echo 'Hết hạn';
										elseif($items[$i]['tinhtrang']==3) echo 'Đã gửi';
									?>
                                </td>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?=$linkEdit?>&id=<?=$items[$i]['id']?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?=$linkDelete?>&id=<?=$items[$i]['id']?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
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
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-primary text-white" href="<?=$linkAdd?>" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?=$linkDelete?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>
</section>