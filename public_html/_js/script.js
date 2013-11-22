$(document).ready(function()
{
    /* LINEAR LISTINGS */
    
    $('.linear_item_expanded').removeClass('linear_item_expanded');
    
    $('.listing .linear_item h2').click(function(e)
    {
        var item = $(this).closest('.linear_item');
        if(!$(item).hasClass('linear_item_expanded'))
        {
            $(item).addClass('linear_item_expanded');
        }
        else
        {
            $(item).removeClass('linear_item_expanded');
        }
        return false;
    });
    
    /* LISTING FILTER */
    
    
    // Uncomment to make course filter automatically collapse 
    //$('.listing_filter_expanded').removeClass('listing_filter_expanded');
    
    $('.listing_filter h2').click(function()
    {
        var item = $(this).closest('.listing_filter');
        if(!$(item).hasClass('listing_filter_expanded') && !$(item).hasClass('listing_filter_populated'))
        {
            $(item).addClass('listing_filter_expanded');
        }
        else
        {
            $(item).removeClass('listing_filter_expanded').removeClass('listing_filter_populated');
        }
        return false;
    });
    
    /* FANCYBOX */
    
    $('.fancybox').fancybox();
    
    /* REMOVE ALERTS AFTER 10 SECONDS */
    
    setTimeout(function()
    {
         $('.alert').slideUp();
    }, 10000);
    
    /* USE BILLING ADDRES ON DELIVERY ADDRESS */
    
    $('#use_billing_address').click(function()
    {
        $('#DeliveryAddress_first_name').val($('#BillingAddress_first_name').val());
        $('#DeliveryAddress_last_name').val($('#BillingAddress_last_name').val());
        $('#DeliveryAddress_company').val($('#BillingAddress_company').val());
        $('#DeliveryAddress_address_1').val($('#BillingAddress_address_1').val());
        $('#DeliveryAddress_address_2').val($('#BillingAddress_address_2').val());
        $('#DeliveryAddress_city').val($('#BillingAddress_city').val());
        $('#DeliveryAddress_post_code').val($('#BillingAddress_post_code').val());
        $('#DeliveryAddress_country').val($('#BillingAddress_country').val());
        return false;
    });
    
    // HOMEPAGE BANNER 
    
    var current_slide = 0;
    
    $("#homepage_banner .slide").fadeTo(0,0, function()
    {
        $(this).hide();
    });
    
    $("#homepage_banner .current_slide").show().fadeTo(0,1).removeClass('current_slide');
    
    function next_homepage_banner_slide()
    {
        $("#homepage_banner .slide:eq("  + current_slide + ")").fadeTo(500, 0, function()
        {
            $(this).hide(); 
        });
        
        if(current_slide >= ($("#homepage_banner .slide").length -1) )
        {
            next_slide = 0;
        }
        else
        {
            next_slide = current_slide+1;
        }
        
        $("#homepage_banner .slide:eq("  + next_slide + ")").show().fadeTo(500, 1, function()
        {
            current_slide = next_slide;
        });
    }
    
    setInterval(function()
    {
        if($("#homepage_banner .slide").length > 1)
        {
            next_homepage_banner_slide();
        }
    }, 8000);
});