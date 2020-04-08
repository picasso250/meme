$(function () {
    var btn=$('button');
    $('form').submit(function(event) {
        event.preventDefault();
        var email=$('input').val();
        $(btn).prop('disabled',true);
        $(btn).text('正在努力发送邮件...');
        $.post(URL_ROOT+'/login', {email: email}, function(data){
            $(btn).text("已经发送成功，请查看邮件以登陆");
            console.log(data);
        });
    })
});