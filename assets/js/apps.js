
/* Validation form */
validateForm('validation-newsletter');
if(CARTSITE==true) validateForm('validation-cart');
// validateForm('validation-user');
validateForm('validation-contact');
/* Lazys */
NN_FRAMEWORK.Lazys = function () {
	if (isExist($('.lazy'))) {
		var lazyLoadInstance = new LazyLoad({
			elements_selector: '.lazy'
		});
	}
};
NN_FRAMEWORK.Filter = function(){
    function filterProduct() {
        HoldOn.open({
            theme:"sk-bounce",
            message:'Vui lòng chờ tí ...'
        });
        var link = '?filter_active=1';
        const filter1 = [];
        const filter2 = [];
        const filter3 = [];
        if($('#filter_sort_choose li a.checked').data('id')!=undefined) {
            link = link + '&sort=' + $('#filter_sort_choose li a.checked').data('id');
        }
        $('#filter_os_choose a').each(function(index, el) {
        	if($(this).hasClass('checked')) {
        		filter1.push($(this).data('id'));
        	}
        });
        $('#filter_size_choose a').each(function(index, el) {
        	if($(this).hasClass('checked')) {
        		filter2.push($(this).data('id'));
        	}
        });
        $('#filter_color_choose a').each(function(index, el) {
        	if($(this).hasClass('checked')) {
        		filter3.push($(this).data('id'));
        	}
        });
        link += '&brand='+filter1.join()+'&size='+filter2.join()+'&color='+filter3.join();
        var current_link = window.location.href.split("?");
        setTimeout(() => {
            HoldOn.close();
            window.location.href = current_link[0] + link;
        }, 1000)
    }
    $(document).on('click', '#filter_sort_choose li a', function(event) {
        event.preventDefault();
        if($(this).hasClass('checked')) {
            $(this).parents('ul').find('a').removeClass('checked');
        }
        else {
            $(this).parents('ul').find('a').removeClass('checked');
            $(this).addClass('checked');
        }
        filterProduct();
        return false;
    });
    $(document).on('click', '#filter_os_choose li a, #filter_size_choose li a, #filter_color_choose li a', function(event) {
        event.preventDefault();
        $(this).toggleClass('checked');
        filterProduct();
        return false;
    });
    $(document).on('click', '.filter_block .filter_title', function(event) {
        event.preventDefault();
        $(this).parents('.filter_block').find('ul').toggle();
        return false;
    });
    /* click danh muc ben trai */
    $("#danhmuc ul li span").click(function(){ if($(this).parent('li').children('ul').find('li').length>0){ if($(this).hasClass('active')) { $(this).parent('li').find('ul:first').hide(300); $(this).removeClass('active'); }else{ $(this).parent('li').find('ul:first').show(300); $(this).addClass('active'); } return false; } });
};
NN_FRAMEWORK.AutocompleteSeach = function(){
    $(document).on('keyup', '#keyword', function(event) {
        event.preventDefault();
        if($(this).val().length > 0) {
            $.ajax({
                url: 'api/autocomplete.php',
                type: 'post',
                data: {keyword: $(this).val()},
            })
            .done(function(rs) {
                $('.keyword-autocomplete').html(rs);
                $('.keyword-autocomplete').show();
            });
        }
        else {
            $('.keyword-autocomplete').hide();
        }
    });
};
/* Load name input file */
NN_FRAMEWORK.loadNameInputFile = function () {
	if (isExist($('.custom-file input[type=file]'))) {
		$('body').on('change', '.custom-file input[type=file]', function () {
			var fileName = $(this).val();
			fileName = fileName.substr(fileName.lastIndexOf('\\') + 1, fileName.length);
			$(this).siblings('label').html(fileName);
		});
	}
};

/* Back to top */
// NN_FRAMEWORK.GoTop = function () {
// 	$(window).scroll(function () {
// 		if (!$('.scrollToTop').length)
// 			$('body').append('<div class="scrollToTop"><img src="' + GOTOP + '" alt="Go Top"/></div>');
// 		if ($(this).scrollTop() > 100) $('.scrollToTop').fadeIn();
// 		else $('.scrollToTop').fadeOut();
// 	});
// 	$('body').on('click', '.scrollToTop', function () {
// 		$('html, body').animate({ scrollTop: 0 }, 800);
// 		return false;
// 	});
// };

/* Scroll to top */
NN_FRAMEWORK.ScrollToTop = function(){
	$(document).ready(function() {
		"use strict";
		var progressPath = document.querySelector('.progress-wrap path');
		var pathLength = progressPath.getTotalLength();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
		progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
		progressPath.style.strokeDashoffset = pathLength;
		progressPath.getBoundingClientRect();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
		var updateProgress = function() {
			var scroll = $(window).scrollTop();
			var height = $(document).height() - $(window).height();
			var progress = pathLength - (scroll * pathLength / height);
			progressPath.style.strokeDashoffset = progress;
		};
		updateProgress();
		$(window).scroll(updateProgress);
		var offset = 150;
		var duration = 550;
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > offset) {
				$('.progress-wrap').addClass('active-progress');
			} else {
				$('.progress-wrap').removeClass('active-progress');
			}
		});
		$('.progress-wrap').on('click', function(event) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: 0
			}, duration);
			return false;
		});
	});
}

/* Alt images */
NN_FRAMEWORK.AltImg = function () {
	$('img').each(function (index, element) {
		if (!$(this).attr('alt') || $(this).attr('alt') == '') {
			$(this).attr('alt', WEBSITE_NAME);
		}
	});
};
/* Menu */
NN_FRAMEWORK.Menu = function () {
	$(window).scroll(function(){
        if($(window).scrollTop() > $(".menu").height() + 200) $(".menu").addClass('menu-fix');
        else $(".menu").removeClass('menu-fix');
    });
	/* Menu remove empty ul */
	if (isExist($('.menu'))) {
		$('.menu ul li a').each(function () {
			$this = $(this);
			if (!isExist($this.next('ul').find('li'))) {
				$this.next('ul').remove();
				$this.removeClass('has-child');
			}
		});
	}
	/* Mmenu */
	if (isExist($('.load-menu'))) {
		var content_menu = $('.menu-main').html();
		/* tạo menu mobile */
	    //var menu_mobi = $('ul.menu_desktop').html();
	    $('.load-menu').append('<span class="close_menu"><img src="assets/images/close.png" alt="Close"></span><ul>'+content_menu+'</ul>');
	    $(".menu_mobi_add ul li").each(function(index, element) {
	        if($(this).children('ul').children('li').length>0){
	            $(this).children('a').append('<span><i class="fas fa-chevron-right"></i></span>');
	        }
	    });
	    $(".menu_mobi_add ul li a span").click(function(){
	        if($(this).parent('a').hasClass('active2')){
	            $(this).parent('a').removeClass('active2');
	            if($(this).parent('a').parent('li').children('ul').children('li').length > 0){
	                $(this).parent('a').parent('li').children('ul').hide(300);
	                return false;
	            }
	        }
	        else{
	            $(this).parent('a').addClass('active2');
	            if($(this).parents('li').children('ul').children('li').length > 0){
	                $(".menu_m ul li ul").hide(0);
	                $(this).parents('li').children('ul').show(300);
	                return false;
	            }
	        }
	    });

	    $('.icon-menu,.close_menu,.menu_baophu').click(function(){
	        if($('.menu_mobi_add').hasClass('menu_mobi_active'))
	        {
	            $('.menu_mobi_add').removeClass('menu_mobi_active');
	            $('.menu_baophu').fadeOut(300);
	        }
	        else
	        {
	            $('.menu_mobi_add').addClass('menu_mobi_active');
	            $('.menu_baophu').fadeIn(300);
	        }
	        return false;
	    });
		/*if(content_menu!='') {
			$('.load-menu > ul').html(content_menu);
			$('.load-menu > ul').find('.menu-line').remove();
		}*/
		/*$('.load-menu').mmenu({
			extensions: ['border-full', 'position-left', 'position-front']
		});*/
	}
};
/* Tools */
NN_FRAMEWORK.Tools = function () {
	if (isExist($('.toolbar'))) {
		$('.footer').css({ marginBottom: $('.toolbar').innerHeight() });
	}
};
/* Popup */
NN_FRAMEWORK.Popup = function () {
	if (isExist($('#popup'))) {
		$('#popup').modal('show');
	}
	$("body").on("click",".icon-map",function(){  
        $('#popup-map').modal('show');
    });
    $("body").on("click",".icon-baogia",function(){  
        $('#popup-baogia').modal('show');
    });
    // $("body").on("click",".btn-show",function(){  
    //     $('#popup-form').modal('show');
    // });
};
/* Wow */
NN_FRAMEWORK.Wows = function () {
	new WOW().init();
};
/* Pagings */
/*NN_FRAMEWORK.Pagings = function () {
	
	if (isExist($('.paging-product'))) {
		loadPaging('api/product.php?perpage=8', '.paging-product');
	}
	
	if (isExist($('.paging-product-category'))) {
		$('.paging-product-category').each(function () {
			var list = $(this).data('list');
			loadPaging('api/product.php?perpage=8&idList=' + list, '.paging-product-category-' + list);
		});
	}
};*/
/* Ticker scroll */
/*NN_FRAMEWORK.TickerScroll = function () {
	if (isExist($('.news-scroll'))) {
		$('.news-scroll')
			.easyTicker({
				direction: 'up',
				easing: 'swing',
				speed: 'slow',
				interval: 3500,
				height: 'auto',
				visible: 3,
				mousePause: true,
				controls: {
					up: '.news-control#up',
					down: '.news-control#down'
				},
				callbacks: {
					before: function (ul, li) {},
					after: function (ul, li) {}
				}
			})
			.data('easyTicker');
	}
};*/
/* Photobox */
NN_FRAMEWORK.Photobox = function () {
	if (isExist($('.album-gallery'))) {
		$('.album-gallery').photobox('a', { thumbs: true, loop: false });
	}
};
/* Comment */
/*NN_FRAMEWORK.Comment = function () {
	if (isExist($('.comment-page'))) {
		$('.comment-page').comments({
			url: 'api/comment.php'
		});
	}
};*/
/* DatePicker */
/*NN_FRAMEWORK.DatePicker = function () {
	if (isExist($('#birthday'))) {
		$('#birthday').datetimepicker({
			timepicker: false,
			format: 'd/m/Y',
			formatDate: 'd/m/Y',
			minDate: '01/01/1950',
			maxDate: TIMENOW
		});
	}
};*/
/* Search */
NN_FRAMEWORK.Search = function () {
	// if (isExist($('.icon-search'))) {
	// 	$('.icon-search').click(function () {
	// 		if ($(this).hasClass('active')) {
	// 			$(this).removeClass('active');
	// 			$('.search-grid').stop(true, true).animate({ opacity: '0', width: '0px' }, 200);
	// 		} else {
	// 			$(this).addClass('active');
	// 			$('.search-grid').stop(true, true).animate({ opacity: '1', width: '250px' }, 200);
	// 		}
	// 		document.getElementById($(".li-tim").next().find('input').attr('id')).focus();
	// 		$('.icon-search i').toggleClass('fa fa-search fa fa-times');
	// 	});
	// }
	
	if (isExist($(".icon-search"))) {
		$(".icon-search").click(function () {
		  if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(".search-grid")
			  .stop(true, true)
			  .animate({ opacity: "0", width: "0px" }, 200);
		  } else {
			$(this).addClass("active");
			$(".search-grid")
			  .stop(true, true)
			  .animate({ opacity: "1", width: "250px" }, 200);
		  }
		  document.getElementById($('.icon-search').next().find("input").attr("id")).focus();
		 
		  if (!$(".icon-search img").hasClass('change2')) {
		  	$(".icon-search img").attr('src', 'assets/images/close.png');
		  	$(".icon-search img").addClass('change2')
		  } 
		  else  {
		  	$(".icon-search img").attr('src', 'assets/images/search.png');
		  	$(".icon-search img").removeClass('change2')
		  }
		});
	}
	
	if (isExist($(".li-tim"))) {
		$(".li-tim").click(function () {
		  if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(".search-input")
			  .stop(true, true)
			  .animate({ opacity: "0", width: "0px" }, 200);
		  } else {
			$(this).addClass("active");
			$(".search-input")
			  .stop(true, true)
			  .animate({ opacity: "1", width: "250px" }, 200);
		  }
		  document.getElementById($(".li-tim").next().find("input").attr("id")).focus();
		  $(".li-tim i").toggleClass("fa fa-search fa fa-times");
		});
	}
};
/* Videos */
NN_FRAMEWORK.Videos = function () {
	if (isExist($('[data-fancybox="video"]'))) {
		$('[data-fancybox="video"]').fancybox({
			transitionEffect: 'fade',
			transitionDuration: 800,
			animationEffect: 'fade',
			animationDuration: 800,
			arrows: true,
			infobar: false,
			toolbar: true,
			hash: false
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
/* Dom Change */
NN_FRAMEWORK.DomChange = function () {
	/* Video Fotorama */
	$('#video-fotorama').one('DOMSubtreeModified', function () {
		$('#fotorama-videos').fotorama();
	});
	/* Video Select */
	$('#video-select').one('DOMSubtreeModified', function () {
		$('.listvideos').change(function () {
			var id = $(this).val();
			$.ajax({
				url: 'api/video.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id: id
				},
				beforeSend: function () {
					HoldOn.open({
            theme:"sk-bounce",
            message:'Vui lòng chờ tí ...'
			        });
				},
				success: function (result) {
					$('.video-main').html(result);
					holdonClose();
				}
			});
		});
	});

	/* Video Select */
	$('#video-img-select').one('DOMSubtreeModified', function () {
		$('.listvideos').change(function () {
			var id = $(this).val();
			$.ajax({
				url: 'api/video2.php',
				type: 'POST',
				dataType: 'html',
				data: {
					id: id
				},
				beforeSend: function () {
					HoldOn.open({
            theme:"sk-bounce",
            message:'Vui lòng chờ tí ...'
			        });
				},
				success: function (result) {
					$('.video-main').html(result);
					holdonClose();
				}
			});
		});
	});
	/* Chat Facebook */
	$('#messages-facebook').one('DOMSubtreeModified', function () {
		$('.js-facebook-messenger-box').on('click', function () {
			$('.js-facebook-messenger-box, .js-facebook-messenger-container').toggleClass('open'),
				$('.js-facebook-messenger-tooltip').length && $('.js-facebook-messenger-tooltip').toggle();
		}),
			$('.js-facebook-messenger-box').hasClass('cfm') &&
				setTimeout(function () {
					$('.js-facebook-messenger-box').addClass('rubberBand animated');
				}, 3500),
			$('.js-facebook-messenger-tooltip').length &&
				($('.js-facebook-messenger-tooltip').hasClass('fixed')
					? $('.js-facebook-messenger-tooltip').show()
					: $('.js-facebook-messenger-box').on('hover', function () {
							$('.js-facebook-messenger-tooltip').show();
					  }),
				$('.js-facebook-messenger-close-tooltip').on('click', function () {
					$('.js-facebook-messenger-tooltip').addClass('closed');
				}));
		$('.search_open').click(function () {
			$('.search_box_hide').toggleClass('opening');

		});
	});
};

NN_FRAMEWORK.Cart = function () {
	/* Add */
	$('body').on('click', '.addcart', function () {
		
		$this = $(this);
		var size = 0;
		var gia = 0;
		$parents = $this.parents('.right-pro-detail');
		var id = $this.data('id');
		var action = $this.data('action');
		var quantity = $parents.find('.quantity-pro-detail').find('.qty-pro').val();
		quantity = quantity ? quantity : 1;

		/* size màu cơ bản*/
		var color = $parents.find('.color-block-pro-detail').find('.color-pro-detail input:checked').val();
		color = color ? color : 0;
		var size = $parents.find('.size-block-pro-detail').find('.size-pro-detail input:checked').val();
		/* size màu cơ bản*/

		/* size màu nâng cao*/
		// if($('.proprice_item_size').length > 0) {
		// 	if($('.proprice_item_size.active').length > 0) {
		// 		var size = $('.proprice_item_size.active').data('id'); 
		// 		var gia = $('.proprice_item_size.active').data('min_price');
		// 	}
		// 	else {
		// 		var size = 0;
		// 		var gia = 0;
  //               notifyDialog('Bạn vui lòng chọn size!!!', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000');
		// 		return false;
		// 	}
		// }

		// if($('.proprice_item_color').length > 0) {
		// 	if($('.proprice_item_color.active').length > 0) {
		// 		var color = $('.proprice_item_color.active').data('id');             	
		// 		var photo = $('.proprice_item_color.active').data('photo');
		// 	}
		// 	else {
		// 		var color = 0;
		// 		var photo = 0;
  //               notifyDialog('Bạn vui lòng chọn màu!!!', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000');
		// 		return false;
		// 	}
		// }
		/* size màu nâng cao*/

		if (id) {
			$.ajax({
				url: 'api/cart.php',
				type: 'POST',
				dataType: 'json',
				async: false,
				data: {
					cmd: 'add-cart',
					id: id,
					color: color,
					size: size,
					quantity: quantity,
					// gia: gia,
					// photo: photo
				},
				beforeSend: function () {
					holdonOpen();
				},
				success: function (result) {
					if (action == 'addnow') {
						$('.count-cart').html(result.max);
						$.ajax({
							url: 'api/cart.php',
							type: 'POST',
							dataType: 'html',
							async: false,
							data: {
								cmd: 'popup-cart'
							},
							success: function (result) {
								$('#popup-cart .modal-body').html(result);
								$('#popup-cart').modal('show');
								NN_FRAMEWORK.Lazys();
								holdonClose();
							}
						});
					} else if (action == 'buynow') {
						window.location = CONFIG_BASE + 'gio-hang';
					}
				}
			});
		}
	});
	/* Update */
	$('body').on('click', '.change-quantity-procart', function () {

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
	/* Delete */
	$('body').on('click', '.del-procart-popup', function () {
		confirmDialog('delete-procart', LANG['delete_product_from_cart'], $(this));
	});	
};


NN_FRAMEWORK.AutoHeight = function () {
	var src_w = $(window).width();
	if(src_w < 992) {
        $('.autoHeight').find('iframe, video, embed, object').addClass('embed-responsive-item');
        $('.autoHeight').find('iframe, video, embed, object').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $('.autoHeight').find('iframe, video, embed, object').removeAttr('width');
        $('.autoHeight').find('iframe, video, embed, object').removeAttr('height');
        $('.autoHeight').find('iframe, video, embed, object').removeAttr('style');
        $('.autoHeight').find('img').addClass('img-fluid');
    }
    else {
        $('.autoHeight').find('iframe, video, embed, object, img').addClass('border-0 outline-0');
    }
};


/* Quick View */
NN_FRAMEWORK.QuickView = function () {
	$("body").on("click", ".xemnhanh", function () {
	  var id = $(this).data("id");
  		$parents_detail = $this.parents('.grid-pro-detail');
	  $.ajax({
		url: "api/ajax_xemnhanh.php",
		type: "POST",
		dataType: "html",
		data: {
		  id: id,
		},
		beforeSend: function () {
		  //holdonOpen();
		},
		success: function (result) {
		  $("#popup-pro-detail .modal-body").html(result);
		  $("#popup-pro-detail").modal("show");
		  $parents_detail.find('.left-pro-detail').html(result);
		  MagicZoom.refresh('Zoom-1');
		  // NN_FRAMEWORK.OwlData($('.owl-pro-detail'));
		  NN_FRAMEWORK.Cart();
		  NN_FRAMEWORK.Lazys();
		  //holdonClose();
		},
	  });
	});
};

NN_FRAMEWORK.LikeProduct = function () {
	$(document).on('click', '.save-listing', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var ele = $('.save-listing[data-id='+id+']');
        if(id) {
            $.ajax({
                url: 'api/ajax_save-listing.php',
                type: 'post',
                data: {id: id},
            })
            .done(function(kq) {
                ele.addClass('save-listing-already').removeClass('save-listing');
                $('.count-like').html(kq);
            });
            return false;
        }
    });
    $(document).on('click', '.save-listing-already', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var ele = $('.save-listing-already[data-id='+id+']');
        if(id) {
            $.ajax({
                url: 'api/ajax_remove-listing.php',
                type: 'post',
                data: {id: id},
            })
            .done(function(kq) {
                ele.addClass('save-listing').removeClass('save-listing-already');
                $('.count-like').html(kq);
            });
            return false;
        }
    });
};

$("body").on("click",".apply-coupon",function(){  
	var coupon = $(".code-coupon").val();
	var ship = $(".price-ship").val();

	if(coupon=='')
	{
		modalNotify(LANG['no_coupon']);
		return false;
	}

	$.ajax({
		type: "POST",
		url:'api/ajax_coupon_cart.php',
		dataType: 'json',
		data: {coupon:coupon,ship:ship},
		success: function(result){
			$('.price-total').val(result.total);
			$('.load-price-total').html(result.totalText);
			$('.price-endowType').val(result.endowType);
			$('.price-endowID').val(result.endowID);
			$('.price-endow').val(result.endow);
			$('.load-price-endow').html(result.endowText);

			if(result.error!='')
			{
				$(".code-coupon").val("");
				modalNotify(result.error);
			}
		}
	});
});

/*NN_FRAMEWORK.doigia = function(){
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
};*/

NN_FRAMEWORK.ChangeImgToIframe = function(){
	/* Click img ra iframe */
  $("body").on("click", ".youtube-player", function () {
    var target = this;
    var iframe = document.createElement("iframe");

    iframe.height = target.clientHeight;
    iframe.width = target.clientWidth;
    iframe.src = "https://www.youtube.com/embed/" + target.dataset.videoId + "?autoplay=1&mute=1";
    iframe.setAttribute("frameborder", 0);

    if (target.children.length) {
		HoldOn.open({ theme:"sk-bounce", message:'Vui lòng chờ tí ...' });
      	target.replaceChild(iframe, target.firstElementChild);
		HoldOn.close();
    } else {
      	target.appendChild(iframe);
    }
  });
}


NN_FRAMEWORK.NotifyForm = function() {
	$(document).ready(function() {
        $('.check-validate .btn-send').click(function() {
            var categorize = $(this).data('loai');
            var name = $('#fullname-' + categorize);
            var phone = $('#phone-' + categorize);
            var address = $('#address-' + categorize);
            var email = $('#email-' + categorize);
            var content = $('#content-' + categorize);

            if (categorize == 'baogia') {
                if (isEmpty(name.val())) {
                    notifyDialog('Vui lòng nhập họ tên.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', name.focus());
                    return false;
                }
                if (isEmpty(phone.val())) {
                    notifyDialog('Vui lòng nhập số điện thoại.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', phone.focus());
                    return false;
                }
                if (isPhone(phone.val())) {
                    notifyDialog('Số điện thoại không hợp lệ !!!', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', phone.focus());
                    return false;
                }
                if (isEmpty(email.val())) {
                    notifyDialog('Vui lòng nhập email.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', email.focus());
                    return false;
                }
                if (isEmail(email.val())) {
                    notifyDialog('Email không hợp lệ !!!', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', email.focus());
                    return false;
                }
                if (isEmpty(address.val())) {
                    notifyDialog('Vui lòng nhập địa chỉ.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', address.focus());
                    return false;
                }
                if (isEmpty(content.val())) {
                    notifyDialog('Vui lòng nhập nội dung.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', content.focus());
                    return false;
                }
            }
            if (categorize == 'newsletter') {
                if (isEmpty(name.val())) {
                    notifyDialog('Vui lòng nhập họ tên.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', name.focus());
                    return false;
                }
                if (isEmpty(phone.val())) {
                    notifyDialog('Vui lòng nhập số điện thoại.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', phone.focus());
                    return false;
                }
                if (isPhone(phone.val())) {
                    notifyDialog('Số điện thoại không hợp lệ !!!', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', phone.focus());
                    return false;
                }
                if (isEmpty(email.val())) {
                    notifyDialog('Vui lòng nhập email.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', email.focus());
                    return false;
                }
                if (isEmail(email.val())) {
                    notifyDialog('Email không hợp lệ !!!', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', email.focus());
                    return false;
                }
                if (isEmpty(address.val())) {
                    notifyDialog('Vui lòng nhập địa chỉ.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', address.focus());
                    return false;
                }
                if (isEmpty(content.val())) {
                    notifyDialog('Vui lòng nhập nội dung.', 'Thông báo', 'fas fa-exclamation-triangle', 'blue', '3000', content.focus());
                    return false;
                }
            }
        })
    });
}

NN_FRAMEWORK.RunSlick = function() {
	$('.chay-slider').slick({
		lazyLoad: 'progressive',infinite: true,accessibility: true,vertical: false,slidesToShow: 1,
		slidesToScroll: 1,autoplay: true,autoplaySpeed: 3000,speed: 1000,arrows: true,centerMode: false,
		dots: false,draggable: true,
	});
	$('.chay-tintuc-vertical').slick({
		lazyLoad: 'progressive',infinite: true,accessibility: true,vertical: true,slidesToShow: 3,
		slidesToScroll: 1,autoplay: true,autoplaySpeed: 3000,speed: 1000,arrows: false,centerMode: false,
		dots: false,draggable: true, verticalSwiping: true,
		responsive: [
			{ breakpoint: 871, settings: { slidesToShow: 2, slidesToScroll: 1, arrows: false, vertical: true, } }
		]
	});
	$('.chay-tintuc').slick({
		lazyLoad: 'progressive',infinite: true,accessibility: true,vertical: false,slidesToShow: 2,
		slidesToScroll: 1,autoplay: false,autoplaySpeed: 3000,speed: 1000,arrows: false,centerMode: false,
		dots: false,draggable: true, verticalSwiping: false,
		responsive: [
			{ breakpoint: 871, settings: { slidesToShow: 2, slidesToScroll: 1, } }
		]
	});
}

/* Tools */
NN_FRAMEWORK.ToolsApp = function () {
	$('body').on('click', '.scrollToTopMobile', function () {
		$('html, body').animate({ scrollTop: 0 }, 550);
		return false;
	});
	$(".toolbar-app .phone").click(function (e) { 
		e.stopPropagation();
		$(".toolbar-app").toggleClass('is-active');
	});
	$(document).click(function () {
		$(".toolbar-app").removeClass('is-active');
	});
	var lastScrollTop = 0;
	$(window).scroll(function () {
		var ex6Exists = $('.ex6').length > 0;
		if ($(this).scrollTop() > 100) {
			if (!ex6Exists) {
				$('.toolbar-app .scrollToTopMobile').addClass('ex6');
			}
		}else{
			$('.toolbar-app .scrollToTopMobile').removeClass('ex6');
		}

		
		var scrollTop = $(this).scrollTop();
		if (scrollTop <= lastScrollTop && scrollTop < 70) {
			$("body").addClass("show-toolbar");
			$("body").removeClass("hidden-toolbar");
			$('#check-toolbar').prop('checked', true);
		}
		lastScrollTop = scrollTop;
	});
	$("body").addClass("show-toolbar");
	$("#check-toolbar").change(function (e) { 
		if($(this).prop('checked')){
			$("body").addClass("show-toolbar");
			$("body").removeClass("hidden-toolbar");
		}else{
			$("body").removeClass("show-toolbar");
			$("body").addClass("hidden-toolbar");
		}
	});
};

/* Ready */
$(document).ready(function () {
	NN_FRAMEWORK.Lazys();
	NN_FRAMEWORK.Tools();
	NN_FRAMEWORK.Popup();
	NN_FRAMEWORK.Wows();
	NN_FRAMEWORK.AltImg();
	//NN_FRAMEWORK.GoTop();
	NN_FRAMEWORK.ScrollToTop();
	NN_FRAMEWORK.Menu();
	NN_FRAMEWORK.OwlPage();
	//NN_FRAMEWORK.Pagings();
	NN_FRAMEWORK.Cart();
	NN_FRAMEWORK.Videos();
	NN_FRAMEWORK.Photobox();
	//NN_FRAMEWORK.Comment();
	NN_FRAMEWORK.Search();
	NN_FRAMEWORK.DomChange();
	//NN_FRAMEWORK.TickerScroll();
	//NN_FRAMEWORK.DatePicker();
	NN_FRAMEWORK.loadNameInputFile();
	// NN_FRAMEWORK.AutocompleteSeach();
	NN_FRAMEWORK.Filter();
	NN_FRAMEWORK.AutoHeight();
	NN_FRAMEWORK.QuickView();
	NN_FRAMEWORK.LikeProduct();
	//NN_FRAMEWORK.doigia();
	//NN_FRAMEWORK.doihinh();
	NN_FRAMEWORK.ChangeImgToIframe();
	NN_FRAMEWORK.NotifyForm();
	if(SOURCE == 'index') NN_FRAMEWORK.RunSlick();
	NN_FRAMEWORK.ToolsApp();
});