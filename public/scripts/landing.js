$(document).ready(function () {
  var color = 'one';
  var counter = 0;

  // hide the description at the start
  $('.desc').hide();

  // unhide Game and Forum and give a color
  $('.Game').show();
  $('.Forum').show();
  $('.Game').addClass('link');
  $('.Forum').addClass('link');

  // on click redirect to Game or Forum
  $('.Game').click(function () {
    window.location.href = '/game';
  });
  $('.Forum').click(function () {
    window.location.href = '/forum';
  });

  // increment a counter for each different hover so the color changes for the next hexagon
  $('.hexagon').hover(
    function () {
      $(this).find('.desc').fadeIn('fast');
      counter++;
      if (counter === 0) {
        color = 'base';
      } else if (counter === 1) {
        color = 'one';
      } else if (counter === 2) {
        color = 'two';
      } else if (counter === 3) {
        color = 'three';
      } else if (counter >= 4) {
        counter = 0;
        color = 'base';
      }
      $(this).find('.desc').addClass(color);
    },
    function () {
      $(this).find('.desc').fadeOut('fast', function () {
        $(this).removeClass(color);
      });
    });
});