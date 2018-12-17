let xhr = new XMLHttpRequest();
let input = document.getElementById('gameSearch');
let form = document.getElementById('search');
let result = document.getElementById('searchResult');
let searchButton = document.getElementById('buttonSearch');
let closeButton = document.getElementById('closeSearch');

searchButton.addEventListener('click', function (e) {
    e.preventDefault();
    closeButton.style.display = 'initial';
    searchButton.style.display = 'none';
    result.innerText = '';
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            result.innerText = '';
            let gameInfo = JSON.parse(this.responseText);
            gameInfo.forEach(function (element) {
                result.style.display = 'initial';
                result.innerHTML += "<li>" + element.name + "</li>";
            });
        }
    });

    xhr.open("GET", "https://cors-anywhere.herokuapp.com/https://api-2445582011268.apicast.io/games/?search=" + input.value + "&fields=id,name,total_rating");
    xhr.setRequestHeader("user-key", "f52352e7365211a1674dda4f6e8b01ce");

    xhr.send();
});

closeButton.addEventListener('click', function (e) {
    e.preventDefault();
    searchButton.style.display = 'initial';
    closeButton.style.display = 'none';
    result.innerText = '';
    result.style.display = 'none';
});
