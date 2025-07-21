$(document).ready(function(){

    $("button").on('click', function(event){
        event.preventDefault();
        let target = $(this).data('target');
        $("div").remove("#" + target);
    });

})