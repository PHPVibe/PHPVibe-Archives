/*
	Default loader
*/

$(document).ready(function(){

	$('#navigation-main li')
		.bind('mouseenter', function(){
			$(this).addClass('hover');
		})
		.bind('mouseleave', function(){
			$(this).removeClass('hover');
		});

	$('#navigation-main li ul').each(function(){
		var ul = $(this);
		var li = ul.parent();
		var width_difference = Math.ceil( ( li.innerWidth() - ul.width() ) / 2 );
		ul.css('left', width_difference+'px');
	});

	$('a[rel*=record][rel*=delete]').bind('click', function(){
		return confirm($(this).attr('title'));
	});
	
	$('input[rel*=record][rel*=delete]').bind('click', function(){
		var checked = $('table.table-data input[type=checkbox]:checked');
		if(checked.length == 0)
		{
			return false;
		}
		else
		{
			return confirm($(this).attr('title'));
		}
	});
	
	$('div.field-validationarguments').each(function(){
		var form = $(this).closest('form');
		var rule_name_container = $('div.field-name', form);
		var rule_arguments_field = $('input', rule_arguments_container).first().clone().val('');
		var rule_arguments_container = $(this);
		var loaded = false;
		
		$('select', rule_name_container).bind('change', function()
		{
			var option = $('option[value='+$(this).val()+']', rule_name_container).html();
			var argument_number = option.split('-');
				argument_number = parseInt( $.trim(argument_number.pop()) );
			var argument_inputs = $('input', rule_arguments_container);
			
			if( argument_inputs.length != argument_number )
			{
				$('input, p', rule_arguments_container).remove();
	
				for( var i = 0; i < argument_number; i++)
				{
					rule_arguments_container.append( rule_arguments_field.clone() );
				}
			}
			
			if( argument_number == 0 && $('p', rule_arguments_container).length === 0 )
			{
				rule_arguments_container.append('<p class="input-static">No arguments required</p>');
			}
			
			loaded = true;
			
		});
		
		$('select', rule_name_container).trigger('change');

	});

	$('table.table-data:not(table.table-supplement)').MK_Table_Data();
	$('form#module-search').MK_Module_Search();

	$('.form-field-richtext textarea').wysiwyg({
		controls: {
			html: { visible : true },
			redo: { visible : false },
			undo: { visible : false },
			superscript: { visible : false },
			subscript: { visible : false },
			insertTable: { visible : false },
			createLink: { visible : true },
			insertHorizontalRule: { visible : false },
			insertImage: { visible : false }
		},
		initialContent: '<p><br /></p>'
	});

});

$.fn.MK_Module_Search = function()
{
	return $(this).each(function()
	{
		var o = $(this);

		o.v = {
			form_elements: $(':input:not([type=submit])', o),
			switch_search: $('p.module-search-expand a', o.parent()),
			clear: $('div.form-field-link a', o)
		};
		
		o.v.clear.bind('click', function()
		{
			o.v.form_elements.val('');
			return false;
		});
		
		o.v.switch_search.bind('click', function()
		{
			var target = $(this).parent();
			target.toggleClass('module-search-contract');
			if(target.is('.module-search-contract'))
			{
				$(this).text('Fewer options')
					.prev().html('&ndash;');
				o.removeClass('search-mini').addClass('search-full');
			}
			else
			{
				$(this).text('More options')
					.prev().html('+');
				o.removeClass('search-full').addClass('search-mini');
			}
			return false;
		});

	});
};

$.fn.MK_Table_Data = function() {

	return $(this).each(function() {
		var table = $(this);

		$('tbody tr td:not(.first, .last)', table)
			.live('click', function(){
				var tr = $(this).closest('tr');
				if(tr.is('.highlight')){
					$('thead input[type=checkbox]', table).removeAttr('checked');
					$('input[type=checkbox]', tr).removeAttr('checked').trigger('change');
				}else{
					$('input[type=checkbox]', tr).attr('checked', 'checked').trigger('change');
				}
			});

		$('tbody tr', table)
			.live('mouseenter', function(){
				$(this).addClass('hover');
			})
			.live('mouseleave', function(){
				$(this).removeClass('hover');
			});

		$('thead input[type=checkbox]', table)
			.live('change', function(){
				var checkboxes = $('tbody input[type=checkbox]', table);
				if($(this).is(':checked')){
					checkboxes.attr('checked', 'checked')
						.closest('tr').addClass('highlight');
				}else{
					checkboxes.removeAttr('checked')
						.closest('tr').removeClass('highlight');
				}
				table.check_selected();
			});

		$('tbody input[type=checkbox]', table)
			.live('change', function(){
				var tr = $(this).closest('tr');
				if($(this).is(':checked')){
					tr.addClass('highlight');
					table.check_selected();
					if($('tbody input[type=checkbox]', table).length === $('tbody input[type=checkbox]:checked', table).length){
						$('thead input[type=checkbox]', table).attr('checked', 'checked');
					}
				}else{
					tr.removeClass('highlight');
					$('thead input[type=checkbox]', table).removeAttr('checked');
					table.check_selected();
				}
			})
			.each(function(){
				var tr = $(this).closest('tr');
				if($(this).is(':checked')){
					tr.addClass('highlight');
				}
			});
		
		table.check_selected = function()
		{
			if( $('tbody input[type=checkbox]:checked', table).length === 0 )
			{
				$('div.field-delete', table.parent()).fadeTo(200, 0.4);
			}
			else
			{
				$('div.field-delete', table.parent()).fadeTo(200, 1);
			}
		}

		table.check_selected();
   });

};
