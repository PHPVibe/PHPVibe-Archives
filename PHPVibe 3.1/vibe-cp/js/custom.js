$(function () {
	
	$.fn.contentTabs = function(){ 
	
		$(this).find(".tab_content").hide(); //Hide all content
		$(this).find("ul.tabs li:first").addClass("activeTab").show(); //Activate first tab
		$(this).find(".tab_content:first").show(); //Show first tab content
	
		$("ul.tabs li").click(function() {
			$(this).parent().parent().find("ul.tabs li").removeClass("activeTab"); //Remove any "active" class
			$(this).addClass("activeTab"); //Add "active" class to selected tab
			$(this).parent().parent().find(".tab_content").hide(); //Hide all tab content
			var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			$(activeTab).show(); //Fade in the active content
			return false;
		});
	
	};
	$("div[class^='widget']").contentTabs(); 
    $('ul#nav .collapse').parents('li').find('ul').hide();
    $('ul#nav .collapse').toggle(function () {
        $(this).parents('li').find('ul').stop(true, true).slideDown('fast');
        return false;
    }, function () {
        $(this).parents('li').find('ul').stop(true, true).slideUp('fast');
        return false;
    });
		$(".hMsg").click(function() {
		$(this).fadeTo(200, 0.00, function(){ //fade
			$(this).slideUp(200, function() { //slide up
				$(this).remove(); //then remove from the DOM
			});
		});
	});	
	
  

    $('.datatable').dataTable({
      "sPaginationType": "full_numbers",
      "bStateSave": true
    });
  
    $('.dataTables_wrapper').each(function() {
      var table = $(this);
      var info = table.find('.dataTables_info');
      var paginate = table.find('.dataTables_paginate');
    
      table.find('.datatable').after('<div class="action_bar nomargin"></div>');
      table.find('.action_bar').prepend(info).append(paginate);
    });
	
		/* Sortables
	------------------------------------------------------------------------- */
	
	$('#easyhome').sortable();


	

});
 $('document').ready(function(){

            $('.menu').fixedMenu();
		    $('.lightbox').lightbox();
			$('input[type=checkbox], input[type=radio]').prettyCheckboxes();
			$('select').select_skin();
			$('input[type="file"]').customFileInput();    
		    $('#large_grid ul').masonry({   itemSelector: '#large_grid ul li',
		     columnWidth: function( containerWidth ) {     return containerWidth / 4;  }		  
		  }); 
		  $('#photoimg').live('change', function()	{ 
			 $("#preview").html('');
			 $("#preview").html('<img src="../com/loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({ 	target: '#preview'	}).submit();		
			});  
$("#easyhome ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			
			$.post("updateDB.php", order, function(theResponse){
				$("#respo").html(theResponse).fadeIn(400).delay(800).slideUp(300);
			}); 															 
		}								  
		});			
    });

	
	/**
 * jQuery Masonry v2.1.05
 * A dynamic layout plugin for jQuery
 * The flip-side of CSS Floats
 * http://masonry.desandro.com
 *
 * Licensed under the MIT license.
 * Copyright 2012 David DeSandro
 */
(function(a,b,c){"use strict";var d=b.event,e;d.special.smartresize={setup:function(){b(this).bind("resize",d.special.smartresize.handler)},teardown:function(){b(this).unbind("resize",d.special.smartresize.handler)},handler:function(a,c){var d=this,f=arguments;a.type="smartresize",e&&clearTimeout(e),e=setTimeout(function(){b.event.handle.apply(d,f)},c==="execAsap"?0:100)}},b.fn.smartresize=function(a){return a?this.bind("smartresize",a):this.trigger("smartresize",["execAsap"])},b.Mason=function(a,c){this.element=b(c),this._create(a),this._init()},b.Mason.settings={isResizable:!0,isAnimated:!1,animationOptions:{queue:!1,duration:500},gutterWidth:0,isRTL:!1,isFitWidth:!1,containerStyle:{position:"relative"}},b.Mason.prototype={_filterFindBricks:function(a){var b=this.options.itemSelector;return b?a.filter(b).add(a.find(b)):a},_getBricks:function(a){var b=this._filterFindBricks(a).css({position:"absolute"}).addClass("masonry-brick");return b},_create:function(c){this.options=b.extend(!0,{},b.Mason.settings,c),this.styleQueue=[];var d=this.element[0].style;this.originalStyle={height:d.height||""};var e=this.options.containerStyle;for(var f in e)this.originalStyle[f]=d[f]||"";this.element.css(e),this.horizontalDirection=this.options.isRTL?"right":"left",this.offset={x:parseInt(this.element.css("padding-"+this.horizontalDirection),10),y:parseInt(this.element.css("padding-top"),10)},this.isFluid=this.options.columnWidth&&typeof this.options.columnWidth=="function";var g=this;setTimeout(function(){g.element.addClass("masonry")},0),this.options.isResizable&&b(a).bind("smartresize.masonry",function(){g.resize()}),this.reloadItems()},_init:function(a){this._getColumns(),this._reLayout(a)},option:function(a,c){b.isPlainObject(a)&&(this.options=b.extend(!0,this.options,a))},layout:function(a,b){for(var c=0,d=a.length;c<d;c++)this._placeBrick(a[c]);var e={};e.height=Math.max.apply(Math,this.colYs);if(this.options.isFitWidth){var f=0;c=this.cols;while(--c){if(this.colYs[c]!==0)break;f++}e.width=(this.cols-f)*this.columnWidth-this.options.gutterWidth}this.styleQueue.push({$el:this.element,style:e});var g=this.isLaidOut?this.options.isAnimated?"animate":"css":"css",h=this.options.animationOptions,i;for(c=0,d=this.styleQueue.length;c<d;c++)i=this.styleQueue[c],i.$el[g](i.style,h);this.styleQueue=[],b&&b.call(a),this.isLaidOut=!0},_getColumns:function(){var a=this.options.isFitWidth?this.element.parent():this.element,b=a.width();this.columnWidth=this.isFluid?this.options.columnWidth(b):this.options.columnWidth||this.$bricks.outerWidth(!0)||b,this.columnWidth+=this.options.gutterWidth,this.cols=Math.floor((b+this.options.gutterWidth)/this.columnWidth),this.cols=Math.max(this.cols,1)},_placeBrick:function(a){var c=b(a),d,e,f,g,h;d=Math.ceil(c.outerWidth(!0)/this.columnWidth),d=Math.min(d,this.cols);if(d===1)f=this.colYs;else{e=this.cols+1-d,f=[];for(h=0;h<e;h++)g=this.colYs.slice(h,h+d),f[h]=Math.max.apply(Math,g)}var i=Math.min.apply(Math,f),j=0;for(var k=0,l=f.length;k<l;k++)if(f[k]===i){j=k;break}var m={top:i+this.offset.y};m[this.horizontalDirection]=this.columnWidth*j+this.offset.x,this.styleQueue.push({$el:c,style:m});var n=i+c.outerHeight(!0),o=this.cols+1-l;for(k=0;k<o;k++)this.colYs[j+k]=n},resize:function(){var a=this.cols;this._getColumns(),(this.isFluid||this.cols!==a)&&this._reLayout()},_reLayout:function(a){var b=this.cols;this.colYs=[];while(b--)this.colYs.push(0);this.layout(this.$bricks,a)},reloadItems:function(){this.$bricks=this._getBricks(this.element.children())},reload:function(a){this.reloadItems(),this._init(a)},appended:function(a,b,c){if(b){this._filterFindBricks(a).css({top:this.element.height()});var d=this;setTimeout(function(){d._appended(a,c)},1)}else this._appended(a,c)},_appended:function(a,b){var c=this._getBricks(a);this.$bricks=this.$bricks.add(c),this.layout(c,b)},remove:function(a){this.$bricks=this.$bricks.not(a),a.remove()},destroy:function(){this.$bricks.removeClass("masonry-brick").each(function(){this.style.position="",this.style.top="",this.style.left=""});var c=this.element[0].style;for(var d in this.originalStyle)c[d]=this.originalStyle[d];this.element.unbind(".masonry").removeClass("masonry").removeData("masonry"),b(a).unbind(".masonry")}},b.fn.imagesLoaded=function(a){function h(){a.call(c,d)}function i(a){var c=a.target;c.src!==f&&b.inArray(c,g)===-1&&(g.push(c),--e<=0&&(setTimeout(h),d.unbind(".imagesLoaded",i)))}var c=this,d=c.find("img").add(c.filter("img")),e=d.length,f="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",g=[];return e||h(),d.bind("load.imagesLoaded error.imagesLoaded",i).each(function(){var a=this.src;this.src=f,this.src=a}),c};var f=function(b){a.console&&a.console.error(b)};b.fn.masonry=function(a){if(typeof a=="string"){var c=Array.prototype.slice.call(arguments,1);this.each(function(){var d=b.data(this,"masonry");if(!d){f("cannot call methods on masonry prior to initialization; attempted to call method '"+a+"'");return}if(!b.isFunction(d[a])||a.charAt(0)==="_"){f("no such method '"+a+"' for masonry instance");return}d[a].apply(d,c)})}else this.each(function(){var c=b.data(this,"masonry");c?(c.option(a||{}),c._init()):b.data(this,"masonry",new b.Mason(a,this))});return this}})(window,jQuery);

// Sticky v1.0 by Daniel Raftery
// http://thrivingkings.com/sticky
;(function(a){a.sticky=function(e,d,f){return a.fn.sticky(e,d,f)};a.fn.sticky=function(e,d,f){var b={speed:"fast",duplicates:!1,autoclose:5E3,position:"top-right",type:""};d&&a.extend(b,d);e||(e=this.html());var g=!0,h="no",c=Math.floor(99999*Math.random());a(".sticky-note").each(function(){a(this).html()==e&&a(this).is(":visible")&&(h="yes",b.duplicates||(g=!1));a(this).attr("id")==c&&(c=Math.floor(9999999*Math.random()))});a("body").find(".sticky-queue."+b.position).html()||a("body").append('<div class="sticky-queue '+ b.position+'"></div>');g&&(a(".sticky-queue."+b.position).prepend('<div class="sticky border-'+b.position+" "+b.type+'" id="'+c+'"></div>'),a("#"+c).append('<span class="close st-close" rel="'+c+'" title="Close">&times;</span>'),a("#"+c).append('<div class="sticky-note" rel="'+c+'">'+e+"</div>"),d=a("#"+c).height(),a("#"+c).css("height",d),a("#"+c).slideDown(b.speed),g=!0);a(".sticky").ready(function(){b.autoclose&&a("#"+c).delay(b.autoclose).slideUp(b.speed,function(){var b=a(this).closest(".sticky-queue"), c=b.find(".sticky");a(this).remove();c.length=="1"&&b.remove()})});a(".st-close").click(function(){a("#"+a(this).attr("rel")).dequeue().slideUp(b.speed,function(){var b=a(this).closest(".sticky-queue"),c=b.find(".sticky");a(this).remove();c.length=="1"&&b.remove()})});d={id:c,duplicate:h,displayed:g,position:b.position,type:b.type};if(f)f(d);else return d}})(jQuery);