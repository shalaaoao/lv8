// 手机号错误弹窗
var alert_slide = function (copysuc) {
    var $html = $("<div class='copy-tips2'><div class='copy-tips-wrap2'>" + copysuc + "</div></div>");
    $("body").find(".copy-tips2").remove().end().append($html);
    var width = $(".copy-tips2").outerWidth();
    $(".copy-tips2").css("marginLeft", -width / 2)
    $(".copy-tips2").animate({
        top: "30px"
    }, 800);
    setTimeout("fn2()", 1500);
};

function fn2() {
    $(".copy-tips2").fadeOut(1000);
}