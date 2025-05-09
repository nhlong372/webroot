<div class="wrap-user">
    <div class="title-user">
        <span><?= dangky ?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/dang-ky" enctype="multipart/form-data">
        <?= $flash->getMessages("frontend") ?>
        <label><?= hoten ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control text-sm" id="fullname" name="fullname" placeholder="<?= nhaphoten ?>" value="<?= $flash->get('fullname') ?>" required>
            <div class="invalid-feedback"><?= vuilongnhaphoten ?></div>
        </div>
        <label><?= taikhoan ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?= nhaptaikhoan ?>" value="<?= $flash->get('username') ?>" required>
            <div class="invalid-feedback"><?= vuilongnhaptaikhoan ?></div>
        </div>
        <label><?= matkhau ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control text-sm" id="password" name="password" placeholder="<?= nhapmatkhau ?>" required>
            <div class="invalid-feedback"><?= vuilongnhapmatkhau ?></div>
        </div>
        <label><?= nhaplaimatkhau ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control text-sm" id="repassword" name="repassword" placeholder="<?= nhaplaimatkhau ?>" required>
            <div class="invalid-feedback"><?= vuilongnhaplaimatkhau ?></div>
        </div>
        <label><?= gioitinh ?></label>
        <div class="input-group input-user">
            <?php $flashGender = $flash->get('gender'); ?>
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nam" name="gender" class="custom-control-input" value="1" <?= ($flashGender == 1) ? 'checked' : '' ?> required>
                <label class="custom-control-label" for="nam"><?= nam ?></label>
            </div>
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nu" name="gender" class="custom-control-input" value="2" <?= ($flashGender == 2) ? 'checked' : '' ?> required>
                <label class="custom-control-label" for="nu"><?= nu ?></label>
            </div>
        </div>
        <label><?= ngaysinh ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="text" class="form-control text-sm" id="birthday" name="birthday" placeholder="<?= nhapngaysinh ?>" value="<?= $flash->get('birthday') ?>" required autocomplete="off">
            <div class="invalid-feedback"><?= vuilongnhapsodienthoai ?></div>
        </div>
        <label>Email</label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
            </div>
            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="<?= nhapemail ?>" value="<?= $flash->get('email') ?>" required>
            <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
        </div>
        <label><?= dienthoai ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-phone-square"></i></div>
            </div>
            <input type="number" class="form-control text-sm" id="phone" name="phone" placeholder="<?= nhapdienthoai ?>" value="<?= $flash->get('phone') ?>" required>
            <div class="invalid-feedback"><?= vuilongnhapsodienthoai ?></div>
        </div>
        <label><?= diachi ?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-map"></i></div>
            </div>
            <input type="text" class="form-control text-sm" id="address" name="address" placeholder="<?= nhapdiachi ?>" value="<?= $flash->get('address') ?>" required>
            <div class="invalid-feedback"><?= vuilongnhapdiachi ?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary btn-block" name="registration-user" value="<?= dangky ?>">
        </div>
    </form>
</div>