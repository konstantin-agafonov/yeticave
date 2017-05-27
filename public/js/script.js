$(document).ready(function(){

    $('.main-header__search').submit(function(e){
        e.preventDefault();
        var searchString = $(this).find('input[name="search_string"]').val();
        window.location.href = "http://" + document.location.hostname + "/search/" + encodeURIComponent(searchString);
    });

});