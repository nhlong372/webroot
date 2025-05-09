<div class="wrap-user">
    <div class="title-user">
        <span><?= quenmatkhau ?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/quen-mat-khau" enctype="multipart/form-data">
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
                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
            </div>
            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="<?= nhapemail ?>" required>
            <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary" name="forgot-password-user" value="<?= laymatkhau ?>" disabled>
        </div>
    </form>
</div>