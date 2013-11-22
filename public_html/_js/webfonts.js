$(document).ready(function()
{
	//Here we're telling the script what font families we're loading. 
	//When the fonts have loaded, we're going to reload masonry.
	//This fixes issue with extra spacing between masonry items after fonts have loaded. 
	
	WebFontConfig =
	{
		custom:
		{
			families: [ 'ff-tisa-web-pro', 'proxima-nova' ]
		},
		active: function()
		{
		    
			/* NAV HEIGHT MATCHING */
    
            var nav_section = $('.nav_section');
            
            var max_height = 0;
            
            $(nav_section).find('ul').each(function(i,e)
            {
            	if($(e).height() > max_height)
            	{
            		max_height = $(e).height();
            	}
            });
            
            $(nav_section).find('ul li').height(max_height);
            
            /* NAV VERTICAL ALIGNMENT */
            
            $(nav_section).find('ul li').each(function(i,e)
            {
            	$(e).find('a').css('margin-top', ($(e).height() - $(e).find('a').outerHeight(true)) / 2);
            });
		}
	};
		
	(function()
	{
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})();
});