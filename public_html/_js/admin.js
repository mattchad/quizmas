$(document).ready(function()
{
	var jcrop_api;
	
	function applyJCrop(target, min_width, min_height)
	{
		crop_aspect_ratio = (min_width / min_height);
		
		$(target).Jcrop(
		{
			aspectRatio: crop_aspect_ratio,
			bgColor: 'black',
			bgOpacity: 0.3,
			minSize: [min_width,min_height],
			onSelect: function(coords)
			{
			
				console.log(coords);
				$('#image_x').val(coords.x);
				$('#image_y').val(coords.y);
				$('#image_w').val(coords.w);
				$('#image_h').val(coords.h);
			}
		}, function()
		{
			jcrop_api = this;
			var x = $('#image_x').val();
			var y = $('#image_y').val();
			var w = $('#image_w').val();
			var h = $('#image_h').val();

			var image_width = $(target).width();
			var image_height = $(target).height();
			
			if(w < min_width || h < min_height)
			{
				var image_aspect_ratio = image_width / image_height;
				
				if(image_aspect_ratio > crop_aspect_ratio)
				{
					h = image_height;
					w = image_height * crop_aspect_ratio;
					x = (image_width - w) / 2;
                	y = 0;
				}
				else if(image_aspect_ratio == crop_aspect_ratio)
				{
					h = image_height;
	                w = h / crop_aspect_ratio;
	                x = 0;
	                y = 0;
				}
				else
				{
					h = image_width / crop_aspect_ratio;
	                w = image_width;
	                x = 0;
	                y = (image_height - h) / 2;
				}
			}
			
			$('#image_x').val(x);
			$('#image_y').val(y);
			$('#image_w').val(w);
			$('#image_h').val(h);
			
			jcrop_api.setSelect([x,y,(parseInt(x)+parseInt(w)),(parseInt(y)+parseInt(h))]);
		});
	}
	
	if($("#jcrop_target").length)
	{
		applyJCrop('#jcrop_target', 150, 150);
	}
	
	if($("#jcrop_target_2").length)
	{
		applyJCrop('#jcrop_target_2', 300, 200);
	}


	$('.fancybox').fancybox({
		width: 500, 
		height: 500,
	});

    $('.tooltip-right').tooltip({
        'placement': 'right'
    });
    
    $('.more_popover').popover({trigger: "hover"});
    
    $('.character_count').each(function(i,e)
    {
        var input = $(e).find('.count_input');
        $(input).on('keyup', function()
        {
            var number = $(e).find('.count_input').val().length;
            if(number == 1)
            {
                $(e).find('.count_number').text(number + ' character');
            }
            else
            {
                $(e).find('.count_number').text(number + ' characters');
            }
        });
    });
    
    $('.delete_confirm').click(function()
    {
        if(!confirm('Are you sure you want to delete this?'))
        {
            return false;
        }
    });
    
    $("#page_listing_choices").change(function()
    {
        $("#page_listing_choice .page").hide();
        $("#page_listing_choice .listing").hide();
        
        switch($("#page_listing_choices").val())
        {
            case "1":
            {
                $("#page_listing_choice .page").show();
                break;
            }
            case "2":
            {
                $("#page_listing_choice .listing").show();
                break;
            }
            default:
            {
                break;
            }
        }
    })
    
});