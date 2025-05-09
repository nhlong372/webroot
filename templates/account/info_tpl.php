<div class="box_info">
    <div class="wap_1200">
        <div class="flex_info">
            <div class="left_info">
                <div class="title-user">
                    <span>Danh mục quản lý</span>
                </div>
                <ul class="list_mananger">
                    <li>
                        <a class="d-block sty_list act" data-vitri="1">Quản lý thông tin</a>
                    </li>
                    <?php if($config['user']['info'] == true) { ?>  
                    <li>
                        <a class="d-block sty_list" data-vitri="2">Quản lý đơn hàng</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="right_info">
                <div class="container_load_info load1 mo">
                    <div class="title-user">
                        <span><?= thongtincanhan ?></span>
                    </div>
                    <form class="form-user validation-user" novalidate method="post" action="account/thong-tin" enctype="multipart/form-data">
                        <?= $flash->getMessages("frontend") ?>
                        <label><?= hoten ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="fullname" name="fullname" placeholder="<?= nhaphoten ?>" value="<?= (!empty($flash->has('fullname'))) ? $flash->get('fullname') : $rowDetail['fullname'] ?>" required>
                            <div class="invalid-feedback"><?= vuilongnhaphoten ?></div>
                        </div>
                        <label><?= taikhoan ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="username" name="username" placeholder="<?= nhaptaikhoan ?>" value="<?= $rowDetail['username'] ?>" readonly required>
                        </div>
                        <label><?= matkhaucu ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control text-sm" id="old-password" name="old-password" placeholder="<?= nhapmatkhaucu ?>">
                        </div>
                        <label><?= matkhaumoi ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control text-sm" id="new-password" name="new-password" placeholder="<?= nhapmatkhaumoi ?>">
                        </div>
                        <label><?= nhaplaimatkhaumoi ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control text-sm" id="new-password-confirm" name="new-password-confirm" placeholder="<?= nhaplaimatkhaumoi ?>">
                        </div>
                        <label><?= gioitinh ?></label>
                        <div class="input-group input-user">
                            <?php $flashGender = $flash->get('gender'); ?>
                            <div class="radio-user custom-control custom-radio">
                                <input type="radio" id="nam" name="gender" class="custom-control-input" <?= (!empty($flashGender) && $flashGender == 1) ? 'checked' : (($rowDetail['gender'] == 1) ? 'checked' : '') ?> value="1" required>
                                <label class="custom-control-label" for="nam"><?= nam ?></label>
                            </div>
                            <div class="radio-user custom-control custom-radio">
                                <input type="radio" id="nu" name="gender" class="custom-control-input" <?= (!empty($flashGender) && $flashGender == 2) ? 'checked' : (($rowDetail['gender'] == 2) ? 'checked' : '') ?> value="2" required>
                                <label class="custom-control-label" for="nu"><?= nu ?></label>
                            </div>
                        </div>
                        <label><?= ngaysinh ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="birthday" name="birthday" placeholder="<?= nhapngaysinh ?>" value="<?= (!empty($flash->has('birthday'))) ? $flash->get('birthday') : date("d/m/Y", $rowDetail['birthday']) ?>" required autocomplete="off">
                            <div class="invalid-feedback"><?= vuilongnhapngaysinh ?></div>
                        </div>
                        <label>Email</label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                            </div>
                            <input type="email" class="form-control text-sm" id="email" name="email" placeholder="<?= nhapemail ?>" value="<?= (!empty($flash->has('email'))) ? $flash->get('email') : $rowDetail['email'] ?>" required>
                            <div class="invalid-feedback"><?= vuilongnhapdiachiemail ?></div>
                        </div>
                        <label><?= dienthoai ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-phone-square"></i></div>
                            </div>
                            <input type="number" class="form-control text-sm" id="phone" name="phone" placeholder="<?= nhapdienthoai ?>" value="<?= (!empty($flash->has('phone'))) ? $flash->get('phone') : $rowDetail['phone'] ?>" required>
                            <div class="invalid-feedback"><?= vuilongnhapsodienthoai ?></div>
                        </div>
                        <label><?= diachi ?></label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-map"></i></div>
                            </div>
                            <input type="text" class="form-control text-sm" id="address" name="address" placeholder="<?= nhapdiachi ?>" value="<?= (!empty($flash->has('address'))) ? $flash->get('address') : $rowDetail['address'] ?>" required>
                            <div class="invalid-feedback"><?= vuilongnhapdiachi ?></div>
                        </div>
                        <div class="button-user">
                            <input type="submit" class="sty_btn_info btn-block" name="info-user" value="<?= capnhat ?>">
                        </div>
                    </form>
                </div>
                <?php if($config['user']['info'] == true) { ?>          
                <div class="container_load_info load2 dong">
                    <div class="title-user">
                        <span>Thông tin đơn hàng của bạn <?=$_SESSION[$loginMember]['fullname']?></span>
                    </div>
                    <?php if(array_key_exists($loginMember, $_SESSION) && $_SESSION[$loginMember]['active'] == true) { ?>
                        <?php
                            $iduser = $_SESSION[$loginMember]['id'];
                            $donhang = $d->rawQuery("select code, order_status, total_price, id, date_created from #_order where id_user = ?",array($iduser));	
                            if(count($donhang)) { ?>
                            <?php foreach($donhang as $v1) {
                                $chitiet = $d->rawQuery("select photo,name,regular_price,sale_price,quantity,id_product from #_order_detail where id_order = ?",array($v1['id']));
                                $tinhtrang = $d->rawQueryOne("select namevi from #_order_status where id = ? limit 0,1",array($v1['tinhtrang']));
                            ?>
                            <div class="wrap-cart d-flex align-items-stretch justify-content-between box-ql-donhang">
                                <div class="top-cart">
                                    <p class="title-cart">Đơn hàng: <span><?=$v1['code']?></span> , Tình trạng: <span><?=$tinhtrang['namevi']?></span></p>
                                    <div class="list-procart">
                                        <table class="table">
                                            <thead>
                                                <th scope="col">STT</th>
                                                <th scope="col" width="85px">Hình ảnh</th>
                                                <th scope="col">Tên sản phẩm</th>
                                                <th scope="col" width="100px">Ngày đặt</th>
                                                <th scope="col" class="text-center">Số lượng</th>
                                                <th scope="col">Thành tiền</th>
                                            </thead>
                                            <?php foreach($chitiet as $k2 => $v2) {
                                                $pid = $v2['productid'];
                                                $quantity = $v2['quantity'];						
                                                $proinfo = $cart->get_product_info($pid);
                                                $pro_price = $v2['regular_price'];
                                                $pro_price_new = $v2['sale_price'];
                                                $pro_price_qty = $pro_price*$quantity;
                                                $pro_price_new_qty = $pro_price_new*$quantity; 
                                            ?>
                                                <tbody>
                                                    <th>
                                                        <?=$k2?>
                                                    </th>
                                                    <th>
                                                        <a class="text-decoration-none d-block" target="_blank" title="<?=$v2['name']?>"><img onerror="this.src='<?=THUMBS?>/85x85x2/assets/images/noimage.png';" src="<?=THUMBS?>/85x85x1/<?=UPLOAD_PRODUCT_L.$v2['photo']?>" alt="<?=$v2['name']?>"></a>
                                                    </th>
                                                    <th><h3 class="name-procart"><a class="text-decoration-none" target="_blank" title="<?=$v2['name']?>"><?=$v2['name']?></a></h3></th>
                                                    <th><?=date("d/m/Y",$v1['date_created'])?></th>
                                                    <th class="text-center"><?=$quantity?></th>
                                                    <th><p class="total-price load-price-total"><?=$func->format_money($pro_price_qty)?></p></th>
                                                </tbody>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <div class="money-procart">				    
                                        <div class="total-procart d-flex align-items-center justify-content-between">
                                            <p><?=tongtien?>:</p>
                                            <p class="total-price load-price-total"><?=$func->format_money($v1['total_price'])?></p>
                                        </div>			        
                                    </div>
                                </div>		    
                            </div>
                        <?php } ?>
                        <?php } else { ?>
                            <a href="san-pham" class="sty_btn_info empty-cart text-decoration-none">
                                <i class="fa fa-cart-arrow-down"></i>
                                <p>Bạn chưa có đơn hàng nào</p>
                                <span>Vào mua hàng</span>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>