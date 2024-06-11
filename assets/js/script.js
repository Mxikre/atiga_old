$(document).ready(function () {
    $(window).scroll(function () {
        var wScroll = $(this).scrollTop();

        if ((wScroll / 10)) {
            $('.card').addClass('right-slide');
            $('.cod').addClass('left-slide');
        }
    });
});
