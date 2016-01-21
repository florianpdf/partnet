$(document).ready(function() {
    $("#appbundle_organisme_backgroundColor").colorpicker({
        strings: "Couleurs de themes,Couleurs de base,Plus de couleurs,Moins de couleurs,Palette,Historique,Pas encore d'historique.",
        history: false,
        color: "#c0504d",
        hideButton: true,
        displayIndicator: false
    });
});
$("#appbundle_organisme_backgroundColor").on("change.color", function(event, color){
    $('#appbundle_organisme_backgroundColor').css('background-color', color);
});
$("#appbundle_organisme_backgroundColor").colorpicker("showPalette");

// https://github.com/evoluteur/colorpicker //