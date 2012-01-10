// Scroll to element ask questions
$(document).ready(function(){
	$(".scroll").click(function(event){
		//prevent the default action for the click event
		event.preventDefault();

		//get the full url - like mysitecom/index.htm#home
		var full_url = this.href;

		//split the url by # and get the anchor target name - home in mysitecom/index.htm#home
		var parts = full_url.split("#");
		var trgt = parts[1];

		//get the top offset of the target anchor
		var target_offset = $("#"+trgt).offset();
		var target_top = target_offset.top;

		//goto that anchor by setting the body scroll top to anchor top
		$('html, body').animate({scrollTop:target_top}, 500);
	});
});

// small editing for view
jQuery(document).ready(function() {
	$(".guest_block").last().css('margin-right', '0px')
	$(".third_news").last().css('margin-right', '0px')
	$(".paginator li a").first().css('padding-left', '0px')
	$(".not_suitable_block").last().css('margin-right', '0px')
	$(".med_profile ul").last().css('width', '250px')
	$(".med_programs ul").last().css('width', '265px')
});

// Panorama items hover
jQuery(document).ready(function() {
	$(".panorama_item").mouseenter(function(){
		$(this).find('.itembg').attr("src","images/panorama_hover_itembg.png");
	});

	$(".panorama_item").mouseleave(function(){
		$(this).find('.itembg').attr("src","images/panorama_itembg.png");
	});
});

// added height images in ie6
jQuery(document).ready(function() {
	if ( $.browser.version==6 ) {
		$("div.services_submenu_bottom").append("<img src='images/0.gif' alt='' class='hackie' />")
		$("div.submenuhr").append("<img src='images/0.gif' alt='' class='hackie' />")
		$("div.big_photohr").append("<img src='images/0.gif' alt='' class='hackie' />")
		$("div.complexhr").append("<img src='images/0.gif' alt='' class='hackie' />")
		$("div.roomrh").append("<img src='images/0.gif' alt='' class='hackie' />")
	}
	
	if ( $.browser.msie ) {
		$('input:checkbox').css('border', '0px none!important');
	}
});












// replacement images in fucking ie6
//jQuery(document).ready(function() {
//	if ( $.browser.version==6 ) {
//		$(".boxbg").attr("src","images/rooms_boxbg.gif");
//	}
//});
