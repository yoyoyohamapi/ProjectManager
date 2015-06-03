/**
 * Created by CSCV.
 * Desc: 疾病首页
 * User: Woo
 * Date: 15/5/31
 * Time: 下午11:22
 */
define(function (require, exports, module) {

    exports.run = function () {
        heightAdjust();

        $(window).resize(function () {
            heightAdjust();
        });
    }

    function heightAdjust() {
        // 设置添加卡片高度
        var height =
            $("#list").children().length == 1 ?
                300 : $("#list .card:first").height();
        $("#add").css('height', parseInt(height));
    }
});