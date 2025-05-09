	<?php /**/ ?>
    <link href="assets/css/seo.css?v=<?=time()?>" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<div class="panel panel-default" id="seoBox" data-type="detail">
    <div class="panel-heading">
        <h6 class="panel-title">Tối ưu SEO
        <span class="display-block">Thiết lập các thẻ mô tả giúp khách hàng dễ dàng tìm thấy sản phẩm trên công cụ
        tìm kiếm như Google.
        </span>
        </h6>
        <div class="heading-elements">
            <div class="btn-group heading-btn">
                <button type="button" class="btn bg-slate-300 btn-xs btn-ladda btn-ladda-spinne" id="generate_seo">Tạo SEO</button>
            </div>
            <ul class="icons-list">
                <li><i class="fa fa-caret-down"></i></li>
            </ul>
        </div>
    </div>	
	
    <div class="panel-body">
		<?php /*
		<div class="form-group">
			<label>Từ khóa trang  (*)</label>
			<input data-seo="seo_keyword" required="required" class="form-control" name="data[keywords_vi]" type="text" value="<?=@$item['keywords_vi']?>">
			<span class="help-block"></span>
		</div>
					
		<div class="form-group">
			<label for="tiêu đề trang (<title>)">Tiêu đề Trang (&lt;title&gt;)</label>
			<label class="pull-right"><span id="count_meta_title"></span>/70 ký tự</label>
			<input class="form-control" data-seo="seo_title" name="data[title_vi]" type="text" value="<?=@$item['title_vi']?>">
			<span class="help-block"></span>
		</div>
				
		<div class="form-group">
			<label for="mô tả trang ( <meta description> )">Mô Tả Trang ( &lt;meta Description&gt; )</label>
			<label class="pull-right"><span id="count_meta_description"></span>/160 ký tự</label>
			<textarea class="form-control" rows="5" data-seo="seo_description" name="data[description_vi]" cols="50"><?=@$item['description_vi']?></textarea>
			<span class="help-block"></span>
		</div>
		*/ ?>

		<div class="form-group-slug">
			<div class="form-group row">
				<div class="col-lg-12">
				<label class="text-capitalize">Đường dẫn (*)</label>
				</div>
				<div class="col-lg-12">
			   <div class="input-group1">
					<input type="text" disabled class="form-control full_input" bs-type="slug" bs-slug-from="title" data-seo="url" name="tenkhongdau_vi" value="https://<?=$configBase?><?=@$item['slugvi']?>">					
				</div>
				   <span class="help-block"></span>
				</div>
			</div>
		</div>

		<fieldset class="content-group">
			<legend class="text-bold">Khi lên top, page này sẽ hiển thị như sau:</legend>
			<div class="form-group">
				<h3 class="seo_title_google"></h3>
				<div class ="slugins">
					<span class="prefix_url"></span><span class="slug_google"></span><span class="slug_google_extension"></span>
				</div>
				<div class="seo_description_google"></div>
			</div>
		</fieldset>
		
		<div class="form-group switch">
			<input bs-type="switch" class="switch-input" data-on-text="Bật" data-off-text="Tắt" checked="checked" name="robots" type="checkbox" value="1">Index, Follow
			<button type="button" class="btn btn-success pull-right" id="btnCheckSeo">Kiểm tra SEO</button>
		</div>
		
		<div class="form-group" id="finalResult"></div>
		
    
	</div>
</div><!--end seoBox-->
<span class=""></span>





