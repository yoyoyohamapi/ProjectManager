/**
 * Created by CSCV.
 * Desc: Web基本框架：导航，侧栏，Footer
 * User: Woo
 * Date: 15/5/3
 * Time: 下午10:22
 */
define(function (require, exports, module) {
    require('semantic-sidebar');
    var Widget = require('arale-widget');
    var Base = Widget.extend({
            element: 'body',
            attrs: {
                // 侧栏
                sidebar: $('#sidebar')
            },
            events: {
                'click #sideLaunch': 'toggleSidebar'
            },
            setup: function () {

            },
            toggleSidebar: function () {
                this.get('sidebar').sidebar('toggle');
            }
        }
    );
    module.exports = Base;
});
