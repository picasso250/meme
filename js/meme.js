$(function () {
    
    
    // 修改标题按钮
    $('.change.btn').click(function () {
        var that = $(this).hide();
        var title = that.parent().find('h2').hide();
        var titleStr = title.text();
        var input = $('<input name="title" value="' + titleStr + '" />');
        var cancel = $('<span class="cancel btn">取消</span>').click(function () {
            title.show();
            form.remove();
            that.show();
        });
        var form = $('<form method="post"></form>');
        form.append(input).append('<input type="submit" value="好" />').append(cancel);
        that.before(form);
    });
    
    var baseForm = function () {
        var ta = $('<textarea name="text"></textarea>');
        var ok = $('<input type="submit" value="好" />');
        var cancel = $('<span class="cancel btn">取消</span>').click(function () {
            form.hide();
        });
        var form = $('<form method="post"></form>').
            append(ta).append(ok).append(cancel);
        return { textarea:ta, okBtn:ok, cancelBtn:cancel, form:form };
    };
    
    // 编辑按钮
    $('.edit.btn').click(function () {
        // hide div
        // show form
        var that = $(this);
        var div = that.parents('div.node');
        var id = div.attr('data-id');
        var text = div.find('.text').hide();
        var textStr = text.text();
        var control = div.find('.control').hide();
        var f = baseForm();
        var ta = f.textarea.val(textStr);
        f.cancelBtn.click(function () {
            text.show();
            control.show();
        });
        var form = f.form.submit(function () {
            f.okBtn.val('稍等').prop('disabled', true);
            $.post('?', {
                a: 'edit',
                node: id,
                text: ta.val()
            }, function (ret) {
                window.location.href = ret;
            }, 'json');
            return false;
        });
        div.append(form);
    });
    
    // 在其后加入 按钮
    $('.add.btn').click(function () {
        var that = $(this).hide();
        var id = that.attr('data-id');
        var f = baseForm();
        var ta = f.textarea;
        f.cancelBtn.click(function () {
            ad.remove();
            that.show();
        });
        var form = f.form.submit(function () {
            f.okBtn.val('稍等').prop('disabled', true);
            $.post('?', {
                a: 'after',
                node: id,
                text: ta.val()
            }, function (ret) {
                window.location.href = ret;
            }, 'json');
            return false;
        });
        var ad = $('<div class="node"></div>').append(form);
        that.after(ad);
    });
    
    // 删除按钮
    $('.del.btn').click(function () {
        var id = $(this).parents('div.node').attr('data-id');
        $.get('?', {
            a: 'delete',
            node: id
        }, function (ret) {
            window.location.href = ret;
        }, 'json');
    });
});