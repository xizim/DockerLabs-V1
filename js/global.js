(function($) {
"use strict";

$(document).ready(function()
{
	// Close sidenav menu on body click
	$("body").on("click", function(e)
	{
		// Check if click was triggered on or within #sidenav menu
		if ($(e.target).closest("#sidenav").length > 0)
		{
			// return false;
		}
		else
		{
			if ($("#sidenav").css("right") == "0px")
			{
				closeNav();
			}
		}
	});

	// Homepage slider
	var $item 		= $(".carousel .item");
	var $wHeight 	= $(window).height();

	$item.eq(0).addClass("active");
	$item.height($wHeight);
	$item.addClass("full-screen-carousel");

	$(".carousel img").each(function()
	{
		var $src = $(this).attr("src");

		$(this).parent().css({
			"background-image" : "url(" + $src + ")"
		});

		$(this).remove();
	});

	$(window).on("resize", function()
	{
		$wHeight = $(window).height();
		$item.height($wHeight);
	});

	$(".carousel").carousel({
		interval: 6000,
		pause: "false"
	});
	// Homepage slider

	// This button will increment the value
	$("input[name='qty_plus']").on("click", function(e)
	{
		e.preventDefault();

		// Get the field name
		var fieldName = $(this).parent().parent().find("input[name='"+$(this).attr("data-field")+"']");

		// Get its current value
		var currentVal = parseInt($(fieldName).val());

		// If is not undefined
		if (!isNaN(currentVal))
		{
			// Increment
			$(fieldName).val(currentVal + 1);
		}
		else
		{
			// Otherwise put a 1 there
			$(fieldName).val(1);
		}
	});

	// This button will decrement the value till 1
	$("input[name='qty_minus']").on("click", function(e)
	{
		e.preventDefault();

		// Get the field name
		var fieldName = $(this).parent().parent().find("input[name='"+$(this).attr("data-field")+"']");

		// Get its current value
		var currentVal = parseInt($(fieldName).val());

		// If it isn't undefined or its greater than 1
		if (!isNaN(currentVal) && currentVal > 1)
		{
			// Decrement one
			$(fieldName).val(currentVal - 1);
		}
		else
		{
			// Otherwise put a 1 there
			$(fieldName).val(1);
		}
	});

	// Hide billing details row
	$("#billing_details").hide();

	// Toggle show/hide billing details row
	$("#same_for_billing").on("change", function()
	{
		$("#billing_details").toggle();
	});

	// OwlCarousel init for awards
	if ($("#awards").length > 0)
	{
		$("#awards").owlCarousel({
			loop:true,
			margin:10,
			// nav:true,
			autoplay:true,
			autoplayTimeout:2000,
			autoplayHoverPause:true,
			responsive:{
				0:{
					items:2
				},
				600:{
					items:3
				},
				1000:{
					items:5
				}
			}
		});
	}

	// bxSlider init for product images
	if ($(".bxslider").length)
	{
		$(".bxslider").bxSlider({
			mode: "horizontal",
			// auto: true,
			nextText: "<i class='fa fa-angle-right fa-4x m-r-10'></i>",
			prevText: "<i class='fa fa-angle-left fa-4x'></i>"
		});
	}
});

})(jQuery);

// Sidenav menu
function openNav()
{
	$("#sidenav").css("right", "0");
}

function closeNav()
{
	$("#sidenav").css("right", "-250px");
}

// Search overlay
function openSearch()
{
	$("#searchoverlay").css("width", "100%");

	setTimeout(function() {
		$(".search-close-btn").show();
	}, 500);
}

function closeSearch()
{
	$(".search-close-btn").hide();
	$("#searchoverlay").css("width", "0%");
}

// Contact page / Google Map init
function initMap()
{
	var id 			= "map";
	var lat 		= $("#"+id).attr("data-lat");
	var lng 		= $("#"+id).attr("data-lng");
	var myLatlng 	= new google.maps.LatLng(lat, lng);
	var myZoom 		= parseInt($("#"+id).attr("data-zoom"), 10);
	var pin 		= $("#"+id).attr("data-marker");
	var info 		= $("#"+id).attr("data-string");

	var mapOptions = {
		center: myLatlng,
		zoom: myZoom,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	var map = new google.maps.Map(document.getElementById(id), mapOptions);

	var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			icon: pin
		});

	if (info != "")
	{
		var infowindow = new google.maps.InfoWindow({
				content: info
			});
	}

	// Open infowindow on page load
	infowindow.open(map, marker);

	// Open infowindow on click
	if (info != "")
	{
		google.maps.event.addListener(marker, "click", function() {
			infowindow.open(map, marker);
		});
	}
}