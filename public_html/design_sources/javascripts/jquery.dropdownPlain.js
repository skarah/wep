$(function(){

    $("ul.dropdown li").hover(function(){
    
//        $(this).addClass("hover");
        $(this).find('a.current').addClass("hover");
        $('ul:first',this).css('visibility', 'visible');
    
    }, function(){
    
//        $(this).removeClass("hover");
         $(this).find('a.current').removeClass("hover");
        $('ul:first',this).css('visibility', 'hidden');
    
    });
    
//    $("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");



		$("ul.dropdown ul li.first a").last().css('margin-bottom', '0px')


});