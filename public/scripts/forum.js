// Hide/unhide categories
$(function () {
    $('.toggleCategory').click(function () {
        var getClass = ($(this).attr("class") == 'fas toggleCategory fa-toggle-on');
        if (getClass) { // check if icon/button has on or off class
            $(this).removeClass('fa-toggle-on');
            $(this).addClass('fa-toggle-off');
            $(this).nextAll("#categories").first().css('display', 'none'); //hide all categories
            $(this).nextAll("#container").first().css('background-color', 'rgba(204, 133, 0, 0.70)');
            $(this).nextAll("#container").first().css('border-color', 'rgba(143, 21, 21, 0.70)');
        } else {
            $(this).removeClass('fa-toggle-off');
            $(this).addClass('fa-toggle-on');
            $(this).nextAll("#categories").first().css('display', 'initial');
            $(this).nextAll("#container").first().css('background-color', '#CC8400');
            $(this).nextAll("#container").first().css('border-color', 'rgb(143, 21, 21)');
        }
    });
});