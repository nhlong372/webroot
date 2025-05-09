var slug_lang = "vi";
function init_slick_loai(tab_class='', tab_return='', page_per=0, table_select='', type_select='',showphantrang=1,vungchay='') {
    if(tab_class!='') {
        if($('.' + tab_class + ' a.active').length == 0) {
            $('.' + tab_class + ' a').eq(0).addClass('active');
        }
        var where_select = '' + $('.' + tab_class + ' a.active').data('id');
    }
    else {
        var where_select = '  1';
    }
    $.ajax({
        url: 'api/ajax_run_slick_loai.php',
        type: 'post',
        dataType: 'html',
        data: {id_danhmuc: 0, page_per: page_per, table_select: table_select, type_select: type_select, where_select: where_select, tab_return: tab_return,showphantrang:showphantrang,vungchay:vungchay},
    })
    .done(function(result) {
        $('.' + tab_return).html(result);
    });
}
function init_run_slick(tab_class='', tab_return='', page_per=0, table_select='', type_select='', where_select='',showphantrang=1) {
    if(tab_class!='') {
        if($('.' + tab_class + ' a.active').length == 0) {
            $('.' + tab_class + ' a').eq(0).addClass('active');
        }
        var id_danhmuc = $('.' + tab_class + ' a.active').data('id');
    
    }else{
        var id_danhmuc = 0;
    }
    //alert(showphantrang);return false;
    $.ajax({
        url: 'api/ajax_run_slick.php',
        type: 'post',
        dataType: 'html',
        data: {id_danhmuc: id_danhmuc, page_per: page_per, table_select: table_select, type_select: type_select, where_select: where_select, tab_return: tab_return,showphantrang:showphantrang},
    })
    .done(function(result) {
        $('.' + tab_return).html(result);
    });
}

function init_run_slick_cap1(a = 0, t = "", e = 0, n = "", p = "", d = "") {
    $.ajax({ url: "api/ajax_run_slick_cap1.php", type: "post", dataType: "html", data: {slug_lang:slug_lang, id_danhmuc: a, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).html(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}

function init_run_slick_cap2(tab_class='', tab_return='', page_per=0, table_select='', type_select='', where_select='',showphantrang=1) {
    if(tab_class!='') {
        if($('.' + tab_class + ' a.active').length == 0) {
            $('.' + tab_class + ' a').eq(0).addClass('active');
        }
        var id_list = $('.' + tab_class + ' a.active').data('id');
    
    }else{
        var id_list = 0;
    }
    var id_danhmuc = $('.' + tab_class + ' a.active').data('id_danhmuc');
    //alert(showphantrang);return false;
    $.ajax({
        url: 'api/ajax_run_slick_cap2.php',
        type: 'post',
        dataType: 'html',
        data: {id_danhmuc: id_danhmuc,id_list:id_list, page_per: page_per, table_select: table_select, type_select: type_select, where_select: where_select, tab_return: tab_return,showphantrang:showphantrang},
    })
    .done(function(result){
        $('.' + tab_return).html(result);
    });
}

function init_run_slick_brand(tab_class='', tab_return='', page_per=0, table_select='', type_select='', where_select='',showphantrang=1) {
    if(tab_class!='') {
        if($('.' + tab_class + ' a.active').length == 0) {
            $('.' + tab_class + ' a').eq(0).addClass('active');
        }
        var id_danhmuc = $('.' + tab_class + ' a.active').data('id');
    
    }else{
        var id_danhmuc = 0;
    }
    $.ajax({
        url: 'api/ajax_run_slick_brand.php',
        type: 'post',
        dataType: 'html',
        data: {id_danhmuc: id_danhmuc, page_per: page_per, table_select: table_select, type_select: type_select, where_select: where_select, tab_return: tab_return,showphantrang:showphantrang},
    })
    .done(function(result) {
        $('.' + tab_return).html(result);
    });
}

function init_paging_loai_more(a = "", t = "", e = 0, n = "", p = "", z = 0) {
    if ("" != a) {
        0 == $("." + a + " a.active").length &&
            $("." + a + " a")
                .eq(0)
                .addClass("active");
        var d = " and " + $("." + a + " a.active").data("id");
    } else d = " and 1";
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {viewmore: z, slug_lang:slug_lang, id_danhmuc: 0, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).append(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_paging_loai(a = "", t = "", e = 0, n = "", p = "", z = 0) {
    if ("" != a) {
        0 == $("." + a + " a.active").length &&
            $("." + a + " a")
                .eq(0)
                .addClass("active");
        var d = " and " + $("." + a + " a.active").data("id");
    } else d = " and 1";
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {viewmore: z,slug_lang:slug_lang, id_danhmuc: 0, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).html(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_paging(a = "", t = "", e = 0, n = "", p = "", d = "", z = 0) {
    if ("" != a) {
        0 == $("." + a + " a.active").length &&
            $("." + a + " a")
                .eq(0)
                .addClass("active");
        var i = $("." + a + " a.active").data("id");
    } else i = 0;
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {viewmore: z,slug_lang:slug_lang, id_danhmuc: i, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).html(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_paging_more(a = "", t = "", e = 0, n = "", p = "", d = "", z = 0) {
    if ("" != a) {
        0 == $("." + a + " a.active").length &&
            $("." + a + " a")
                .eq(0)
                .addClass("active");
        var i = $("." + a + " a.active").data("id");
    } else i = 0;
    $.ajax({ 
        url: "api/paging.php", 
        type: "post", 
        dataType: "html", 
        data: {viewmore: z,slug_lang:slug_lang, id_danhmuc: i, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).append(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_paging_category(a = 0, t = "", e = 0, n = "", p = "", d = "") {
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {slug_lang:slug_lang, id_danhmuc: a, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).html(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_paging_category_more(a = 0, t = "", e = 0, n = "", p = "", d = "", z = 1) {
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {viewmore: z, slug_lang:slug_lang, id_danhmuc: a, page_per: e, table_select: n, type_select: p, where_select: d, tab_return: t } }).done(function (a) {
        $("." + t).append(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_paging_category_list(a = 0, t = "", e = "", n = 0, p = "", d = "", i = "", z = 0) {
    if ("" != t) {
        0 == $("." + t + " a.active").length &&
            $("." + t + " a")
                .eq(0)
                .addClass("active");
        var l = $("." + t + " a.active").data("id");
    }
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {viewmore: z,slug_lang:slug_lang, id_danhmuc: a, page_per: n, table_select: p, type_select: d, where_select: i, tab_return: e, id_list: l } }).done(function (a) {
        $("." + e).html(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
}
function init_ajax_scroll(a = "", t = 0) {
    $.ajax({ url: "api/data.php", type: "post", dataType: "html", data: { page_per: t, tab_return: a } }).done(function (t) {
        $("." + a).append(t); NN_FRAMEWORK.Lazys();
    });
}
$(document).on("click", ".paging-sm a", function (a) {
    a.preventDefault();
    var t = $(this),
        e = t.attr("data-danhmuc"),
        n = t.attr("data-list"),
        p = t.attr("data-per"),
        d = t.attr("data-table"),
        i = t.attr("data-type"),
        l = t.attr("data-where"),
        c = t.attr("data-tab"),
        r = t.attr("data-page");
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {slug_lang: slug_lang, id_danhmuc: e, page_per: p, table_select: d, type_select: i, where_select: l, tab_return: c, page: r, id_list: n } }).done(function (a) {
        $("." + c).html(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
});
$(document).on("click", ".btn_viewmore a", function (a) {
    a.preventDefault();
    $(this).parent('.btn_viewmore').remove();
    var t = $(this),
        e = t.attr("data-danhmuc"),
        n = t.attr("data-list"),
        p = t.attr("data-per"),
        d = t.attr("data-table"),
        i = t.attr("data-type"),
        l = t.attr("data-where"),
        c = t.attr("data-tab"),
        r = t.attr("data-page");
    $.ajax({ url: "api/paging.php", type: "post", dataType: "html", data: {viewmore: 1, slug_lang: slug_lang, id_danhmuc: e, page_per: p, table_select: d, type_select: i, where_select: l, tab_return: c, page: r, id_list: n } }).done(function (a) {
        $("." + c).append(a); NN_FRAMEWORK.Lazys(); reloadLike(LIST_SAVED);
    });
});