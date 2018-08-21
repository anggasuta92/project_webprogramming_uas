$(document).ready(function(){

	/* Slider */
	$('#slider .flexslider').flexslider({
		controlNav: false,
		animation: "slide",
		start: function(slider) { $('#slider .flexslider').removeClass('loading') }
	});
	
	$('#main .features .flexslider').flexslider({
		directionNav: false,
		animation: "slide",
		animationLoop: false,
	    slideshow: false,
		start: function(slider) { $('#main .features .flexslider').removeClass('loading') }
	});
	/* End slider */
	
	
	/* Contact us process */
	$("#contact-form").submit(function() {
		var submitData 	= $('#contact-form').serialize();
		$("#contact-form input[name='name']").attr('disabled','disabled');
		$("#contact-form input[name='email']").attr('disabled','disabled');
		$("#contact-form input[name='subject']").attr('disabled','disabled');
		$("#contact-form textarea[name='message']").attr('disabled','disabled');
		$("#contact-form input[name='submit']").attr('disabled','disabled');
		$("#contact-form .data-status").show().html('<div class="alert alert-info"><strong>Pesan Terkirim..</strong></div>');
	});
	/* End contact us process */
	
	
	// jQuery smooth scrolling
	$('#header .nav-menu ul li a').bind('click', function(event) {
		var $anchor = $(this);		
		$('html, body').stop().animate({
			scrollTop: parseInt($($anchor.attr('href')).offset().top)
		}, 2000,'easeInOutExpo');
		event.preventDefault();
	});
	
	// jQuery placeholder for IE
	$("input, textarea").placeholder();
	

});