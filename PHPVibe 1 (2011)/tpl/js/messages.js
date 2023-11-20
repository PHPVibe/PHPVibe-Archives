$(document).bind('ready', function(){
	
	$('tbody td input').bind('change', function(){
		if( $('tbody td input').length == $('tbody td input:checked').length )
		{
			$('thead th input').attr('checked', 'checked');
		}
		else
		{
			$('thead th input').removeAttr('checked');
		}
	});

	$('thead th input').bind('change', function(){
		if( $(this).is(':checked') )
		{
			$('tbody td input').attr('checked', 'checked');
		}
		else
		{
			$('tbody td input').removeAttr('checked');
		}
	});

});