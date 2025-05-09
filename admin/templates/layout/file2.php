<div class="photoUpload-zone">
	<div class="photoUpload-detail" id="photoUpload-preview">
        <div class="name-file mb-2">
        	<?php if (!empty(@$item['file_attach'])) { ?>
        		<img src="assets/images/attached-file.png">
        		<span><?=@$item['file_attach']?></span>
        	<?php } else {?>
        		<span>Chưa chọn file</span>
        	<?php } ?>
        </div>
        <?php if(!empty(@$item['file_attach'])) {?>
        	<a class="btn btn-sm bg-gradient-primary text-white d-inline-block p-1 rounded" href="<?=@$tailieuDetail?>" title="Download tập tin" target="_blank" download><i class="fas fa-download mr-2"></i>Download tập tin</a>
        <?php } ?>
	</div>
	<div class="input-group mb-3" id="file-zone">
		<div class="custom-file">
			<input type="file" name="file_attach" id="file-zone-tailieu">
			<label class="custom-file-label" for="file-zone-tailieu">Chọn file</label>
		</div>
	</div>
	<div class="photoUpload-dimension"><?=@$dimensiontailieu?></div>
</div>