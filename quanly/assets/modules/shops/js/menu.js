$(document).ready(function() {
    $(".nav .dropdown-toggle").click(function() {
        window.location = $(this).attr('href');
    });
});