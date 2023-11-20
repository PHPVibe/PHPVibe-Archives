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
 
 //Initialize
jQuery(function($){
/*Detect touch device*/
	var tryTouch;
	try {
	document.createEvent("TouchEvent");
	tryTouch = 1;
	} catch (e) {
		tryTouch = 0;
	}
/*Browser detection*/
	var $is_mobile = false;
    var $is_tablet = false;
	var $is_pc = false;

if ($( window ).width() < 500) {
$is_mobile = true;
} else if ($( window ).width() < 900) {
$is_tablet = true;
} else {
$is_pc = true;
}
	
	$('.tt-query').typeahead([
{
name: 'country',
prefetch: site_url + 'lib/ajax/countries.json',
}
]);
	
$('#multisel').multiSelect();	
	$('.auto').autosize();
	$('.tags').tagsInput({width:'100%'});
	$(".select").minimalect();		
	$(".styled").uniform({ radioClass: 'choice' });
	
	$('.pv_tip, .tipN, .tipS, .tipW, .tipE').tooltip();
	$('#share-embed-code, #share-embed-code-small, #share-embed-code-large, #share-this-link').tooltip({'trigger':'focus'});
	$('.pv_pop').popover();
	$('.dropdown-toggle').dropdown();
	
	 var vh = $("#video-wrapper").height() - 36;	
	if($is_mobile) { 	
	  $('.scroll-items').slimScroll({height:180});
	  $('.items').slimScroll({height:180});
	   $('.video-player, #video-content').removeAttr("style");
	   $('.video-player, #video-content').attr('style','min-height:200px;');
	  } else {
	  $('.scroll-items').slimScroll({height:340});
	  $('.items').slimScroll({height:vh});
	  }
	
 
     //$(".video-player").fitVids();
  
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
	/* Infinite scroll */	
	var $container = $('.loop-content:last');	
		if(jQuery('#page_nav').html()){
		
      $container.infinitescroll({
        navSelector  : '#page_nav',    // selector for the paged navigation 
        nextSelector : '#page_nav a',  // selector for the NEXT link (to page 2)
        itemSelector : '.video', 		// selector for all items you'll retrieve
		bufferPx: 60,
        loading: {
		    msgText: 'Loading next',
            finishedMsg: 'The End.',
            img: site_url + 'tpl/main/images/load.gif'
          }
        },
        // call Isotope as a callback
     function ( newElements ) {	
	  NProgress.start();
  var $newElems = jQuery( newElements ).hide(); // hide to begin with
  // ensure that images load before adding to masonry layout
  $newElems.imagesLoaded(function(){
    $newElems.fadeIn(); // fade in when ready	
	 });
	 NProgress.done();
	  });
	    };
	  
	$("#validate").validationEngine({promptPosition : "topRight:-122,-5"});  
	
	/* END */
	
});
$(window).load(function(){
setTimeout(function() { NProgress.done(); }, 2000);
});
$(document).ready(function(){
if ($( window ).width() > 500) { 
	  var oh = $("#video-wrapper").height() - 36;
	 $('.items').parent().replaceWith($('.items'));	 
	 $('.items').slimScroll({height:oh});
	  }

if (typeof next_url !== 'undefined') {
var wtime = next_time - 12000;
setTimeout(function(){
       $(".next-an").prepend( nv_lang );}, wtime )
setTimeout(function(){
       window.location.replace(next_url);}, next_time)
}
//Fill the screen
  $(".fullit").click(function(){
 	$("#video-wrapper").toggleClass('gofullscreen');
	$("#video-reverter").toggleClass('hide');
  });
//Emoticons
$('.message .body').emotions();

//Kill ad
   $(".close-ad").click(function(){
 	$(this).closest(".adx").hide();
  });

  //Add to
   $("#addtolist").click(function(){
    $("#bookit").slideToggle();
  });
  //Sidebar mobile
      $("#show-sidebar").click(function(){
    $("#sidebar-wrapper").toggleClass('hidden-phone').toggleClass('hidden-tablet');
  });
     $("#mobi-hide-right-sidebar").click(function(){
    $(".right-side").toggleClass('hidden-phone').toggleClass('hidden-tablet');
  });
     $("#mobi-hide-sidebar ").click(function(){
    $("#sidebar-wrapper").toggleClass('hidden-phone').toggleClass('hidden-tablet');
  });

  
  //End sidebar
    $("#report").click(function(){
    $("#report-it").slideToggle()
  });
 
 
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
	
	  jQuery(".backtotop").addClass("hidden");
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() === 0) {
            jQuery(".backtotop").addClass("hidden")
        } else {
            jQuery(".backtotop").removeClass("hidden")
        }
    });

    jQuery('.backtotop').click(function () {
        jQuery('body,html').animate({
            scrollTop:0
        }, 1200);
        return false;
    });
});

function iLikeThis(vid){
    $.post(
            site_url + 'lib/ajax/like.php', { 
                video_id:   vid,
				type : 1
            },
            
            function(data){
                $('#i-like-it').addClass('done-like');
						var a = JSON.parse(data);	
  $.gritter.add({            
            title:  a.title,          
            text: '<p>' + a.text + '</p>',           
            sticky: false,
			 class_name: 'gritter-light',          
            time: 15000
        });
            }); 
}
function iHateThis(vid){
    $.post(
            site_url + 'lib/ajax/like.php', { 
                video_id:   vid,
				type : 2
            },
            
            function(data){
                $('#i-dislike-it').addClass('done-dislike');
						var a = JSON.parse(data);	
  $.gritter.add({            
            title:  a.title,          
            text: '<p>' + a.text + '</p>',           
            sticky: false,			        
            time: 15000
        });
            }); 
}
function Subscribe(user,type){
    $.post(
            site_url + 'lib/ajax/subscribe.php', { 
                the_user:   user,
				the_type : type
            },
            
            function(data){
			var a = JSON.parse(data);	
  $.gritter.add({            
            title:  a.title,          
            text: '<p>' + a.text + '</p>',           
            sticky: false,
			 class_name: 'gritter-light',          
            time: 15000
        });				
            }); 
}

function addEMComment(oid){
    if($('textarea#addEmComment_'+oid).val()){
        //mark comment box as inactive
           $('#emAddButton_'+oid).attr('disabled','true');

      
        $.post(
            site_url + 'lib/ajax/addComment.php', { 
                comment:      encodeURIComponent($('textarea#addEmComment_'+oid).val()),
                object_id:    oid
               
            },
            
            function(data){
                $('#emContent_'+oid).prepend('<li id="comment-'+data.id+'" class="left"><img class="avatar" src="'+data.image+'" /><div class="message"><span class="arrow"> </span><a class="name" href="'+data.url+'">'+data.name+'</a> <span class="date-time"> '+data.date+' </span> <div class="body">'+data.text+'</div> </div></li>');
                //$('#comment_'+data.id).slideDown();
                $('.body').emotions();
               $('textarea#addEmComment_'+oid).val('');
			   $('.body').emotions();
			    $('html, body').animate({scrollTop:$('#emContent_'+oid).offset().top - 1}, 'slow');
            }, "json");            
            
    }else{
        $('#addEmComment_'+oid).focus();
    }
	
 $('#emAddButton_'+oid).attr('disabled','false');
 
    return false;
}

function iLikeThisComment(cid){
    $.post(
            site_url + 'lib/ajax/likeComment.php', { 
                comment_id:   cid
            },
            
            function(data){
			    
			    $('#iLikeThis_'+cid).html('');
                $('#iLikeThis_'+cid).prepend(data.text+'! &nbsp;');
            }, "json"); 
}
function processVid(file){
$('#vfile').val(file);
$('#Subtn').prop('disabled', false).html('Save').addClass("btn-success");
}
 /*! jQuery Cookie Plugin v1.3 | https://github.com/carhartl/jquery-cookie */
(function(f,b,g){var a=/\+/g;function e(h){return h}function c(h){return decodeURIComponent(h.replace(a," "))}var d=f.cookie=function(p,o,u){if(o!==g){u=f.extend({},d.defaults,u);if(o===null){u.expires=-1}if(typeof u.expires==="number"){var q=u.expires,s=u.expires=new Date();s.setDate(s.getDate()+q)}o=d.json?JSON.stringify(o):String(o);return(b.cookie=[encodeURIComponent(p),"=",d.raw?o:encodeURIComponent(o),u.expires?"; expires="+u.expires.toUTCString():"",u.path?"; path="+u.path:"",u.domain?"; domain="+u.domain:"",u.secure?"; secure":""].join(""))}var h=d.raw?e:c;var r=b.cookie.split("; ");for(var n=0,k=r.length;n<k;n++){var m=r[n].split("=");if(h(m.shift())===p){var j=h(m.join("="));return d.json?JSON.parse(j):j}}return null};d.defaults={};f.removeCookie=function(i,h){if(f.cookie(i)!==null){f.cookie(i,null,h);return true}return false}})(jQuery,document);

/**
* jQuery Emoticons
**/
(function($){	
	$.fn.emotions = function(options){
		$this = $(this);
		var opts = $.extend({}, $.fn.emotions.defaults, options);
		return $this.each(function(i,obj){
			var o = $.meta ? $.extend({}, opts, $this.data()) : opts;					   	
			var x = $(obj);
			// Entites Encode 
			var encoded = [];
			for(i=0; i<o.s.length; i++){
				encoded[i] = String(o.s[i]).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
			}
			for(j=0; j<o.s.length; j++){
				var repls = x.html();
				if(repls.indexOf(o.s[j]) || repls.indexOf(encoded[j])){
					var imgr = o.a+o.b[j]+"."+o.c;			
					var rstr = "<img src='"+imgr+"' border='0' />";	
					x.html(repls.replace(o.s[j],rstr));
					x.html(repls.replace(encoded[j],rstr));
				}
			}
		});
	}	
	// Defaults
	$.fn.emotions.defaults = {
		a : site_url + "tpl/main/images/emoticons/",			// Emotions folder
		b : new Array("angel","colonthree","confused","cry","devil","frown","gasp","glasses","grin","grumpy","heart","kiki","kiss","pacman","smile","squint","sunglasses","tongue","wink"),			// Emotions Type
		s : new Array("o:)",":3","o.O",":'(","3:)",":(",":O","8)",":D",">:(","<3","^_^",":*",":v",":)","-_-","8|",":p",";)"),
		c : "gif"					// Emotions Image format
	};
})(jQuery);