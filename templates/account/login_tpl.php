<div class="wrap-user">
    <div class="title-user">
        <span><?= dangnhap ?></span>
        <a href="account/quen-mat-khau" title="<?= quenmatkhau ?>"><?= quenmatkhau ?></a>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/dang-nhap" enctype="multipart/form-data">
        <?= $flash->getMessages("frontend") ?>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?= taikhoan ?>" required>
            <div class="invalid-feedback"><?= vuilongnhaptaikhoan ?></div>
        </div>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control text-sm" id="password" name="password" placeholder="<?= matkhau ?>" required>
            <div class="invalid-feedback"><?= vuilongnhapmatkhau ?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary" name="login-user" value="<?= dangnhap ?>">
            <div class="checkbox-user custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember-user" id="remember-user" value="1">
                <label class="custom-control-label" for="remember-user"><?= nhomatkhau ?></label>
            </div>
        </div>
        <div class="note-user">
            <span><?= banchuacotaikhoan ?> ! </span>
            <a href="account/dang-ky" title="<?= dangkytaiday ?>"><?= dangkytaiday ?></a>
        </div>
    </form>
</div>