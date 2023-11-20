$(document).bind('ready', function(){
	$('#header li')
		.bind('mouseenter', function(){
			$(this).addClass('hover');
		})
		.bind('mouseleave', function(){
			$(this).removeClass('hover');
		});

	$('.form-field-richtext textarea').wysiwyg({
		controls: {
			h1: { visible : false },
			h2: { visible : false },
			h3: { visible : false },
			html: { visible : false },
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

	$('[rel~=confirm]').bind('click', function(){
		return confirm($(this).attr('title') || 'Are you sure you want to perform this action?');
	});

	$('input[type=text]').each(function(){
		var target = $(this);
		if(title = target.attr('title')){
			if(target.val().length === 0){
				target.val(target.attr('title'));
			}
			
			target.bind('blur', function(){
				if(target.val().length === 0){
					target.val(target.attr('title'));
				}
			});
	
			target.bind('focus', function(){
				if(target.val() === target.attr('title')){
					target.val('');
				}
			});
		}
	});

});