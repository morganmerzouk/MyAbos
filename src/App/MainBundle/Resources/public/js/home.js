// Javascript Document

/* =================================
   LOADER                     
=================================== */
// makes sure the whole site is loaded
$(window).load(function() {

    "use strict";

    // will first fade out the loading animation
    $(".signal").fadeOut();
        // will fade out the whole DIV that covers the website.
    $(".preloader").fadeOut("slow");

});

/* =================================
LOGIN-FACEBOOK 
=================================== */
function statusChangeCallback(response) {
    if (response.status === 'connected') {
    	console.log(response.authResponse.accessToken);
    	FB.api('/me', function(response) {
    	    console.log(JSON.stringify(response.name));
    	});
      // Logged into your app and Facebook.
    } else if (response.status === 'not_authorized') {
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
}

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
function checkLoginState() {
    FB.getLoginStatus(function(response) {
    	statusChangeCallback(response);
    });
}
/* =================================
   LOGIN-SIGNUP MODAL                     
=================================== */

function showRegisterForm(){
    "use strict";
    $('.passwordForgottenBox').fadeOut('fast');
    $('.loginBox').fadeOut('fast',function(){
        $('.registerBox').fadeIn('fast');
        $('.login-footer').fadeOut('fast',function(){
            $('.register-footer').fadeIn('fast');
        });
        $('.modal-title').html('<span>Créer un compte</span>');
    });
    $('.error').removeClass('alert alert-danger').html('');
}


function showLoginForm(){
    "use strict";
    $('.passwordForgottenBox').fadeOut('fast');
    $('#loginModal .registerBox').fadeOut('fast',function(){
        $('.loginBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast',function(){
            $('.login-footer').fadeIn('fast');
        });
        
        $('.modal-title').html('Se connecter à <span>MyAbos</span>');
    });
    $('.error').removeClass('alert alert-danger').html('');
}

function showPasswordForgottenForm(title){
    "use strict";
    //Display loader
    $(".lm-success, .lm-failed, .lm-success-email").hide();
    $('#loginModal .loginBox').fadeOut('fast',function(){
        $('.passwordForgottenBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast',function(){
            $('.login-footer').fadeIn('fast');
        });
        
        $('.modal-title').html(title);
    });
    $('.error').removeClass('alert alert-danger').html('');
}

function sendResetMailForm(url){
    "use strict";
    //Display loader
	$('.invalid-username, .password-already-requested, .password-resetting-success').hide();
    $.ajax({
		type: "GET",
		url: url,
		data: { username:  $("#username").val()}
    })
    .done(function(msg) {
    	if(msg == "invalid_username") {
    		$('.invalid-username').show();
    	}
    	else if(msg == "password_already_requested") {
    		$('.password-already-requested').show();
    	}
    	else {
    		$('.password-resetting-success').html(msg);
    		$('.password-resetting-success').show();
    	}
    })
    .fail(function() {
      alert( "Erreur" );
    })
    .always(function() {
	    //Loader fade
	});
}

function sendRegisterForm(url){
    "use strict";
    //Display loader
	$('.invalid-username, .password-already-requested, .password-resetting-success').hide();
	var password = [];
	password["first"] = $("#fos_user_registration_form_plainPassword_first").val();
	password["second"] = $("#fos_user_registration_form_plainPassword_second").val();
	
	var dataString = 'fos_user_registration_form[_token]='
        +  $("#fos_user_registration_form__token").val()
        + '&fos_user_registration_form[email]='
        + $("#fos_user_registration_form_email").val()
        + '&fos_user_registration_form[phone]='
        + $("#fos_user_registration_form_phone").val()
        + '&fos_user_registration_form[gender]='
        + $("#fos_user_registration_form_gender").val()
        + '&fos_user_registration_form[firstname]='
        + $("#fos_user_registration_form_firstname").val()
        + '&fos_user_registration_form[lastname]='
        + $("#fos_user_registration_form_lastname").val()
        + '&fos_user_registration_form[plainPassword][first]='
        + $("#fos_user_registration_form_plainPassword_first").val()
        + '&fos_user_registration_form[plainPassword][second]='
        + $("#fos_user_registration_form_plainPassword_second").val();
    $.ajax({
		type: "POST",
		url: url,
		data: dataString
    })
    .done(function(msg) {
    	$('.registerBox').html(msg);
    })
    .fail(function() {
      alert( "Erreur" );
    })
    .always(function() {
	    //Loader fade
	});
}

function openLoginModal(){
    "use strict";
    showLoginForm();
    $('#loginModal').modal('show');
}


function openRegisterModal(){
    "use strict";
    showRegisterForm();
    $('#loginModal').modal('show');
}



/* =================================
   SCROLL NAVBAR
=================================== */
$(window).scroll(function(){
    "use strict";
    var b = $(window).scrollTop();
    if( b > 100 ){
        $(".overlay .navbar").addClass("is-scrolling");
    } else {
        $(".overlay .navbar").removeClass("is-scrolling");
    }
});


/* =================================
   TYPING EFFECT
=================================== */
(function($) {

    "use strict";

    $('[data-typer-targets]').typer();
    $.typer.options.clearOnHighlight=false;

})(jQuery);


/* =================================
   DATA SPY FOR ACTIVE SECTION                 
=================================== */
(function($) {
    
    "use strict";
    
    $('body').attr('data-spy', 'scroll').attr('data-target', '.navbar-fixed-top').attr('data-offset', '11');

})(jQuery);


/* =================================
   HIDE MOBILE MENU AFTER CLICKING 
=================================== */
(function($) {
    
    "use strict";
    
    $('.nav.navbar-nav li a').click(function () {
        var $togglebtn = $(".navbar-toggle");
        if (!($togglebtn.hasClass("collapsed")) && ($togglebtn.is(":visible"))){
            $(".navbar-toggle").trigger("click");
        }
    });

})(jQuery);


/* ==================================================== */
/* ==================================================== */
/* =======================================================
   DOCUMENT READY
======================================================= */
/* ==================================================== */
/* ==================================================== */

$(document).ready(function() {


"use strict";


/* =====================================
    PARALLAX STELLAR WITH MOBILE FIXES                    
======================================== */
if (Modernizr.touch && ($('.header').attr('data-stellar-background-ratio') !== undefined)) {
    $('.header').css('background-attachment', 'scroll');
    $('.header').removeAttr('data-stellar-background-ratio');
} else {
    $(window).stellar({
        horizontalScrolling: false
    });
}

/* =================================
    WOW ANIMATIONS                   
=================================== */
new WOW().init();

/* ==========================================
    EASY TABS
============================================= */
$('.tabs.testimonials').easytabs({
    animationSpeed: 300,
    updateHash: false,
    cycle: 10000
});

$('.tabs.features').easytabs({
    animationSpeed: 300,
    updateHash: false
});


/* ==========================================
   OWL CAROUSEL 
============================================= */
/* App Screenshot Carousel in Mobile-Download Section */
$("#owl-carousel-shots-phone").owlCarousel({
    singleItem:true,navigation: true,
    navigationText: [
        "<i class='icon arrow_carrot-left'></i>",
        "<i class='icon arrow_carrot-right'></i>"
                    ],
    addClassActive : true,
    itemsDesktop : [1200, 1],
    itemsDesktopSmall : [960, 1],
    itemsTablet : [769, 1],
    itemsMobile : [700, 1],
    responsiveBaseWidth : ".shot-container",
    items : 1,
    slideSpeed : 1000,
    mouseDrag : true,
    responsiveRefreshRate : 200,
    autoPlay: 5000
});

/* ==========================================
    VENOBOX - LIGHTBOX FOR GALLERY AND VIDEOS
============================================= */
$('.venobox').venobox();

/* =================================
   SCROLL TO                  
=================================== */
var onMobile;

onMobile = false;
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) { onMobile = true; }

if (onMobile === true) {
    jQuery('a.scrollto').click(function (event) {
    jQuery('html, body').scrollTo(this.hash, this.hash, {gap: {y: -10}, animation:  {easing: 'easeInOutCubic', duration: 0}});
    event.preventDefault();
});
} else {
    jQuery('a.scrollto').click(function (event) {
    jQuery('html, body').scrollTo(this.hash, this.hash, {gap: {y: -10}, animation:  {easing: 'easeInOutCubic', duration: 1500}});
        event.preventDefault();
});
}


/* ==========================================
   MAILCHIMP NEWSLETTER SUBSCRIPTION
============================================= */
$(".mailchimp-subscribe").ajaxChimp({
    callback: mailchimpCallback,
    url: "http://morganmerzouk.us10.list-manage.com/subscribe/post?u=747564b3c5653c7d399cc8295&amp;id=8bc398fa0a" // Replace your mailchimp post url inside double quote "".  
});

function mailchimpCallback(resp) {
if(resp.result === 'success') {
    $('.mc-success')
    .html('<i class="icon icon_check_alt2"></i>' + resp.msg)
    .fadeIn(1000);

    $('.mc-failed').fadeOut(500);
        
} else if(resp.result === 'error') {
    $('.mc-failed')
    .html('<i class="icon icon_close_alt2"></i>' + resp.msg)
    .fadeIn(1000);
            
    $('.mc-success').fadeOut(500);
}
}

/* ==========================================
   FUNCTION FOR EMAIL ADDRESS VALIDATION
============================================= */
function isValidEmail(emailAddress) {

    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

    return pattern.test(emailAddress);

}

/* ==========================================
   LOCAL NEWSLETTER
============================================= */
$("#subscribe").submit(function(e) {
    e.preventDefault();
    var data = {
        email: $("#s-email").val()
    };

    if ( isValidEmail(data['email']) ) {
        $.ajax({
            type: "POST",
            url: urlSignUp,
            data: data,
            success: function() {
                $('.subscription-success').fadeIn(1000);
                $('.subscription-failed').fadeOut(500);
            }
        });
    } else {
        $('.subscription-failed').fadeIn(1000);
        $('.subscription-success').fadeOut(500);
    }

    return false;
});

/* ============================
   LOGIN-MODAL VALIDATION. 
=============================== */
$("#login-modal").submit(function(e) {
    e.preventDefault();
    var data = {
        _password: $("#lm-password").val(),
        _username: $("#lm-email").val(),
        _remember_me: false,
        _csrf_token: $("#csrf_token").val(),
        _target_path: $("#_target_path").val()
    };

    if (!isValidEmail(data['_username'])) {
    	$('.lm-failed-email').fadeIn(1000);
        $('.lm-failed').fadeOut(500);
    }
    else if ( data['_password'].length > 1 ) {
        $.ajax({
            type: "POST",
            url: urlLogin,
            data: data,
            success: function(msg) {
            	if(msg) {
            		if(msg.indexOf("success") > -1) {
                		$('.lm-success').fadeIn(1000);
                    	$('.lm-failed-email').fadeOut(500);
                    	window.location.href= urlDashboard;
            		} else if(msg.indexOf("Mot de passe") > -1) {
                    	$('.lm-failed').fadeIn(1000);
                		$('.lm-success').fadeOut(500);
                    	$('.lm-failed-email').fadeOut(500);
            		} else {
                    	$('.lm-failed').fadeIn(1000);
                		$('.lm-success').fadeOut(500);
                    	$('.lm-failed-email').fadeOut(500);
            		}
            	}
                $('.lm-failed-email').fadeOut(500);
            }
        });
    } else {
        $('.lm-failed').fadeIn(1000);
        $('.lm-success').fadeOut(500);
    }

    return false;
});


/* ===========================================
   SIGNUP-MODAL VALIDATION. WITH CONFIRM PSW. 
============================================== */
$("#signup-modal").submit(function(e) {
    e.preventDefault();
    var data = {
        password: $("#sm-password").val(),
        email: $("#sm-email").val(),
        pswconfirm: $("#sm-confirm").val()
    };

    if ( isValidEmail(data['email']) && (data['password'].length > 1) && (data['password'].match(data['pswconfirm'])) ) {
        $.ajax({
            type: "POST",
            url: urlSignUp,
            data: data,
            success: function() {
                $('.sm-success').fadeIn(1000);
                $('.sm-failed').fadeOut(500);
            }
        });
    } else {
        $('.sm-failed').fadeIn(1000);
        $('.sm-success').fadeOut(500);
    }

    return false;
});

/* ================================================
   SIGNUP-DIVIDER VALIDATION. WITHOUT CONFIRM PSW. 
=================================================== */
$("#signup-divider").submit(function(e) {
    e.preventDefault();
    var data = {
        email: $("#signup-email").val(),
        password: $("#signup-password").val()
    };

    if ( isValidEmail(data['email']) && (data['password'].length > 1)) {
        $.ajax({
            type: "POST",
            url: "assets/php/subscribe.php",
            data: data,
            success: function() {
                $('.signup-success').fadeIn(1000);
                $('.signup-failed').fadeOut(0);
            }
        });
    } else {
        $('.signup-failed').fadeIn(1000);
        $('.signup-success').fadeOut(500);
    }

    return false;
});

/* ===================================================
   FAST-REGISTRATION VALIDATION. WITHOUT CONFIRM PSW. 
====================================================== */
$("#fast-reg").submit(function(e) {
    e.preventDefault();
    var data = {
        email: $("#fast-email").val(),
        password: $("#fast-password").val()
    };

    if ( isValidEmail(data['email']) && (data['password'].length > 1)) {
        $.ajax({
            type: "POST",
            url: "assets/php/subscribe.php",
            data: data,
            success: function() {
                $('.fast-success').fadeIn(1000);
                $('.fast-failed').fadeOut(500);
            }
        });
    } else {
        $('.fast-failed').fadeIn(1000);
        $('.fast-success').fadeOut(500);
    }

    return false;
});

/* =======================================================================
   DOUGHNUT CHART
========================================================================== */
var isdonut = 0;
        
$('.start-charts').waypoint(function(direction){
    if (isdonut == 1){}
        else {
            var doughnutData = [
                {
                    value: 50,
                    color:"#C0392B",
                    highlight: "#EA402F",
                    label: "Beautiful Design"
                },
                {
                    value: 25,
                    color: "#323A45",
                    highlight: "#4C5B70",
                    label: "Responsive Layout"
                },
                {
                    value: 15,
                    color: "#949FB1",
                    highlight: "#A8B3C5",
                    label: "Persuasive Call to Action"
                },
                {
                    value: 5,
                    color: "#27AE60",
                    highlight: "#29C36A",
                    label: "Social Proof"
                }

            ];

            var doughnut2Data = [
                {
                    value: 827,
                    color:"#C0392B",
                    highlight: "#EA402F",
                    label: "Cups of Coffee"
                },
                {
                    value: 1775,
                    color: "#323A45",
                    highlight: "#4C5B70",
                    label: "Code Hours"
                },
                {
                    value: 580,
                    color: "#2980B9",
                    highlight: "#2F97DC",
                    label: "Design Hours"
                },
                {
                    value: 540,
                    color: "#949FB1",
                    highlight: "#A8B3C5",
                    label: "Songs Listened"
                }
            ];

            
            
            var ctx = document.getElementById("chart-area").getContext("2d");
            window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : false});

            var ctx = document.getElementById("chart2-area").getContext("2d");
            window.myDoughnut = new Chart(ctx).Doughnut(doughnut2Data, {responsive : false});

            isdonut = 1;
        }
});

/* =======================================================================
   LINE CHART
========================================================================== */
var isline = 0;
        
$('.start-line').waypoint(function(direction){
    if (isline == 1){}
        else {

            var lineChartData = {
                labels : ["January","February","March","April","May","June","July"],
                datasets : [
                    {
                        label: "My First dataset",
                        fillColor : "rgba(192,57,43,0.2)",
                        strokeColor : "rgba(192,57,43,1)",
                        pointColor : "rgba(192,57,43,1)",
                        pointStrokeColor : "#fff",
                        pointHighlightFill : "#fff",
                        pointHighlightStroke : "rgba(192,57,43,1)",
                        data : [10,20,20,15,25,37,32]
                    },
                    {
                        label: "My Second dataset",
                        fillColor : "rgba(50,58,69,0.2)",
                        strokeColor : "rgba(50,58,69,1)",
                        pointColor : "rgba(50,58,69,1)",
                        pointStrokeColor : "#fff",
                        pointHighlightFill : "#fff",
                        pointHighlightStroke : "rgba(50,58,69,1)",
                        data : [20,23,33,57,74,81,96]
                    }
                ]

            };

            var ctx = document.getElementById("line-canvas").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, {responsive: true});

            isline = 1;
        }
});

/* ===========================================================
   BOOTSTRAP FIX FOR IE10 in Windows 8 and Windows Phone 8  
============================================================== */
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style');
    msViewportStyle.appendChild(
        document.createTextNode(
            '@-ms-viewport{width:auto!important}'
            )
        );
    document.querySelector('head').appendChild(msViewportStyle);
}


});




