$(function () {
    $('.toggleCategory').click(function () {
        var getClass = ($(this).attr("class") == 'fas toggleCategory fa-toggle-on');
        if (getClass) {
            $(this).removeClass('fa-toggle-on');
            $(this).addClass('fa-toggle-off');
            $('#categories').first().css('display', 'none');
        } else {
            $(this).removeClass('fa-toggle-off');
            $(this).addClass('fa-toggle-on');
            $('#categories').first().css('display', 'initial');
        }
    });
});