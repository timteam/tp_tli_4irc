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
        $("#popup").html('<div>connexion</div>');
        $("#popup").dialog("option", "title", "connexion");
        $("#popup").dialog("option", "width", 800);
        $("#popup").dialog("open");
        $.ajax({
            url: element.data('href'),
            dataType: 'html',
            success: function (data) {
                element.parents('.fiche_bien').slideUp({
                    duration: 250,
                    easing: 'easeInQuad'
                });
            }
        });
    });
});