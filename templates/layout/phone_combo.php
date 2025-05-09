<link rel="stylesheet" href="assets/arcontactus/arcontactus.css" type="text/css" media="all">
<script src="assets/arcontactus/arcontactus.js"></script>
<script>
    //<![CDATA[
    var arCuMessages = [];
    var arCuLoop = false;
    var arCuCloseLastMessage = false;
    var arCuPromptClosed = false;
    var _arCuTimeOut = null;
    var arCuDelayFirst = 2000;
    var arCuTypingTime = 2000;
    var arCuMessageTime = 4000;
    var arCuClosedCookie = 0;
    var arcItems = [];
    window.addEventListener('load', function() {
        // arCuClosedCookie = arCuGetCookie('arcu-closed');
        jQuery('#arcontactus').on('arcontactus.init', function() {
            if (arCuClosedCookie) {
                return false;
            }
            arCuShowMessages();

        });
        jQuery('#arcontactus').on('arcontactus.openMenu', function() {
            clearTimeout(_arCuTimeOut);
            arCuPromptClosed = true;
            jQuery('#contact').contactUs('hidePrompt');
            arCuCreateCookie('arcu-closed', 1, 30);
        });
        jQuery('#arcontactus').on('arcontactus.hidePrompt', function() {
            clearTimeout(_arCuTimeOut);
            arCuPromptClosed = true;
            arCuCreateCookie('arcu-closed', 1, 30);
        });
        var arcItem = {};
        arcItem.id = 'msg-item-1';
        arcItem.class = 'msg-item-facebook-messenger';
        arcItem.title = 'Messenger';
        arcItem.icon =
            '<svg xmlns="//www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 32C15.9 32-77.5 278 84.6 400.6V480l75.7-42c142.2 39.8 285.4-59.9 285.4-198.7C445.8 124.8 346.5 32 224 32zm23.4 278.1L190 250.5 79.6 311.6l121.1-128.5 57.4 59.6 110.4-61.1-121.1 128.5z"></path></svg>';
        arcItem.href = 'https://fb.com/msg/<?=$optsetting['messenger']?>/?ref=page_internal'; <?php /*<?=$optsetting['fanpage']?>*/?>
        arcItem.color = '#02a2ff';
        arcItems.push(arcItem);
        var arcItem = {};
        arcItem.id = 'msg-item-9';
        arcItem.class = 'msg-item-telegram-plane';
        arcItem.title = 'Zalo Chat';
        arcItem.icon =
            "<svg id='Layer_1' xmlns='//www.w3.org/2000/svg' viewBox='0 0 460.1 436.6'><path fill='currentColor' class='st0' d='M82.6 380.9c-1.8-.8-3.1-1.7-1-3.5 1.3-1 2.7-1.9 4.1-2.8 13.1-8.5 25.4-17.8 33.5-31.5 6.8-11.4 5.7-18.1-2.8-26.5C69 269.2 48.2 212.5 58.6 145.5 64.5 107.7 81.8 75 107 46.6c15.2-17.2 33.3-31.1 53.1-42.7 1.2-.7 2.9-.9 3.1-2.7-.4-1-1.1-.7-1.7-.7-33.7 0-67.4-.7-101 .2C28.3 1.7.5 26.6.6 62.3c.2 104.3 0 208.6 0 313 0 32.4 24.7 59.5 57 60.7 27.3 1.1 54.6.2 82 .1 2 .1 4 .2 6 .2H290c36 0 72 .2 108 0 33.4 0 60.5-27 60.5-60.3v-.6-58.5c0-1.4.5-2.9-.4-4.4-1.8.1-2.5 1.6-3.5 2.6-19.4 19.5-42.3 35.2-67.4 46.3-61.5 27.1-124.1 29-187.6 7.2-5.5-2-11.5-2.2-17.2-.8-8.4 2.1-16.7 4.6-25 7.1-24.4 7.6-49.3 11-74.8 6zm72.5-168.5c1.7-2.2 2.6-3.5 3.6-4.8 13.1-16.6 26.2-33.2 39.3-49.9 3.8-4.8 7.6-9.7 10-15.5 2.8-6.6-.2-12.8-7-15.2-3-.9-6.2-1.3-9.4-1.1-17.8-.1-35.7-.1-53.5 0-2.5 0-5 .3-7.4.9-5.6 1.4-9 7.1-7.6 12.8 1 3.8 4 6.8 7.8 7.7 2.4.6 4.9.9 7.4.8 10.8.1 21.7 0 32.5.1 1.2 0 2.7-.8 3.6 1-.9 1.2-1.8 2.4-2.7 3.5-15.5 19.6-30.9 39.3-46.4 58.9-3.8 4.9-5.8 10.3-3 16.3s8.5 7.1 14.3 7.5c4.6.3 9.3.1 14 .1 16.2 0 32.3.1 48.5-.1 8.6-.1 13.2-5.3 12.3-13.3-.7-6.3-5-9.6-13-9.7-14.1-.1-28.2 0-43.3 0zm116-52.6c-12.5-10.9-26.3-11.6-39.8-3.6-16.4 9.6-22.4 25.3-20.4 43.5 1.9 17 9.3 30.9 27.1 36.6 11.1 3.6 21.4 2.3 30.5-5.1 2.4-1.9 3.1-1.5 4.8.6 3.3 4.2 9 5.8 14 3.9 5-1.5 8.3-6.1 8.3-11.3.1-20 .2-40 0-60-.1-8-7.6-13.1-15.4-11.5-4.3.9-6.7 3.8-9.1 6.9zm69.3 37.1c-.4 25 20.3 43.9 46.3 41.3 23.9-2.4 39.4-20.3 38.6-45.6-.8-25-19.4-42.1-44.9-41.3-23.9.7-40.8 19.9-40 45.6zm-8.8-19.9c0-15.7.1-31.3 0-47 0-8-5.1-13-12.7-12.9-7.4.1-12.3 5.1-12.4 12.8-.1 4.7 0 9.3 0 14v79.5c0 6.2 3.8 11.6 8.8 12.9 6.9 1.9 14-2.2 15.8-9.1.3-1.2.5-2.4.4-3.7.2-15.5.1-31 .1-46.5z'></path></svg>";
        arcItem.href = 'https://zalo.me/<?= preg_replace('/[^0-9]/', '', $optsetting['zalo']); ?>';
        arcItem.color = '#0180c7';
        arcItems.push(arcItem);
        /*var arcItem = {};
        arcItem.id = 'msg-item-6';
        arcItem.class = 'msg-item-skype';
        arcItem.title = 'Skype Chat';
        arcItem.icon = '<svg xmlns="//www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.7 299.8c2.9-14 4.7-28.9 4.7-43.8 0-113.5-91.9-205.3-205.3-205.3-14.9 0-29.7 1.7-43.8 4.7C161.3 40.7 137.7 32 112 32 50.2 32 0 82.2 0 144c0 25.7 8.7 49.3 23.3 68.2-2.9 14-4.7 28.9-4.7 43.8 0 113.5 91.9 205.3 205.3 205.3 14.9 0 29.7-1.7 43.8-4.7 19 14.6 42.6 23.3 68.2 23.3 61.8 0 112-50.2 112-112 .1-25.6-8.6-49.2-23.2-68.1zm-194.6 91.5c-65.6 0-120.5-29.2-120.5-65 0-16 9-30.6 29.5-30.6 31.2 0 34.1 44.9 88.1 44.9 25.7 0 42.3-11.4 42.3-26.3 0-18.7-16-21.6-42-28-62.5-15.4-117.8-22-117.8-87.2 0-59.2 58.6-81.1 109.1-81.1 55.1 0 110.8 21.9 110.8 55.4 0 16.9-11.4 31.8-30.3 31.8-28.3 0-29.2-33.5-75-33.5-25.7 0-42 7-42 22.5 0 19.8 20.8 21.8 69.1 33 41.4 9.3 90.7 26.8 90.7 77.6 0 59.1-57.1 86.5-112 86.5z"></path></svg>';
        arcItem.href = 'skype://<?= $optsetting['hotline'] ?>?chat';
        arcItem.color = '#1C9CC5';
        arcItems.push(arcItem);*/
        var arcItem = {};
        arcItem.id = 'msg-item-7';
        arcItem.class = 'msg-item-envelope';
        arcItem.title = 'Gửi Email';
        arcItem.icon =
            '<svg  xmlns="//www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z"></path></svg>';
        arcItem.href = 'mailto:<?= $optsetting['email'] ?>';
        arcItem.color = '#d7473b';
        arcItems.push(arcItem);
        var arcItem = {};
        arcItem.id = 'msg-item-8';
        arcItem.class = 'msg-item-phone';
        arcItem.title = 'Call <?= $optsetting['hotline'] ?>';
        arcItem.icon = '<i class="fas fa-phone"></i>';
        arcItem.href = 'tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>';
        arcItem.color = '#4EB625';
        arcItems.push(arcItem);

        var arcItem = {};
        arcItem.id = 'msg-item-9';
        arcItem.class = 'msg-item-chiduong';
        arcItem.title = 'Bản đồ';
        arcItem.icon = '<img src="assets/images/maps.png" alt="Chỉ đường">';//worldwide-location--v2
        arcItem.href = '<?= $optsetting['map'] ?>';
        arcItem.color = '#FFCE00';
        arcItems.push(arcItem);

        jQuery('#arcontactus').contactUs({
            items: arcItems
        });
    });
    //]]>
</script>

<div id='arcontactus'></div>

<div class="quick_contact">
    <a class="button_gradient" href="tel:<?= preg_replace('/[^0-9]/', '', $optsetting['hotline']); ?>">
        <span class="button_gradient"><i class="fas fa-phone"></i></span>
        <p class="contact-phone"><?= $optsetting['hotline']; ?></p>
    </a>
</div>