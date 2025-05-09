$.fn.comments = function(options){
    var wrapper = $(this);
    var wrapperLists = wrapper.find(".comment-lists");
    var base_url = '';

    if(options)
    {
        if(options.url)
        {
            base_url = options.url;
        }
    }

    var parseResponse = function(errors){
        str = '';
        if(errors.length)
        {
            str += '<div class="text-left">';

                if(errors.length > 1)
                {
                    for(i = 0; i < errors.length; i++)
                    {
                        str += "- " + errors[i] + "</br>";
                    }
                }
                else if(errors.length == 1)
                {
                    str += errors[0];
                }

            str += "</div>";
        }
        return str;
    };

    var posCursor = function(ctrl){
        var len = ctrl.val();
        ctrl.focus().val("").blur().focus().val(len + ' ');
    };

    var mediaSlid = function(){
        wrapperLists.find(".carousel-comment-media").each(function(){
            $this = $(this);
            $this.on('slid.bs.carousel', function(e){
                $thisSlid = $(this);
                var videoActive = $thisSlid.find(".carousel-lists .carousel-comment-media-item-video.active");
                var videoItem = $thisSlid.find(".carousel-lists .carousel-comment-media-item-video");

                if(isExist(videoActive))
                {
                    videoActive.find("#file-video").trigger("play");
                }
                else
                {
                    videoItem.find("#file-video").trigger("pause");
                }
            });
        });
    };

    $(window).on('load', function(){
        mediaSlid();
    });

    wrapper.on('click', '.btn-reply-comment', function(e){
        e.preventDefault();

        $this = $(this);
        $parents = $this.parents(".comment-item-information");
        var form = $parents.find("#form-reply");
        $this.text($this.text() == 'Trả lời' ? 'Hủy bỏ' : 'Trả lời');
        $this.toggleClass('active');
        form.toggleClass('comment-show');
        form.trigger("reset");
        form.find('textarea').val('@' + $this.data('name') + ':');
        posCursor(form.find('textarea'));

        /* Turn off media when reply */
        if($this.hasClass("active"))
        {
            var media = $parents.find(".carousel-comment-media .carousel-indicators li.active");

            if(media.length)
            {
                media.trigger("click");
            }
        }
    });

    wrapper.on('click', '.btn-status-comment', function(e){
        e.preventDefault();
        $this = $(this);
        var id = $this.attr('data-id');
        var status = $this.attr('data-status');
        var newSibling = $this.attr('data-new-sibling');

        $.ajax({
            url: base_url + '?get=status',
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                id: id,
                status: status
            },
            success: function(response){
                if(response.errors)
                {
                    showNotify(response.errors, 'Thông báo', 'danger');
                }
                else
                {
                    showNotify('Cập nhật trạng thái thành công', 'Thông báo', 'success');
                    $this.parents(".comment-action").prevAll("." + newSibling).find(".comment-new").remove();
                    $this.text($this.text() == 'Duyệt' ? 'Bỏ duyệt' : 'Duyệt');
                    $this.toggleClass('btn-warning btn-primary');
                }
            }
        });
    });

    wrapper.on('click', '.btn-delete-comment', function(e){
        e.preventDefault();
        $this = $(this);
        $loadControl = $this.parents("." + $this.attr("data-parents")).find(".comment-load-more-control");
        var id = $this.attr('data-id');
        var limitFrom = parseInt($loadControl.find(".limit-from").val());
        limitFrom = (limitFrom > 0) ? limitFrom - 1 : 0;

        $.confirm({
            title: 'Thông báo',
            icon: 'fas fa-exclamation-triangle', // font awesome
            type: 'blue', // red, green, orange, blue, purple, dark
            content: 'Bạn muốn xóa bình luận này ?', // html, text
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
                    text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
                    btnClass: 'btn-blue btn-sm bg-gradient-primary',
                    action: function(){
                        $.ajax({
                            url: base_url + '?get=delete',
                            method: 'POST',
                            dataType: 'json',
                            async: false,
                            data: {
                                id: id
                            },
                            beforeSend: function(){
                                holdonOpen();
                            },
                            error: function(e){
                                holdonClose();
                                showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
                            },
                            success: function(response){
                                holdonClose();
                                
                                if(response.errors)
                                {
                                    showNotify(response.errors, 'Thông báo', 'danger');
                                }
                                else
                                {
                                    $loadControl.find(".limit-from").val(limitFrom);
                                    $this.parents('.' + $this.data('class')).remove();
                                    showNotify('Xóa bình luận thành công', 'Thông báo', 'success');

                                }
                            }
                        });
                    }
                },
                cancel: {
                    text: '<i class="fas fa-times align-middle mr-2"></i>Hủy',
                    btnClass: 'btn-red btn-sm bg-gradient-danger'
                }
            }
        });
    });

    wrapper.on('click', '.btn-cancel-reply', function(e){
        e.preventDefault();
        $this = $(this);
        $parents = $this.parents(".comment-item-information");
        var form = $parents.find("#form-reply");
        form.trigger("reset").toggleClass('comment-show');
        $parents.find(".btn-reply-comment").text('Trả lời');
    });

    wrapper.on('click', '.carousel-comment-media .carousel-indicators li', function(e){
        $this = $(this);
        $parents = $this.parents(".carousel-comment-media");
        var id = $this.data("id");
        var videoThis = $parents.find(".carousel-lists .carousel-comment-media-item-" + id);
        var videoItem = $parents.find(".carousel-lists .carousel-comment-media-item-video");

        if($this.hasClass("active"))
        {
            $parents.find(".carousel-indicators li, .carousel-lists .carousel-item").removeClass("active");
            videoItem.find("#file-video").trigger("pause");
        }
        else
        {
            $parents.find(".carousel-indicators li").removeClass("active");
            $this.addClass("active");
            $parents.find(".carousel-lists .carousel-item").removeClass("active");

            /* Video */
            videoThis.addClass("active");
            
            if(isExist(videoThis.find("#file-video")))
            {
                videoThis.find("#file-video").trigger("play");
            }
            else
            {
                videoItem.find("#file-video").trigger("pause");
            }
        }
    });

    wrapper.on('click', '.btn-load-more-comment-parent', function(e){
        e.preventDefault();
        $this = $(this);
        $loadControl = $this.parents(".comment-load-more-control");
        $loadResult = $this.parents(".comment-lists").find(".comment-load");
        var limitFrom = parseInt($loadControl.find(".limit-from").val());
        var limitGet = parseInt($loadControl.find(".limit-get").val());
        var idVariant = parseInt($loadControl.find(".id-variant").val());
        var type = $loadControl.find(".type").val();

        $.ajax({
            url: base_url + '?get=limitLists',
            method: 'GET',
            dataType: 'json',
            async: false,
            data: {
                limitFrom: limitFrom,
                limitGet: limitGet,
                idVariant: idVariant,
                type: type,
                isAdmin: 1
            },
            beforeSend: function(){
                $this.text("Đang tải ...");
                $this.attr("disabled", true);
            },
            error: function(e){
                $this.text("Tải thêm bình luận");
                $this.attr("disabled", false);
                showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
            },
            success: function(response){
                $this.text("Tải thêm bình luận");
                $this.attr("disabled", false);

                if(response.data)
                {
                    $loadResult.append(response.data);
                    $loadControl.find(".limit-from").val(limitFrom + limitGet);
                    mediaSlid();
                }

                /* Check to remove load more button */
                var listsLoaded = $loadResult.find(".comment-item").length;

                if(parseInt(listsLoaded) == parseInt(response.total))
                {
                    $loadControl.remove();
                }
            }
        });
    });

    wrapper.on('click', '.btn-load-more-comment-child', function(e){
        e.preventDefault();
        $this = $(this);
        $loadControl = $this.parents(".comment-load-more-control");
        $loadResult = $this.parents(".comment-item").find(".comment-item-information .comment-replies .comment-replies-load");
        var limitFrom = parseInt($loadControl.find(".limit-from").val());
        var limitGet = parseInt($loadControl.find(".limit-get").val());
        var idParent = parseInt($loadControl.find(".id-parent").val());
        var idVariant = parseInt($loadControl.find(".id-variant").val());
        var type = $loadControl.find(".type").val();

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
                type: type,
                isAdmin: 1
            },
            beforeSend: function(){
                $this.text("Đang tải ...");
                $this.attr("disabled", true);
            },
            error: function(e){
                $this.text("Xem thêm bình luận");
                $this.attr("disabled", false);
                showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
            },
            success: function(response){
                $this.text("Xem thêm bình luận");
                $this.attr("disabled", false);

                if(response.data)
                {
                    $loadResult.append(response.data);
                    $loadControl.find(".limit-from").val(limitFrom + limitGet);
                }

                /* Check to remove load more button */
                var listsLoaded = $loadResult.find(".comment-replies-item").length;

                if(parseInt(listsLoaded) == parseInt(response.total))
                {
                    $loadControl.remove();
                }
            }
        });
    });

    wrapper.on('submit', '#form-reply', function(e){
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        var responseEle = form.find(".response-reply");
        var content = form.find("#reply-content");
        var contentDataName = content.data('name');

        responseEle.html("");
        holdonOpen();

        setTimeout(function(){
            $.ajax({
                url: base_url + '?get=addAdmin',
                method: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'json',
                data: formData,
                async: false,
                processData: false,
                contentType: false,
                cache: false,
                error: function(e){
                    showNotify('Hệ thống bị lỗi. Vui lòng thử lại sau.', 'Thông báo', 'error');
                },
                success: function(response){
                    if(response.errors)
                    {
                        responseEle.html('<div class="alert alert-danger">' + parseResponse(response.errors) + '</div>');
                        goToByScroll(form.attr("id"));
                        holdonClose();
                    }
                    else
                    {
                        form.trigger('reset');
                        form.find("#reply-content").val(contentDataName + ' ');
                        holdonClose();
                        showNotify('Phản hồi thành công', 'Thông báo', 'success');
                    }
                }
            });
        }, 500);

        return false;
    });
};