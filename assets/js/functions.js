function isEmpty(o,t){return""==o&&(void 0!==t&&alert(t),!0)}
function isPhone(o,t){return(10!=o.length||0!=o.substr(0,1))&&(void 0!==t&&alert(t),!0)}
function isEmail(o,t){return emailRegExp=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,!emailRegExp.test(o.toLowerCase())&&(void 0!==t&&alert(t),!0)}
/*** Hàm lấy danh sách yêu thích ***/
function reloadLike( LIST_SAVED = '' ) {
    if(LIST_SAVED!=null && LIST_SAVED!='') {
        $('.save-listing').each(function(index, el) {
            var pid = $(this).data('id');
            var ele = $(this);
            for(var i = 0; i < LIST_SAVED.length; i++) 
            {
                if(LIST_SAVED[i] == pid)
                {
                    ele.addClass('save-listing-already').removeClass('save-listing');
                    return true;
                }
            }
        });
    }
}
/*** Hàm number_format js ***/
function number_format(t, e, a, i) {
    t = (t + "").replace(/[^0-9+\-Ee.]/g, "");
    var n = isFinite(+t) ? +t : 0,
        o = isFinite(+e) ? Math.abs(e) : 0,
        r = void 0 === i ? "." : i,
        l = void 0 === a ? "." : a,
        s = "";
    return (s = (o ? function(t, e) {
        var a = Math.pow(10, e);
        return "" + Math.round(t * a) / a
    }(n, o) : "" + Math.round(n)).split("."))[0].length > 3 && (s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, r)), (s[1] || "").length < o && (s[1] = s[1] || "", s[1] += new Array(o - s[1].length + 1).join("0")), s.join(l)
}
function isExist(ele) {
    return ele.length;
}
function isNumeric(value) {
    return /^\d+$/.test(value);
}
function getLen(str) {
    return /^\s*$/.test(str) ? 0 : str.length;
}
function showNotify(
    text = "Notify text",
    title = "Thông báo",
    status = "success"
) {
    new Notify({
        status: status, // success, warning, error
        title: title,
        text: text,
        effect: "fade",
        speed: 400,
        customClass: null,
        customIcon: null,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 3000,
        gap: 10,
        distance: 10,
        type: 3,
        position: "right top",
    });
}
function notifyDialog(
    content = "",
    title = "Thông báo",
    icon = "fas fa-exclamation-triangle",
    type = "blue",
    time_duration = "3000"
) {
    $.alert({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: content, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: "zoom",
        closeAnimation: "scale",
        typeAnimated: true,
        animateFromElement: false,
        autoClose: "accept|"+time_duration,
        escapeKey: "accept",
        buttons: {
            accept: {
                text: "Đồng ý",
                btnClass: "btn-sm btn-primary",
            },
        },
    });
}
function confirmDialog(
    action,
    text,
    value,
    title = "Thông báo",
    icon = "fas fa-exclamation-triangle",
    type = "blue",
    time_duration = "3000"
) {
    $.confirm({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: text, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: "zoom",
        closeAnimation: "scale",
        typeAnimated: true,
        animateFromElement: false,
        autoClose: "cancel|"+time_duration,
        escapeKey: "cancel",
        buttons: {
            success: {
                text: "Đồng ý",
                btnClass: "btn-sm btn-primary",
                action: function () {
                    if (action == "delete-procart") deleteCart(value);
                },
            },
            cancel: {
                text: "Hủy",
                btnClass: "btn-sm btn-danger",
            },
        },
    });
}
function validateForm(ele = "") {
    if (ele) {
        $("." + ele)
            .find("input[type=submit]")
            .removeAttr("disabled");
        var forms = document.getElementsByClassName(ele);
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener(
                "submit",
                function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add("was-validated");
                },
                false
            );
        });
    }
}
function readImage(inputFile, elementPhoto) {
    if (inputFile[0].files[0]) {
        if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
            var size = parseInt(inputFile[0].files[0].size) / 1024;
            if (size <= 4096) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(elementPhoto).attr("src", e.target.result);
                };
                reader.readAsDataURL(inputFile[0].files[0]);
            } else {
                notifyDialog(
                    "Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB"
                );
                return false;
            }
        } else {
            $(elementPhoto).attr("src", "");
            notifyDialog("Định dạng hình ảnh không hợp lệ");
            return false;
        }
    } else {
        $(elementPhoto).attr("src", "");
        return false;
    }
}
function photoZone(eDrag, iDrag, eLoad) {
    if ($(eDrag).length) {
        /* Drag over */
        $(eDrag).on("dragover", function () {
            $(this).addClass("drag-over");
            return false;
        });
        /* Drag leave */
        $(eDrag).on("dragleave", function () {
            $(this).removeClass("drag-over");
            return false;
        });
        /* Drop */
        $(eDrag).on("drop", function (e) {
            e.preventDefault();
            $(this).removeClass("drag-over");
            var lengthZone = e.originalEvent.dataTransfer.files.length;
            if (lengthZone == 1) {
                $(iDrag).prop("files", e.originalEvent.dataTransfer.files);
                readImage($(iDrag), eLoad);
            } else if (lengthZone > 1) {
                notifyDialog("Bạn chỉ được chọn 1 hình ảnh để upload");
                return false;
            } else {
                notifyDialog("Dữ liệu không hợp lệ");
                return false;
            }
        });
        /* File zone */
        $(iDrag).change(function () {
            readImage($(this), eLoad);
        });
    }
}
function generateCaptcha(action, id, id_form) {
    if (RECAPTCHA_ACTIVE && action && id && $("#" + id).length) {
        grecaptcha
            .execute(RECAPTCHA_SITEKEY, { action: action })
            .then(function (token) {
                var recaptchaResponse = document.getElementById(id);
                recaptchaResponse.value = token;
                document.getElementById(id_form).submit();
            });
    }
}
function loadPaging(url = "", eShow = "") {
    if ($(eShow).length && url) {
        $.ajax({
            url: url,
            type: "GET",
            data: {
                eShow: eShow,
            },
            success: function (result) {
                $(eShow).html(result);
                NN_FRAMEWORK.Lazys();
            },
        });
    }
}
function doEnter(event, obj) {
    if (event.keyCode == 13 || event.which == 13) onSearch(obj);
}
function onSearch(obj) {
    var keyword = $("#" + obj).val();
    if (keyword == "") {
        notifyDialog(LANG["no_keywords"]);
        return false;
    } else {
        location.href = "tim-kiem?keyword=" + encodeURI(keyword);
    }
}
function goToByScroll(id, minusTop) {
    minusTop = parseInt(minusTop) ? parseInt(minusTop) : 0;
    id = id.replace("#", "");
    $("html,body").animate(
        {
            scrollTop: $("#" + id).offset().top - minusTop,
        },
        "slow"
    );
}
function holdonOpen(
    theme = "sk-bounce",
    text = "Vui lòng chờ tí ...",
    backgroundColor = "rgba(0,0,0,0.8)",
    textColor = "white"
) {
    var options = {
        theme: theme,
        message: text,
        backgroundColor: backgroundColor,
        textColor: textColor,
    };
    HoldOn.open(options);
}
function holdonClose() {
    HoldOn.close();
}