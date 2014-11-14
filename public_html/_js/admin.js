$(document).ready(function()
{
    $("#question_list").sortable({ items: ".question" });
    $("#question_list").disableSelection();
     
    $('#question_list').on( "sortstop", function( event, ui )
    {
        var orderData = [];
        $('#question_list .question').each(function(i, e)
        {
            $(e).find('.number').html(i+1);
            orderData[(i+1)] = $(e).data('id');
        });
        
        $.ajax(
        {
            type: 'POST',
            url: "/order",
            data: { orderData: orderData },
            cache: false,
            success: function(data)
            {
                
            },
            error: function(data)
            {
                
            },
        });
    });
});