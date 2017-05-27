$(function() {
    menuShow();
    selectByTitle();
});

function menuShow() {
    $('.menu ul li').mouseover(function() {
        $('.menu-item')[($(this).index())].style.display = 'block';
    });
    $('.menu ul li').mouseout(function() {
        $('.menu-item')[($(this).index())].style.display = 'none';
    });
    $('.menu-item').mouseover(function() {
        $(this).css('display', '  block ');
    });
    $('.menu-item').mouseout(function() {
        $(this).css('display', 'none');
    });
}

function selectByTitle() {
    $('.select-auth ul li h4').click(function() {
        if ($(this).parent().find('input').attr('checked')) {
            $(this).parent().parent().find('input').removeAttr('checked'); //取消选择当前权限下的所有选项
        } else {
            $(this).parent().parent().find('input').attr('checked', 'checked'); //选择当前权限下的所有选项
        }
    });
}