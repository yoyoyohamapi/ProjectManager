define(function (require, exports, module) {
    exports.run = function () {
        $('#submit').click(function () {
            var values = {};
            $.each($("form").serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            $.ajax({
                type: $("form").attr('method'),
                url: $("form").attr('action'),
                data: values,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                }
            });
        });
    }
});