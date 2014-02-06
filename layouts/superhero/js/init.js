(function($){
	//"use strict";
	$(function(){
		/* Make the navbar solid when the window is scrolled below the jumbotron */
		var 
			$window = $(window),
			$herounit = $('#jumbotron'),
			$topnav = $('#top-nav'),
			herounit_bottom, 
			navheight, 
			switch_over
		;
		if($herounit.length && $topnav.length){
			
			$window.resize(function(){
				herounit_bottom = $herounit.position().top + $herounit.height();
				navheight = $topnav.height();
				switch_over = herounit_bottom;// - navheight;
			});
			$window.resize();//calculate now
			
			$window.scroll(function(){
				if($window.scrollTop() > switch_over){
					$topnav.removeClass('transparent');
				}else{
					$topnav.addClass('transparent');
				}
			});
		}
	});
})(jQuery);