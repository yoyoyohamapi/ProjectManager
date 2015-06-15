define(function (require, exports, module) {
    exports.run = function () {
        $(".menu .item").on('click', function (e) {
            item = $(e.target);
            menuChange(item);
        });
    };
    function menuChange(toItem) {
        $(".active.teal.item").attr("class", "item");
        toItem.attr("class", " active teal item");
    }
});