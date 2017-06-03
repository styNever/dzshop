$(function() {
    $('#submit-bt').click(function() {
        postData();
    });
    $('.vCode-img').click(function() {
        reloadImg();
    });
});


function postData() {
    if (check()) {
        $.ajax({
            'type': 'post',
            'data': 'm_name=' + $('#name').val() + '&m_passwd=' + $('#pwd').val() + ',&vCode=' + $('#vCode').val(),
            success: function(msg) {
                if (!msg.errorCode) {
                    $('.msg-error').html(msg.message);
                    setTimeout(function() {
                        location.href = msg.url;
                    }, 500);
                } else {
                    reloadImg();
                    $('.msg-error').html(msg.message);
                }
            }
        });
    }
}

function check() {
    var namePattern = /\W/;
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

function reloadImg() {
    $('.vCode-img').attr('src', '/index.php/admin/common/getVCode.html?code=' +
        new Date().getTime());
}