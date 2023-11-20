/********************************************
 * Custom jQuery
 ********************************************/
jQuery(document).ready(function($){
	

 
	/********************************************
	 *  Portfolio box animations
	 ********************************************/
	 function addPortfolioHover(){
		 
			 $('.portfolio-box').hover(function(){
				
				$(this).find(".portfolio-hover").stop(true, true).fadeIn(200)
							.find(".circle").stop(true, true).animate({opacity:'1', height:'84px'},400,'easeOutBack')
								.find("span").stop(true, true).animate({opacity:'1'},400,'easeOutBack');
				
				
			 },
			 function(){
				 
				 $(this).find(".portfolio-hover").stop(true, true).fadeOut(200)
				 			.find(".circle").stop(true, true).animate({opacity:'0', height:'76px'},400,'easeOutBack')
				 				.find("span").stop(true, true).animate({opacity:'0'},400,'easeOutBack');
				 
			});
	 }
	 
	 addPortfolioHover();
	 
	 /********************************************
	  *  Portfolio sort
	  ********************************************/
	 function addPortfolioSort(){
		 
		 	  // set portfolioItems container min-height
		 	  var portfolioHolder=$('#portfolio-items');
		 	  var portfolioH=$('#wrapper').height()-($('#sidebar').height()+$('#portfolio-filter').height()+100);
		 	  
		 	  portfolioHolder.css('min-height', portfolioH);
		 	  
		 	  
			  // get the action filter option item on page load
			  var $filterType = $('#portfolio-filter li .active a').attr('class');
	
			  // get and assign the ourHolder element to the
			  // $holder varible for use later
			  var $holder = $('#portfolio-items');
	
			  // clone all items within the pre-assigned $holder element
			  var $data = $holder.clone();
	
			  // attempt to call Quicksand when a filter option
			  // item is clicked
			  $('#portfolio-filter li a').click(function(e) {
					    
				  		// reset the active class on all the buttons
					    $('#portfolio-filter li').removeClass('active');
			
					    // assign the class of the clicked filter option
					    // element to our $filterType variable
					    var $filterType = $(this).attr('class');
					    $(this).parent().addClass('active');
					    
					    if ($filterType == 'all') {
					      // assign all li items to the $filteredData var when
					      // the 'All' filter option is clicked
					      var $filteredData = $data.find('.portfolio-box');
					      
					    }
					    else {
					      // find all li elements that have our required $filterType
					      // values for the data-type element
					      var $filteredData = $data.find('div[data-type=' + $filterType + ']');
					    }
					    
					    // align portfolio boxes
					    var count=1;
					    
					    for(i=0; i<$filteredData.length; i++){
					    	
					    	$($filteredData[i]).removeClass('last-item');
					    	
					    	if(count==4){
					    		$($filteredData[i]).addClass('last-item');
					    		count=1;
					    	}else{
					    		count+=1;
					    	}
					    	
					    }
					    
					    // call quicksand and assign transition parameters
					    $holder.quicksand($filteredData, {
						      duration: 500,
						      easing: 'easeOutExpo'
						    },addPortfolioHover); //callback function (add portfolio boxes hover state)
					    return false;
			  });
	 }
	 addPortfolioSort();
	 
	 /********************************************
	  *  Blog image animations
	  ********************************************/
	 function addBlogHover(){
			 
		 $('.post-img').hover(function(){
			
			$(this).find(".img-hover").stop(true, true).fadeIn(200);
					
		     		
			},
			function(){
					 
			$(this).find(".img-hover").stop(true, true).fadeOut(200);
		 	    	 
			});
		 }
		 
	 addBlogHover();
	 
	
	 //  Shortcodes
	 
	 /********************************************
	  *  Toggle
	  ********************************************/
	 $('.xtoggle').each(function(){
		 
		 var content = $(this).find('.xtoggle-content');
		 var state = content.attr('data-show');
		 var disable = 0;
		 
		 if(state == 'false'){
			 disable = false;
	 	 }
		 
		 $(this).accordion({
				collapsible: true,
				active: disable
		 });
		 
	 });
	 
	 /********************************************
	  *  Tabs
	  ********************************************/
	 $('.tabs').each(function(){
		 $(this).tabs(); 
	 });
	 
	 /********************************************
	  *  Single Portfolio nav box animations
	  ********************************************/
	 function addPortfolioNavHover(){
		 	 
		 $('.nav-portfolio').hover(function(){
			
			 $(this).find('.nav-portfolio-hover').stop(true, true).fadeIn(200)
					.find("span").stop(true, true).animate({opacity:'1', marginLeft: '95.5px'},400,'easeOutBack');
				
					
		},
		function(){
			
				 var target = $(this).find('.nav-portfolio-hover');
				 
				 if(target.find("span").hasClass('arrow-next')){
					 // animate next arrow
					 target.stop(true, true).fadeOut(200)
							.find("span").stop(true, true).animate({opacity:'0', marginLeft: '75.5px'},400,'easeOutBack');
				 }else{
					 // animate prev arrow
					 target.stop(true, true).fadeOut(200)
							.find("span").stop(true, true).animate({opacity:'0', marginLeft: '115.5px'},400,'easeOutBack');
				 }
				 
				});
		 }
		 
	 addPortfolioNavHover();
(function($){$.fn.extend({thumbnlist:function(options){jQuery(".viboxes ul li").hover(function(){jQuery(this).find(".picture").stop().animate({"top":-30},500,"easeOutExpo");jQuery(this).find(".alpha a").find("img").stop().animate({"opacity":0.50},500,"easeOutExpo");},function(){jQuery(this).find(".picture").stop().animate({"top":0},500,"easeOutExpo");jQuery(this).find(".alpha a").find("img").stop().animate({"opacity":1},500,"easeOutExpo");});}});})(jQuery);
	jQuery('.videoboxes').thumbnlist();	
	

	 /* ================================================================================== */
/* == Global Preloader ============================================================== */
/* ================================================================================== */

 var preload = function(container,time){
	   
	  temp = container.find("img");
	
	  temp.each(function(){
		  
		  jQuery(this).bind("load error",function(){
		 
		  jQuery(this).css({ "visibility": "visible" }).animate({ opacity:"1" },time);
		  
		  }).each(function(){
                if(this.complete || (jQuery.browser.msie && parseInt(jQuery.browser.version) == 6)) { jQuery(this).trigger('load');  }
            });
		  
	  });
	   
	  }
	  
 //----------------------------
	//        Box toggling
	//----------------------------
	function boxToggle(target)
	{		
		var boxparent = $(target).closest('.box'); //get box parent element
		
		if($(boxparent).hasClass("hidden")) //parent is hidden //toggle box parent
		{						
			$(boxparent).removeClass("hidden"); //remove hidden css class			
			$(boxparent).children('.content').slideDown(); //show box content
		}
		else
		{
			//parent is visible			
  	$(boxparent).addClass("hidden"); //apply hidden css class
			$(boxparent).children('.content').slideUp(); //hide box content
		}
	}
	/*Triggers*/	
	$('.toggle').click(function(e)  /*toggle button*/
	{
		e.preventDefault();	
		boxToggle($(this));
	});
	
	$('.box .header h2 a').click(function(e) /*header title*/
	{
		e.preventDefault();	
		boxToggle($(this));
	});
		

});
