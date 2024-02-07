$(document).ready(function () {
    $.get("/stillAlive");
    setInterval(function () {
        $.get("/stillAlive");
    }, 10000);
});