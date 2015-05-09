define(function (require, exports, module) {
    window.$ = window.jQuery = require('jquery');
    require('semantic-ui');
    require('semantic-transit');
    // 先执行基本的脚本
    var cscv_app_base = require('cscv-app-base');
    cscv_app_base.run();
    exports.load = function (name) {
        name = 'http://' + window.location.host + '/bundles/cscvapp/module/controller/' + name + '.js';
        seajs.use(name, function (module) {
            // Auto Run
            if ($.isFunction(module.run)) {
                module.run();
            }
        });

    };
    //Load the Controller
    if (app.action) {
        exports.load(app.action);
    }

});