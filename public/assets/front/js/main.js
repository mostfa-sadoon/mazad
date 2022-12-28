
$(document).ready(function() {
	
window.onscroll = function() {myFunction()};

var header = document.getElementById("header");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
	
		var menu = document.getElementById("main_menu");
		var btnico = document.getElementById("nav-trigger");
	$('#nav-trigger').on('click', function() {
		
		menu.classList.toggle("active");
		btnico.classList.toggle("cansel");
		
	});
    $("#close-menu ").on('click', function() {
		
		menu.classList.toggle("active");
		btnico.classList.toggle("cansel");

    });
    $(".ico_serch ").on('click', function() {
		$("#search-pop").toggleClass('active');

    });
    $("#close-search ").on('click', function() {
		$("#search-pop").toggleClass('active');

    });
	
	
   /* ==============================================
  	Dropdown Select
  	=============================================== */ 

	$('.dropdown-select').on( 'click', '.dropdown-menu li a', function() { 
	   var target = $(this).html();

	   //Adds active class to selected item
	   $(this).parents('.dropdown-menu').find('li').removeClass('active');
	   $(this).parent('li').addClass('active');

	   //Displays selected text on dropdown-toggle button
	   $(this).parents('.dropdown-select').find('.dropdown-toggle').html(target + ' <i class="fa fa-chevron-down"></i>');
	});
	
	$('.dropdown-select').on( 'click', '.dropdown-menu li label', function() { 
	   var target = $(this).html();

	   //Adds active class to selected item
	   $(this).parents('.dropdown-menu').find('li').removeClass('active');
	   $(this).parent('li').addClass('active');

	   //Displays selected text on dropdown-toggle button
	   $(this).parents('.dropdown-select').find('.dropdown-toggle').html(target + ' <i class="fa fa-chevron-down"></i>');
	});

    $('.gallery .small-images img').on('click', function() {
        $('.gallery .small-images .swiper-slide').addClass('selected').siblings().removeClass("selected")

        $('.gallery .master-img img').hide().attr('src', $(this).attr('src')).fadeIn(500);
        $('.gallery .master-img a').hide().attr('href', $(this).attr('src'));

        console.log($(this).attr('src'))
    });

    $('.small-images .fa-caret-right').on("click", function() {


        if ($('.gallery .small-images img.selected').is(':last-child')) {

            $('.gallery .small-images img ').eq(0).click()
        } else {
            $('.gallery .small-images img.selected').next().click();
        }
    });

    $('.small-images .fa-caret-left').on("click", function() {


        if ($('.gallery .small-images img.selected').is(':first-child')) {

            $('.gallery .small-images img:last-child ').click()
        } else {
            $('.gallery .small-images img.selected').prev().click();
        }
    });

	/*====================================
    OTP Validation Code
    ======================================*/	
$('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
});
	
	
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#mainImage').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgMain").change(function(){
        readURL(this);
    });	
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imgOther-1').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgOther1").change(function(){
        readURL1(this);
    });	
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imgOther-2').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgOther2").change(function(){
        readURL2(this);
    });	
    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imgOther-3').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgOther3").change(function(){
        readURL3(this);
    });	
    function readURL4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imgOther-4').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgOther4").change(function(){
        readURL4(this);
    });	
    function readURL5(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imgOther-5').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgOther5").change(function(){
        readURL5(this);
    });	
    function readURL6(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imgOther-6').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgOther6").change(function(){
        readURL6(this);
    });	
    function readURL7(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#mainvideo').attr('src', e.target.result).addClass('active');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#videoMain").change(function(){
        readURL7(this);
    });	
	
	
	
var sliderSelector = '.swiper-auctions',
    options = {
      init: false,
      speed:800,
      slidesPerView: 4, // or 'auto'
      slidesPerGroup:4,
      spaceBetween: 15,
      grabCursor: true,
      autoplay: {
        delay:5000
      },
      breakpoints: {
        1023: {
          slidesPerView: 2,
          spaceBetween: 5
        }
      },
      // Events
      on: {
        init: function(){
          this.autoplay.stop();
        },
        imagesReady: function(){
          this.autoplay.start();
          this.el.classList.remove('loading');
        }
      }
    };
var mySwiper = new Swiper(sliderSelector, options);

// Initialize slider
mySwiper.init();			
	
	
var sliderSelector = '.swiper-small-images',
    options = {
      init: false,
      speed:800,
      slidesPerView: 4, // or 'auto'
      slidesPerGroup:1,
      spaceBetween: 15,
      grabCursor: true,
      autoplay: {
        delay:5000
      },
	  navigation: {
		nextEl: ".fa-caret-left",
		prevEl: ".fa-caret-right",
	  },      breakpoints: {
        1023: {
          slidesPerView: 2,
          spaceBetween: 5
        }
      },
      // Events
      on: {
        init: function(){
          this.autoplay.stop();
        },
        imagesReady: function(){
          this.autoplay.start();
          this.el.classList.remove('loading');
        }
      }
    };
var mySwiper = new Swiper(sliderSelector, options);

// Initialize slider
mySwiper.init();			


	
	
	
$('input.CurrencyInput').on('blur', function() {
  const value = this.value.replace(/,/g, '');
  this.value = parseFloat(value).toLocaleString('en-US', {
    style: 'decimal',
    maximumFractionDigits: 2,
    minimumFractionDigits: 2
  });
});

	

function deleteAuction() {
  $('#content').parent().before('<div class="completeDelete">تم حذف المنتج بنجاح</div>');
				setTimeout(function() { $(".completeDelete").fadeOut(1500); $('#cart #cart-total').html('1'); }, 100)
}

});

