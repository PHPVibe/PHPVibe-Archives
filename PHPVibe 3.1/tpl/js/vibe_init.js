/********************************************
 * Custom jQuery for phpVibe
 ********************************************/
$ = jQuery.noConflict();

(function ($) {
    $('.loop-actions .view a').click(function (e) {
        e.preventDefault();
        var viewType = $(this).attr('data-type'),
            loop = $('.switchable-view'),
            loopView = loop.attr('data-view');
        if (viewType == loopView) return false;
        $(this).addClass('current').siblings('a').removeClass('current');
        loop.stop().fadeOut(100, function () {
            if (loopView) loop.removeClass(loopView);
            $(this).fadeIn().attr('data-view', viewType).addClass(viewType);
        });
        $.cookie('loop_view', viewType, {
            path: '/',
            expires: 999
        });
        return false;
    });
    // skin the select
 $("select, .check, .check :checkbox, input:radio, input:file").uniform();
  $("img").lazyload({
     effect       : "fadeIn"
 });
  $(".attachPhoto").live('click',function() {
   $(".picsShare").toggle();
   return false;
 });
 $("#update_button").live('click',function() {
var x=$("#update").val();
var dataString = 'content='+ x;
var us_name = $(".namecap").text();
var us_av = $(".mythumb").html();
$(".newsfeed").prepend('<div id="status-new" class="status"><div class="thumb">'+us_av+'</div> <div class="data"><h2 class="title">'+x+'</h2><span class="author">Added by '+us_name+'</span> <div class="desc">'+x+'</div></div></div>');
$.ajax({
type: "POST",
  url: "ajax/update_status.php",
   data: dataString,
  cache: false,
  success: function(html){
   }
 });
 $("#update").val('');
return false;
});
 
$(".deletebox").live('click',function() {
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;
if(confirm("Sure you want to delete this update? There is NO undo!")) {
$('#status-'+ID).fadeOut('slow');  
$.ajax({
  type: "POST",
  url: "ajax/delete_status.php",
  data: dataString,
  cache: false,
  success: function(html){
  }
 });
}
return false;
});
}(jQuery));

/* Document ready 
====================================*/
jQuery(document).ready(function () {
    jQuery('.side-menu').initMenu();
    jQuery('#embed').lightbox();
    jQuery('.lightbox').lightbox();
	jQuery('.form').validationEngine();	
	var cc = $.cookie('loop_view');
    if (cc) {
        loope = $('.switchable-view'),
        loopeView = loope.attr('data-view');
        if (cc == loopeView) return false;
        loope.stop().fadeOut(100, function () {
            if (loopeView) loope.removeClass(loopeView);
            loope.fadeIn().attr('data-view', cc).addClass(cc);
        });
        return false;
    };

});
// OPEN LINKS IN NEW WINDOW
jQuery(function () {
    jQuery('a[rel*=nofollow]').click(function () {
        window.open(this.href);
        return false;
    });
		
jQuery('#getVideo').click(function(){

		$.post("com/video-data.php",
		{ link: $('#link').val() },
		function(data){
		//alert(data);
			$('#preview')
			.fadeIn(200, function() {
				$(this).html(data);
				
			});
		});
		$('#dumpvideo').hide();
		$('#submiter').hide();
		$('#channel').uniform();
		$('#nsfw').uniform();
		//$.uniform.update(); 


	});
});
jQuery.fn.initMenu = function () {
    return this.each(function () {
        var theMenu = $(this).get(0);
        $('.acitem', this).hide();
        $('li.expand > .acitem', this).show();
        $('li.expand > .acitem', this).prev().addClass('active');
        $('li a', this).click(

        function (e) {
            e.stopImmediatePropagation();
            var theElement = $(this).next();
            var parent = this.parentNode.parentNode;
            if ($(parent).hasClass('noaccordion')) {
                if (theElement[0] === undefined) {
                    window.location.href = this.href;
                }
                $(theElement).slideToggle('normal', function () {
                    if ($(this).is(':visible')) {
                        $(this).prev().addClass('active');
                    } else {
                        $(this).prev().removeClass('active');
                    }
                });
                return false;
            } else {
                if (theElement.hasClass('acitem') && theElement.is(':visible')) {
                    if ($(parent).hasClass('collapsible')) {
                        $('.acitem:visible', parent).first().slideUp('normal',

                        function () {
                            $(this).prev().removeClass('active');
                        });
                        return false;
                    }
                    return false;
                }
                if (theElement.hasClass('acitem') && !theElement.is(':visible')) {
                    $('.acitem:visible', parent).first().slideUp('normal', function () {
                        $(this).prev().removeClass('active');
                    });
                    theElement.slideDown('normal', function () {
                        $(this).prev().addClass('active');
                    });
                    return false;
                }
            }
        });
    });
};
jQuery(function($){

	$('#video-sidebar .items').jCarouselLite({
		btnNext: "#video-sidebar  .next",
		btnPrev: "#video-sidebar .prev",
		visible: 9,
		scroll: 3,
		vertical: true,
		circular: true,
		// auto: 1500
	});
	
	
	$('#userflow .items').jCarouselLite({
		btnNext: "#userflow .next",
		btnPrev: "#userflow .prev",
		visible: 10,
		scroll: 3,
		vertical: true,
		circular: true,
		// auto: 1500
	});
		
	
});
$(document).ready(function() {
		// Toggle the dropdown menu's
		$(".dropdown .button, .dropdown button").click(function () {
			$(this).parent().find('.dropdown-slider').slideToggle('fast');
			$(this).find('span.toggle').toggleClass('active');
			return false;
		});
	}); // END document.ready
	
	// Close open dropdown slider/s by clicking elsewhwere on page
	$(document).bind('click', function (e) {
		if (e.target.id != $('.dropdown').attr('class')) {
			$('.dropdown-slider').slideUp();
			$('span.toggle').removeClass('active');
		}
	}); // END document.bind	
	