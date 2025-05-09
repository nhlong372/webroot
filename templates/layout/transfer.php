<HTML>

<HEAD>
    <TITLE>:: Thông Báo ::</TITLE>
    <base href="<?= $basehref ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="REFRESH" content="4.5; url=<?= $page_transfer ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="noodp,noindex,nofollow" />
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.css">

    <style type="text/css">
        body {
            background: #eee
        }

        #alert {
            background: #fff;
            padding: 20px;
            margin: 30px auto;
            border-radius: 3px;
            -webkit-box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
            -moz-box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
            box-shadow: 0px 0px 3px 0px rgba(50, 50, 50, 0.3);
            margin-top: 100px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        #alert .fas {
            font-size: 60px;
        }

        #alert .rlink {
            margin: 10px 0px;
        }

        #alert .title {
            text-transform: uppercase;
            font-weight: bold;
            margin: 10px;
        }

        .fasuccess {
            color: #5cb85c;
        }

        .fadanger {
            color: #D9534F;
        }

        #process-bar {
            width: 0%;
            -webkit-transition: all 0.3s !important;
            transition: all 0.3s !important;
        }

        @font-face {
            font-family: 'Font Awesome 5 Brands';
            font-style: normal;
            font-weight: normal;
            font-display: auto;
            src: url("assets/fonts/awesome/fa-brands-400.woff2") format("woff2"), url("assets/fonts/awesome/fa-brands-400.woff") format("woff");
        }

        .fab {
            font-family: 'Font Awesome 5 Brands';
        }

        @font-face {
            font-family: 'Font Awesome 5 Free';
            font-style: normal;
            font-weight: 400;
            font-display: auto;
            src: url("assets/fonts/awesome/fa-regular-400.woff2") format("woff2"), url("assets/fonts/awesome/fa-regular-400.woff") format("woff");
        }

        .far {
            font-family: 'Font Awesome 5 Free';
            font-weight: 400;
        }

        @font-face {
            font-family: 'Font Awesome 5 Free';
            font-style: normal;
            font-weight: 900;
            font-display: auto;
            src: url("assets/fonts/awesome/fa-solid-900.woff2") format("woff2"), url("assets/fonts/awesome/fa-solid-900.woff") format("woff");
        }

        .fa,
        .fas {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }

        .fa,
        .fas,
        .far,
        .fal,
        .fab {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }

        .fa-envelope-open:before {
            content: "\f2b6";
        }

        .fa-phone:before {
            content: "\f095";
        }

        .fa-map-marker-alt:before {
            content: "\f3c5";
        }

        .fa-shopping-cart:before {
            content: "\f07a";
        }

        .fa-bars:before {
            content: "\f0c9";
        }

        .fa-calendar-alt:before {
            content: "\f073";
        }

        .fa-search:before {
            content: "\f002";
        }

        .fa-exclamation-triangle:before {
            content: "\f071";
        }

        .fa-check-circle:before {
            content: "\f058";
        }

        .fa-user:before {
            content: "\f007";
        }

        .fa-sign-out-alt:before {
            content: "\f2f5";
        }

        .fa-minus:before {
            content: "\f068";
        }

        .fa-plus:before {
            content: "\f067";
        }
    </style>
</HEAD>

<BODY>
    <div id="alert">
        <i class="fas <?= ($numb) ? 'fa-check-circle fasuccess' : 'fa-exclamation-triangle fadanger' ?>"></i>
        <div class="title">Thông báo</div>
        <div class="message alert <?= ($numb) ? 'alert-success' : 'alert-danger' ?>"><?= $showtext ?></div>
        <div class="rlink">(<a href="<?= $page_transfer ?>">Click vào đây nếu không muốn đợi lâu</a>)</div>
        <div class="progress">
            <div id="process-bar" class="progress-bar progress-bar-striped progress-bar-<?= ($numb) ? 'success' : 'danger' ?> active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <script type="text/javascript">
        var elem = document.getElementById("process-bar");
        var pos = 0;
        setInterval(function() {
            pos += 1;
            elem.style.width = pos + '%';
        }, 40);
    </script>
</BODY>

</HTML>