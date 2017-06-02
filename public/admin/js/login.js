$(function() {
    $('#submit-bt').click(function() {
        if (check()) {
            $.ajax({
                'type': 'post',
                'url': '',
                'data': 'm_name=adf&m_passwd=jiojji',
                success: function(msg) {
                    // alert(msg.message);
                    alert(msg.info);
                }
            });

        }
    });
});

function check() {
    var namePattern = /\W+/;
    var username = $('#name').val();
    var passwd = $('#pwd').val();
    $('.check-info').html('');
    if (username.length < 2 || username.length > 12) {
        // alert('用户名长度2到12位');
        $('.check-info')[0].innerHTML = '用户名长度2到12位';
        return;
    }
    if (passwd.length < 6) {
        $('.check-info')[1].innerHTML = '密码长度不得少于6位';
        return;
    }
    if (namePattern.test(username)) {
        $('.check-info')[0].innerHTML = '账号不合法,只允许数字字母下划线';
        return;
    }
    if (namePattern.test(passwd)) {
        $('.check-info')[1].innerHTML = '密码不合法,只允许数字字母下划线';
        return;
    }
    if ($('#vCode').val().length != 5) {
        $('.check-info')[2].innerHTML = '验证码不合法,验证码长度为5位';
        return;
    }
    return true;
}