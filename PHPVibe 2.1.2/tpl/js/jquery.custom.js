/********************************************
 * Custom jQuery for phpVibe
 ********************************************/

jQuery(document).ready(function(){
    jQuery("#suggest-youtube").googleSuggest({service: "youtube"});
	jQuery('#embed').lightbox();
	jQuery('#reqfriend').lightbox();
	jQuery('.lightbox').lightbox();
   
	
// Port Hover
	jQuery(".channel-box-hover").hover(function(){
		jQuery(this).animate({ opacity: 0.55 }, 500, 'easeOutExpo');
		jQuery(this).find('span').animate({ left: '50%'}, 400, 'easeOutExpo');
		
	}, function(){
		jQuery(this).find('span').animate({ left: '150%'}, 400, 'easeInExpo', function(){
		jQuery(this).css('left','-50%');
		});
		jQuery(this).animate({ opacity: 0 }, 500, 'easeInExpo');
	});


  jQuery("#playlist_btn").click(function () {
   jQuery("#playlist_container").show("slow");
    });

	
	 //  Shortcodes
	 
	 /********************************************
	  *  Toggle
	  ********************************************/
	 jQuery('.xtoggle').each(function(){		 
		 var content = jQuery(this).find('.xtoggle-content');
		 var state = content.attr('data-show');
		 var disable = 0;		 
		 if(state == 'false'){
			 disable = false;
	 	 }
		 
		 jQuery(this).accordion({
				collapsible: true,
				active: disable
		 });
		 
	 });
	 
	 /********************************************
	  *  Tabs
	  ********************************************/
	 jQuery('.tabs').each(function(){
		 jQuery(this).tabs(); 
	 });
	 

(function () {
    jQuery.fn.extend({
        thumbnlist: function (options) {
            jQuery(".viboxes ul li").hover(function () {
                jQuery(this).find(".picture").stop().animate({
                    "top": -30
                }, 500, "easeOutExpo");
                jQuery(this).find(".alpha a").find("img").stop().animate({
                    "opacity": 0.50
                }, 500, "easeOutExpo");
            }, function () {
                jQuery(this).find(".picture").stop().animate({
                    "top": 0
                }, 500, "easeOutExpo");
                jQuery(this).find(".alpha a").find("img").stop().animate({
                    "opacity": 1
                }, 500, "easeOutExpo");
            });
        }
    });
})(jQuery);
jQuery('.videoboxes').thumbnlist();
	

 //----------------------------
	//        Box toggling
	//----------------------------
	function boxToggle(target)
	{		
		var boxparent = jQuery(target).closest('.box'); //get box parent element
		
		if(jQuery(boxparent).hasClass("hidden")) //parent is hidden //toggle box parent
		{						
			jQuery(boxparent).removeClass("hidden"); //remove hidden css class			
			jQuery(boxparent).children('.content').slideDown(); //show box content
		}
		else
		{
			//parent is visible			
  	jQuery(boxparent).addClass("hidden"); //apply hidden css class
			jQuery(boxparent).children('.content').slideUp(); //hide box content
		}
	}
	/*Triggers*/	
	jQuery('.toggle').click(function(e)  /*toggle button*/
	{
		e.preventDefault();	
		boxToggle(jQuery(this));
	});
	
	jQuery('.box .header h2 a').click(function(e) /*header title*/
	{
		e.preventDefault();	
		boxToggle(jQuery(this));
	});
	

});
