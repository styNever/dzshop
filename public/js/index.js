$(function() {
    var imgRoll = new imgScroll();
    $(imgRoll.img[0]).css('z-index', '1'); //初始化图片位置
    $(imgRoll.i[0]).addClass('img-active'); //初始化图片位置
    imgRoll.IntervalId = imgRoll.setIntervalFn(imgRoll); //设置定时器
    changeDot(imgRoll);
});

var imgScroll = function() {};
imgScroll.prototype.count = 0; //计数
imgScroll.prototype.size = $('.img-control-bar i').length; //总数量
imgScroll.prototype.img = $('.scroll-img img'); //滚动图片集合
imgScroll.prototype.i = $('.img-control-bar i'); //控制
imgScroll.prototype.IntervalId;
imgScroll.prototype.setIntervalFn = function(imgRoll) {
    return setInterval(function() { //定时器
        imgRoll.changeImg(imgRoll);
    }, 2000);
};

function changeDot(imgRoll) { //切换红点
    $('.img-control-bar i').click(function() {
        imgRoll.count = $(this).index();
        imgRoll.changeImg(imgRoll, true);
    });
}

imgScroll.prototype.changeImg = function(imgRoll, clean) {
    if (imgRoll.count >= imgRoll.size) imgRoll.count = 0;
    imgRoll.img.css('z-index', '0').css('opacity', '0');
    // imgRoll.i.css('background', '#fff');
    // $(imgRoll.i[imgRoll.count]).css('background', '#db192a');
    imgRoll.i.removeClass('img-active');
    $(imgRoll.i[imgRoll.count]).addClass('img-active');
    $(imgRoll.img[imgRoll.count]).animate({
        opacity: '1',
        'z-index': '0'
    }, 1, function() {
        imgRoll.count = imgRoll.count + 1;
        if (imgRoll.count == imgRoll.size || clean) {
            clearInterval(imgRoll.IntervalId);
            imgRoll.IntervalId = imgRoll.setIntervalFn(imgRoll);
        }
    });
}