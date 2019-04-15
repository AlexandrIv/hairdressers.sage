jQuery(document).ready(function($){

	$('#search-form').on('submit', function(e){
		e.preventDefault();
		setTimeout(body_bg_on, 300);
		var form_data = $('#search-form').serializeArray();
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_order_services_db",
				"form_data": form_data,
			},
			dataType: "html",
			type: 'POST',
			success: function(jsonData) {
				if( jsonData ) {
					setTimeout(body_bg_off, 1300);
					setTimeout(show_result, 1400);
					function show_result() {
						$('.search-result').html(jsonData);
						initMap();
					}
				}
			},
		});
	});
	$(".body_bg").dblclick(function() {
		body_bg_off();
	});
	$('<div class="body_bg"><img src="/wp-content/themes/hairdres/dist/images/preloader.gif" alt="" /></div>').prependTo('body');
	function body_bg_on() {
		$('.body_bg').css({'overflow':'visible', 'opacity':'0.5', 'transition':'0.4s', 'background-color':'#000', 'z-index':'100'});
		scroll_result_search();
	}
	function body_bg_off() {
		$('.body_bg').css({'overflow':'hidden', 'opacity':'0', 'transition':'0.4s', 'z-index':'0'});
	}
	function scroll_result_search(){
		var top = $('.search-result').offset().top;
		$('body,html').animate({scrollTop: top}, 1000);
	}
	function initMap() {
	var positionArray = JSON.parse(window.coordinateArray);
      $.each(positionArray, function( index, value ) {
      	console.log(value.lat);
      	console.log(value.lng);
      /*var marker = new google.maps.Marker({
	      	position: {
	      		lat: value,
	      		lng: value
	      	},
	      	map: map
      	});*/
      });
      var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 12, center: {lat: }});
    }
});