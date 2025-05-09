function changeToSlug(slug, focus = false) {
    slug = slug.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, '');
    slug = slug.replace(/\-\-\-\-\-/gi, '');
    slug = slug.replace(/\-\-\-\-/gi, '');
    slug = slug.replace(/\-\-\-/gi, '');
    slug = slug.replace(/\-\-/gi, '');
    if (!focus) {
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    }
    slug = slug.replaceAll('-', '');
    return slug;
}! function(e) {
    "use strict";
    var t = function(t) {
            return this.each(function() {
                var n, i, a = e(this),
                    c = a.data(),
                    r = [a],
                    o = this.tagName,
                    l = 0;
                n = e.extend({
                    content: "body",
                    headings: "h1,h2,h3"
                }, {
                    content: c.toc || void 0,
                    headings: c.tocHeadings || void 0
                }, t), i = n.headings.split(","), e(n.content).find(n.headings).attr("id", function(t, n) {
                    return n || function(e) {
                        0 === e.length && (e = "?");
                        for (var t = changeToSlug(e), n = "", i = 1; null !== document.getElementById(t + n);) n = "_" + i++;
                        return (t + n).trim()
                    }(e(this).text())
                }).each(function() {
                    var t = e(this),
                        n = e.map(i, function(e, n) {
                            return t.is(e) ? n : void 0
                        })[0];
                    if (n > l) {
                        var a = r[0].children("li:last")[0];
                        a && r.unshift(e("<" + o + "/>").appendTo(a))
                    } else r.splice(0, Math.min(l - n, Math.max(r.length - 1, 0)));
                    e("<li/>").appendTo(r[0]).append(e("<a/>").text(t.text()).attr("data-rel", "#" + t.attr("id").trim())), l = n
                })
            })
        },
        n = e.fn.toc;
    e.fn.toc = t, e.fn.toc.noConflict = function() {
        return e.fn.toc = n, this
    }, e(function() {
        t.call(e("[data-toc]"))
    })
}(window.jQuery);