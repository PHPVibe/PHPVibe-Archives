/*!
 * phpVibe v3.2
 *
 * Copyright Media Vibe Solutions
 * http://www.phpRevolution.com
 * phpVibe IS NOT FREE SOFTWARE
 * If you have downloaded this CMS from a website other
 * than www.phpvibe.com or www.phpRevolution.com or if you have received
 * this CMS from someone who is not a representative of phpVibe, you are involved in an illegal activity.
 * The phpVibe team takes actions against all unlincensed websites using Google, local authorities and 3rd party agencies.
 * Designed and built exclusively for sale @ phpVibe.com & phpRevolution.com.
 */

jQuery(function($){

//confirm
$('.confirm').click(function(){
    return confirm("Are you sure you want to delete this? This is permanent");
})
//sorts
$('#sortable').sortable();

      // Disable # function
      $('a[href="#"]').click(function(e){
        e.preventDefault();
      });

    //-----  / FOR DEMO PURPOSES ONLY -----//
    //-----  / FOR DEMO PURPOSES ONLY -----//
    //-----  / FOR DEMO PURPOSES ONLY -----//


    //-----  Menu functions -----//

    // slide menu out from the left 
    $('.slide_menu_left').click(function(e){
        e.preventDefault();
        if($(".navbar").hasClass('open_left')){
          sidemenu_close();
        }else{
            sidemenu_open();
            $('.main_container').bind('click', function(){
                sidemenu_close();
            });
        }
    });

    // slide menu out
    function sidemenu_close(){
        $(".main_container").stop().animate({
            'left': '0'
        }, 250, 'swing');

        $(".navbar").stop().animate({
            'left': '-200px'
        }, 250, 'swing', function(){
            $(this).css('left', '').removeClass('open_left');
            $(this).children('.sidebar-nav').css('height', '');
        });

        $('.main_container').unbind('click');

        if(typeof handler != 'undefined'){
            $(window).unbind('resize', handler);
        }
    }

    // slide menu in
    function sidemenu_open(){
        $(".main_container").stop().animate({
            'left': '200px'
        }, 250, 'swing');
        $(".navbar").stop().animate({
            'left': '0'
        }, 250, 'swing').addClass('open_left');
        $('.navbar').animate('slow', function(){
            marginLeft:0
        });
    }

    $('.accordion-toggle').removeClass('toggled');
    // fade to white when clicked on mobile
    $('.accordion-toggle').click(function(){
      $('.accordion-toggle').removeClass('toggled');
      $(this).addClass('toggled');
    });
$('.tipN').tipsy({gravity: 'n',fade: true, html:true});
	$('.tipS').tipsy({gravity: 's',fade: true, html:true});
	$('.tipW').tipsy({gravity: 'w',fade: true, html:true});
	$('.tipE').tipsy({gravity: 'e',fade: true, html:true});
	
	$('.auto').autosize();
	$('.limited').inputlimiter({
		limit: 100,
		boxId: 'limit-text',
		boxAttach: false
	});
	$('.tags').tagsInput({width:'100%'});
	//===== Select2 dropdowns =====//

	$(".select").select2();
				
	$("#loading-data").select2({
		placeholder: "Enter at least 1 character",
        allowClear: true,
        minimumInputLength: 1,
        query: function (query) {
            var data = {results: []}, i, j, s;
            for (i = 1; i < 5; i++) {
                s = "";
                for (j = 0; j < i; j++) {s = s + query.term;}
                data.results.push({id: query.term + i, text: s});
            }
            query.callback(data);
        }
    });		

	$("#max-select").select2({ maximumSelectionSize: 3 });		

	$("#clear-results").select2({
	    placeholder: "Select a State",
	    allowClear: true
	});

	$("#min-select2").select2({
        minimumInputLength: 2
    });
	
	$("#disableselect, #disableselect2").select2(
        "disable"
    );

	$("#minimum-input-single").select2({
	    minimumInputLength: 2
	});
	
	$(".styled").uniform({ radioClass: 'choice' });
	
	$('.pv_tip').tooltip();
    $('.pv_pop').popover();
	$('.dropdown-toggle').dropdown();
	 // Custom scrollbar plugin
	 var vh = $(".video-player").height();
	  $('.items').slimScroll({height:vh});
	  $('.scroll-items').slimScroll({height:300});
     //$(".video-player").fitVids();
  /* Dual select boxes */	
	$.configureBoxes();
	/* Ajax forms */
	 $('.ajax-form').ajaxForm({
            target: '.ajax-form-result',
			success: function(data) {
            $('.ajax-form').hide();
        }
        });
		$('.ajax-form-video').ajaxForm({
            target: '.ajax-form-result',
			success: function(data) {         
        }
        });
	$("#validate").validationEngine({promptPosition : "topRight:-122,-5"});  

	$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
	
 });  
 
 
$(document).ready(function(){
$('.table-checks .check-all').click(function(){
		var parentTable = $(this).parents('table');										   
		var ch = parentTable.find('tbody input[type=checkbox]');										 
		if($(this).is(':checked')) {
		
			//check all rows in table
			ch.each(function(){ 
				$(this).attr('checked',true);
				$(this).parent().addClass('checked');	//used for the custom checkbox style
				$(this).parents('tr').addClass('selected');
			});
						
			//check both table header and footer
			parentTable.find('.check-all').each(function(){ $(this).attr('checked',true); });
		
		} else {
			
			//uncheck all rows in table
			ch.each(function(){ 
				$(this).attr('checked',false); 
				$(this).parent().removeClass('checked');	//used for the custom checkbox style
				$(this).parents('tr').removeClass('selected');
			});	
			
			//uncheck both table header and footer
			parentTable.find('.check-all').each(function(){ $(this).attr('checked',false); });
		}
	});

	$('.check-all-notb').click(function(){
		var parentTable = $(this).parents('form');										   
		var ch = parentTable.find('article input[type=checkbox]');										 
		if($(this).is(':checked')) {
		
			//check all rows in article
			ch.each(function(){ 
				$(this).attr('checked',true);
				$(this).parent().addClass('checked');	//used for the custom checkbox style
				$(this).parents('article').addClass('selected');
			});
						
			//check both article header and footer
			parentTable.find('.check-all-notb').each(function(){ $(this).attr('checked',true); });
		
		} else {
			
			//uncheck all rows in article
			ch.each(function(){ 
				$(this).attr('checked',false); 
				$(this).parent().removeClass('checked');	//used for the custom checkbox style
				$(this).parents('article').removeClass('selected');
			});	
			
			//uncheck both article header and footer
			parentTable.find('.check-all-notb').each(function(){ $(this).attr('checked',false); });
		}
	});
	
$("#easyhome ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			
			$.post("sort.php", order, function(theResponse){
				$("#respo").html(theResponse).fadeIn(400).delay(800).slideUp(300);
			}); 															 
		}								  
		});	
	
});

// Sticky v1.0 by Daniel Raftery
// http://thrivingkings.com/sticky
(function(a){a.sticky=function(e,d,f){return a.fn.sticky(e,d,f)};a.fn.sticky=function(e,d,f){var b={speed:"fast",duplicates:!1,autoclose:5E3,position:"top-right",type:""};d&&a.extend(b,d);e||(e=this.html());var g=!0,h="no",c=Math.floor(99999*Math.random());a(".sticky-note").each(function(){a(this).html()==e&&a(this).is(":visible")&&(h="yes",b.duplicates||(g=!1));a(this).attr("id")==c&&(c=Math.floor(9999999*Math.random()))});a("body").find(".sticky-queue."+b.position).html()||a("body").append('<div class="sticky-queue '+ b.position+'"></div>');g&&(a(".sticky-queue."+b.position).prepend('<div class="sticky border-'+b.position+" "+b.type+'" id="'+c+'"></div>'),a("#"+c).append('<span class="close st-close" rel="'+c+'" title="Close">&times;</span>'),a("#"+c).append('<div class="sticky-note" rel="'+c+'">'+e+"</div>"),d=a("#"+c).height(),a("#"+c).css("height",d),a("#"+c).slideDown(b.speed),g=!0);a(".sticky").ready(function(){b.autoclose&&a("#"+c).delay(b.autoclose).slideUp(b.speed,function(){var b=a(this).closest(".sticky-queue"), c=b.find(".sticky");a(this).remove();c.length=="1"&&b.remove()})});a(".st-close").click(function(){a("#"+a(this).attr("rel")).dequeue().slideUp(b.speed,function(){var b=a(this).closest(".sticky-queue"),c=b.find(".sticky");a(this).remove();c.length=="1"&&b.remove()})});d={id:c,duplicate:h,displayed:g,position:b.position,type:b.type};if(f)f(d);else return d}})(jQuery);
