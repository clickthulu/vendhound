$(document).ready(function(){

    $("button").on('click', function(event){
        event.preventDefault();
        let target = $(this).data('target');
        $("div").remove("#" + target);
    });


    $(".mailaddress_ajax_submit").on('click', function(event){
        event.preventDefault();
        let target = "/address/add"
        let data = {};

        $('.mailaddress-input').each(function(idx, item){
            let itemName = $(item).attr('name');
            data[itemName] = $(item).val();
        });

        $.post(
            target,
            data
        ).done(function(returnData){
            $('.address-target').empty();
            $.each(returnData['addresses'], function(key, value){
                $('.address-target').append($("<option></option>").attr('value', value.id).text(value.name));
            });
            console.log(returnData); // We should return the value of the mail address for this user
        }).fail(function(returnData){
            console.log("Error");
            console.log(returnData);
        })




    })

})