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
});
