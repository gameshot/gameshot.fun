let button = document.getElementById("gameSearchButton");
let input = document.getElementById("gameSearch");

button.addEventListener('click', function () {

    let xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            console.log(this.response);
        }
    });

    xhr.open("GET", "http://api-2445582011268.apicast.io/games/?search=" + input.value + "&fields=id,name,total_rating", true);
    xhr.setRequestHeader("user-key", "f52352e7365211a1674dda4f6e8b01ce");

    xhr.send(null);
});

