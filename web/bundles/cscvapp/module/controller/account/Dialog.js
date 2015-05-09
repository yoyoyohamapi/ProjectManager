/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/4/19
 * Time: 下午9:59
 */
define(function (require, exports, module) {
    var Widget = require("arale-widget");
    // 登陆注册框对象,继承自arale-widget
    var AccountDialog = Widget.extend({
        // 所操作的DOM对象
        element: "form",
        events: {
            'click .field.error': 'refreshInput'
        },
        setup: function () {
            if ($(this).has("#error")) {
                $("#error")
                    .transition({
                        animation: 'fade down',
                        duration: '2s'
                    }).transition({
                        animation: 'fade up',
                        duration: '2s'
                    });
            }
        },
        refreshInput: function (event) {
            $(event.target).parent().removeClass('error');
        }
    });

    // 对外提供模块
    module.exports = AccountDialog;
});