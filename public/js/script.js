$(document).ready(function(){

    $('.main-header__search').submit(function(e){
        e.preventDefault();
        var searchString = $(this).find('input[name="search_string"]').val();
        window.location.href = "http://" + document.location.hostname + "/search/" + encodeURIComponent(searchString);
    });

    $('.main-header__search input[name="search_string"]').autocomplete({
        minLength: 3,
        source: function( request, response ) {
            $.ajax( {
                url: "http://" + document.location.hostname + "/search/suggest/"
                    + encodeURIComponent($('.main-header__search input[name="search_string"]').val()),
                method: 'GET',
                success: function( data ) {
                    response( data );
                }
            } );
        }
    });

});