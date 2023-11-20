/**
 *  Plugin which renders the YouTube channel videos list to the page
 *  @author:  H. Yankov (hristo.yankov at gmail dot com)
 *  @version: 1.0.0 (Nov/27/2009)
 *	http://yankov.us
 */

 var __mainDiv;
 var __preLoaderHTML;
 var __opts;
 
 function __jQueryYouTubeChannelReceiveData(data) {
	$.each(data.feed.entry, function(i,e) {
		__mainDiv.append(e.content.$t);
	});
	
	// Mark the first div in the list
	$(__mainDiv).find("div:first").addClass("firstVideo");
	
	// Now hide objects depending on the settings and fix the img style
	$(__mainDiv).find("div").each(function () {
		// Do we need to remove borders from image?
		if (__opts.removeBordersFromImage) {
			jQuery(this).find("table > tbody > tr:first > td:first > div").css("border", "0px");
			jQuery(this).find("table > tbody > tr:first > td:first > div > a > img").css("border", "0px");
		}
		
		// Open in new tab?
		if (__opts.linksInNewWindow) {
			jQuery(this).find("table > tbody > tr:first > td:first > div > a").attr("target", "_blank");
			jQuery(this).find("table > tbody > tr:first > td:eq(1)  > div > a").attr("target", "_blank");
		}
	
		// Hide the video length
		if (__opts.hideVideoLength)
			jQuery(this).find("table > tbody > tr:last > td:first").hide();
		
		var additionalInfo = jQuery(this).find("table > tbody > tr:first > td:last");
		
		if (__opts.hideFrom)
			$(additionalInfo).find("div:eq(0)").hide();
		
		if (__opts.hideViews)
			$(additionalInfo).find("div:eq(1)").hide();
		
		if (__opts.hideRating)
			$(additionalInfo).find("div:eq(2)").hide();
			
		if (__opts.hideNumberOfRatings)
			$(additionalInfo).find("div:eq(3)").hide();
			
		// Always hide the additional categories
		jQuery(this).find("table > tbody > tr:last  > td:last").hide();
	});
	
	// Remove the preloader and show the content
	$(__preLoaderHTML).remove();
	__mainDiv.show();
}
				
(function($) {
$.fn.youTubeChannel = function(options) {
	var videoDiv = $(this);

	$.fn.youTubeChannel.defaults = {
		userName: null,
		loadingText: "Loading...",
		linksInNewWindow: true,
		hideVideoLength: false,
		hideFrom: true,
		hideViews: false,
		hideRating: false,
		hideNumberOfRatings: true,
		removeBordersFromImage: true
	}
			
    __opts = $.extend({}, $.fn.youTubeChannel.defaults, options);
	
	return this.each(function() {
		if (__opts.userName != null) {			
			videoDiv.append("<div id=\"channel_div\"></div>");
			__mainDiv = $("#channel_div");
			__mainDiv.hide();
			
			__preLoaderHTML = $("<p class=\"loader\">" + __opts.loadingText + "</p>");
			videoDiv.append(__preLoaderHTML);
			
			// TODO: Error handling!
			$.getScript("http://gdata.youtube.com/feeds/base/users/" + __opts.userName + "/uploads?alt=json-in-script&callback=__jQueryYouTubeChannelReceiveData");
		}
	});
};
})(jQuery);