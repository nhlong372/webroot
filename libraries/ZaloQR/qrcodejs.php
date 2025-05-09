<?php for ($i = 0; $i < $config['setting']['soqrzalo']; $i++) {
    if ($optsetting['codezalo' . $i] != '') { ?>
        <script type="text/javascript">
            var zalo_acc = {
                "<?= preg_replace('/[^0-9]/', '', $optsetting['zalo']); ?>": "<?= $optsetting['codezalo' . $i] ?>",
            };

            function devvnCheckLinkAvailability(link, successCallback, errorCallback) {
                var hiddenIframe = document.querySelector("#hiddenIframe");
                if (!hiddenIframe) {
                    hiddenIframe = document.createElement("iframe");
                    hiddenIframe.id = "hiddenIframe";
                    hiddenIframe.style.display = "none";
                    document.body.appendChild(hiddenIframe);
                }
                var timeout = setTimeout(function() {
                    errorCallback("Link is not supported.");
                    window.removeEventListener("blur", handleBlur);
                }, 2500); // Đặt timeout (2.5 giây) để kiểm tra liên kết. Thay đổi số này lên 5000 nếu bạn chưa chạy được
                var result = {};

                function handleMouseMove(event) {
                    if (!result.x) {
                        result = {
                            x: event.clientX,
                            y: event.clientY,
                        };
                    }
                }

                function handleBlur() {
                    clearTimeout(timeout);
                    window.addEventListener("mousemove", handleMouseMove);
                }
                window.addEventListener("blur", handleBlur);
                window.addEventListener(
                    "focus",
                    function onFocus() {
                        setTimeout(function() {
                            if (document.hasFocus()) {
                                successCallback(function(pos) {
                                    if (!pos.x) {
                                        return true;
                                    }
                                    var screenWidth =
                                        window.innerWidth ||
                                        document.documentElement.clientWidth ||
                                        document.body.clientWidth;
                                    var alertWidth = 300;
                                    var alertHeight = 100;
                                    var isXInRange =
                                        pos.x - 100 < 0.5 * (screenWidth + alertWidth) &&
                                        pos.x + 100 > 0.5 * (screenWidth + alertWidth);
                                    var isYInRange =
                                        pos.y - 40 < alertHeight && pos.y + 40 > alertHeight;
                                    return isXInRange && isYInRange ?
                                        "Link can be opened." :
                                        "Link is not supported.";
                                }(result));
                            } else {
                                successCallback("Link can be opened.");
                            }
                            window.removeEventListener("focus", onFocus);
                            window.removeEventListener("blur", handleBlur);
                            window.removeEventListener("mousemove", handleMouseMove);
                        }, 500);
                    }, {
                        once: true
                    }
                );
                hiddenIframe.contentWindow.location.href = link;
            }
            Object.keys(zalo_acc).map(function(sdt, index) {
                let qrcode = zalo_acc[sdt];
                const zaloLinks = document.querySelectorAll('a[href*="https://zalo.me/' + sdt + '"]');
                zaloLinks.forEach((zalo) => {
                    zalo.addEventListener("click", (event) => {
                        event.preventDefault();
                        const userAgent = navigator.userAgent.toLowerCase();
                        const isIOS = /iphone|ipad|ipod/.test(userAgent);
                        const isAndroid = /android/.test(userAgent);
                        let redirectURL = null;
                        if (isIOS) {
                            redirectURL = 'zalo://qr/p/' + qrcode;
                            window.location.href = redirectURL;
                        } else if (isAndroid) {
                            redirectURL = 'zalo://zaloapp.com/qr/p/' + qrcode;
                            window.location.href = redirectURL;
                        } else {
                            redirectURL = 'zalo://conversation?phone=' + sdt;
                            zalo.classList.add("zalo_loading");
                            devvnCheckLinkAvailability(
                                redirectURL,
                                function(result) {
                                    zalo.classList.remove("zalo_loading");
                                },
                                function(error) {
                                    zalo.classList.remove("zalo_loading");
                                    redirectURL = 'https://chat.zalo.me/?phone=' + sdt;
                                    window.location.href = redirectURL;
                                }
                            );
                        }
                    });
                });
            });
            //Thêm css vào site để lúc ấn trên pc trong lúc chờ check chuyển hướng sẽ không ấn vào thẻ a đó được nữa
            var styleElement = document.createElement("style");
            var cssCode = ".zalo_loading { pointer-events: none; }";
            styleElement.innerHTML = cssCode;
            document.head.appendChild(styleElement);
        </script>
<?php }
}
