define(function (require, exports, module) {
    exports.run = function () {
        $(".menu .item:not('#edit')").on('click', function (e) {
            item = $(e.target);
            menuChange(item);
        });
    };
    function menuChange(toItem) {
        // 改变选项状态
        $(".active.teal.item").attr("class", "item");
        toItem.attr("class", " active teal item");
        // 滚动到对应位置
        var toDisease = $(toItem.attr('data-id'));
        //滚动到对应疾病位置
        $('html, body').animate(
            {scrollTop: toDisease.position().top}, 300);

    }
});