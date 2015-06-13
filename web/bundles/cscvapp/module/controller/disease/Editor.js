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
    require('tinymce');
    require("semantic-dimmer");
    require("semantic-modal");
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
            $("textarea").each(function () {
                tinymce.init({
                    selector: "#" + $(this).attr('id'),
                    height: 500,
                    menubar: false,
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview media link image"
                });
            });
        }
    });
    module.exports = Editor;
});