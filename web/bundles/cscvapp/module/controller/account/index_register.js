/**
 * Created by CSCV.
 * Desc: 注册主页
 * User: Woo
 * Date: 15/4/17
 * Time: 下午9:21
 */
define(function (require, exports, module) {
    var AccountDialog = require('./Dialog.js');
    exports.run = function () {
        var account_dialog = new AccountDialog();
    };
});