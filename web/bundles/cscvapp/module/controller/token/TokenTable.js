/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/8
 * Time: 上午9:22
 */
define(function (require, exports, module) {
    require("semantic-dimmer");
    require("semantic-modal");
    require("semantic-form");
    var Widget = require('arale-widget');
    var TokenTable = Widget.extend({
        element: '#token_table',
        attrs: {
            'newModal': $("#newModal"),
            'editModal': $('#editModal'),
            'removeModal': $('#removeModal')
        },
        events: {
            'click #showNewModal': 'showNewModal',
            'click [data-method="edit"]': 'showEditModal',
            'click [data-method="remove"]': 'showRemoveModal'
        },
        setup: function () {
            this.initModals();
        },
        initModals: function () {
            var this_el = this;
            var newModal = this.get("newModal");
            var editModal = this.get("editModal");
            var removeModal = this.get("removeModal");


            newModal.modal({
                onApprove: function () {
                    newModal.find('form').form(
                        'validate form'
                    );
                    return false;
                },
                selector: {
                    approve: '#newAction'
                }
            });

            editModal.modal({
                onApprove: function () {
                    editModal.find('form').form(
                        'validate form'
                    );
                    return false;
                },
                onHidden: function () {
                    // 清空
                },
                selector: {
                    approve: '#updateAction'
                }
            });

            removeModal.modal({
                onApprove: function () {
                    this_el.doRemove();
                },
                selector: {
                    approve: '#removeAction'
                }
            });

            // 初始化各个Modal的form
            this.initFormValidator(newModal);
            this.initFormValidator(editModal);
        },
        initFormValidator: function (modal) {
            var this_el = this;
            var formValidationRules = {
                name: {
                    identifier: 'api_token_appName',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '应用名不能为空'
                        }
                    ]
                }
            };
            var formSettings = {
                // 表单验证成功，实例化
                onSuccess: function () {
                    modal.modal('hide');
                    this_el.doSave(modal);
                }
            };
            modal.find('form').form(
                formValidationRules,
                formSettings
            );
        },
        showNewModal: function () {
            this.get('newModal').modal('toggle');
        },
        showEditModal: function (e) {
            this.refreshEditModal(e);
            this.get('editModal').modal('toggle');
        },
        showRemoveModal: function (e) {
            var btn = $(e.target);
            var url = btn.attr('data-url');
            var tr = btn.parents('tr');
            var id = tr.attr('data-id');
            this.get('removeModal').attr('data-id', id);
            this.get('removeModal').modal('toggle');
        },
        // 刷新编辑Modal
        refreshEditModal: function (e) {
            var btn = $(e.target);
            var tr = btn.parents('tr');
            var appName = tr.find('[data-type="colAppName"]').text();
            var limit = tr.find('[data-type="colLimit"]').text();
            var date = new Date(limit);
            var id = tr.attr('data-id');
            var modal = this.get('editModal');
            modal.find('#token_id').val(id);
            modal.find('#api_token_appName').val(appName);
            modal.find('#api_token_limit_year').val(date.getFullYear());
            modal.find('#api_token_limit_month').val(date.getMonth() + 1);
            modal.find('#api_token_limit_day').val(date.getDate());

        },
        doSave: function (modal) {
            var form = modal.find('form');
            var values = {};
            var url = modal.attr('data-url');
            // 序列化表单参数
            $.each(form.serializeArray(), function (i, field) {
                values[field.name] = field.value;
            });
            var method = modal.selector == '#newModal' ? 'POST' : 'PUT';
            $.ajax({
                url: url,
                method: method,
                data: values,
                dataType: 'json',
                async: true,
                success: function (data) {
                    if (data.message == 'success')
                        window.location.reload();
                }
            });
            return true;
        },
        doRemove: function () {
            var removeModal = this.get('removeModal');
            var url = removeModal.attr('data-url');
            var id = removeModal.attr('data-id');
            $.ajax({
                    url: url,
                    dataType: 'json',
                    data: 'id=' + id,
                    type: 'DELETE',
                    success: function (data) {
                        if (data.message == 'success')
                            window.location.reload();
                    }
                }
            );
        }
    });
    module.exports = TokenTable;
});