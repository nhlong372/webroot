/* Validation form */
validateForm('validation-newsletter');
if(CARTSITE==true) validateForm('validation-cart');
// validateForm('validation-user');
validateForm('validation-contact');

NN_FRAMEWORK.Toc = function(){
    $(document).ready(function () {                
        $(".toc-list").toc({
            content: "div#toc-content",
            headings: "h2,h3,h4"
        });
        if(!$(".toc-list li").length){ $(".meta-toc").hide();}
        $('.toc-list').find('a').click(function(){
            var x = $(this).attr('data-rel');
            goToByScroll(x,60);
        });
    });
};

/* Pagings */
NN_FRAMEWORK.Pagings = function () {
	/* Products */
	if (isExist($('.paging-product'))) {
		loadPaging('api/product.php?perpage=8', '.paging-product');
	}
	/* Categories */
	if (isExist($('.paging-product-category'))) {
		$('.paging-product-category').each(function () {
			var list = $(this).data('list');
			loadPaging('api/product.php?perpage=8&idList=' + list, '.paging-product-category-' + list);
		});
	}
};

/* Comment */
NN_FRAMEWORK.Comment = function () {
	if (isExist($('.comment-page'))) {
		$('.comment-page').comments({
			url: 'api/comment.php'
		});
	}
};

/* DatePicker */
NN_FRAMEWORK.DatePicker = function () {
	if (isExist($('#birthday'))) {
		$('#birthday').datetimepicker({
			timepicker: false,
			format: 'd/m/Y',
			formatDate: 'd/m/Y',
			minDate: '01/01/1950',
			maxDate: TIMENOW
		});
	}
};

/* Owl Data */
NN_FRAMEWORK.OwlData = function (obj) {
	if (!isExist(obj)) return false;
	var items = obj.attr('data-items');
	var rewind = Number(obj.attr('data-rewind')) ? true : false;
	var autoplay = Number(obj.attr('data-autoplay')) ? true : false;
	var loop = Number(obj.attr('data-loop')) ? true : false;
	var lazyLoad = Number(obj.attr('data-lazyload')) ? true : false;
	var mouseDrag = Number(obj.attr('data-mousedrag')) ? true : false;
	var touchDrag = Number(obj.attr('data-touchdrag')) ? true : false;
	var animations = obj.attr('data-animations') || false;
	var smartSpeed = Number(obj.attr('data-smartspeed')) || 800;
	var autoplaySpeed = Number(obj.attr('data-autoplayspeed')) || 800;
	var autoplayTimeout = Number(obj.attr('data-autoplaytimeout')) || 5000;
	var dots = Number(obj.attr('data-dots')) ? true : false;
	var responsive = {};
	var responsiveClass = true;
	var responsiveRefreshRate = 200;
	var nav = Number(obj.attr('data-nav')) ? true : false;
	var navContainer = obj.attr('data-navcontainer') || false;
	var navTextTemp =
		"<svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-left' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='5' y1='12' x2='9' y2='16' /><line x1='5' y1='12' x2='9' y2='8' /></svg>|<svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-narrow-right' width='50' height='37' viewBox='0 0 24 24' stroke-width='1' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><line x1='5' y1='12' x2='19' y2='12' /><line x1='15' y1='16' x2='19' y2='12' /><line x1='15' y1='8' x2='19' y2='12' /></svg>";
	var navText = obj.attr('data-navtext');
	navText =
		nav &&
		navContainer &&
		(((navText === undefined || Number(navText)) && navTextTemp) ||
			(isNaN(Number(navText)) && navText) ||
			(Number(navText) === 0 && false));
	if (items) {
		items = items.split(',');
		if (items.length) {
			var itemsCount = items.length;
			for (var i = 0; i < itemsCount; i++) {
				var options = items[i].split('|'),
					optionsCount = options.length,
					responsiveKey;
				for (var j = 0; j < optionsCount; j++) {
					const attr = options[j].indexOf(':') ? options[j].split(':') : options[j];
					if (attr[0] === 'screen') {
						responsiveKey = Number(attr[1]);
					} else if (Number(responsiveKey) >= 0) {
						responsive[responsiveKey] = {
							...responsive[responsiveKey],
							[attr[0]]: (isNumeric(attr[1]) && Number(attr[1])) ?? attr[1]
						};
					}
				}
			}
		}
	}
	if (nav && navText) {
		navText = navText.indexOf('|') > 0 ? navText.split('|') : navText.split(':');
		navText = [navText[0], navText[1]];
	}
	obj.owlCarousel({
		rewind,
		autoplay,
		loop,
		lazyLoad,
		mouseDrag,
		touchDrag,
		smartSpeed,
		autoplaySpeed,
		autoplayTimeout,
		dots,
		nav,
		navText,
		navContainer: nav && navText && navContainer,
		responsiveClass,
		responsiveRefreshRate,
		responsive
	});
	if (autoplay) {
		obj.on('translate.owl.carousel', function (event) {
			obj.trigger('stop.owl.autoplay');
		});
		obj.on('translated.owl.carousel', function (event) {
			obj.trigger('play.owl.autoplay', [autoplayTimeout]);
		});
	}
	if (animations && isExist(obj.find('[owl-item-animation]'))) {
		var animation_now = '';
		var animation_count = 0;
		var animations_excuted = [];
		var animations_list = animations.indexOf(',') ? animations.split(',') : animations;
		obj.on('changed.owl.carousel', function (event) {
			$(this).find('.owl-item.active').find('[owl-item-animation]').removeClass(animation_now);
		});
		obj.on('translate.owl.carousel', function (event) {
			var item = event.item.index;
			if (Array.isArray(animations_list)) {
				var animation_trim = animations_list[animation_count].trim();
				if (!animations_excuted.includes(animation_trim)) {
					animation_now = 'animate__animated ' + animation_trim;
					animations_excuted.push(animation_trim);
					animation_count++;
				}
				if (animations_excuted.length == animations_list.length) {
					animation_count = 0;
					animations_excuted = [];
				}
			} else {
				animation_now = 'animate__animated ' + animations_list.trim();
			}
			$(this).find('.owl-item').eq(item).find('[owl-item-animation]').addClass(animation_now);
		});
	}
};
/* Owl Page */
NN_FRAMEWORK.OwlPage = function () {
	if (isExist($('.owl-page'))) {
		$('.owl-page').each(function () {
			NN_FRAMEWORK.OwlData($(this));
		});
	}
};
/* Cart */
NN_FRAMEWORK.Cart2 = function () {	
	/* Delete */
	$('body').on('click', '.del-procart', function () {
		confirmDialog('delete-procart', LANG['delete_product_from_cart'], $(this));
	});
	/* Counter */
	$('body').on('click', '.counter-procart', function () {

		var button = $(this);
		var quantity = 1;
		var input = button.parent().find('input');
		var id = input.data('pid');
		var code = input.data('code');
		var oldValue = button.parent().find('input').val();
		if (button.hasClass("increase")) quantity = parseFloat(oldValue) + 1;
		else if (button.hasClass("decrease") && oldValue > 1) quantity = parseFloat(oldValue) - 1;
		button.parent().find('input').val(quantity);
		updateCart(id, code, quantity);
	});

	/* Quantity */
	$('body').on('change', 'input.quantity-procart', function () {
		var quantity = $(this).val() < 1 ? 1 : $(this).val();
		$(this).val(quantity);
		var id = $(this).data('pid');
		var code = $(this).data('code');
		updateCart(id, code, quantity);
	});
	/* City */
	if (isExist($('.select-city-cart'))) {
		$('.select-city-cart').change(function () {
			var id = $(this).val();
			loadDistrict(id);
			loadShip();
		});
	}
	/* District */
	if (isExist($('.select-district-cart'))) {
		$('.select-district-cart').change(function () {
			var id = $(this).val();
			loadWard(id);
			loadShip();
		});
	}
	/* Ward */
	if (isExist($('.select-ward-cart'))) {
		$('.select-ward-cart').change(function () {
			var id = $(this).val();
			loadShip(id);
		});
	}
	/* Payments */
	if (isExist($('.payments-label'))) {
		$('.payments-label').click(function () {
			var payments = $(this).data('payments');
			$('.payments-cart .payments-label, .payments-info').removeClass('active');
			$(this).addClass('active');
			$('.payments-info-' + payments).addClass('active');
		});
	}
	/* Colors */
	if (isExist($('.color-pro-detail'))) {
		$('.color-pro-detail input').click(function () {
			$this = $(this).parents('label.color-pro-detail');
			$parents = $this.parents('.attr-pro-detail');
			$parents_detail = $this.parents('.grid-pro-detail');
			$parents.find('.color-block-pro-detail').find('.color-pro-detail').removeClass('active');
			$parents.find('.color-block-pro-detail').find('.color-pro-detail input').prop('checked', false);
			$this.addClass('active');
			$this.find('input').prop('checked', true);
			var id_color = $parents.find('.color-block-pro-detail').find('.color-pro-detail input:checked').val();
			var id_pro = $this.data('idproduct');
			$.ajax({
				url: 'api/color.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id_color: id_color,
					id_pro: id_pro
				},
				beforeSend: function () {
					HoldOn.open({
			            theme:"sk-bounce",
			            message:'Vui lòng chờ tí ...'
			        });
				},
				success: function (result) {
					if (result) {
						$parents_detail.find('.left-pro-detail').html(result);
						MagicZoom.refresh('Zoom-1');
						NN_FRAMEWORK.OwlData($('.owl-pro-detail'));
						NN_FRAMEWORK.Lazys();
					}
					holdonClose();
				}
			});
		});
	}
	/* Sizes */
	if (isExist($('.size-pro-detail'))) {
		$('.size-pro-detail input').click(function () {
			$this = $(this).parents('label.size-pro-detail');
			$parents = $this.parents('.attr-pro-detail');
			$parents.find('.size-block-pro-detail').find('.size-pro-detail').removeClass('active');
			$parents.find('.size-block-pro-detail').find('.size-pro-detail input').prop('checked', false);
			$this.addClass('active');
			$this.find('input').prop('checked', true);
		});
	}
	/* Quantity detail page */
	if (isExist($('.quantity-pro-detail span'))) {
		$('.quantity-pro-detail span').click(function () {
			var button = $(this);
			var oldValue = $(this).parent().find('input').val();
			if (button.hasClass("increase")) {
				var newVal = parseFloat(oldValue) + 1;
			} else if (button.hasClass("decrease")) {
				if (oldValue > 1) var newVal = parseFloat(oldValue) - 1;
				else var newVal = 1;
			}
			button.parent().find('input').val(newVal);
		});
	}
};

// NN_FRAMEWORK.LikeProduct = function () {
// 	$(document).on('click', '.save-listing', function(event) {
//         event.preventDefault();
//         var id = $(this).data('id');
//         var ele = $('.save-listing[data-id='+id+']');
//         if(id) {
//             $.ajax({
//                 url: 'api/ajax_save-listing.php',
//                 type: 'post',
//                 data: {id: id},
//             })
//             .done(function(kq) {
//                 ele.addClass('save-listing-already').removeClass('save-listing');
//                 $('.count-like').html(kq);
//             });
//             return false;
//         }
//     });
//     $(document).on('click', '.save-listing-already', function(event) {
//         event.preventDefault();
//         var id = $(this).data('id');
//         var ele = $('.save-listing-already[data-id='+id+']');
//         if(id) {
//             $.ajax({
//                 url: 'api/ajax_remove-listing.php',
//                 type: 'post',
//                 data: {id: id},
//             })
//             .done(function(kq) {
//                 ele.addClass('save-listing').removeClass('save-listing-already');
//                 $('.count-like').html(kq);
//             });
//             return false;
//         }
//     });
// 	};

// 	$("body").on("click",".apply-coupon",function(){  
// 	var coupon = $(".code-coupon").val();
// 	var ship = $(".price-ship").val();

// 	if(coupon=='')
// 	{
// 		modalNotify(LANG['no_coupon']);
// 		return false;
// 	}

// 	$.ajax({
// 		type: "POST",
// 		url:'api/ajax_coupon_cart.php',
// 		dataType: 'json',
// 		data: {coupon:coupon,ship:ship},
// 		success: function(result){
// 			$('.price-total').val(result.total);
// 			$('.load-price-total').html(result.totalText);
// 			$('.price-endowType').val(result.endowType);
// 			$('.price-endowID').val(result.endowID);
// 			$('.price-endow').val(result.endow);
// 			$('.load-price-endow').html(result.endowText);

// 			if(result.error!='')
// 			{
// 				$(".code-coupon").val("");
// 				modalNotify(result.error);
// 			}
// 		}
// 	});
// });

NN_FRAMEWORK.doigia = function(){
	if (isExist($('.proprice_item_size'))) {
		$(document).on('click', '.proprice_item_size', function(event) {
			event.preventDefault();
			$('.proprice_item').removeClass('active');
			$(this).addClass('active').siblings('.proprice_item_size').removeClass('active');
			fill_price($(this).data('min_price'));
		});
	}
};

NN_FRAMEWORK.doihinh = function(){
	if (isExist($('.proprice_item_color'))) {
		$(document).on('click', '.proprice_item_color', function(event) {
			event.preventDefault();
			$('.proprice_item1').removeClass('active');
			$(this).addClass('active').siblings('.proprice_item_color').removeClass('active');
			var photo = $('.proprice_item1.active').data('img');
			var id_product = $('.proprice_item1.active').data('id_prod');
			
			$.ajax({
				url: 'doihinh',
				type: 'post',
				data: {
					id_product: id_product,
					photo: photo,
				},
			})
			.done(function(kq) {
				$('.productTop1_fotorama').html(kq);
				$('.fotorama').fotorama();
			});		
		});
	}
};

NN_FRAMEWORK.Warning = function() {
	const phoneNumber = PHONENUMBER;
	const regex = '/[^0-9]/';
	const completePhone = phoneNumber.replace(regex, "");

	const zalo = ZALO;
	const completeZalo = phoneNumber.replace(regex, "");

	$('.btn-alert').click(function () {
		notifyDialog('Hiện sản phẩm này chưa có giá, bạn vui lòng liên hệ qua hotline <a href="tel:'+ completePhone +'">' + PHONENUMBER + '</a> hoặc liên hệ qua zalo <a href="tel:'+ completeZalo +'">' + ZALO + '</a> để được báo giá', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '10000');
	});
	$('.btn-alert2').click(function () {
		notifyDialog('Hiện sản phẩm này chưa có giá, bạn vui lòng liên hệ qua hotline <a href="tel:'+ completePhone +'">' + PHONENUMBER + '</a> hoặc liên hệ qua zalo <a href="tel:'+ completeZalo +'">' + ZALO + '</a> để được báo giá', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '10000');
	});
}

/* Ready */
$(document).ready(function () {	
	NN_FRAMEWORK.OwlPage();
	NN_FRAMEWORK.Pagings();		
	NN_FRAMEWORK.Comment();
	NN_FRAMEWORK.DatePicker();	
	NN_FRAMEWORK.Cart2();
	//NN_FRAMEWORK.LikeProduct();
	NN_FRAMEWORK.doigia();
	NN_FRAMEWORK.doihinh();
	// NN_FRAMEWORK.Toc();
	// NN_FRAMEWORK.Warning();
});