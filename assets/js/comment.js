$.fn.comments = function (options) {
	var wrapper = $(this);
	var wrapperLists = wrapper.find('.comment-lists');
	var base_url = '';

	if (options) {
		if (options.url) {
			base_url = options.url;
		}
	}

	var parseResponse = function (errors) {
		str = '';
		if (errors.length) {
			str += '<div class="text-left">';

			if (errors.length > 1) {
				for (i = 0; i < errors.length; i++) {
					str += '- ' + errors[i] + '</br>';
				}
			} else if (errors.length == 1) {
				str += errors[0];
			}

			str += '</div>';
		}
		return str;
	};

	var posCursor = function (ctrl) {
		var len = ctrl.val();
		ctrl.focus()
			.val('')
			.blur()
			.focus()
			.val(len + ' ');
	};

	var mediaSlid = function () {
		wrapperLists.find('.carousel-comment-media').each(function () {
			$this = $(this);
			$this.on('slid.bs.carousel', function (e) {
				$thisSlid = $(this);
				var videoActive = $thisSlid.find('.carousel-lists .carousel-comment-media-item-video.active');
				var videoItem = $thisSlid.find('.carousel-lists .carousel-comment-media-item-video');

				if (isExist(videoActive)) {
					videoActive.find('#file-video').trigger('play');
				} else {
					videoItem.find('#file-video').trigger('pause');
				}
			});
		});
	};

	var mediaPhoto = function () {
		if (isExist($('#review-file-photo'))) {
			$('#review-file-photo').getEvali({
				limit: 3,
				maxSize: 30,
				extensions: ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG', 'Png'],
				editor: false,
				addMore: true,
				enableApi: false,
				dragDrop: true,
				changeInput:
					'<div class="review-fileuploader">' +
					'<div class="review-fileuploader-caption"><strong>${captions.feedback}</strong></div>' +
					'<div class="review-fileuploader-text mx-3">${captions.or}</div>' +
					'<div class="review-fileuploader-button btn btn-sm btn-primary text-capitalize font-weight-500 py-2 px-3">${captions.button}</div>' +
					'</div>',
				theme: 'dragdrop',
				captions: {
					feedback: '(Kéo thả ảnh vào đây)',
					or: '-hoặc-',
					button: 'Chọn ảnh'
				},
				thumbnails: {
					popup: false,
					canvasImage: false
				},
				dialogs: {
					alert: function (e) {
						return notifyDialog(e);
					},
					confirm: function (e, t) {
						$.confirm({
							title: 'Thông báo',
							icon: 'fas fa-exclamation-triangle',
							type: 'orange',
							content: e,
							backgroundDismiss: true,
							animationSpeed: 600,
							animation: 'zoom',
							closeAnimation: 'scale',
							typeAnimated: true,
							animateFromElement: false,
							autoClose: 'cancel|3000',
							escapeKey: 'cancel',
							buttons: {
								success: {
									text: 'Đồng ý',
									btnClass: 'btn-sm btn-warning',
									action: function () {
										t();
									}
								},
								cancel: {
									text: 'Hủy',
									btnClass: 'btn-sm btn-danger'
								}
							}
						});
					}
				},
				afterSelect: function () {},
				onEmpty: function () {},
				onRemove: function () {}
			});
		}
	};

	var mediaVideo = function () {
		if (isExist($('#review-poster-video'))) {
			photoZone('#review-poster-video-label', '#review-poster-video', '#review-poster-video-preview img', '');
		}
	};

	$(window).on('load', function () {
		mediaPhoto();
		mediaVideo();
		mediaSlid();
	});

	wrapper
		.on('mouseover', 'i.fa-star', function (e) {
			e.preventDefault();
			$this = $(this);
			var id = $this.attr('data-value');
			$this
				.parent('p')
				.children('i')
				.each(function () {
					var val = $this.attr('data-value');
					if (val <= id) {
						$this.removeClass('star-empty');
					}
				});
		})
		.on('mouseout', 'i.fa-star', function (e) {
			e.preventDefault();
			$this
				.parent()
				.children('i')
				.each(function (e) {
					$this.parent().children('i').addClass('star-empty');
				});
		});

	wrapper.on('click', 'i.fa-star', function () {
		$this = $(this);
		var value = $this.attr('data-value');
		$this.parents('.review-rating-star').find('input').attr('value', value);
		var onStar = parseInt($this.data('value'), 10);
		var stars = $this.parent().children('i');

		for (i = 0; i < stars.length; i++) {
			$(stars[i]).removeClass('star-not-empty');
		}

		for (i = 0; i < onStar; i++) {
			$(stars[i]).addClass('star-not-empty');
		}

		$this.parent().parent().find('a').show();

		return false;
	});

	wrapper.on('click', '.btn-write-comment', function () {
		$('.comment-write').toggleClass('comment-show');
	});

	wrapper.on('click', '.btn-reply-comment', function (e) {
		e.preventDefault();
		$this = $(this);
		$parents = $this.parents('.comment-item-information');
		var form = $parents.find('#form-reply');
		$this.text($this.text() == 'Trả lời' ? 'Hủy bỏ' : 'Trả lời');
		$this.toggleClass('active');
		form.toggleClass('comment-show');
		form.trigger('reset');
		form.find('textarea').val('@' + $this.data('name') + ':');
		posCursor(form.find('textarea'));

		/* Turn off media when reply */
		if ($this.hasClass('active')) {
			var media = $parents.find('.carousel-comment-media .carousel-indicators li.active');

			if (media.length) {
				media.trigger('click');
			}
		}
	});

	wrapper.on('click', '.btn-cancel-reply', function (e) {
		e.preventDefault();
		$this = $(this);
		$parents = $this.parents('.comment-item-information');
		var form = $parents.find('#form-reply');
		form.trigger('reset').toggleClass('comment-show');
		$parents.find('.btn-reply-comment').text('Trả lời');
	});

	wrapper.on('click', '.carousel-comment-media .carousel-indicators li', function (e) {
		$this = $(this);
		$parents = $this.parents('.carousel-comment-media');
		var id = $this.data('id');
		var videoThis = $parents.find('.carousel-lists .carousel-comment-media-item-' + id);
		var videoItem = $parents.find('.carousel-lists .carousel-comment-media-item-video');

		if ($this.hasClass('active')) {
			$parents.find('.carousel-indicators li, .carousel-lists .carousel-item').removeClass('active');
			videoItem.find('#file-video').trigger('pause');
		} else {
			$parents.find('.carousel-indicators li').removeClass('active');
			$this.addClass('active');
			$parents.find('.carousel-lists .carousel-item').removeClass('active');

			/* Video */
			videoThis.addClass('active');

			if (isExist(videoThis.find('#file-video'))) {
				videoThis.find('#file-video').trigger('play');
			} else {
				videoItem.find('#file-video').trigger('pause');
			}
		}
	});

	wrapper.on('click', '.btn-load-more-comment-parent', function (e) {
		e.preventDefault();
		$this = $(this);
		$loadControl = $this.parents('.comment-load-more-control');
		$loadResult = $this.parents('.comment-lists').find('.comment-load');
		var limitFrom = parseInt($loadControl.find('.limit-from').val());
		var limitGet = parseInt($loadControl.find('.limit-get').val());
		var idVariant = parseInt($loadControl.find('.id-variant').val());
		var type = $loadControl.find('.type').val();

		$.ajax({
			url: base_url + '?get=limitLists',
			method: 'GET',
			dataType: 'json',
			async: false,
			data: {
				limitFrom: limitFrom,
				limitGet: limitGet,
				idVariant: idVariant,
				type: type
			},
			beforeSend: function () {
				$this.text('Đang tải');
				$this.attr('disabled', true);
			},
			error: function (e) {
				$this.text('Tải thêm bình luận');
				$this.attr('disabled', false);
				showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
			},
			success: function (response) {
				$this.text('Tải thêm bình luận');
				$this.attr('disabled', false);

				if (response.data) {
					$loadResult.append(response.data);
					$loadControl.find('.limit-from').val(limitFrom + limitGet);
					mediaSlid();
					NN_FRAMEWORK.Lazys();
				}

				/* Check to remove load more button */
				var listsLoaded = $loadResult.find('.comment-item').length;

				if (parseInt(listsLoaded) == parseInt(response.total)) {
					$loadControl.remove();
				}
			}
		});
	});

	wrapper.on('click', '.btn-load-more-comment-child', function (e) {
		e.preventDefault();
		$this = $(this);
		$loadControl = $this.parents('.comment-load-more-control');
		$loadResult = $this
			.parents('.comment-item')
			.find('.comment-item-information .comment-replies .comment-replies-load');
		var limitFrom = parseInt($loadControl.find('.limit-from').val());
		var limitGet = parseInt($loadControl.find('.limit-get').val());
		var idParent = parseInt($loadControl.find('.id-parent').val());
		var idVariant = parseInt($loadControl.find('.id-variant').val());
		var type = $loadControl.find('.type').val();

		$.ajax({
			url: base_url + '?get=limitReplies',
			method: 'GET',
			dataType: 'json',
			async: false,
			data: {
				limitFrom: limitFrom,
				limitGet: limitGet,
				idParent: idParent,
				idVariant: idVariant,
				type: type
			},
			beforeSend: function () {
				$this.text('Đang tải');
				$this.attr('disabled', true);
			},
			error: function (e) {
				$this.text('Xem thêm bình luận');
				$this.attr('disabled', false);
				showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
			},
			success: function (response) {
				$this.text('Xem thêm bình luận');
				$this.attr('disabled', false);

				if (response.data) {
					$loadResult.append(response.data);
					$loadControl.find('.limit-from').val(limitFrom + limitGet);
					NN_FRAMEWORK.Lazys();
				}

				/* Check to remove load more button */
				var listsLoaded = $loadResult.find('.comment-replies-item').length;

				if (parseInt(listsLoaded) == parseInt(response.total)) {
					$loadControl.remove();
				}
			}
		});
	});

	wrapper.on('submit', '#form-comment', function (e) {
		e.preventDefault();
		$this = $(this);
		var form = $this;
		var formData = new FormData(form[0]);
		var responseEle = form.find('.response-review');

		responseEle.html('');
		holdonOpen();

		setTimeout(function () {
			$.ajax({
				url: base_url + '?get=add',
				method: 'POST',
				enctype: 'multipart/form-data',
				dataType: 'json',
				data: formData,
				async: false,
				processData: false,
				contentType: false,
				cache: false,
				error: function (e) {
					holdonClose();
					showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
				},
				success: function (response) {
					if (response.errors) {
						responseEle.html(
							'<div class="alert alert-danger">' + parseResponse(response.errors) + '</div>'
						);
						goToByScroll('comment-write', 20);
						holdonClose();
					} else {
						form.trigger('reset');
						holdonClose();
						showNotify(
							'Bình luận sẽ được hiển thị sau khi được Bản Quản Trị kiểm duyệt',
							'Bình luận thành công',
							'success'
						);

						setTimeout(function () {
							location.reload();
						}, 2000);
					}
				}
			});
		}, 500);

		return false;
	});

	wrapper.on('submit', '#form-reply', function (e) {
		e.preventDefault();
		$this = $(this);
		$parents = $this.parents('.comment-item');
		var form = $this;
		var formData = new FormData(form[0]);
		var responseEle = form.find('.response-reply');
		var content = form.find('#reply-content');
		var contentDataName = content.data('name');

		responseEle.html('');
		holdonOpen();

		setTimeout(function () {
			$.ajax({
				url: base_url + '?get=add',
				method: 'POST',
				enctype: 'multipart/form-data',
				dataType: 'json',
				data: formData,
				async: false,
				processData: false,
				contentType: false,
				cache: false,
				error: function (e) {
					showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
				},
				success: function (response) {
					if (response.errors) {
						responseEle.html(
							'<div class="alert alert-danger">' + parseResponse(response.errors) + '</div>'
						);
						goToByScroll(form.attr('id'), 20);
						holdonClose();
					} else {
						form.trigger('reset');
						form.find('#reply-content').val(contentDataName + ' ');
						holdonClose();
						showNotify(
							'Bình luận sẽ được hiển thị sau khi được Bản Quản Trị kiểm duyệt',
							'Bình luận thành công',
							'success'
						);
					}
				}
			});
		}, 500);

		return false;
	});
};
