$(document).on("click", "#click_print", function () {
    $("#element_print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});
//add3Dots("Hello World",9);
function add3Dots(string, limit) {
    var dots = "...";
    if (string.length > limit) {
        string = string.substring(0, limit) + dots;
    }

    return string;
}

//addDots(9);
function addDots(limit) {
    var dots = ".";
    var html = "";
    limit = parseInt(limit);
    for (var i = 0; i < limit; i++) {
        html += dots;
    }

    return html;
}