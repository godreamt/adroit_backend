$(document).ready(function(){
	$('.review_inner').owlCarousel({
		loop:true,
		nav:false,
		dots:true,
		items:1
	});
	$('.newproduct_wrapper').owlCarousel({
		loop:true,
		nav:true,
		dots:false,
		lazyLoad: true,
		margin:30,
		navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		responsive:{
			0:{
				items:1
			},
			768:{
				items:1
			},
			1000:{
				items:2
			}
		}
	});
	$('.our_team_slider').owlCarousel({
		loop:true,
		nav:true,
		dots:false,
		lazyLoad: true,
		margin:30,
		navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		responsive:{
			0:{
				items:1
			},
			400:{
				items:2
			},
			768:{
				items:3
			},
			990:{
				items:4
			},
			1200:{
				items:5
			}
		}
	});
	$('.related_project_slider').owlCarousel({
		loop:true,
		nav:true,
		dots:false,
		lazyLoad: true,
		margin:20,
		navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		responsive:{
			0:{
				items:1
			},
			400:{
				items:2
			},
			768:{
				items:3
			},
			990:{
				items:4
			}
		}
	});
	$('.hero_slider').owlCarousel({
		loop:true,
		autoplay: true,
		animateOut: 'fadeOut',
		nav:false,
		dots:false,
		items:1
	});
	
	$('.mobile_menu_outer').click(function(){
		// $(this).removeClass('active');
		toggleMenu();
	});

	$('.label_trans input').focus(function(){
		$(this).parents('.label_trans').addClass('focused');
	  });

	  $('.label_trans input').blur(function(){
		var inputValue = $(this).val();
		if ( inputValue == "" ) {
		  $(this).parents('.form-group').removeClass('focused');  
		} 
	  });
	  
 	/*----------------------------------------------------*/
    /*  Menu scroll js
	/*----------------------------------------------------*/
	
	$(document).scroll(function () {
		fixedNavbarHandle();
	  });
	  fixedNavbarHandle();
  
	function fixedNavbarHandle() {
	  var $nav = $(".header_wrapper");
	  $nav.toggleClass('header_fixed', $(this).scrollTop() > $nav.height());
	}

	$('.scroll_down_btn').bind('click', function (event) { //just pass move-me in design and start scrolling
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top -60
        }, 1000);
        event.preventDefault();
	});
	

	$('#contactForm').validate({

        rules: {
            name: {
                required: true,                                          
            },

            mobile:{
              required:true,
              number: true
            },

            email: {  
                required:true,              
                 email: true,                                        
            }

        },
        messages: {

            name: "Please enter your name",    
            mobile:{
              required: "Please enter your telephone number",            
              number: "Please enter a valid telephone number"
            },
            email: {
             required: "Please enter your email address",
             email: "Enter a valid email address",    
            }
        },           
  });

  $('#EnquireForm').validate({

	rules: {
		cetegory: {
			required: true,                                          
		},
		product: {
			required: true,                                          
		},
		name: {
			required: true,                                          
		},
		mobile:{
		  required:true,
		  number: true
		},
		email: {  
			required:true,              
			 email: true,                                        
		},
		info:{
			required: true,
		}

	},
	messages: {
		cetegory : "Please select Cetegory",
		product : "Please select Product",
		name: "Please enter your name",    
		mobile:{
		  required: "Please enter your telephone number",            
		  number: "Please enter a valid telephone number"
		},
		email: {
		 required: "Please enter your email address",
		 email: "Enter a valid email address",    
		},
		info : "Please enter information about you"
	},           
});

});

function toggleMenu(){
	$('.mobile_menu_outer').toggleClass('active');
	$('.menu_burger_btn').toggleClass('active');
	$('.menu_wrapper').toggleClass('open');
}

function toggleFilter(){
	$('.filter_wrapper').toggleClass('open');
}
