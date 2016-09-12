;(function($){

 	$(document).ready(function() {
 		$("#splash_home").addClass("loaded");

        $(window).scroll(function() {
            var maxScroll = -90,
            	yPos 	  = -($(window).scrollTop() / 5),
            	coords 	  = '50% '+ yPos + 'px';

            // Move the background
            if (yPos >= maxScroll){
            	$('.leading-0').css({ backgroundPosition: coords });
            }
        }); 
	});

})(jQuery);

