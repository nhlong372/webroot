if($('#seoBox').length){
    var $menu_name = $('input[data-seo="menu_name"]');
    var $title = $('input[data-seo="title"]');
    var $description = $('[data-seo="description"]');
    var $heading = $('[data-seo="heading"]');
    var $heading_description = $('[data-seo="heading_description"]');
    var $content = $('[data-seo="content"]');
    var $seo_title = $('input[data-seo="seo_title"]');
    var $seo_keyword = $('input[data-seo="seo_keyword"]');
    var $seo_description = $('textarea[data-seo="seo_description"]');
    var $slug = $('input[data-seo="url"]');
    var $seo_title_google = $(".seo_title_google");
    var $slug_goole = $(".slug_google");
    var $seo_description_google = $(".seo_description_google");


    if ($slug.val() === "homepage" || $slug.val() === "home") {
        $slug.val("");
    }

    $("#btnCheckSeo").on("click", function(event) {
        let title = $title.val();
        let description_id = $description.attr("id");
        let description_content;
        if (CKEDITOR.instances[description_id] == undefined) {
            description_content = $description.val();
        } else {
            description_content = CKEDITOR.instances[description_id].getData();
        }

        let content_id = $content.attr("id");
        let content;
        if (CKEDITOR.instances[content_id] == undefined) {
            content = $content.val();
        } else {
            content = CKEDITOR.instances[content_id].getData();
        }
        //alert(content);return false;
        let seo_title = $seo_title.val();
        let seo_keyword = $seo_keyword.val();
        let seo_description = $seo_description.val();
        let url = $slug.val();
        let heading = $('input[data-seo="heading"]').val();
        let heading_description = $heading_description.val();
        let result;
        if (heading == null || heading == undefined) {
            WBSeo.checkSeoDetailPage({
                title: title,
                description: description_content,
                content: content,
                seo_title: seo_title,
                seo_keyword: seo_keyword,
                seo_description: seo_description,
                url: url
            }).then(function(result) {
                showSeoResult(result);
            });
        } else {
            result = WBSeo.checkSeoMenuPage({
                seo_title: seo_title,
                seo_keyword: seo_keyword,
                seo_description: seo_description,
                url: url,
                heading: heading,
                heading_description: heading_description
            }).then(function(result) {
                showSeoResult(result);
            });
        }
    });
    // view wb.checkSeo.js, check document description
    var showRecommendedKeywordAppearTime = recommendedAppearTime => {
        if (recommendedAppearTime < 0) {
            recommendedAppearTime = 1;
        }
        let html = `<span class="keyword-suggestion"> (Bạn nên rải từ khóa trung bình ${parseInt(
            recommendedAppearTime
        )} lần trong đoạn này)</span>`;
        $(document)
            .find(".keyword-suggestion")
            .remove();
        setTimeout(() => {
            // keyword suggestion will be appended after seo result
            $('textarea[data-seo="content"]')
                .parent()
                .append(html);
        }, 200);
    };
    // view wb.checkSeo.js, check document description
    var clearRecommendedKeywordAppearTime = () => {
        $(".recommended-keyword-appear-time-label").html("");
    };
    var showSeoResult = function(result) {
        $(document)
            .find(".seo_result")
            .remove();
        $(document)
            .find(".help-block")
            .html("");
        Object.keys(result).forEach(function(key) {
            $('[data-seo="' + key + '"]')
                .closest('.form-group')
                .append(result[key]);
        });
        $(result.final_result).appendTo("#finalResult");
    };

    $seo_keyword.on("focusout", function() {
        if ($seo_keyword.val().trim().length > 0) {
            var kw = $seo_keyword.val().split(",")[0];
            createSlugFromKeyword(kw.trim());
            createRelatedFromKeyword(kw.trim());
        }
    });

    $seo_title.on("keydown", function() {
        let seo_title = $(this).val();
        if (seo_title.length > 70) {
            $('.err_title').html('Bạn đã nhập quá 70 kí tự.');           
        }else{
            $('.err_title').html('');
        }
    });

    $seo_title.on("keyup", function() {
        let seo_title = $(this).val();
        $("#count_meta_title").html(seo_title.length);
        let seo_title_google =
            "Tiêu đề seo website không vượt quá 70 kí tự (tốt nhất từ 60-70 kí tự)";        
        if (seo_title) {
            seo_title_google = seo_title;
        }
        if (seo_title_google.length > 70) {
            seo_title_google = seo_title_google.substr(0, 67) + "...";
        }
        $seo_title_google.html(seo_title_google);
    });

    $seo_description.on("keydown", function() {
        let seo_description = $(this).val();       
        if (seo_description.length > 160) {
            $('.err_des').html('Bạn đã nhập quá 160 kí tự.');           
        }else{
            $('.err_des').html('');
        }
    });

    $seo_description.on("keyup", function() {
        let seo_description = $(this).val();
        $("#count_meta_description").html(seo_description.length);
        let seo_description_google =
            "Mô tả seo website không vượt quá 160 kí tự. Là những đoạn mô tả ngắn gọn về website, bài viết...";        
        if (seo_description) {
            seo_description_google = seo_description;
        }
        if (seo_description_google.length > 160) {
            seo_description_google = seo_description_google.substr(0, 160);
        }
        $seo_description_google.html(seo_description_google);
    });

    function createSlugFromKeyword(keyword) {
        if (isNotChangeSlug) {
            let old_slug = $slug.val();
            let slug = keyword
                .toLowerCase()
                .trim()
                .replace(/&/g, "-and-")
                .replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, "a")
                .replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, "e")
                .replace(/(ì|í|ị|ỉ|ĩ)/g, "i")
                .replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, "o")
                .replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, "u")
                .replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, "y")
                .replace(/(đ)/g, "d")
                .replace(/[^a-z0-9-]+/g, "-")
                .replace(/\-\-+/g, "-")
                .replace(/^-+|-+$/g, "");

            if (old_slug != slug) {
                $slug.val(slug);
                $slug.trigger("change");
            }
        }
    }



    function generateSEO() {
        $seo_title.val($title.val());
        $seo_title.trigger("keyup");

        let description_id = $description.attr("id");
        let description_content;
        if (CKEDITOR.instances[description_id] == undefined) {
            description_content = $description.val();
        } else {
            description_content = CKEDITOR.instances[description_id].getData();
            description_content = $(description_content).text();
        }
        $seo_description.val(description_content);
        $seo_description.trigger("keyup");
        swal.close();
    }
    $("#generate_seo").click(function() {
        if ($seo_title.val() || $seo_description.val()) {
            warningSwal(
                {
                    title:
                        "Nội dung SEO đã có sẵn, bạn có chắc chắn thay đổi không ?"
                },
                generateSEO
            );
        } else {
            generateSEO();
        }
    });

    var isNotChangeSlug = $slug.val() === "" ? true : false;
    var isNotChangeTite = $title.val() === "" ? true : false;
    var isNotChangeHeading = $heading.val() === "" ? true : false;
    var isNotChangeMenuName = $menu_name.val() === "" ? true : false;
    var isNotChangeSeoTite = $seo_title.val() === "" ? true : false;
    var isNotChangeSeoDescription = $seo_description.val() === "" ? true : false;

    $title.change(function() {
        if (isNotChangeSeoTite) {
            $seo_title.val($title.val());
            $seo_title.trigger("keyup");
        }

        if ($(this).val() === "") {
            isNotChangeTite = true;
            return;
        }
        isNotChangeTite = false;
    });
    $menu_name.change(function() {
        if ($(this).val() === "") {
            isNotChangeMenuName = true;
            return;
        }
        isNotChangeMenuName = false;
    });
    $seo_title.change(function() {
        if ($(this).val() === "") {
            isNotChangeSeoTite = true;
            return;
        }
        isNotChangeSeoTite = false;
    });
    $seo_description.change(function() {
        if ($(this).val() === "") {
            isNotChangeSeoDescription = true;
            return;
        }
        isNotChangeSeoDescription = false;
    });
    $heading_description.on("change", function() {
        if (isNotChangeSeoDescription) {
            $seo_description.val($(this).val());
            $seo_description.trigger("keyup");
        }
    });
    if (CKEDITOR.instances[$description.attr("id")] == undefined) {
        $description.on("change", function() {
            if (isNotChangeSeoDescription) {
                $seo_description.val($(this).val());
                $seo_description.trigger("keyup");
            }
        });
    } else {
        CKEDITOR.instances[$description.attr("id")].on("change", function() {
            if (isNotChangeSeoDescription) {
                let description_content = CKEDITOR.instances[
                    $description.attr("id")
                ].getData();
                $seo_description.val($(description_content).text());
                $seo_description.trigger("keyup");
            }
        });
    }

    function createRelatedFromKeyword(keyword) {
        if (isNotChangeTite) {
            $title.val(keyword.charAt(0).toUpperCase() + keyword.slice(1));
        }

        if (isNotChangeHeading) {
            $heading.val(keyword.charAt(0).toUpperCase() + keyword.slice(1));
        }

        if (isNotChangeMenuName) {
            $menu_name.val(keyword.charAt(0).toUpperCase() + keyword.slice(1));
        }

        if (isNotChangeSeoTite) {
            $seo_title.val(keyword.charAt(0).toUpperCase() + keyword.slice(1));
            $seo_title.trigger("keyup");
        }
    }

    function initSEO() {
        $seo_title.trigger("keyup");
        $seo_description.trigger("keyup");
        $slug_goole.html($slug.val());
    }
    initSEO();
}
