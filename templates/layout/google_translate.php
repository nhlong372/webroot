    <div class="lang-header-top">
    <p class="lang-header-main">
        <strong>
            <span class="notranslate">Tiếng việt</span>
            <img src="assets/images/vi.jpg" alt="Tiếng việt">
        </strong>
        <i class="fa fa-sort-down"></i>
    </p>
    <ul class="lang-header-ul">
        <li class="lang-vi" onclick="doGoogleLanguageTranslator('vi'); return false;">
            <span class="notranslate">Tiếng việt</span>
            <img src="assets/images/vi.jpg" alt="Tiếng việt">
        </li>
        <li class="lang-en" onclick="doGoogleLanguageTranslator('en'); return false;">
            <span class="notranslate">Tiếng anh</span>
            <img src="assets/images/en.jpg" alt="Tiếng anh">
        </li>        
    </ul>
</div>

<div id="google_language_translator" style="display: none;"></div>

<style type="text/css">
    .skiptranslate{display:none!important;}.lang-header-top{position:relative;}
    .lang-header-top .lang-header-main{border: 1px solid #cfcfcf;width: 145px;height: 37px;border-radius: 26px;text-align:center;padding:0px 7px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;margin-bottom: 0;    background: rgb(255 255 255 / 75%);color: #000;}
    .lang-header-top .lang-header-main strong{display:flex;align-items:center;justify-content:space-between;font-weight:normal;width: 87%;}
    .lang-header-top .lang-header-main strong span{font-size:12.5px;width: 90px;text-align:left;padding-right:5px;}
    .lang-header-top .lang-header-main strong img{width: 23px;height: 15px;margin-top:1px;}
    .lang-header-top .lang-header-main i{margin-top: -1px;color: #a5a4a4;margin-right: 5px;}
    .lang-header-top .lang-header-ul{display:none; position:absolute;width:100%;top: 37px;left:0px;background: #464646;font-size:13px;padding:3px;opacity: 1;min-width: 100%;border-radius: 10px;}
    .lang-header-top .lang-header-ul.active{display:block;-webkit-transform: perspective(600px) rotateX(0);transform: perspective(600px) rotateX(0);transform-origin: 0 0 0;-webkit-transform-origin: 0 0 0;opacity: 1;visibility: visible;}
    .lang-header-top .lang-header-ul li{cursor:pointer;margin-bottom:5px;padding: 5px 8px;display:flex;align-items:center;justify-content:space-between;width: 100%;height: 26px !important;z-index: 999999;color: #fff;}
    .lang-header-top .lang-header-ul li img{display: inline-block;}
    .lang-header-top .lang-header-ul li:hover{background: #fff100;color: #000;}
    .lang-header-top .lang-header-ul li:last-child{margin-bottom:0px;}
    .lang-header-top .lang-header-ul li span{width:80px;text-align:left;padding-right:5px;display: block;}
</style>