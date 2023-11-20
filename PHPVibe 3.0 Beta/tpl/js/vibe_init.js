/********************************************
 * Custom jQuery for phpVibe
 ********************************************/
$ = jQuery.noConflict();

jQuery.fn.initMenu = function() {  
    return this.each(function(){
        var theMenu = $(this).get(0);
        $('.acitem', this).hide();
        $('li.expand > .acitem', this).show();
        $('li.expand > .acitem', this).prev().addClass('active');
        $('li a', this).click(
            function(e) {
                e.stopImmediatePropagation();
                var theElement = $(this).next();
                var parent = this.parentNode.parentNode;
                if($(parent).hasClass('noaccordion')) {
                    if(theElement[0] === undefined) {
                        window.location.href = this.href;
                    }
                    $(theElement).slideToggle('normal', function() {
                        if ($(this).is(':visible')) {
                            $(this).prev().addClass('active');
                        }
                        else {
                            $(this).prev().removeClass('active');
                        }    
                    });
                    return false;
                }
                else {
                    if(theElement.hasClass('acitem') && theElement.is(':visible')) {
                        if($(parent).hasClass('collapsible')) {
                            $('.acitem:visible', parent).first().slideUp('normal', 
                            function() {
                                $(this).prev().removeClass('active');
                            }
                        );
                        return false;  
                    }
                    return false;
                }
                if(theElement.hasClass('acitem') && !theElement.is(':visible')) {         
                    $('.acitem:visible', parent).first().slideUp('normal', function() {
                        $(this).prev().removeClass('active');
                    });
                    theElement.slideDown('normal', function() {
                        $(this).prev().addClass('active');
                    });
                    return false;
                }
            }
        }
    );
});
};
/* ------------------------------------------------------------------------
	prettyCheckboxes
	
	Developped By: Stephane Caron (http://www.no-margin-for-errors.com)
	Inspired By: All the non user friendly custom checkboxes solutions ;)
	Version: 1.1
	
	Copyright: Feel free to redistribute the script/modify it, as
			   long as you leave my infos at the top.
------------------------------------------------------------------------- */
jQuery.fn.prettyCheckboxes=function(a){a=jQuery.extend({checkboxWidth:18,checkboxHeight:19,className:"prettyCheckbox",display:"list"},a);$(this).each(function(){$label=$('label[for="'+$(this).attr("id")+'"]');$label.prepend("<span class='holderWrap'><span class='holder'></span></span>");if($(this).is(":checked")){$label.addClass("checked")}$label.addClass(a.className).addClass($(this).attr("type")).addClass(a.display);$label.find("span.holderWrap").width(a.checkboxWidth).height(a.checkboxHeight);$label.find("span.holder").width(a.checkboxWidth);$(this).addClass("hiddenCheckbox");$label.bind("click",function(){$("input#"+$(this).attr("for")).triggerHandler("click");if($("input#"+$(this).attr("for")).is(":checkbox")){$(this).toggleClass("checked");$("input#"+$(this).attr("for")).checked=true;$(this).find("span.holder").css("top",0)}else{$toCheck=$("input#"+$(this).attr("for"));$('input[name="'+$toCheck.attr("name")+'"]').each(function(){$('label[for="'+$(this).attr("id")+'"]').removeClass("checked")});$(this).addClass("checked");$toCheck.checked=true}});$("input#"+$label.attr("for")).bind("keypress",function(b){if(b.keyCode==32){if($.browser.msie){$('label[for="'+$(this).attr("id")+'"]').toggleClass("checked")}else{$(this).trigger("click")}return false}})})};checkAllPrettyCheckboxes=function(b,a){if($(b).is(":checked")){$(a).find("input[type=checkbox]:not(:checked)").each(function(){$('label[for="'+$(this).attr("id")+'"]').trigger("click");if($.browser.msie){$(this).attr("checked","checked")}else{$(this).trigger("click")}})}else{$(a).find("input[type=checkbox]:checked").each(function(){$('label[for="'+$(this).attr("id")+'"]').trigger("click");if($.browser.msie){$(this).attr("checked","")}else{$(this).trigger("click")}})}};
/**
 * --------------------------------------------------------------------
 * jQuery customfileinput plugin
 * Author: Scott Jehl, scott@filamentgroup.com
 * Copyright (c) 2009 Filament Group 
 * licensed under MIT (filamentgroup.com/examples/mit-license.txt)
 * --------------------------------------------------------------------
 */
$.fn.customFileInput = function(){
	return $(this).each(function(){
	//apply events and styles for file input element
	var fileInput = $(this)
		.addClass('customfile-input') //add class for CSS
		.mouseover(function(){ upload.addClass('customfile-hover'); })
		.mouseout(function(){ upload.removeClass('customfile-hover'); })
		.focus(function(){
			upload.addClass('customfile-focus'); 
			fileInput.data('val', fileInput.val());
		})
		.blur(function(){ 
			upload.removeClass('customfile-focus');
			$(this).trigger('checkChange');
		 })
		 .bind('disable',function(){
		 	fileInput.attr('disabled',true);
			upload.addClass('customfile-disabled');
		})
		.bind('enable',function(){
			fileInput.removeAttr('disabled');
			upload.removeClass('customfile-disabled');
		})
		.bind('checkChange', function(){
			if(fileInput.val() && fileInput.val() != fileInput.data('val')){
				fileInput.trigger('change');
			}
		})
		.bind('change',function(){
			//get file name
			var fileName = $(this).val().split(/\\/).pop();
			//get file extension
			var fileExt = 'customfile-ext-' + fileName.split('.').pop().toLowerCase();
			//update the feedback
			uploadFeedback
				.text(fileName) //set feedback text to filename
				.removeClass(uploadFeedback.data('fileExt') || '') //remove any existing file extension class
				.addClass(fileExt) //add file extension class
				.data('fileExt', fileExt) //store file extension for class removal on next change
				.addClass('customfile-feedback-populated'); //add class to show populated state
			//change text of button	
			uploadButton.text('Change File');	
		})
		.click(function(){ //for IE and Opera, make sure change fires after choosing a file, using an async callback
			fileInput.data('val', fileInput.val());
			setTimeout(function(){
				fileInput.trigger('checkChange');
			},100);
		});
		
	//create custom control container
	var upload = $('<div class="customfile"></div>');
	//create custom control button
	var uploadButton = $('<span class="customfile-button" aria-hidden="true">Choose File</span>').appendTo(upload);
	//create custom control feedback
	var placeholder = $(this).attr("placeholder");
	var uploadFeedback = $('<span class="customfile-feedback" aria-hidden="true">' + placeholder + '</span>').appendTo(upload);
	
	//match disabled state
	if(fileInput.is('[disabled]')){
		fileInput.trigger('disable');
	}
		
	
	//on mousemove, keep file input under the cursor to steal click
	upload
		.mousemove(function(e){
			fileInput.css({
				'left': e.pageX - upload.offset().left - fileInput.outerWidth() + 20, //position right side 20px right of cursor X)
				'top': e.pageY - upload.offset().top - $(window).scrollTop() - 3
			});	
		})
		.insertAfter(fileInput); //insert after the input
	
	fileInput.appendTo(upload);
		
	});
};

/*jquery.select_skin.js */
/*
 * jQuery select element skinning
 * version: 1.0.6 (26/06/2010)
 * @requires: jQuery v1.2 or later
 * adapted from Derek Harvey code
 *   http://www.lotsofcode.com/javascript-and-ajax/jquery-select-box-skin.htm
 * Licensed under the GPL license:
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Copyright 2010 Colin Verot
 */


(function ($) {

    // skin the select
    $.fn.select_skin = function (w) {
        return $(this).each(function(i) {
            s = $(this);
            if (!s.attr('multiple')) {
                // create the container
                s.wrap('<div class="cmf-skinned-select"></div>');
                c = s.parent();
                c.children().before('<div class="cmf-skinned-text">&nbsp;</div>').each(function() {
                    if (this.selectedIndex >= 0) $(this).prev().text(this.options[this.selectedIndex].innerHTML)
                });
                c.width(s.outerWidth()-2);
                c.height(s.outerHeight()-2);

                // skin the container
                c.css('background-color', s.css('background-color'));
                c.css('color', s.css('color'));
                c.css('font-size', s.css('font-size'));
                c.css('font-family', s.css('font-family'));
                c.css('font-style', s.css('font-style'));
                c.css('position', 'relative');

                // hide the original select
                s.css( { 'opacity': 0,  'position': 'relative', 'z-index': 100 } );

                // get and skin the text label
                var t = c.children().prev();
                t.height(c.outerHeight()-s.css('padding-top').replace(/px,*\)*/g,"")-s.css('padding-bottom').replace(/px,*\)*/g,"")-t.css('padding-top').replace(/px,*\)*/g,"")-t.css('padding-bottom').replace(/px,*\)*/g,"")-2);
                t.width(c.innerWidth()-s.css('padding-right').replace(/px,*\)*/g,"")-s.css('padding-left').replace(/px,*\)*/g,"")-t.css('padding-right').replace(/px,*\)*/g,"")-t.css('padding-left').replace(/px,*\)*/g,"")-c.innerHeight());
                t.css( { 'opacity': 100, 'overflow': 'hidden', 'position': 'absolute', 'text-indent': '0px', 'z-index': 1, 'top': 0, 'left': 0 } );

                // add events
                c.children().click(function() {
                    t.text( (this.options.length > 0 && this.selectedIndex >= 0 ? this.options[this.selectedIndex].innerHTML : '') );
                });
                c.children().change(function() {
                    t.text( (this.options.length > 0 && this.selectedIndex >= 0 ? this.options[this.selectedIndex].innerHTML : '') );
                });
             }
        });
    }

    // un-skin the select
    $.fn.select_unskin = function (w) {
        return $(this).each(function(i) {
            s = $(this);
            if (!s.attr('multiple') && s.parent().hasClass('cmf-skinned-select')) {
                s.siblings('.cmf-skinned-text').remove();
                s.css( { 'opacity': 100, 'z-index': 0 } ).unwrap();
             }
        });
    }
}(jQuery));

/* Document ready 
====================================*/
jQuery(document).ready(function(){
    jQuery('.side-menu').initMenu();   
	jQuery('#embed').lightbox();
	jQuery('#addtoplaylist').dropdown();
	jQuery('.lightbox').lightbox();
	jQuery('input[type=checkbox], input[type=radio]').prettyCheckboxes();
	jQuery('input[type="file"]').customFileInput();
	jQuery('select').select_skin();
	jQuery( ".vibox-img" ).aeImageResize({ height: 186, width: 100 });
 
  });
  
// OPEN LINKS IN NEW WINDOW
jQuery(function() {
	jQuery('a[rel*=external]').click( function() {
		window.open(this.href);
		return false;
	});
});


if(jQuery) (function($) {
	
	$.extend($.fn, {
		dropdown: function(method, data) {
			
			switch( method ) {
				case 'hide':
					hideDropdowns();
					return $(this);
				case 'attach':
					return $(this).attr('data-dropdown', data);
				case 'detach':
					hideDropdowns();
					return $(this).removeAttr('data-dropdown');
				case 'disable':
					return $(this).addClass('dropdown-disabled');
				case 'enable':
					hideDropdowns();
					return $(this).removeClass('dropdown-disabled');
			}
			
		}
	});
	
	function showMenu(event) {
		
		var trigger = $(this),
			dropdown = $( $(this).attr('data-dropdown') ),
			isOpen = trigger.hasClass('dropdown-open');
		
		event.preventDefault();
		event.stopPropagation();
		
		hideDropdowns();
		
		if( isOpen || trigger.hasClass('dropdown-disabled') ) return;
		
		dropdown
			.css({
				left: dropdown.hasClass('anchor-right') ? 
					trigger.offset().left - (dropdown.outerWidth() - trigger.outerWidth()) : trigger.offset().left,
				top: trigger.offset().top + trigger.outerHeight()
			})
			.show();
		
		trigger.addClass('dropdown-open');
		
	};
	
	function hideDropdowns(event) {
		
		var targetGroup = event ? $(event.target).parents().andSelf() : null;
		if( targetGroup && targetGroup.is('.dropdown-menu') && !targetGroup.is('A') ) return;
		
		$('BODY')
			.find('.dropdown-menu').hide().end()
			.find('[data-dropdown]').removeClass('dropdown-open');
	};
	
	$(function () {
		$('BODY').on('click.dropdown', '[data-dropdown]', showMenu);
		$('HTML').on('click.dropdown', hideDropdowns)
	});
	
})(jQuery);