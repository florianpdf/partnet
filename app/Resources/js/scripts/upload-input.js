$( ".fileUpload input" ).change(function() {
    var selected_file = $( this ).val();
    // if true : évite que l'input ne soit vidé si l'utilisateur clique sur "Annuler"
    if (selected_file) {
        $( this).prev().text( selected_file );
    }
});