/**
 * Created by GàConIT on 8/31/2017.
 */
var global_notice_options = {
    timeOut: 1000,
    positionClass: "toast-bottom-right",
}

function successNotice(title, msg, custom_options = global_notice_options) {
    toastr.success(msg, title, custom_options);
}

function warningNotice(title, msg, custom_options = global_notice_options) {
    toastr.warning(msg, title, custom_options);
}

function errorNotice(title, msg, custom_options = global_notice_options) {
    custom_options.timeOut = 3000;
    let options = Object.assign({}, global_notice_options, custom_options);
    toastr.error(msg, title, options);
}

function infoNotice(title, msg, custom_options = global_notice_options) {
    toastr.info(msg, title, custom_options);
}

function closeNotice() {
    toastr.clear();
}

let warningSwal = function callWarningSwal(data, callback) {
    let warning_options = {
        title: data.title,
        text: data.message,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        showLoaderOnConfirm: true,
        cancelButtonText: "Hủy",
        confirmButtonText: "OK",
        closeOnConfirm: false,
        html: true
    };
    if (data.options) {
        warning_options = Object.assign(warning_options, data.options);
    }
    swal(warning_options, callback);
};

let errorSwal = function callErrorSwal(title, message) {
    swal(title, message, 'error');
};