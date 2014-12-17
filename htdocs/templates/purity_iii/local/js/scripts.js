;(function($){

 	$(document).ready(function() {
 		$("#splash_home").addClass("loaded");
	});

})(jQuery);

var eyecentersofohio = eyecentersofohio || {};

eyecentersofohio.isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i) ? true : false;
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i) ? true : false;
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i) ? true : false;
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
    }
};

eyecentersofohio.maps = eyecentersofohio.maps || {};

eyecentersofohio.maps.openMap = function(strAddress) {
	if(navigator && navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showMap, handleMapsError);
	} else {
		showMap();
	}

	function handleMapsError(error) {
		if (error.code == 1) {
			//user said no!
		} else if (error.code == 2) {
			//position unavailable
		} else if (error.code == 3) {
			//timed out
		}
		showMap();
	}

	function showMap(location) {
		var latitude, longitude;
		if(location) {
			latitude = location.coords.latitude;
			longitude = location.coords.longitude;
		}
	} 
}

