setTimeout(function () {
    location.href = "http://localhost/game";
}, 10000);

let barWidth = 100;
let bars = document.querySelectorAll('.progress-bar-animated');
setInterval(function () {
    barWidth -=10;
    bars.forEach(function (bar) {
        bar.style.width = barWidth + '%';
    });
}, 1000);