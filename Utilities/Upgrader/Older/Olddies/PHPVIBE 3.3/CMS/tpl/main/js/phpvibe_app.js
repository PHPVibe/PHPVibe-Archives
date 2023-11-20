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
	var deviceAgent = navigator.userAgent.toLowerCase();
	var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
	if (agentID) {
	    $('body').addClass('pv-ios');  
	}
	
	if ($.browser.msie) {
		$('body').addClass('pv-ie');
	    if ($.browser.version == 8) $('body').addClass('pv-ie8');
	    if ($.browser.version == 7) $('body').addClass('pv-ie7');
	};
	
	if( $.browser.opera ){
		$('body').addClass('pv-opera');
	}
	
	if ($('body').hasClass('pv-ie7')) {
		$('body').css({position: 'relative'}).append('<span class="ie7overlay"></span>').html('<div class="ie7message">Hello! Thi website requires MS Internet Explorer 8 or higher version. Please update your browser.</div>')
	}
	$('.tipN').tipsy({gravity: 'n',fade: true, html:true});
	$('.tipS').tipsy({gravity: 's',fade: true, html:true});
	$('.tipW').tipsy({gravity: 'w',fade: true, html:true});
	$('.tipE').tipsy({gravity: 'e',fade: true, html:true});
	
	
	/* 
	$('.tipOpen').tipsy({trigger:'manual', gravity: 'w', html:true});
	$('.tipOpen').tipsy('show');
	$('.tipOpen').bind('mouseover',function(e){
    $(this).tipsy('hide');
    */
	$('.auto').autosize();
	$('.limited').inputlimiter({
		limit: 100,
		boxId: 'limit-text',
		boxAttach: false
	});
	$('.tags').tagsInput({width:'100%'});
	$('.tags-autocomplete').tagsInput({
		width:'100%',
		autocomplete_url:'tags_autocomplete.html'
	});
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
	/* Infinite scroll */	
	var $container = $('.loop-content');	
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
  var $newElems = jQuery( newElements ).hide(); // hide to begin with
  // ensure that images load before adding to masonry layout
  $newElems.imagesLoaded(function(){
    $newElems.fadeIn(); // fade in when ready
	 });
	  });
	    };
	  
	$("#validate").validationEngine({promptPosition : "topRight:-122,-5"});  
	
	/* END */
	
});

$(document).ready(function(){
win		    = $(window),
ww			= parseInt(win.width(),10) * 0.8, 	//default lightbox width: 80% of the window size
wh 			= (ww/16)*9;						//default lightbox height (16:9 ratio)
$("a[rel^='prettyPhoto']").prettyPhoto({ social_tools:'',slideshow: 5000, deeplinking: false, overlay_gallery:false, default_width: ww, default_height: wh, theme: 'light_square'});
    $("#addtolist").click(function(){
    $("#bookit").slideToggle()
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
  /* Swipe menu support */
		
	$('.touch-gesture #content').hammer().on('swipeleft', function(event) {
		 $(".right-side").toggleClass('hidden-phone').toggleClass('hidden-tablet');
	});
		
	$('.touch-gesture #content').hammer().on('swiperight', function(event) {
		 $("#sidebar-wrapper").toggleClass('hidden-phone').toggleClass('hidden-tablet');
	});

  
  //End sidebar
    $("#report").click(function(){
    $("#report-it").slideToggle()
  });
   $("#show_desc").click(function(){
    $(".video-description ").slideToggle()
  });
   CNav.init({
            element : "#CNav"
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
});

function iLikeThis(vid){
    $.post(
            site_url + 'lib/ajax/like.php', { 
                video_id:   vid,
				type : 1
            },
            
            function(data){
                $('#i-like-it').addClass('done-like');
				$.sticky(data, {autoclose : 15000, position: "bottom-left" });
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
				$.sticky(data, {autoclose : 15000, position: "bottom-left" });
            }); 
}
function Subscribe(user,type){
    $.post(
            site_url + 'lib/ajax/subscribe.php', { 
                the_user:   user,
				the_type : type
            },
            
            function(data){
				$.sticky(data, {autoclose : 15000, position: "bottom-left" });
            }); 
}

function addEMComment(oid){
    if($('#addEmComment_'+oid).val()){
        //mark comment box as inactive
        $('#addEmComment_'+oid).attr('disabled','true');
        $('#emAddButton_'+oid).attr('disabled','true');

      
        $.post(
            site_url + 'lib/ajax/addComment.php', { 
                comment:      encodeURIComponent($('#addEmComment_'+oid).val()),
                object_id:    oid
               
            },
            
            function(data){
                $('#emContent_'+oid).prepend('<article id="comment-'+data.id+'" class="comment-item media arrow-left"><a class="pull-left thumb-small com-avatar" href="'+data.url+'"><img src="'+data.image+'" /></a><section class="media-body panel"><header class="panel-heading clearfix"><a href="'+data.url+'">'+data.name+'</a> - '+data.date+' <span class="text-muted m-l-small pull-right"><a href="javascript:iLikeThisComment(13)" title="Like"> <i class="icon-thumbs-up icon-large"></i>  </a></span></header> <div>'+data.text+'</div> </section> </article>');
                //$('#comment_'+data.id).slideDown();
                
                resetFields(oid);
            }, "json");            
            
    }else{
        $('#addEmComment_'+oid).focus();
    }

    return false;
}
function resetFields(oid){
    var obj = document.getElementById('addEmComment_'+oid);
    if(obj){
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        obj.style.height = '29px';
        inputPlaceholder(document.getElementById('addEmComment_'+oid));
    }

    obj = document.getElementById('addEmName_'+oid);
    if(obj){
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        inputPlaceholder(document.getElementById('addEmName_'+oid));
    }

    obj = document.getElementById('addEmMail_'+oid);
    if(obj){
        obj.value = '';
        obj.style.color = '#333';
        obj.disabled = false;
        inputPlaceholder(document.getElementById('addEmMail_'+oid));
    }

    obj = document.getElementById('emAddButton_'+oid);    
    if(obj){
        obj.disabled = false;
    }
}
function iLikeThisComment(cid){
    $.post(
            site_url + 'lib/ajax/likeComment.php', { 
                comment_id:   cid
            },
            
            function(data){
                $('#iLikeThis_'+cid).prepend(data.text+'! &nbsp;');
            }, "json"); 
}
function processVid(file){
$('#vfile').val(file);
$('#Subtn').prop('disabled', false).html('Save').addClass("btn-success");
}
 /*! jQuery Cookie Plugin v1.3 | https://github.com/carhartl/jquery-cookie */
(function(f,b,g){var a=/\+/g;function e(h){return h}function c(h){return decodeURIComponent(h.replace(a," "))}var d=f.cookie=function(p,o,u){if(o!==g){u=f.extend({},d.defaults,u);if(o===null){u.expires=-1}if(typeof u.expires==="number"){var q=u.expires,s=u.expires=new Date();s.setDate(s.getDate()+q)}o=d.json?JSON.stringify(o):String(o);return(b.cookie=[encodeURIComponent(p),"=",d.raw?o:encodeURIComponent(o),u.expires?"; expires="+u.expires.toUTCString():"",u.path?"; path="+u.path:"",u.domain?"; domain="+u.domain:"",u.secure?"; secure":""].join(""))}var h=d.raw?e:c;var r=b.cookie.split("; ");for(var n=0,k=r.length;n<k;n++){var m=r[n].split("=");if(h(m.shift())===p){var j=h(m.join("="));return d.json?JSON.parse(j):j}}return null};d.defaults={};f.removeCookie=function(i,h){if(f.cookie(i)!==null){f.cookie(i,null,h);return true}return false}})(jQuery,document);
var CNav = {
    o: {
        element: '',
        hideStep: 199,
        duration: 200,        
        backBtn: 'a#CNav-back',
        lastId: 0,
        lastelm: 0,
        currentStep: 0,
        ul_heights: {},
        running: false
    },
    option: {},
    init: function (customOption) {
        var self = this;
        self.option = $.extend({}, self.o, customOption);
        self.initCNav();
        self.observerClick()
    },
    initCNav: function () {
	var pathname = window.location.pathname;
        var self = this,
            el = self.option.element,
            $el = $(el),
            $first = $el.first();
        $el.css("height", $(self.option.element + " ul").first().height());
        $(self.option.element).scrollLeft(0);
        $first.find('ul').addClass('pos--1');
        $first.find('li').each(function (ii) {
            var $this = $(this),
                $firstUl = $this.find("ul").first();
            $firstUl.addClass("poz-" + ii);
            if ($firstUl.size() > 0) {
			var a_href =  $this.find('a').first().attr('href');
			var a_name = $this.find('a').first().text();
                $this.find('a').first().append('<i class="icon-double-angle-right"></i>').attr('href', pathname + '#!/' + $this.find('a').first().text()).addClass('haveSubItem');
                $this.find('a').first().next('ul').css('opacity', 0).css('visibility', 'hidden').prepend('<li><a href="' + a_href + '" title="' + a_name + '"><strong>' + a_name + '</strong></a></li>');
            }
        })
    },
    moveMenu: function ($this, direction) {
        var self = this;
        if (!self.option.running) {
            self.option.running = true;
            if (direction == 'next') {
                self.option.currentStep = parseInt($(self.option.element).scrollLeft()) + self.option.hideStep;
                $(self.option.element).animate({
                    height: $this.next('ul').height()
                }, self.option.duration);
                self.option.lastId = $this.parents('ul').attr('class');
                self.option.lastElm = $this.next('ul');
                $this.next('ul').css('visibility', 'visible').animate({
                    opacity: 1
                })
            } else {
                self.option.currentStep = parseInt($(self.option.element).scrollLeft()) - self.option.hideStep;
                $(self.option.element).animate({
                    height: self.option.lastElm.parent('li').parent('ul').height()
                }, self.option.duration, function () {
                    self.option.lastElm.animate({
                        opacity: 0
                    }, self.option.duration / 2).css('visibility', 'hidden');
                    self.option.lastElm = self.option.lastElm.parent('li').parent('ul');
                    self.option.lastId = $(this).attr('class')
                })
            }
            $(self.option.element).animate({
                scrollLeft: self.option.currentStep
            }, self.option.duration, function () {
                if ($(self.option.element).scrollLeft() > 0) {
                    $(self.option.backBtn).animate({
                        left: '-14px'
                    }, self.option.duration, function () {
                        $(this).css('z-index', 1);
						$(this).removeClass('hide');
                        self.option.running = false
                    });
                    $(self.option.backBtn).click(function () {
                        self.moveMenu($(this), 'prev')
                    })
                } else if (self.option.currentStep <= 0) {
                    $(self.option.backBtn).css('z-index', -1).animate({
                        left: '-14px'
                    }, self.option.duration, function () {
                        self.option.running = false;
						$(this).addClass('hide');
                    })
                }
            })
        }
    },
    observerClick: function () {
        var self = this;
        $(self.option.element + " ul a.haveSubItem").click(function () {
		    self.moveMenu($(this), 'next')
        })
    }
};

// Sticky v1.0 by Daniel Raftery
// http://thrivingkings.com/sticky
(function(a){a.sticky=function(e,d,f){return a.fn.sticky(e,d,f)};a.fn.sticky=function(e,d,f){var b={speed:"fast",duplicates:!1,autoclose:5E3,position:"top-right",type:""};d&&a.extend(b,d);e||(e=this.html());var g=!0,h="no",c=Math.floor(99999*Math.random());a(".sticky-note").each(function(){a(this).html()==e&&a(this).is(":visible")&&(h="yes",b.duplicates||(g=!1));a(this).attr("id")==c&&(c=Math.floor(9999999*Math.random()))});a("body").find(".sticky-queue."+b.position).html()||a("body").append('<div class="sticky-queue '+ b.position+'"></div>');g&&(a(".sticky-queue."+b.position).prepend('<div class="sticky border-'+b.position+" "+b.type+'" id="'+c+'"></div>'),a("#"+c).append('<span class="close st-close" rel="'+c+'" title="Close">&times;</span>'),a("#"+c).append('<div class="sticky-note" rel="'+c+'">'+e+"</div>"),d=a("#"+c).height(),a("#"+c).css("height",d),a("#"+c).slideDown(b.speed),g=!0);a(".sticky").ready(function(){b.autoclose&&a("#"+c).delay(b.autoclose).slideUp(b.speed,function(){var b=a(this).closest(".sticky-queue"), c=b.find(".sticky");a(this).remove();c.length=="1"&&b.remove()})});a(".st-close").click(function(){a("#"+a(this).attr("rel")).dequeue().slideUp(b.speed,function(){var b=a(this).closest(".sticky-queue"),c=b.find(".sticky");a(this).remove();c.length=="1"&&b.remove()})});d={id:c,duplicate:h,displayed:g,position:b.position,type:b.type};if(f)f(d);else return d}})(jQuery);
