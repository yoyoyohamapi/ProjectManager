/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/4/24
 * Time: 下午10:40
 */
define(function (require, exports, module) {
    require('jquery-file-upload');
    require('jquery-file-upload-process');
    require('jquery-file-upload-validate');
    require('jquery-file-upload-image');
    require('semantic-progress');
    require('semantic-checkbox');
    var Widget = require('arale-widget');
    var Calibrate = Widget.extend({
        element: '#calibrate',
        attrs: {
            // 存储图像数组
            imageArray: [],
            arraySize: 0,
            baseUrl: 'storage/images/tmp',
            showSelectDialog: $("#showSelectDialog"),
            fileupload: $("#fileupload"),
            progress: $("#progress"),
            calibrateProgress: $("#calibrateProgress"),
            card: $("#card"),
            form: $("form"),
            previewMaxWidth: 220,
            previewHeight: 220,
            previewCrop: true,
            files: [],
            currentFile: undefined,
        },
        events: {
            'click #submit': 'doSubmit',
            'click #showSelectDialog': 'showSelectDialog',
            'click #diseaseList>.item>button': 'setDisease',
            'click #locationList>.item>button ': 'setLocation',
            'click #croppedHolder': 'setCropped'
        },
        setup: function () {
            // 初始化文件上传组件
            this.initFileUpload();
            // 初始化表单中的select
            this.initFormOptions();
        },
        // 初始化文件上传
        initFileUpload: function () {
            // 初始化时文件上传组件
            var this_el = this;
            var fileupload = this.get('fileupload');
            var progress = this.get('progress');
            var calibrateProgress = this.get('calibrateProgress');
            // 初始化上传进度条以及标定进度条
            progress.progress({
                percent: 0
            });
            calibrateProgress.progress({
                percent: 0
            });
            var card = this.get('card');
            var imageArray = this.get('imageArray');
            var baseUrl = this.get('baseUrl');
            // 设定上传参数
            var upload = fileupload.fileupload({
                dataType: 'json',
                sequentialUploads: true,
                // 只接受jpg图像类型,/i 表示匹配的时候忽视大小写
                acceptFileTypes: /(\.|\/)(jpe?g)$/i,
                autoUpload: true,
                start: function (e) {
                    // 隐藏上传框，显示进度条
                    this_el.get('showSelectDialog').transition({
                            animation: 'fade',
                            duration: '0.5s',
                            onComplete: function () {
                                progress.transition({
                                    animation: 'fade',
                                    duration: '0.5s'
                                });
                            }
                        }
                    );
                },
                progressall: function (e, data) {
                    // 当前进度
                    var ratio = parseInt(data.loaded / data.total * 100, 10);
                    progress.progress({
                        percent: ratio
                    });
                },
                done: function (e, data) {
                    // 每次完成，保存上传后的图像路径
                    var image_name = data.result.data.tmp_path;
                    imageArray.push(image_name);
                }
            }).on('fileuploadprocessalways', function (e, data) {
                var currentFile = data.files[data.index];
                if (data.files.error && currentFile.error) {
                    alert("文件类型错误");
                }
            }).on('fileuploadstop', function (e) {
                this_el.set('arraySize', imageArray.length);
                // 上传结束，隐藏进度条，
                progress.transition({
                    animation: 'scale',
                    duration: '0.5s',
                    onComplete: function () {
                        this_el.get('card').transition({
                            animation: 'scale',
                            duration: '1s'
                        });
                    }
                });
                this_el.refreshCard();
            });
        },
        // 初始化表单中的select
        initFormOptions: function () {
            var diseaseList = this.$("#diseaseList");
            var locationList = this.$("#locationList");
            // 初始化疾病
            this.$('#image_disease option').each(function () {
                diseaseList.append("<div class='item'><button class='ui red mini button' data-value='" +
                $(this).val() + "'>"
                + $(this).text()
                + "</button></div>");
            });
            // 默认选中第一个疾病
            this.$("#diseaseList>.item:first").find('button').click();
            // 初始化部位
            this.$('#image_location option').each(function () {
                locationList.append("<div class='item'><button class='ui teal mini button' data-value='" +
                $(this).val() + "'>"
                + $(this).text()
                + "</button></div>");
            });
            // 默认选中第一个部位
            this.$("#locationList>.item:first").find('button').click();

        },
        // 刷新标定卡
        refreshCard: function () {
            var this_el = this;
            var baseUrl = this.get('baseUrl');
            var continueUpload = this.get('showSelectDialog');
            var imageArray = this.get('imageArray');
            var cardSrcContent = this.get('cardSrcContent');
            var formSrcContent = this.get('formSrcContent');
            var card = this.get('card');
            var form = this.get('form');
            if (imageArray.length) {
                var imageName = imageArray.pop();
                var imageFullPath = 'http://' + window.location.host + '/' + baseUrl + "/" + imageName;
                // 初始化checkbox
                card.find(".ui.checkbox").checkbox();
                // 更新预览图
                card.find('#preview').attr('src', imageFullPath);
                // 更新hidden input
                form.find("input#image_name").attr('value', imageName);
            } else {
                // 标定结束,显示继续上传
                card.transition({
                    animation: 'scale',
                    duration: '0.5s',
                    onComplete: function () {
                        this_el.initFileUpload();
                        continueUpload.transition({
                            animation: 'scale',
                            duration: '0.5s'
                        });
                    }
                });
            }
        },
        // 设置是否剪裁
        setCropped: function (e) {
            // 切换标签文字
            var tagTxt = this.$("#croppedTag").text() == '已剪裁' ? '未剪裁' : '已剪裁';
            this.$("#croppedTag").text(tagTxt);
            this.$("#image_cropped").click();
        },
        // 设置疾病
        setDisease: function (e) {
            var disease = $(e.target).attr('data-value');
            var diseaseName = $(e.target).text();
            this.$('#image_disease').val(disease);
            // 设置标签
            this.$('#diseaseTag').text(diseaseName);
        },
        // 设置部位
        setLocation: function (e) {
            var location = $(e.target).attr('data-value');
            var locationName = $(e.target).text();
            // 设置表单项
            this.$('#image_location').val(location);
            this.$('#locationTag').text(locationName);
        },
        // 提交表单
        doSubmit: function (e) {
            var submitBtn = $(e.target);
            var this_el = this;
            var form = this.get('form');
            var values = {};
            // 设置按钮不可按
            submitBtn.attr('disabled', true);
            // 序列化表单参数
            $.each(form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: values,
                dataType: 'json',
                success: function (data) {

                    // 成功标定后，进行下一张图像标定,并更新进度
                    this_el.refreshCard();
                    var curImageIndex = this_el.get('arraySize')
                        - this_el.get('imageArray').length;
                    // 当前进度
                    var ratio = parseInt(curImageIndex / this_el.get('arraySize') * 100, 10);
                    this_el.get('calibrateProgress').progress({
                        percent: ratio
                    });

                    submitBtn.attr('disabled', false);
                }
            });
        },
        // 显示文件上传框
        showSelectDialog: function () {
            this.get('fileupload').click();
        }
    });

    module.exports = Calibrate;

});