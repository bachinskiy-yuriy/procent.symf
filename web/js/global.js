/*-------------------------------------------------------------------------------------------------------------------------------*/
/*This is main JS file that contains custom style rules used in this template*/
/*-------------------------------------------------------------------------------------------------------------------------------*/
/* Template Name: "Title"*/
/* Version: 1.0 Initial Release*/
/* Build Date: 06-02-2016*/
/* Author: Title*/
/* Copyright: (C) 2016 */
/*-------------------------------------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------*/
/* TABLE OF CONTENTS: */
/*--------------------------------------------------------*/
/* 01 - VARIABLES */
/* 02 - page calculations */
/* 03 - function on document ready */
/* 04 - function on page load */
/* 05 - function on page resize */
/* 06 - function on page scroll */
/* 07 - swiper sliders */
/* 08 - buttons, clicks, hovers */

var _functions = {};

$(function() {

	"use strict";

	/*================*/
	/* 01 - VARIABLES */
	/*================*/
	var swipers = [], winW, winH, headerH, winScr, footerTop, _isresponsive, _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

	/*========================*/
	/* 02 - page calculations */
	/*========================*/
	_functions.pageCalculations = function(){
		winW = $(window).width();
		winH = $(window).height();
	};

	/*=================================*/
	/* 03 - function on document ready */
	/*=================================*/
	if(_ismobile) $('body').addClass('mobile');
	_functions.pageCalculations();

	/*============================*/
	/* 04 - function on page load */
	/*============================*/
	$(window).load(function(){
		_functions.initSwiper();
		$('body').addClass('loaded');
		$('#loader-wrapper').fadeOut();
	});

	/*==============================*/
	/* 05 - function on page resize */
	/*==============================*/
	_functions.resizeCall = function(){
		_functions.pageCalculations();
	};
	if(!_ismobile){
		$(window).resize(function(){
			_functions.resizeCall();
		});
	} else{
		window.addEventListener("orientationchange", function() {
			_functions.resizeCall();
		}, false);
	}

	/*==============================*/
	/* 06 - function on page scroll */
	/*==============================*/
	$(window).scroll(function(){
		_functions.scrollCall();
	});

	_functions.scrollCall = function(){
		winScr = $(window).scrollTop();
		if(winScr>150){
			$('.onekey-header').addClass('stick');
		} else{
			$('.onekey-header').removeClass('stick');
			$('.onekey-header-inner').css('transition','none');
		}
		if(winScr>250){
			$('.onekey-header').addClass('active');
			$('.onekey-header-inner').css('transition','all 0.5s ease-in-out');
		} else{
			$('.onekey-header').removeClass('active');
		}
	};

	/*=====================*/
	/* 07 - swiper sliders */
	/*=====================*/
	var initIterator = 0;
	_functions.initSwiper = function(){
		$('.swiper-container').not('.initialized').each(function(){								  
			var $t = $(this);								  

			var index = 'swiper-unique-id-'+initIterator;

			$t.addClass('swiper-'+index+' initialized').attr('id', index);
			$t.find('.swiper-pagination').addClass('swiper-pagination-'+index);
			$t.find('.swiper-button-prev').addClass('swiper-button-prev-'+index);
			$t.find('.swiper-button-next').addClass('swiper-button-next-'+index);

			var slidesPerViewVar = ($t.data('slides-per-view'))?$t.data('slides-per-view'):1;
			if(slidesPerViewVar!='auto') slidesPerViewVar = parseInt(slidesPerViewVar, 10);

			swipers['swiper-'+index] = new Swiper('.swiper-'+index,{
				pagination: '.swiper-pagination-'+index,
		        paginationClickable: true,
		        nextButton: '.swiper-button-next-'+index,
		        prevButton: '.swiper-button-prev-'+index,
		        slidesPerView: slidesPerViewVar,
		        autoHeight:($t.is('[data-auto-height]'))?parseInt($t.data('auto-height'), 10):0,
		        loop: ($t.is('[data-loop]'))?parseInt($t.data('loop'), 10):0,
				autoplay: ($t.is('[data-autoplay]'))?parseInt($t.data('autoplay'), 10):0,
				spaceBetween: ($t.is('[data-space-between]'))?parseInt($t.data('space-between'), 10):0,				
		        breakpoints: ($t.is('[data-breakpoints]'))? { 767: { slidesPerView: parseInt($t.attr('data-xs-slides'), 10) }, 991: { slidesPerView: parseInt($t.attr('data-sm-slides'), 10) }, 1199: { slidesPerView: parseInt($t.attr('data-md-slides'), 10) } } : {},
		        initialSlide: ($t.is('[data-ini]'))?parseInt($t.data('ini'), 10):0,
		        speed: ($t.is('[data-speed]'))?parseInt($t.data('speed'), 10):500,
		        keyboardControl: true,
		        mousewheelControl: ($t.is('[data-mousewheel]'))?parseInt($t.data('mousewheel'), 10):0,
		        mousewheelReleaseOnEdges: true,
		        direction: ($t.is('[data-direction]'))?$t.data('direction'):'horizontal'
			});
			swipers['swiper-'+index].update();
			initIterator++;
		});
		$('.swiper-container.swiper-control-top').each(function(){
			swipers['swiper-'+$(this).attr('id')].params.control = swipers['swiper-'+$(this).parent().find('.swiper-control-bottom').attr('id')];
		});
		$('.swiper-container.swiper-control-bottom').each(function(){
			swipers['swiper-'+$(this).attr('id')].params.control = swipers['swiper-'+$(this).parent().find('.swiper-control-top').attr('id')];
		});
	};

	/*==============================*/
	/* 08 - buttons, clicks, hovers */
	/*==============================*/
	//menu
	$('.onekey-toggle-switch').on('click', function(e){
		$(this).toggleClass('active');
		$('.onekey-toggle-block').toggleClass('active');
		e.preventDefault();
	});



	//slider range
  	$(".onekey-range-item" ).each(function(index) {
     	var counter = $(this).data('counter'),
     		step = parseInt($(this).data('step'),10),
     		to = parseInt($(this).data('to'),10),     	     	
     		min = parseInt($(this).data('min'),10),     	     	
     		max = parseInt($(this).data('max'),10);     	     	
     	$(this).find(".onekey-range").attr("id","onekey-range-"+index);
     	$(this).find(".onekey-range-start").attr("id","onekey-range-start-"+index);
     	$(this).find(".onekey-range-end").attr("id","onekey-range-end-"+index);
     	$(this).find(".onekey-range-value").attr("id","onekey-range-value-"+index);     	   	
	  	$("#onekey-range-"+index).slider({
	  		range: "min",
			min: min,
			max: max,
			step: step,
			value: to,
			slide: function( event, ui ) {
				$("#onekey-range-value-"+index).val(ui.value);
							
			},
			change: function( event, ui ) {
			    var money = $("#onekey-range-value-0").val();
			    var term = $("#onekey-range-value-1").val();
                transitionAjax('/calc/'+money+'/'+term);
			}
	    });
		$("#onekey-range-start-"+index).val(min);
		$("#onekey-range-end-"+index).val(max);   		
    });

	$('.onekey-range-change').on('click', function(){
		var $range = $(this).siblings('.onekey-range'),
			step = $range.slider("option","step"),
			value = $range.slider("value");
		if($(this).hasClass('plus')){
			$(this).closest('.onekey-range-item').find('.onekey-range-value').val(value+step);
			$range.slider("value",value+step);
		} else{
			$(this).closest('.onekey-range-item').find('.onekey-range-value').val(value-step);
			$range.slider("value",value-step)
		}
	});
	$('.onekey-reply-stars-entry .fa').on('click',function(){
		var count = $(this).index()+1;
		$(this).parent().removeClass().addClass('onekey-reply-stars-entry star'+count);
        $("#onekey-reply-star-cnt").val(count);      
	});

	//Ajax demo
		function showprogress() {
		    if (document.images.length == 0) {
		        return false;
		    }
		    var loaded = 0;
		    for (var i = 0; i < document.images.length; i++) {
		        if (document.images[i].complete) {
		            loaded++;
		        }
		    }
		    percentage = (loaded / document.images.length);
		}
		var ID, percentage, ajaxFinish = 0;

		var _if_state = (typeof(history.replaceState) !== "undefined") ? true : false;

		function transitionAjax(foo) {
		    if (ajaxFinish) return false;
		    ajaxFinish = 1;
		    var url = foo;

		    $.ajax({
		        type: "GET",
		        async: true,
		        url: url,
		        success: function(response) {

						var responseObject = $($.parseHTML(response));
   						$('.onekey-credit-rating').animate({'opacity':'0'}, 1000, function(){
     					$(this).html(responseObject.html());

		                ID = window.setInterval(function() {
		                    showprogress();
		                    if (percentage == 1) {
		                        window.clearInterval(ID);
		                        percentage = 0;

		                        $(window).load();
		                        $('.onekey-credit-rating').animate({
		                            'opacity': '1'
		                        }, 1000, function() {
		                            ajaxFinish = 0;
		                            _functions.resizeCall();
		                        });
		                    }
		                });

		            });

		        }
		    });

		}
    

});