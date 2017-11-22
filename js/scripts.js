$('#aboutContainer').parallax({
	imageSrc: 'img/bg/tools.jpg'
});

// Scrolling
var nav = $("#navId");
var navOverflow = $("#navOverflow");
var page_end_logo_nav = $("#page_end_logo_nav").visible();
var logoContainer = $("#logoContainer");
var nav_ani_speed = 200; // In ms
var nav_state = 0; // 0 is nav, 1 is hamburger visable
var hamburger = $("#hamburgermenu");
var distanceY;
var shrinkOn;

// Set scroll for desktop nav
function nav_desktop_check() {
	distanceY = window.pageYOffset || document.documentElement.scrollTop;
	shrinkOn = 100;

	// Run the header script
	if(distanceY > shrinkOn) {
		if(nav_state === 0) {
			nav_hamburger();
		}
	}
	else {
		if(nav_state === 1) {
			if($(window).width() >= 900) {
				nav_normal_desktop();
			}
		}
	}
}

// Tablet nav check
function tablet_nav_check() {
	if(nav_state === 0) {
		if($(window).width() <= 900) {
			nav_hamburger();
		}
	}
}
tablet_nav_check();


// Hambutton onclick
hamburger.click(function() {
	if(nav_state === 1) {
		if($(window).width() >= 900) {
			nav_normal_desktop();
		}
		else {
			nav_normal_mobile();
		}
		logo_animation();
	}else {
		nav_hamburger()
	}
});

// Nav to hamburger
function nav_hamburger() {
	hamburger.removeClass("active")
		navOverflow.animate({
		width: 0
	}, nav_ani_speed, function(){
		hamburger.addClass("active")
	});
	nav_state = 1;
	logo_animation();
}

// Hamburger to nav
function nav_normal_desktop() {
	hamburger.addClass("active");
	hamburger.removeClass("active");
	navOverflow.css("width", "auto");
	nav_witdh = navOverflow.innerWidth();
	navOverflow.css("width", 0);
	navOverflow.animate({
		width: nav_witdh
	}, nav_ani_speed, function() {
		hamburger.removeClass("active")
	});
	nav_state = 0;

}

function nav_normal_mobile() {
	navOverflow.animate({
		width: "100%"
	}, nav_ani_speed, function() {
		hamburger.removeClass("active")
	});
	nav_state = 0;
}

// Logo aperances
function logo_animation() {
	if(page_end_logo_nav === false) {
		if($(window).width() >= 1500) {
			logoContainer.addClass("active")
		}
		else {
			if(nav_state === 0) {
				logoContainer.removeClass("active")
			}
			else {
				logoContainer.addClass("active")
			}

		}
	}
	else {
		if($(window).width() >= 1500) {
			logoContainer.removeClass("active")
		}
		else {
			if(nav_state === 1) {
				logoContainer.removeClass("active")
			}
		}
	}
}
logo_animation();

// Event listeners
$(window).scroll(function() {
	page_end_logo_nav = $("#page_end_logo_nav").visible();
	// Logo animation
	logo_animation();
	// Check if desktop is activated
	nav_desktop_check()
});

$(window).resize(function() {
	// If smaller then 900px remove nav
	tablet_nav_check()
});
