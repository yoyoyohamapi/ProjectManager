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
            //当前状态标识：是否为新建，反之为编辑
            isInNewing: true,
            // 存储图像数组
            imageArray: [],
            arraySize: 0,
            baseUrl: 'storage/images/tmp',
            showSelectDialog: $("#showSelectDialog"),
            fileupload: $("#fileupload"),
            fileload: $("#fileload"),
            imageServer: '192.168.1.137:8081/images',
            progress: $("#progress"),
            calibrateProgress: $("#calibrateProgress"),
            card: $("#card"),
            newForm: $("#newFormContainer").find("form"),
            editForm: $("#editFormContainer").find("form"),
            previewMaxWidth: 220,
            previewHeight: 220,
            previewCrop: true,
            files: [],
            currentFile: undefined
        },
        events: {
            'click #submit': 'doSave',
            'click #showSelectDialog': 'showSelectDialog',
            'click #diseaseList>.item>button': 'setDisease',
            'click #locationList>.item>button ': 'setLocation',
            'click #croppedHolder': 'setCropped',
            'click #fileload': 'loadImages'
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
                    // 隐藏操作框，显示进度条
                    $('#actions').transition({
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
                        // 完成后显示标定卡
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
            this.get("newForm").find('#image_disease option').each(function () {
                diseaseList.append("<div class='item'><button class='ui red mini button' data-value='" +
                $(this).val() + "'>"
                + $(this).text()
                + "</button></div>");
            });
            // 默认选中第一个疾病
            this.$("#diseaseList>.item:first").find('button').click();
            // 初始化部位
            this.get("newForm").find('#image_location option').each(function () {
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
            var imageArray = this.get('imageArray');
            var card = this.get('card');
            if (imageArray.length) {
                var imageFullPath = '';
                // 新建图像标定过程
                if (this.get('isInNewing')) {
                    var imageName = imageArray.pop();
                    imageFullPath = 'http://' + window.location.host + '/' + baseUrl + "/" + imageName;
                    this.get("newForm").find("input#path").attr('value', imageName);

                } else {
                    //编辑图像标定过程
                    var image = imageArray.pop();
                    // 显示缺失标记
                    if (!image.hasOwnProperty('disease')) {
                        //如果疾病缺失,提示缺失
                        card.find('#diseaseMisLabel').show();
                    } else {
                        // 否则疾病选中
                        $("#diseaseList").find("[data-value='" + image.disease + "']").click();
                    }
                    if (!image.hasOwnProperty('location')) {
                        //如果部位缺失,提示缺失
                        card.find("#locationMisLabel").show();
                    } else {
                        //否则部位选中
                        $("#locationList").find("[data-value='" + image.location + "']").click();
                    }
                    imageFullPath = 'http://' + this.get("imageServer") + '/' + image.file;
                    this.get("editForm").find("input#image_id").attr('value', image.id);
                }
                //-------------更新card------------------
                // 初始化checkbox
                card.find(".ui.checkbox").checkbox();
                // 更新预览图
                card.find('#preview').attr('src', imageFullPath);

            } else {
                // 标定结束,显示操作框
                card.transition({
                    animation: 'scale',
                    duration: '0.5s',
                    onComplete: function () {
                        this_el.initFileUpload();
                        $("#actions").transition({
                            animation: 'scale',
                            duration: '0.5s'
                        });
                    }
                });
            }
        },
        // 设置是否剪裁
        setCropped: function (e) {
            var isInNewing = this.get('isInNewing');
            var form = isInNewing == true ?
                this.get('newForm') : this.get('editForm');
            // 切换标签文字
            var tagTxt = this.$("#croppedTag").text() == '已剪裁' ? '未剪裁' : '已剪裁';
            this.$("#croppedTag").text(tagTxt);
            form.find("#image_cropped").click();
        },
        // 设置疾病
        setDisease: function (e) {
            var isInNewing = this.get('isInNewing');
            var form = isInNewing == true ?
                this.get('newForm') : this.get('editForm');
            var disease = $(e.target).attr('data-value');
            var diseaseName = $(e.target).text();
            form.find('#image_disease').val(disease);
            // 设置标签
            this.$('#diseaseTag').text(diseaseName);
        },
        // 设置部位
        setLocation: function (e) {
            var isInNewing = this.get('isInNewing');
            var form = isInNewing == true ?
                this.get('newForm') : this.get('editForm');
            var location = $(e.target).attr('data-value');
            var locationName = $(e.target).text();
            // 设置表单项
            form.find('#image_location').val(location);
            this.$('#locationTag').text(locationName);
        },
        // 存储图像
        doSave: function (e) {
            var submitBtn = $(e.target);
            var this_el = this;
            // 根据当前状态决定表单操作目的
            var isInNewing = this.get('isInNewing');
            var form = isInNewing == true ?
                this.get('newForm') : this.get('editForm');
            var method = isInNewing == true ?
                'POST' : 'PUT';
            var values = {};
            // 设置按钮不可按，避免连续点击12
            submitBtn.attr('disabled', true);
            // 序列化表单参数
            $.each(form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            $.ajax({
                type: method,
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
            //当前模式为新建
            this.set('isInNewing', true);
            this.get('fileupload').click();
        },
        // 读取已有文件，对信息不完整者进行标定
        loadImages: function (e) {
            //当前状态改为编辑
            this.set('isInNewing', false);
            var btn = $(e.target);
            var this_el = this;
            $.ajax({
                url: btn.attr('data-url'),
                type: 'get',
                dataType: 'json',
                statusCode: {
                    200: function (data) {
                        // 刷新图像数组
                        this_el.setImgObj2ImgArray(data.data);
                        // 隐藏操作框，显示card
                        $('#actions').transition({
                                animation: 'fade',
                                duration: '0.5s',
                                onComplete: function () {
                                    // 完成后显示标定卡
                                    this_el.get('card').transition({
                                        animation: 'scale',
                                        duration: '1s'
                                    });
                                }
                            }
                        );
                        this_el.refreshCard();
                    }
                }
            });
        },
        //将图像Obj数组转换为一般数组
        setImgObj2ImgArray: function (obj) {
            var imageArray = [];
            $.each(obj, function (key, value) {
                var image = {};
                image.id = key;
                image.file = value['imageFiles'][0]['$id']['$id'];
                if (value.hasOwnProperty('disease'))
                    image.disease = value['disease']['$id'];
                if (value.hasOwnProperty('location'))
                    image.location = value['location'];
                imageArray.push(image);
            });
            this.set('imageArray', imageArray);
            this.set('arraySize', imageArray.length);
        }
    });

    module.exports = Calibrate;

});