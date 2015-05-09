/**
 * Created by CSCV.
 * Desc: 图片标定主页JS
 * User: Woo
 * Date: 15/4/24
 * Time: 下午10:39
 */
define(function (require, exports, module) {
    require('semantic-dropdown');
    var Calibrate = require('./Calibrate.js');
    exports.run = function () {
        var calibrate = new Calibrate();
    };
});