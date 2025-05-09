<div class="card-seo">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab-lang" role="tablist">
                <?php foreach($config['website']['seo'] as $k => $v) { $seo_create .= $k.","; ?>
                    <li class="nav-item">
                        <a class="nav-link <?=($k=='vi')?'active':''?>" id="tabs-lang-schema" data-toggle="pill" href="#tabs-schemalang-<?=$k?>" role="tab" aria-controls="tabs-schemalang-<?=$k?>" aria-selected="true">Schema JSON (<?=$v?>)</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent-lang">
                <?php foreach($config['website']['seo'] as $k => $v) { ?>
                    <div class="tab-pane fade show <?=($k=='vi')?'active':''?>" id="tabs-schemalang-<?=$k?>" role="tabpanel" aria-labelledby="tabs-lang">
                        <div class="form-group">
						    <div class="label-seo">
						        <label for="schema<?=$k?>">Schema JSON(<?=$k?>):</label>
						    </div>
						    <textarea class="form-control schema-seo" name="dataSchema[schema<?=$k?>]" id="schema<?=$k?>" rows="15" placeholder="Nếu quý khách không biết cách sử dụng Data Structure vui lòng không nhập nội dung vào khung này để tránh phát sinh lỗi..."><?=@$seoDB['schema'.$k]?></textarea>
						</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>