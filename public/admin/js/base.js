$(function() {

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
});