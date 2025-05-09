<div class="photoUpload-zone">
	<div class="photoUpload-detail" id="photoUpload-preview4">
		<img class="rounded" src="<?= $photoDetail4 ?>" onerror="src='assets/images/noimage.png'" alt="Alt Photo" style="<?= $config[$com][$type]['css_hinh'] ?>" />
		<?php if($item['photo4']!='' and (($com == 'static' and $act == 'update') or ($com == 'news' and $act == 'edit') or ($com == 'product' and $act == 'edit'))) { ?>
            <a href="javascript:void(0)" class="delete_1hinh" data-id="<?=$item['id']?>" data-table="<?=$com?>" data-cot="photo4" data-type="<?=$type?>" data-vitrixoa="photoUpload-preview4" title="Xóa ảnh này ?">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
            </a>
        <?php } ?>
	</div>
	<label class="photoUpload-file" id="photo-zone4" for="file-zone4">
		<input type="file" name="file4" id="file-zone4">
		<i class="fas fa-cloud-upload-alt"></i>
		<p class="photoUpload-drop">Kéo và thả hình vào đây</p>
		<p class="photoUpload-or">hoặc</p>
		<p class="photoUpload-choose btn btn-sm bg-gradient-success">Chọn hình</p>
	</label>
	<div class="photoUpload-dimension"><?= @$dimension4 ?></div>
</div>