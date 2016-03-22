$(document).ready(function () {
    $("#popup").dialog({
        autoOpen: false,
        modal: true,
        height: 'auto',
        width: 'auto',
        dialogClass: "sc-jquery-popup",
        show: {
            effect: "fade",
            duration: 250
        },
        hide: {
            effect: "fade",
            duration: 250
        }
    });
    $('.ajax-popup').click(function () {
        element = $(this);
        $.ajax({
            url: element.data('href'),
            dataType: 'html',
            success: function (data) {
                $("#popup").html(data);
                $("#popup").dialog("option", "title",element.data('titre'));
                $("#popup").dialog("option", "width", 400);
                $("#popup").dialog("open");
            }
        });
    });
});