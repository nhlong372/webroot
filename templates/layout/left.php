<div id="category">
	<div class="title-left"><span>Danh mục sản phẩm</span></div>
	<?php $product_list = $func->get_cap('hienthi', 'san-pham', 'product_list', 50); ?>
	<div class="bix-l bix-l-khac">
		<?php for ($i = 0; $i < count($product_list); $i++) {
			$sql_cat = ("select name$lang, slugvi, slugen,id from #_product_cat where type = ? and find_in_set('hienthi',status) and id_list=" . $product_list[$i]['id'] . " order by numb,id desc");
			$arr_cat = array('san-pham');
			$product_cat = $d->rawQuery($sql_cat, $arr_cat);
		?>
			<li class="cap1">
				<a href="<?= $product_list[$i][$sluglang] ?>" class="item_product_list "><span><?= $product_list[$i]['name' . $lang] ?></span></a>
				<?php if (count($product_cat) > 0) { ?>
					<ul class="ul_cap2">
						<?php for ($j = 0; $j < count($product_cat); $j++) {

							$sql_item = ("select name$lang, slugvi, slugen,id from #_product_item where type=? and find_in_set('hienthi',status) and id_cat=" . $product_cat[$j]['id'] . " order by numb,id desc");
							$arr_item = array('san-pham');
							$product_item = $d->rawQuery($sql_item, $arr_item);
						?>
							<li class="cap2">
								<a href="<?= $product_cat[$j][$sluglang] ?>" class=""><span><?= $product_cat[$j]['name' . $lang] ?></span></a>
								<?php if (count($product_item) > 0) { ?>
									<ul class="ul_cap3">
										<?php for ($m = 0; $m < count($product_item); $m++) { ?>
											<li>
												<a href="<?= $product_item[$m][$sluglang] ?>"><span><?= $product_item[$m]['name' . $lang] ?></span></a>
											</li>
										<?php } ?>
									</ul>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>

<?php /* ?>
<div id="support">
	<div class="title-left"><span>Hỗ trợ trực tuyến</span></div>
	<div class="content-support">
		<div class="photo-support">
			<p class="mb-0 scale-img">
				<?= $func->getImage(['sizes' => '126x126x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $haSupport['photo'], 'alt' => $setting['name' . $lang]]) ?>
			</p>
		</div>
		<div class="hotline-support">
			<span>Hotline : </span><a href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>"><?=$optsetting['hotline']?></a>
		</div>
		<?php if (count($yahoo) != 0) { for ($i = 0; $i < count($yahoo); $i++) {
			$optyahoo = (isset($yahoo[$i]['options2']) && $yahoo[$i]['options2'] != '') ? json_decode($yahoo[$i]['options2'], true) : null; ?>
			<div class="info-support">
				<div class="name-yahoo"><?= $yahoo[$i]['name' . $lang] ?></div>
				<div class="info-yahoo">
					<div class="phone-yahoo">Điện thoại: <span><a href="tel:<?= $optyahoo['dienthoai'] ?>"><?= $optyahoo['dienthoai'] ?></a></span></div>
					<div class="phone-yahoo"><?= $optyahoo['email'] ?></div>
				</div>
			</div>
		<?php }} ?>
		<div class="social-support">
			<div class="title-social d-inline-block">Mạng xã hội</div>
			<ul class="list-social list-unstyled p-0 m-0">
                <?php foreach ($social as $k => $v) { ?>
                    <li class="d-inline-block">
                        <a href="<?= $v['link'] ?>" target="_blank">
                            <?= $func->getImage(['sizes' => '28x28x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $v['photo'], 'alt' => $v['name' . $lang]]) ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
		</div>
	</div>
</div>
<?php */ ?>