<?php
	include "config.php";
	$keyword = (isset($_POST['keyword']) && $_POST['keyword'] != '') ? htmlspecialchars($_POST['keyword']) : '';
	$keyword = $func->changeTitle($keyword);
	// $keyword = str_replace('-', '|', $keyword);
	$sql = "select photo, name$lang, slugvi, slugen, sale_price, regular_price, discount, id from table_product where type = 'san-pham' and find_in_set('hienthi',status) and ( slug$lang LIKE '%$keyword%' ) order by numb, id desc limit 10";
	$ketquatim = $d->rawQuery($sql);
?>
<?php if(!empty($ketquatim)) { ?>
	<?php foreach ($ketquatim as $key => $value) { ?>
	<div class="autocomplete_item">
		<a href="<?=$value[$sluglang]?>">
			<picture class="block scale-img">
				<img class="w-full block" src="<?=THUMBS?>/270x270x2/<?=UPLOAD_PRODUCT_L.$value['photo']?>" alt="<?=$value['name'.$lang]?>">
			</picture>
			<section>
				<h3><?=$value['name'.$lang]?></h3>
				<p class="price-product">
	                <?php if ($value['discount']) { ?>
	                    <span class="price-new"><?= $func->formatMoney($value['sale_price']) ?></span>
	                    <span class="price-old"><?= $func->formatMoney($value['regular_price']) ?></span>
	                    <span class="price-per"><?= '-' . $value['discount'] . '%' ?></span>
	                <?php } else { ?>
	                    <span class="price-new"><?= ($value['regular_price']) ? $func->formatMoney($value['regular_price']) : lienhe ?></span>
	                <?php } ?>
	            </p>
			</section>
		</a>
	</div>
	<?php } ?>
<?php } else { ?>
	<div class="p-2"><?=khongtimthayketqua?></div>
<?php } ?>