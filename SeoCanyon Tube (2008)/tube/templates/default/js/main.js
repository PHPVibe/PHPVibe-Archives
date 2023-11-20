jQuery(document).ready(function()
{	
	
	// INITIALIZE CUFON FONT REPLACEMENT
	Cufon.replace('h1, h2, h3, h4, h5, h6', { hover: 'true' });
	
	
			
	// APPEND SOME EXTRA SPANS TO STYLE FANCY FRAMES CORRECTLY
	jQuery('.frame').append('<span class="helper1"></span><span class="helper2"></span>');
	   
});
