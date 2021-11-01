$(function () {
    $('.menu-btn').on('click', function () {
        $('.menu').toggleClass('menu-active');
        $('.first-span').toggleClass('first-span-active');
        $('.last-span').toggleClass('last-span-active');
        $('.center-span').toggleClass('center-span-active');

    });
});