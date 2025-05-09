<?php if (isset($config['setting']['qrcodezalo']) && $config['setting']['qrcodezalo'] == true) {
    if ($_GET['com'] == "setting") { ?>
        <script src="<?= LIBRARIES . 'ZaloQR/html5-qrcode.min.js' ?>"></script>
        <script>
            $(document).ready(function() {
                <?php for ($i = 0; $i < $config['setting']['soqrzalo']; $i++) { ?>
                    //Trỏ tới card cần thêm code
                    parent = $("section.content").children().children().eq(3).find('.row');
                    //Khởi tạo các element cho qr code
                    qrcode = document.createElement("div");
                    $(qrcode).addClass("form-group col-md-4 col-sm-6");

                    main_label = document.createElement("div");
                    $(main_label)
                        .addClass("d-flex align-items-start")
                        .append(
                            $(document.createElement("label"))
                            .addClass("mr-2")
                            .text("QR Code Zalo:")
                        ).append(
                            $(document.createElement("label"))
                            .attr("for", "qrzalo<?= $i ?>")
                            .addClass("btn btn-primary mb-0 py-0 px-1")
                            .text("Chọn hình ảnh QR")
                        ).append(
                            $(document.createElement("input"))
                            .attr("type", "file")
                            .attr("id", "qrzalo<?= $i ?>")
                            .addClass("d-none qrcode-c")
                            .attr("accept", "image/png, image/gif, image/jpeg, image/jpg")
                        );
                    qrinput = document.createElement("input");
                    $(qrinput).addClass("form-control text-sm").attr({
                        type: "text",
                        name: "data[options][codezalo<?= $i ?>]",
                        id: "codezalo<?= $i ?>",
                        placeholder: "Chọn hình ảnh QR",
                        
                    }).val('<?= $options['codezalo' . $i] ?>')
                    $(parent).append($(qrcode).append(main_label).append(qrinput));
                <?php } ?>
                //Xử lý xuất code qr

                let code = "";
                $(".qrcode-c").on("change", function() {
                    const html5QrCode = new Html5Qrcode($(this).attr("id"));
                    thisbtn = this;
                    file = $(this).get(0).files[0];
                    html5QrCode.scanFile(file, true)
                        .then(qrCodeMessage => {
                            // success, use qrCodeMessage
                            code = qrCodeMessage.split("/");
                            arrlenght = code.length;
                            code = code[arrlenght - 1];
                            $(thisbtn).parent().parent().children("input").val(code);
                        })
                        .catch(err => {
                            $(thisbtn).parent().parent().children("input").val(`Lỗi file: ${err}`);
                        });
                })
            });
        </script>
<?php }
}
