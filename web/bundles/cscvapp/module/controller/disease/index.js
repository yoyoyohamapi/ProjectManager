/**
 * Created by CSCV.
 * Desc: 疾病首页
 * User: Woo
 * Date: 15/5/31
 * Time: 下午11:22
 */
define(function (require, exports, module) {

    var DiseaseCards = require('./DiseaseCards.js');
    exports.run = function () {
        var diseaseCards = new DiseaseCards();
    }

});