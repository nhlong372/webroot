<!-- Js Config -->
<script type="text/javascript">
    var NN_FRAMEWORK = NN_FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var JS_AUTOPLAY = <?= ($_SERVER["SERVER_NAME"] != "localhost") ? 'true' : 'false' ?>;
    var ASSET = '<?= ASSET ?>';
    var WEBSITE_NAME = '<?= (!empty($setting['name' . $lang])) ? addslashes($setting['name' . $lang]) : '' ?>';
    var TIMENOW = '<?= date("d/m/Y", time()) ?>';
    var SHIP_CART = <?= (!empty($config['order']['ship'])) ? 'true' : 'false' ?>;
    var RECAPTCHA_ACTIVE = <?= (!empty($config['googleAPI']['recaptcha']['active'])) ? 'true' : 'false' ?>;
    var RECAPTCHA_SITEKEY = '<?= $config['googleAPI']['recaptcha']['sitekey'] ?>';
    var GOTOP = ASSET + 'assets/images/ico-top.png';
    var LANG = {
        'no_keywords': '<?= chuanhaptukhoatimkiem ?>',
        'delete_product_from_cart': '<?= banmuonxoasanphamnay ?>',
        'no_products_in_cart': '<?= khongtontaisanphamtronggiohang ?>',
        'ward': '<?= phuongxa ?>',
        'back_to_home': '<?= vetrangchu ?>',
    };
    var LIST_SAVED = '';
    var CARTSITE = '<?= (CARTSITE) ? 'true' : 'false' ?>';
    var TIMEMAX = '<?= date("d/m/Y H:i", time() + 31536000) ?>';
    var PHONENUMBER = '<?= $optsetting['hotline'] ?>';
    var ZALO = '<?= $optsetting['zalo'] ?>';
    var SOURCE = '<?= ($source == 'index') ? "index" : "" ?>';
</script>
<!-- Js Files -->
<?php
$js->set("js/jquery.min.js");
//$js->set("js/jquery2.min.js");
$js->set("js/lazyload.min.js");
$js->set("js/pagingnation.js");
$js->set("bootstrap/bootstrap.js");
$js->set("js/wow.min.js");
$js->set("confirm/confirm.js");
$js->set("holdon/HoldOn.js");
//$js->set("easyticker/easy-ticker.js");
$js->set("fotorama/fotorama.js");
$js->set("slick/slick.js");
$js->set("fancybox3/jquery.fancybox.js");
$js->set("photobox/photobox.js");
// $js->set("simplenotify/simple-notify.js");
// $js->set("fileuploader/jquery.fileuploader.min.js");
//$js->set("datetimepicker/php-date-formatter.min.js");
//$js->set("datetimepicker/jquery.mousewheel.js");
// $js->set("datetimepicker/jquery.datetimepicker.js");
$js->set("js/functions.js");
if (SHOWCOMMENT) {
    $js->set("js/comment.js");
}
$js->set("js/toc.js");
$js->set("js/apps.js");
echo $js->get();
?>
<?php if ($source != 'index') { ?>
    <script src="assets/magiczoomplus/magiczoomplus.js"></script>
    <script src="assets/owlcarousel2/owl.carousel.js"></script>
    <script src="assets/js/apps_nothome.js"></script>
    <?php if ($id != '' || $template == 'static/static') { ?>
        <script src="//sp.zalo.me/plugins/sdk.js"></script>
        <script async src="https://static.addtoany.com/menu/page.js"></script>
        <?php /* css icon màu đen
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-547d33901b6ed4a0"></script>
    */ ?>
    <?php } ?>
<?php } ?>
<?php if (CARTSITE == true) { ?>
    <script src="assets/js/function_cart.js"></script>
<?php } ?>
<?php if ($source == 'index') { ?>
    <?php /*<script type="text/javascript">
        $(document).ready(function(e) {
            $('.bix-l > ul > li').hover(function() {
                var vitri = $(this).position().top;
                $('.bix-l  ul  li  ul.ul_cap2').css({
                    'top': vitri + 'px'
                })
            });
        });
    </script>*/ ?>
    <script>
        $(document).ready(function() {
            /* Demo sản phẩm nổi bật */
            init_paging('', 'page_noibat', 4, 'product', 'san-pham', "and find_in_set('noibat',status)");
            /* Demo sản phẩm nổi bật */

            /* Demo sản phẩm nổi bật theo từng danh mục cấp 1 */
            <?php /*foreach ($splistmenu as $k => $v) {
                $product_id = $func->get_product_id('noibat', 'san-pham', 'id_list', $v['id'], 2);
                if ($product_id) {
            ?>
                    init_paging_category('<?= $v['id'] ?>', 'page_danhmuc<?= $v['id'] ?>', 4, 'product', 'san-pham', "and find_in_set('noibat',status)");
            <?php }
            }*/ ?>
            /* Demo sản phẩm nổi bật theo từng danh mục cấp 1 */

            /* Demo sản phẩm nổi bật theo tab danh mục cấp 1 */
            /*$(document).on('click', '.list_sanpham a', function(event) {
                event.preventDefault();
                $(this).parent('.list_sanpham').find('a').removeClass('active');
                $(this).addClass('active');
                init_paging('list_sanpham', 'page_sanpham', 4, 'product', 'san-pham', "and find_in_set('noibat',status)");
            });
            init_paging('list_sanpham', 'page_sanpham', 4, 'product', 'san-pham', "and find_in_set('noibat',status)");*/
            /* Demo sản phẩm nổi bật theo tab danh mục cấp 1 */

            /* Demo sản phẩm theo tab cố định */
            /*$(document).on('click', '.list_tab a', function(event) {
                event.preventDefault();
                $(this).parent('.list_tab').find('a').removeClass('active');
                $(this).addClass('active');
                init_paging_loai('list_tab', 'page_tabloai', 4, 'product', 'san-pham');
            });
            init_paging_loai('list_tab', 'page_tabloai', 4, 'product', 'san-pham');*/
            /* Demo sản phẩm theo tab cố định */

            /* Demo sản phẩm nổi bật theo từng danh mục cấp 1 & 2 */
            <?php /*foreach ($splistmenu as $key => $value) {
                $product_id = $func->get_product_id('noibat','san-pham','id_list',$v1['id'],2);
                if($product_id){
                 ?>
                init_paging_category_list('<?=$value['id']?>', 'list_<?=$value['id']?>', 'page_danhmuc_list<?=$value['id']?>', 4, 'product', 'san-pham', "and find_in_set('noibat',status)");
                $(document).on('click', '.list_<?=$value['id']?> a', function(event) {
                    event.preventDefault();
                    $(this).parent('.list_<?=$value['id']?>').find('a').removeClass('active');
                    $(this).addClass('active');
                    init_paging_category_list('<?=$value['id']?>', 'list_<?=$value['id']?>', 'page_danhmuc_list<?=$value['id']?>', 4, 'product', 'san-pham', "and find_in_set('noibat',status)");
                });
            <?php } }*/ ?>
            /* Demo sản phẩm nổi bật theo từng danh mục cấp 1 & 2 */
        });
    </script>

    <?php /* Demo sản phẩm xem them */ ?>
    <script>
        $(document).ready(function() {
            /* Demo sản phẩm nổi bật xem thêm */
            init_paging_more('', 'page_noibat_more', 8, 'product', 'san-pham', "and find_in_set('noibat',status)", 1);
            /* Demo sản phẩm nổi bật xem thêm */

            /* Demo sản phẩm nổi bật theo từng danh mục cấp 1 xem thêm */
            <?php /*foreach ($splistmenu as $k => $v) { ?>
                init_paging_category_more('<?=$v['id']?>', 'page_danhmuc_more<?=$v['id']?>', 4, 'product', 'san-pham', "and find_in_set('noibat',status)", 1);
            <?php }*/ ?>
            /* Demo sản phẩm nổi bật theo từng danh mục cấp 1 xem thêm */

            /*  Sản phẩm theo tab danh mục cap 1 xem thêm */
            /*$(document).on('click', '.list_sanpham_more a', function(event) {
                event.preventDefault();
                $(this).parent('.list_sanpham_more').find('a').removeClass('active');
                $(this).addClass('active');
                $('.page_sanpham_more').empty();
                init_paging_more('list_sanpham_more', 'page_sanpham_more', 4, 'product', 'san-pham', "and find_in_set('noibat',status)", 1);
            });
            init_paging_more('list_sanpham_more', 'page_sanpham_more', 4, 'product', 'san-pham', "and find_in_set('noibat',status)", 1);*/
            /*  Sản phẩm theo tab danh mục cap 1 xem thêm */

            /* Demo sản phẩm theo tab cố định xem thêm */
            /*$(document).on('click', '.list_tab_more a', function(event) {
                event.preventDefault();
                $(this).parent('.list_tab_more').find('a').removeClass('active');
                $(this).addClass('active');
                $('.page_tabloai_more').empty();
                init_paging_loai_more('list_tab_more', 'page_tabloai_more', 4, 'product', 'san-pham', 1);
            });
            init_paging_loai_more('list_tab_more', 'page_tabloai_more', 4, 'product', 'san-pham', 1);*/
            /* Demo sản phẩm theo tab cố định xem thêm */
        });
    </script>

    <?php /* Demo sản phẩm chay slick */ ?>
    <script>
        $(document).ready(function() {
            /* Slick theo tab loai */
            $(document).on('click', '.list_tab_slick a', function(event) {
                event.preventDefault();
                $(this).parent('.list_tab_slick').find('a').removeClass('active');
                $(this).addClass('active');
                init_slick_loai('list_tab_slick', 'page_tabloai_slick', 40, 'product', 'san-pham', 1, 'loai_noibat');
            });
            init_slick_loai('list_tab_slick', 'page_tabloai_slick', 40, 'product', 'san-pham', 1, 'loai_noibat');
            /* Slick theo tab loai */

            /* Slick theo từng danh mục cấp 1 */
            <?php /*foreach ($splistnb as $k => $v) {
                $product_id = $func->get_product_id('noibat', 'san-pham', 'id_list', $v['id'], 2);
                if ($product_id) {
            ?>
                    init_run_slick_cap1('<?= $v['id'] ?>', 'page_slick_danhmuc<?= $v['id'] ?>', 40, 'product', 'san-pham', "noibat", 1);
            <?php }
            }*/ ?>

            /* Chạy slick theo tab cap 1 */
            /*$(document).on('click', '.list_slick a', function(event) {
                event.preventDefault();
                $(this).parent('.list_slick').find('a').removeClass('active');
                $(this).addClass('active');
                init_run_slick('list_slick', 'page_slick', 15, 'product', 'san-pham', 'noibat',1);
            });
            init_run_slick('list_slick', 'page_slick', 15, 'product', 'san-pham', 'noibat',1);*/
            /* Chạy slick theo tab cap 1 */

            /* Chạy slick theo tab cap 2 */
            <?php /*foreach ($splistmenu as $k => $v1) {?>
            $(document).on('click', '.list_slick_cat<?=$v1['id']?> a', function(event) {
                event.preventDefault();
                $(this).parent('.list_slick_cat<?=$v1['id']?>').find('a').removeClass('active');
                $(this).addClass('active');
                init_run_slick_cap2('list_slick_cat<?=$v1['id']?>', 'page_slick_cat<?=$v1['id']?>', 15, 'product', 'san-pham', 'noibat',1,<?=$v1['id']?>);
            });
            init_run_slick_cap2('list_slick_cat<?=$v1['id']?>', 'page_slick_cat<?=$v1['id']?>', 15, 'product', 'san-pham', 'noibat',1,<?=$v1['id']?>);
            <?php }*/ ?>
            /* Chạy slick theo tab cap 2 */

            /* Chạy slick theo tab thương hiệu */
            /*$(document).on('click', '.list_tab_brand a', function(event) {
                event.preventDefault();
                $(this).parent('.list_tab_brand').find('a').removeClass('active');
                $(this).addClass('active');
                init_run_slick_brand('list_tab_brand', 'page_slick_thuonghieu', 40, 'product', 'san-pham', 'noibat',1);
            });
            init_run_slick_brand('list_tab_brand', 'page_slick_thuonghieu', 40, 'product', 'san-pham', 'noibat',1);*/
            /* Chạy slick theo tab thương hiệu */

        });
    </script>

<?php } ?>
<?php if (!empty($config['googleAPI']['recaptcha']['active'])) { ?>
    <!-- Js Google Recaptcha V3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?= $config['googleAPI']['recaptcha']['sitekey'] ?>"></script>
    <script type="text/javascript">
        grecaptcha.ready(function() {
            /*báo giá*/
            /*document.getElementById('form-baogia').addEventListener("submit", function(event) {
                    event.preventDefault();
                    generateCaptcha('baogia', 'recaptchaResponseContact', 'form-baogia');
                }, false);*/

            /* Newsletter */
            document.getElementById('form-newsletter').addEventListener("submit", function(event) {
                event.preventDefault();
                generateCaptcha('Newsletter', 'recaptchaResponseNewsletter', 'form-newsletter');
            }, false);

            <?php if ($source == 'contact') { ?>
                /* Contact */
                document.getElementById('form-contact').addEventListener("submit", function(event) {
                    event.preventDefault();
                    generateCaptcha('contact', 'recaptchaResponseContact', 'form-contact');
                }, false);
            <?php } ?>
        });
    </script>
<?php } ?>

<?php if (!empty($config['oneSignal']['active'])) { ?>
    <!-- Js OneSignal -->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script type="text/javascript">
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "<?= $config['oneSignal']['id'] ?>"
            });
        });
    </script>
<?php } ?>
<!-- Js Structdata -->
<?php include TEMPLATE . LAYOUT . "strucdata.php"; ?>
<!-- Js Addons -->
<?= $addons->set('script-main', 'script-main', 2); ?>
<?= $addons->get(); ?>
<!-- Js Body -->
<?= $func->decodeHtmlChars($setting['bodyjs']) ?>
<?php if (!COPYSITE) { ?>
    <!-- Chống Copy -->
    <script type="text/javascript">
        function clickIE() {
            if (document.all) {
                (message);
                return false;
            }
        }

        function clickNS(e) {
            if (document.layers || (document.getElementById && !document.all)) {
                if (e.which == 2 || e.which == 3) {
                    return false;
                }
            }
        }
        if (document.layers) {
            document.captureEvents(Event.MOUSEDOWN);
            document.onmousedown = clickNS;
        } else {
            document.onmouseup = clickNS;
            document.oncontextmenu = clickIE;
            document.onselectstart = clickIE
        }
        document.oncontextmenu = new Function("return false")
    </script>
    <script type="text/javascript">
        function disableselect(e) {
            return false
        }

        function reEnable() {
            return true
        }
        document.onselectstart = new Function("return false")
        if (window.sidebar) {
            document.onmousedown = disableselect
            document.onclick = reEnable
        }
    </script>
    <script>
        $(document).keydown(function(event) {
            if (event.keyCode == 123) {
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
                return false;
            } else if (event.ctrlKey && event.keyCode == 85) {
                return false;
            }
        });
    </script>
<?php } ?>
<!-- Sản phẩm yêu thích -->
<?php if (isset($_SESSION['list_saved']) and $_SESSION['list_saved'] != '') { ?>
    <script>
        var LIST_SAVED = <?php echo json_encode(array_column(json_decode($_SESSION['list_saved'], true), 'id')) ?>;
        reloadLike(LIST_SAVED);
    </script>
<?php } ?>
<?php /*if(count($chinhanh)>0){ ?>
<script>
    $(document).ready(function(e) {            
            var id_item = ''; 
            $(".item-ht").click(function(){
                $('.item-ht').removeClass('act-item');
                id_item = $(this).data('id');
                $(this).addClass('act-item');
                xuly();                                                 
            });
            function xuly(){
                $.ajax({
                    url: 'api/ajax_bando.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {id_item: id_item},                       
                    beforeSend: function(){
                        $("#loading").fadeIn(600);
                    },
                    success: function(result){
                        $("#loading").fadeOut(600);
                        $('.ht-right').html(result);                                        
                        return false;
                    }
                })              
            }           
    });
</script>
<?php }*/ ?>

<?php /*
 <script type="text/javascript">
   $(document).ready(function(e) {
        $(document).on('click', '.sty_list', function(event) {
            var vitri = $(this).data('vitri');
            if($(this).hasClass('act')){
                // $(".load"+vitri).removeClass('mo');
                // $(".load"+vitri).addClass('dong');
                $(this).removeClass('act');
            } else {
                $(".container_load_info").removeClass('mo');
                $(".container_load_info").addClass('dong');
                $(".load"+vitri).removeClass('dong');
                $(".load"+vitri).addClass('mo');            
                $('.sty_list').removeClass('act');
                $(this).addClass('act');
                
            }
        });
   });
</script>
 */ ?>

<?php /* <script>
    $(document).ready(function() {
        $('#date-newsletter').datetimepicker({
            timepicker: false,
            format: 'd/m/Y',
            formatDate: 'd/m/Y H:i',
            minDate: TIMENOW,
            maxDate: TIMEMAX
        });
    });
</script> -->

<!-- <script>
    function GTranslateFireEvent(e,a){try{if(document.createEvent){var n=document.createEvent("HTMLEvents");n.initEvent(a,!0,!0),e.dispatchEvent(n)}else{var n=document.createEventObject();e.fireEvent("on"+a,n)}}catch(t){}}function doGoogleLanguageTranslator(e){if(e.value&&(e=e.value),""!=e){for(var a,n=e,t=document.getElementsByTagName("select"),l=0;l<t.length;l++)"goog-te-combo"==t[l].className&&(a=t[l]);null==document.getElementById("google_language_translator")||0==document.getElementById("google_language_translator").innerHTML.length||0==a.length||0==a.innerHTML.length?setTimeout(function(){doGoogleLanguageTranslator(e)},100):(a.value=n,GTranslateFireEvent(a,"change"),GTranslateFireEvent(a,"change"))}}function GoogleLanguageTranslatorInit(){new google.translate.TranslateElement({pageLanguage:"vi",autoDisplay:!1},"google_language_translator")}function readCookie(e){var a,n,t=document.cookie.split("; "),l={};for(a=t.length-1;a>=0;a--)l[(n=t[a].split("="))[0]]=n[1];return l[e]}if($(document).ready(function(){$(".lang-header-main").click(function(){$(".lang-header-ul").hasClass("active")?($(".lang-header-ul").removeClass("active"),$(".lang-header-ul").hide()):($(".lang-header-ul").addClass("active"),$(".lang-header-ul").show())}),$(".lang-header-ul li").click(function(){$(".lang-header-main strong").html($(this).html()),$(".lang-header-ul").removeClass("active")})}),$(window).load(function(){$("h1.title.gray").remove()}),readCookie("googtrans")){var e=readCookie("googtrans");e=e.split("/vi/"),$(".lang-header-main strong").html($(".lang-"+e[1]).html())}
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit"></script> */ ?>