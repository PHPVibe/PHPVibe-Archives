/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
	$(".menu > li").click(function(e){
		switch(e.target.id){
			case "ucomments":
				//change status & style menu
				$("#ucomments").addClass("active");
				$("#utweets").removeClass("active");
				$("#videoresp").removeClass("active");
				//display selected division, hide others
				$("div.ucomments").fadeIn();
				$("div.utweets").css("display", "none");
				$("div.videoresp").css("display", "none");
			break;
			case "utweets":
				//change status & style menu
				$("#ucomments").removeClass("active");
				$("#utweets").addClass("active");
				$("#videoresp").removeClass("active");
				//display selected division, hide others
				$("div.utweets").fadeIn();
				$("div.ucomments").css("display", "none");
				$("div.videoresp").css("display", "none");
			break;
			case "videoresp":
				//change status & style menu
				$("#ucomments").removeClass("active");
				$("#utweets").removeClass("active");
				$("#videoresp").addClass("active");
				//display selected division, hide others
				$("div.videoresp").fadeIn();
				$("div.ucomments").css("display", "none");
				$("div.utweets").css("display", "none");
			break;
		}
		//alert(e.target.id);
		return false;
	});
});