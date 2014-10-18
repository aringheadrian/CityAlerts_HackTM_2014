/*!
 *	XtendMusic jQuery Plugins
 * 	Author	: @alinhort
 * 	Version	: 1.0
 */

/*----------------------------------------------------------*
*	Toggle between two functions on click					*
*	Use: $(object).ClickToggle(function(){}, function(){});	*
*----------------------------------------------------------*/
(function($) {
    $.fn.ClickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));

 
/*--------------------------------------------------------------------------*
*	Width & Height Auto Increase When typing and Auto Decrease on Delete	*
*	Use with JavaScript		: $(object).GrowAndShrink({options});			*
*	Use without JavaScript	: <input data-init="growandshrink"/>			*
*--------------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		GrowAndShrink: function(options) {
			var defaults = {
				growevent 	: 'keydown',
				shrinkevent : 'keyup',
				speed		: 400
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		  = $(this),
					objData		  = obj.data(),
					o 			  = $.extend(true, {}, options, objData),
					initialWidth  = obj.width(),
					initialHeight = obj.height();
				
				obj.on(o.growevent, function() {
					var $this = $(this);
					$this.css({
						'width' : initialWidth + 'px', 
						'height' : initialHeight + 'px'
					});
					
					var srollWidth 	= $this.prop('scrollWidth'),
						srollHeight = $this.prop('scrollHeight'),
						minWidth 	= $this.css('min-width').replace('px', ''),
						minHeight	= $this.css('min-height').replace('px', '');
					$this.css({
						'width' : Math.max(srollWidth, minWidth) + 'px',
						'height' : Math.max(srollHeight, minHeight) + 'px'
					}); 
				});
				
				obj.on(o.shrinkevent, function() {
					var $this = $(this);
					if($this.val() == '') {
						$this.animate({
							width: initialWidth,
							height: initialHeight
						}, o.speed);
					} 
				});
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="growandshrink"]').each(function() {
			$(this).GrowAndShrink();
		});
	});
})(jQuery);


/*------------------------------------------------------------------*
*	ScrollTop Animation												*
*	Activated by JavaScript	: $(object).ScrollTop({options});		*
*	Activated by Markup 	: <div data-init="scrolltop"></div>		*
*------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		ScrollTop: function(options) {
			var defaults = {
				event 	: 'click',
				speed	: 800
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 	= $(this),
					objData	= obj.data(),
					o 		= $.extend(true, {}, options, objData);
				
				function ShowAndHide(object) {
					if ($(this).scrollTop()) {
						object.stop().fadeIn(o.speed);
					} else {
						object.stop().fadeOut(o.speed);
					}
				}
				
				ShowAndHide(obj);
				
				$(window).on('scroll', function() {
					ShowAndHide(obj);
				});
				
				obj.on(o.event, function(e) {
					e.preventDefault();
					$('body, html').animate({ scrollTop: 0 }, o.speed);
					return false;
				});
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="scrolltop"]').each(function() {
			$(this).ScrollTop();
		});
	});
})(jQuery);


/*----------------------------------------------------------------------*
*	SmoothScroll Animation												*
*	Activated by JavaScript	: $(object).SmoothScroll({options});		*
*	Activated by Markup 	: <a href="#" data-init="smoothscroll"></a>	*
*----------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		SmoothScroll: function(options) {
			var defaults = {
				event 	: 'click',
				speed	: 1000
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 	= $(this),
					objData	= obj.data(),
					o 		= $.extend(true, {}, options, objData);
				
				obj.on(o.event, function(e) {
					e.preventDefault();
					$('html, body').animate({
						scrollTop: $( $(this).attr('href') ).offset().top
					}, o.speed);
				});
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="smoothscroll"]').each(function() {
			$(this).SmoothScroll();
		});
	});
})(jQuery);


/*------------------------------------------------------------------*
*	Tabs															*
*	Activated by JavaScript	: $(object).Tabs({options});			*
*	Activated by Markup 	: <div data-init="tabs"></div>			*
*------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		Tabs: function(options) {
			var defaults = {
				event		: 'click',
				active		: undefined,
				collapsible	: false,
				disabled	: [],
				heightStyle	: 'content',		//auto, fill, content
				hideeffect	: 'fadeOut',
				showeffect	: 'fadeIn',
				duration 	: 400
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData);

				obj.tabs({ 
					event 		: o.event,
					active 		: o.active,
					collapsible	: o.collapsible,
					disabled	: o.disabled,
					heightStyle	: o.heightStyle,
					hide 		: {effect: o.hideeffect, duration : o.duration},
					show 		: {effect: o.showeffect, duration : o.duration}
				});
				
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="tabs"]').each(function() {
			$(this).Tabs();
		});
	});
})(jQuery);


/*------------------------------------------------------------------*
*	Toggle															*
*	Activated by JavaScript	: $(object).Toggle({options});			*
*	Activated by Markup 	: <div data-toggle="#target"></div>		*
*------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		Toggle: function(options) {
			var defaults = {
				event		: 'click',
				speed		: 500,
				menutoggler	: false,
				menutitle	: undefined
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData);

				obj.on(o.event, function() {
					$(obj.data('toggle')).slideToggle(o.speed);
				});
				
				if (o.menutoggler == true) {
					$(window).resize(function() {  
						var w = $(window).width();  
						if(w > 320 && $(obj.data('toggle')).css('display') == "none") {  
							$(obj.data('toggle')).removeAttr('style');  
						}  
					});
					
					if (o.menutitle != undefined) {
						obj.parent().append('<h3>' + obj.data('menutitle') + '</h3>');
					}
				}
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-toggle]').each(function() {
			$(this).Toggle();
		});
	});
})(jQuery);


/*------------------------------------------------------------------*
*	ToolTip															*
*	Activated by JavaScript	: $(object).ToolTip({options});			*
*	Activated by Markup 	: <div data-init="tooltip"></div>		*
*------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		ToolTip: function(options) {
			var defaults = {
				event	: 'mouseover',
				duration: 600
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData);
					
				obj.tooltip({
					track	: true,
					show	: {effect : "fadeIn", duration : o.duration},
					hide	: {effect : "fadeOut", duration : 1},
					position: {
						my: "left+15 top+10",
						at: "left+15 bottom+10"
					}
				});
			});
		}	
	});
	
	$(document).ready(function() {
		$('[title]:not(.fancyFoto)').each(function() {
			$(this).ToolTip();
		});
	});
})(jQuery);


/*------------------------------------------------------------------*
*	Accordion														*
*	Activated by JavaScript	: $(object).Accordion({options});		*
*	Activated by Markup 	: <div data-init="accordion"></div>		*
*------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		Accordion: function(options) {
			var defaults = {
				event 		: 'click',
				header		: '> div > header',
				active		: false,
				collapsible	: true,
				icons		: false,
				heightStyle	: 'content'
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData),
					customIcons = undefined;
					
				if (o.icons == true) {
					customIcons = {
						header		: "fa fa-plus",
						activeHeader: "fa fa-minus"
					};
				};

				obj.accordion({
					event		: o.event,
					icons		: customIcons,
					header		: o.header,
					active		: o.active,
					collapsible	: o.collapsible,
					heightStyle	: o.heightStyle	
				});
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="accordion"]').each(function() {
			$(this).Accordion();
		});
	});
})(jQuery);


/*----------------------------------------------------------------------*
*	CountDownRedirect													*
*	Activated by JavaScript	: $(object).CountDownRedirect({options});	*
*	Activated by Markup 	: <div data-init="countdownredirect"></div>	*
*----------------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		CountDownRedirect: function(options) {
			var defaults = {
				event		: 'load',
				duration	: 1000,
				countfrom	: 5,
				page		: 'index.html'
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData),
					target		= obj.find('.countdown');
					
					
				var countdown = setInterval(function() {
					target.html(o.countfrom);
					
					if (o.countfrom === 0) {
						clearInterval(countdown);
						window.location.href = o.page;
					}
					
					o.countfrom--;
				}, 1000);
				
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="countdownredirect"]').each(function() {
			$(this).CountDownRedirect();
		});
	});
})(jQuery);


/*--------------------------------------------------------------*
*	AlertBox													*
*	Activated by JavaScript	: $(object).AlertBox({options});	*
*	Activated by Markup 	: <div data-init="alertbox"></div>	*
*--------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		AlertBox: function(options) {
			var defaults = {
				event		: 'click',
				speed		: 500,
				timeout		: undefined
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData),
					effect 		= obj.data('effect'),
					closeBtn	= obj.find('.close');
				
				//Close alertbox on click
				closeBtn.on(o.event, function() {
					SetEffect(obj, effect, o.speed);
				});
				
				//Auto close alertbox after 'timeout' miliseconds
				if (o.timeout != undefined) {
					var closeInterval = setInterval(function() {	
						SetEffect(obj, effect, o.speed);
						clearInterval(closeInterval);
					}, o.timeout);
				}
			});
		}	
	});
	
	$(document).ready(function() {
		$('[data-init="alertbox"]').each(function() {
			$(this).AlertBox();
		});
	});
})(jQuery);


/*--------------------------------------------------------------*
*	CustomForm													*
*	Activated by JavaScript	: $(object).CustomForm({options});	*
*	Activated by Markup 	: <div data-init="customform"></div>*
*--------------------------------------------------------------*/
(function($) {
	$.fn.extend({
		CustomForm: function(options) {
			var defaults = {
				event		: 'change'
			};
			var options = $.extend(defaults, options);
			
			return this.each(function() {
				var	obj 		= $(this),
					objData		= obj.data(),
					o 			= $.extend(true, {}, options, objData),
					inputFile	= obj.find('input[type="file"]');
				
				//Input File 
				inputFile.each(function() {
					var $this 		= $(this),
						placeholder = $this.data('placeholder');
					
					$this.wrap('<div class="input fileBrowse"/>');
					
					var wrapper 	= $this.parent();
				
					wrapper.append('<span>' + placeholder + '</span>');
					
					var label 		= wrapper.find('span');

					$this.on('change', function() {
						var val 	= $(this).val();
						
						if (val != "") {
							label.text( val.split('\\').pop() );
						} else {
							label.text(placeholder);
						}
					});
				});
			});
		}	
	});
	
	$(document).ready(function() {
		$('form').each(function() {
			$(this).CustomForm();
		});
	});
})(jQuery);


/*----------------------------------------------------------*
*	Set custome effect for transitions						*
*	Call in JavaScript	: SetEffect(object, effect, speed);	*
*----------------------------------------------------------*/
function SetEffect(object, effect, speed) {
	//Check if effect provided it's a valid function
	if ($.isFunction(object[effect])) {
		//Apply the effect to object
		object[effect](speed);
	} else { 
		//Apply default effect to object
		object.slideUp(speed);
	}
}


/*----------------------------------------------*
*	Plugins auto loaded when DOM is ready		*
*----------------------------------------------*/
(function() {
	
	//Main Navgation
	$('.mainNav').children('li').hover(function() {
		$('ul', this).stop().slideDown(300);

		$(this).has('ul').children('a').click(function(e) {
			if ($(this).attr('href') == "#") {
				e.preventDefault();
			}
		});
	}, function() {		
		$('ul', this).stop().slideUp(300); 		
	});

	//FancyBox
	$(".fancyFoto").fancybox(); 
	
	
	$('.module').on('click', '.openBuyForm', function(e) {
		e.preventDefault();
		
		var $this 			= $(this),
			buyForm			= $('#buyForm'),
			dogDetails		= buyForm.find('.dogDetails'),
			articleClone	= $this.closest('article').removeClass('scaleEffectImg').clone();
		
		articleClone.find('.buttons').remove();
		dogDetails.empty();
		dogDetails.append(articleClone);
		
		$.fancybox({
            content 	: buyForm.html(),
			afterShow 	: function() {
				
				//set required attribute on input to true
				buyForm.find('input').attr('data-parsley-required', 'true');

				//reinitialize parsley
				$('form').parsley();
			}
        });
	});
	
})();