jQuery(document).ready(function($){
	$('#search-form').on('submit', function(e){
		e.preventDefault();
		$('.search-result').fadeOut();
		setTimeout(body_bg_on, 300);
		var form_data = $('#search-form').serializeArray();
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_search_results",
				"form_data": form_data,
			},
			dataType: "html",
			type: 'POST',
			success: function(postData) {
				if( postData ) {
					setTimeout(function(){
						$('.search-result').html(postData).fadeIn(800);
						initMapHome();
						body_bg_off();
					}, 1500);
				}
			},
		});
	});
	$(".body_bg").dblclick(function() {
		body_bg_off();
	});
	$('<div class="body_bg"><img src="/wp-content/themes/hairdres/dist/images/preloader.gif" alt="" /></div>').prependTo('.home');
	function body_bg_on() {
		$('.body_bg').css({'overflow':'visible', 'opacity':'0.7', 'transition':'0.4s', 'background-color':'#000', 'z-index':'100'});
		scroll_result_search();
	}
	function body_bg_off() {
		$('.body_bg').css({'overflow':'hidden', 'opacity':'0', 'transition':'0.4s', 'z-index':'0'});
	}
	function scroll_result_search(){
		var top = $('.search-result').offset().top;
		$('.home,html').animate({scrollTop: top}, 1000);
	}


	jQuery(document).on('click', '.true_loadmore', function () {
		$('.fa-spinner', this).addClass('fa-spin');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_search_results_loadmore",
				"query_vars": window.query_vars,
				"paged": window.paged
			},
			dataType: "html",
			type: 'POST',
			success: function(postData) {
				if( postData ) {
					$('.loadmore-block').html(postData).fadeIn(500);
					initMapHome();
					window.paged+1;
					if (window.paged == window.max_pages) $(".true_loadmore").remove();
				} else {
					$('.true_loadmore').remove();
				}
			},
		});
	});























	function initMapHome() {
		var postsArray = JSON.parse(window.postJson);

		if( window.postJsonAjax != undefined && window.postJsonAjax ) {
			var postAjaxArray = JSON.parse(window.postJsonAjax);
			Array.prototype.push.apply(postsArray, postAjaxArray);
		}else {
			var postsArray = postsArray;
		}
		//console.log(postsArray);
		if ( postsArray ) {
			var map = new google.maps.Map(
				document.getElementById('mapHome'), {
					zoom: 12,
					center: {
						lat: parseFloat(postsArray[0].lat),
						lng: parseFloat(postsArray[0].lng),
					},
				});
			$.each(postsArray, function( index, value ) {
				var iconDefault = '/wp-content/themes/hairdres/dist/images/marker-icon.png';
				var marker = new google.maps.Marker({
					position: {
						lat: parseFloat(value.lat),
						lng: parseFloat(value.lng),
					},
					icon: iconDefault,
					map: map,
					title: 'Uluru (Ayers Rock)',
				});
				var contentString = '<div id="content">'+
				'<div id="siteNotice">'+
				'<img src="'+value.post_image+'" alt="" />'+
				'</div>'+
				'<h3 id="firstHeading" class="firstHeading"><a href="'+value.post_permalink+'">'+value.post_title+'</a></h3>'+
				'<div id="bodyContent">'+
				'<p></p>'+
				'</div>'+
				'</div>';

				var infowindow = new google.maps.InfoWindow({
					content: contentString,
				});
				marker.addListener('click', function() {
					infowindow.open(map, marker);
				});
			})
		}

	}





















	$('#register-partner-form').on('submit', function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			url: ajax['ajax_url'],
			data: formData,
			dataType: "html",
			type: 'POST',
			success: function(jsonDataForm) {
				var result = $.parseJSON(jsonDataForm);
				if( result.succes ){
					console.log(result.user_pass);
					$('.pricing-plans').hide();
					$('.succes-register').show();
					$('.succes-register').before('<p>'+result.succes+'</p>');
				}
			},
		});

	});
	$('#login-form').on('submit', function(e) {
		e.preventDefault();
		var formData = $('#login-form').serialize();
		$.ajax({
			url: ajax['ajax_url'],
			data: formData,
			dataType: "html",
			type: 'POST',
			success: function(jsonDataLoginForm) {
				var result = $.parseJSON(jsonDataLoginForm);
				window.location.assign(result.redirect_url);
			},
		});
	});


	function on_preloader_tab() {
		$("body").css("cursor", "wait");
		$('.tab-content').prepend('<div class="preloader_tab"></div>');
		$(".preloader_tab").css({'opacity':'0.3', 'transition':'0.5s', 'background-color':'#fff'});
	}

	function off_preloader_tab() {
		$("body").css("cursor", "default");
		$(".preloader_tab").css({'opacity':'0', 'transition':'0.5s'});
		$(".tab-content .preloader_tab").remove();
	}

	$('#salon-form').on('submit', function(e) {
		e.preventDefault();
		on_preloader_tab();
		ajax_set_workers_days();
		$.ajax({
			url: ajax['ajax_url'],
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			type: 'POST',
			success: function(jsonDataForm) {
				var result = $.parseJSON(jsonDataForm);
				//console.log(result);
				ajax_get_upload_images();
				$(".images").val("");
				off_preloader_tab();
			},
		});
	});


	function ajax_set_workers_days(){
		var postId = $('.salon-info-tab').data('post-id');
		var daysArray = {};
		$( ".day label input" ).each(function( id ){
			dayname = $(this).data('day')
			daysArray[dayname] = $(this).val();
		});
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "workers_days",
				"days_array": daysArray,
				"post_id": postId,
			},
			type: 'POST',
			success: function(data) {
				console.log(data);
			},
		});
	}



	$(document).ready(function(){
		if( $('.personal-provider-section').html() !== undefined){
			ajax_get_upload_images();
		}
	});

	function ajax_get_upload_images() {
		var postId = $('.salon-info-tab').data('post-id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_upload_images",
				"post_id": postId,
			},
			type: 'POST',
			success: function(imageData) {
				$('.upload-images').html(imageData);
			},
		});
	}

	jQuery(document).on('click', '.upload-images .img-box .del-img', function () {
		var deleteImgId = $(this).data('delete-img-id');
		ajax_remove_gallery_image( deleteImgId );
	});

	function ajax_remove_gallery_image( deleteImgId ) {
		on_preloader_tab();
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "delete_gallery_image",
				"image_id": deleteImgId,
			},
			type: 'POST',
			success: function(imageData) {
				ajax_get_upload_images();
				off_preloader_tab();
			},
		});
	}





});