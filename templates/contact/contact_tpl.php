<div class="title-main"><span><?= $titleMain ?></span></div>

<?= $flash->getMessages("frontend") ?>

<div class="content-main">
    <div class="contact-article row">
        <div class="contact-text col-lg-6"><?= htmlspecialchars_decode($lienhe['content' . $lang]) ?></div>
        <form class="contact-form validation-contact col-lg-6" id="form-contact" novalidate method="post" action="" enctype="multipart/form-data">
            <div class="form-row">
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="fullname-contact" name="dataContact[fullname]" placeholder="<?= hoten ?>" value="<?= $flash->get('fullname') ?>" required />
                    <div class="invalid-feedback"><?= vuilongnhaphoten ?></div>
                </div>
                <div class="contact-input col-sm-6">
                    <input type="number" class="form-control text-sm" id="phone-contact" name="dataContact[phone]" placeholder="<?= sodienthoai ?>" value="<?= $flash->get('phone') ?>" required />
                    <div class="invalid-feedback"><?= vuilongnhapsodienthoai ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="contact-input col-sm-6">
                    <input type="text" class="form-control text-sm" id="address-contact" name="dataContact[address]" placeholder="<?= diachi ?>" value="<?= $flash->get('address') ?>" required />
                    <div class="invalid-feedback"><?= vuilongnhapdiachi ?></div>
                </div>
                <div class="contact-input col-sm-6">
                    <input type="email" class="form-control text-sm" id="email-contact" name="dataContact[email]" placeholder="Email" value="<?= $flash->get('email') ?>" required />
                    <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
                </div>
            </div>
            <div class="contact-input">
                <input type="text" class="form-control text-sm" id="subject-contact" name="dataContact[subject]" placeholder="<?= chude ?>" value="<?= $flash->get('subject') ?>" required />
                <div class="invalid-feedback"><?= vuilongnhapchude ?></div>
            </div>
            <div class="contact-input">
                <textarea class="form-control text-sm" id="content-contact" name="dataContact[content]" placeholder="<?= noidung ?>" required /><?= $flash->get('content') ?></textarea>
                <div class="invalid-feedback"><?= vuilongnhapnoidung ?></div>
            </div>
            <div class="contact-input">
                <input type="file" class="custom-file-input" name="file_attach">
                <label class="custom-file-label" for="file_attach" title="<?= chon ?>"><?= dinhkemtaptin ?></label>
            </div>
            <input type="submit" class="btn btn-primary mr-2" value="<?= gui ?>" disabled />
            <input type="reset" class="btn btn-secondary" value="<?= nhaplai ?>" />
            <input type="hidden" name="submit-contact" value="1">
            <input type="hidden" name="recaptcha_response_contact" id="recaptchaResponseContact">
        </form>
    </div>
    <div class="contact-map"><?= $func->decodeHtmlChars($optsetting['coords_iframe']) ?></div>
</div>