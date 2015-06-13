define(function (require, exports, module) {
    var Widget = require('arale-widget');
    require("semantic-dimmer");
    require("semantic-modal");
    var DiseaseCards = Widget.extend({
        element: "#diseaseCards",
        attr: {
            'removeId': ''
        },
        events: {
            'click .corner.label': 'showRemoveModal'
        },
        setup: function () {
            // 初始化添加卡片高度
            this.heightAdjust();
            var this_el = this;

        },
        heightAdjust: function () {
            // 设置添加卡片高度
            var height =
                this.element.children().length == 1 ?
                    300 : this.element.find('.card').first().height();
            $("#add").css('height', parseInt(height));
        },
        showRemoveModal: function (e) {
            var this_el = this;
            $(".modal").modal({
                onApprove: function () {
                    this_el.remove();
                },
                selector: {
                    approve: "#removeAction"
                }
            }).modal({
                onApprove: function () {
                    this_el.remove();
                },
                selector: {
                    approve: "#removeAction"
                },
                onShow: function () {
                    var removeBtn = $(e.target);
                    var id = removeBtn.attr('data-id');
                    this_el.set('removeId', id);
                }
            }).modal('toggle');

        },
        remove: function () {
            var id = this.get("removeId");
            var url = this.element.attr('data-rm-url');
            $.ajax({
                url: url,
                data: "id=" + id,
                dataType: 'json',
                method: 'DELETE',
                success: function (data) {
                    if (data.message == 'success')
                        window.location.reload();
                }
            });
        }
    });
    module.exports = DiseaseCards;
});