$(document).ready(function () {
    $("#meridien").select2({
        placeholder: "Méridiens"
      });
    $("#keyword").select2({
        placeholder: "Mots clés"
    });
    $("#type").select2({
        placeholder: "Type de pathologie"
    });
    $("#caracteristique").select2({
        placeholder: "Caractéristiques"
    });
    
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
        },
        close: function(event, ui) {
            location.reload(true);
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
    
    $(document).submit('#formConnexion',function (e){
        e.preventDefault(); 
        var element = $('#formConnexion');
        $.ajax({
            url: element.attr('action'),
            type: "GET",
            dataType: 'html',
            contentType: 'text/html',
            data: element.serialize(), 
            success: function (data) {
                $('#formConnexion').html(data);
            }
        });
        return false;
    });
    
    $('.logout-class').click(function (e) {
        e.preventDefault(); 
        element = $(this);
        $.ajax({
            url: element.data('href'),
            type: "DELETE",
            dataType: 'html',
            contentType: 'text/html',
            success: function (data) {
                location.reload(true);
            }
        });
    });
    
    $("#formPatho").change("input,select",function () {
        element = $(this);
        var loader = "<div id='loader'><img src='/media/images/ring.gif' alt='loader'></div>";
        $("#resultat").fadeOut(function () {
            $("#resultat").html(loader);
        });
        $("#resultat").fadeIn();
        $.ajax({
            url: element.attr('action'),
            type: "GET",
            dataType: 'html',
            contentType: 'text/html',
            data: element.serialize(), 
            success: function (data) {
                $("#resultat").fadeOut(function () {
                    $("#resultat").html(data);
                    $("#resultat").fadeIn();
                });
            }
        });
    });
});
