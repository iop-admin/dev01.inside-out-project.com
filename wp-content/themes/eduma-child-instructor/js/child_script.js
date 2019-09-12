(function ($) {
	"use strict";

	$(window).load(function () {
		/* Padding left for section Courses */
		var width_screen = $(window).width();
		var width_container = $('#main-home-content').width();
		var elementPaddingLeft = $('.thim-padding-left');
		var elementInstructorCourses = $('.thim-instructor-courses');

		if(elementPaddingLeft.length){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-padding-left >.vc_column-inner').css('padding-left',margin_left_value + 'px');
				$('.thim-padding-left >.so-panel').css('padding-left',margin_left_value + 'px');
				$('.thim-padding-left >.elementor-column-wrap').css('padding-left',margin_left_value + 'px');
			}
		}

		if(elementInstructorCourses.length){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-instructor-courses .thim-course-slider-instructor .owl-controls .owl-buttons').css('left',margin_left_value+'px');
			}
		}
	})

	$( window ).resize(function() {

		var width_screen = $(window).width();
		var width_container = $('#main-home-content').width();
		var elementPaddingLeft = $('.thim-padding-left');
		var elementInstructorCourses = $('.thim-instructor-courses');

		if(elementPaddingLeft.length){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-padding-left >.vc_column-inner').css('padding-left',margin_left_value + 'px');
			}
		}

		// if(elementInstructorCourses.length){
		// 	if( width_screen > width_container ){
		// 		var margin_left_value = ( width_screen - width_container ) / 2 ;
		// 		$('.thim-instructor-courses .thim-course-slider-instructor .owl-controls .owl-buttons').css('left',margin_left_value+'px');
		// 	}
		// }
	});

})(jQuery);