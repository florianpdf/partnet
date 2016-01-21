$(document).ready(function() {
    $("#appbundle_organisme_backgroundColor").colorpicker({
        displayIndicator: false,
        hideButton: true,
        history: false,
        showOn: "focus",
        strings: "Couleurs de themes,Couleurs de base,Plus de couleurs,Moins de couleurs,Palette,Historique,Pas encore d'historique."
    });
});
$("#appbundle_organisme_backgroundColor").on("change.color", function(event, color){
    $('#appbundle_organisme_backgroundColor').css('background-color', color);
});
$("#appbundle_organisme_backgroundColor").colorpicker("showPalette");
