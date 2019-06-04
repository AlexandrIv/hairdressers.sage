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
		$(".preloader_tab").css({'opacity':'0.4', 'transition':'0.5s', 'background-color':'#fff'});
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
				ajax_get_upload_images();
				ajax_get_workers_days();
				$(".images").val("");
				off_preloader_tab();
			},
		});
	});

	$('#images').on('change', function() {
		on_preloader_tab();
		$('#salon-form').submit();
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
			},
		});
	}



	




	$(document).ready(function(){
		if( $('.personal-provider-section').html() !== undefined){
			ajax_get_upload_images();
			ajax_get_workers_days();
			get_services();
			get_services_staff_list();
			get_staff_table();
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
	function ajax_get_workers_days() {
		var postId = $('.salon-info-tab').data('post-id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"post_id": postId,
				"action": "get_workers_days",
			},
			type: 'POST',
			success: function(dataTime) {
				if( dataTime ) {
					var days_times = JSON.parse(dataTime);
					$.each(days_times, function( index, value ) {
						$('[data-day="'+index+'_start"]').val(value.start);
						$('[data-day="'+index+'_end"]').val(value.end);
					});
				}
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




































	$('.add-new-service').on('click', function(e){
		e.preventDefault();
		on_preloader_tab();
		var category = $('.category-input').data('category-id');
		var name = $('.name-input').val();
		var duration = $('.duration-input').data('duration');
		var price = $('.price-input').val();
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "service_form",
				"category": category,
				"name": name,
				"duration": duration,
				"price": price,
			},
			type: 'POST',
			success: function(serviceData) {
				$('.category-input').val('');
				$('.name-input').val('');
				$('.duration-input').val('');
				$('.price-input').val('');
				get_services();
				get_services_staff_list();
				off_preloader_tab();
			},
		});
	});



	function get_services() {
		on_preloader_tab();
		var author_id = $('.service-tab').data('author-id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_services",
				"author_id": author_id,
			},
			type: 'POST',
			success: function(services_table) {
				$('.services-data').html(services_table);
				off_preloader_tab();
			},
		});
	}

	jQuery(document).on('click', '.remove-service', function() {
		on_preloader_tab();
		var remove_id = $(this).closest('tr').data('id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "remove_service",
				"remove_id": remove_id,
			},
			type: 'POST',
			success: function(removeServ) {
				get_services();
				get_services_staff_list();
				off_preloader_tab();
			},
		});
	});




















	function get_services_staff_list() {
		on_preloader_tab();
		var author_id = $('.service-tab').data('author-id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_services_staff_list",
				"author_id": author_id,
			},
			type: 'POST',
			success: function(services_staff_list) {
				$('.custom-from-list').html(services_staff_list);
				off_preloader_tab();
			},
		});
	}

	$('.add-new-staff').on('click', function(e){
		e.preventDefault();
		on_preloader_tab();
		var staff_name = $('.staff-name-input').val();
		var services_id = [];
		$('.services-from-staff:checked').each(function() {
			services_id.push($(this).data('service-id'));
		});
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "add_new_staff",
				"name": staff_name,
				"services_id": services_id,
			},
			type: 'POST',
			success: function(staffData) {
				$('.services-from-staff').each(function() {
					$(this).removeAttr('checked');
				});
				$('.staff-name-input').val('');
				get_staff_table();
				off_preloader_tab();
			},
		});
	});
	function get_staff_table() {
		var author_id = $('.service-tab').data('author-id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_staff_table",
				"author_id": author_id,
			},
			type: 'POST',
			success: function(staff_data_table) {
				$('.staff-table-body').html(staff_data_table);
				off_preloader_tab();
			},
		});
	}


	jQuery(document).on('click', '.remove-staff', function() {
		on_preloader_tab();
		var remove_id = $(this).closest('tr').data('id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "remove_staff",
				"remove_id": remove_id,
			},
			type: 'POST',
			success: function(removeStaff) {
				get_staff_table();
				off_preloader_tab();
			},
		});
	});




















































	jQuery(document).on('click', '.select-service', function(e) {
		e.preventDefault();
		var service_id = $(this).data('service-id');
		var salon_id = $(this).data('salon-id');
		var author_id = $(this).data('author-id');

		localStorage.setItem('service_id', service_id);
		localStorage.setItem('salon_id', salon_id);
		localStorage.setItem('author_id', author_id);




/*		document.cookie = "service_id="+service_id+"";
		document.cookie = "salon_id="+salon_id+"";
		document.cookie = "author_id="+author_id+"";*/
		window.location = '/first-booking?sce='+service_id+'&stf='+salon_id+'&aut='+author_id;


		/*var xhr = new XMLHttpRequest();
		var params = 'service_name=' + encodeURIComponent(service_name) +
		'&service_id=' + encodeURIComponent(service_id) + 
		'&salon_id=' + encodeURIComponent(salon_id) +
		'&author_id=' + encodeURIComponent(author_id);

		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			window.location = '/first-booking';
		}
		xhr.send(params);*/

		

		/*console.log(service_id);
		console.log(service_name);
		console.log(salon_id);
		console.log(author_id);*/
	});




	if ($("#first-booking-step").length) {
		var service_name = localStorage.getItem('service_name');
		var service_id = localStorage.getItem('service_id');
		var salon_id = localStorage.getItem('salon_id');
		var author_id = localStorage.getItem('author_id');
		get_option_service( service_name, service_id, salon_id, author_id );
		get_option_staff( service_name, service_id, salon_id, author_id );
	}
	function get_option_service() {
		console.log("Services ajax");
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_option_service",
			},
			type: 'POST',
			success: function(option_service) {
				$('.service-select').append(option_service);
			},
		});
	}
	function get_option_staff() {
		console.log("Staff ajax");
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_option_staff",
			},
			type: 'POST',
			success: function(option_staff) {
				$('.staff-select').append(option_staff);
			},
		});
	}




	$('.search-time-button').on('click', function() {

	});


















});