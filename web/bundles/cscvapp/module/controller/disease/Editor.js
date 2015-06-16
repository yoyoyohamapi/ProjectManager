/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/12
 * Time: 下午7:51
 */
define(function (require, exports, module) {
    require('jquery-easing');
    require('fullPage');
    require("semantic-dimmer");
    require("semantic-modal");
    require("ckeditor");
    var Widget = require('arale-widget');
    var Editor = Widget.extend({
        element: '#editor',
        attrs: {
            titles: []
        },
        events: {
            'click #showBackModal': function () {
                $(".modal").modal('show');
            }
        },
        setup: function () {
            var titles = this.get('titles');
            // 初始化页面标题
            $("#title").children().each(function () {
                titles.push($(this));
            });
            // 初始化tinymce
            this.initTinyMCE();
            //初始化Fullpage
            this.element.fullpage({
                slidesNavigation: true,
                loopHorizontal: false,
                navigationColor: '#fff',
                onSlideLeave: function (anchorLink, index, slideIndex, direction, nextSlideIndex) {
                    titles[slideIndex].fadeOut(function () {
                            titles[nextSlideIndex].fadeIn();
                        }
                    );
                }
            });
            //初始化modal
            $(".modal").modal({
                onApprove: function () {
                    var url = $(".modal").attr('data-url');
                    window.history.back(-1);
                    return true;
                },
                selector: {
                    approve: '#backAction'
                }
            });
        },
        initTinyMCE: function () {
            // 获得当前屏幕高度
            var height = window.screen.height;
            $("textarea").each(function () {
                CKEDITOR.replace($(this).attr('name'), {
                    height: height * 0.4
                });
            });
        }
    });
    module.exports = Editor;
});