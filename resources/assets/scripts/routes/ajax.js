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
				/*console.log(jsonDataForm);
				console.log(result);*/
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
			success: function(SalonInfoData) {
				var result = $.parseJSON(SalonInfoData);
				console.log(result);
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


	$('.sort-service').on('click', function(e){
		e.preventDefault();
		on_preloader_tab();
		var author_id = $('.service-tab').data('author-id');
		var type = $(this).data('type');
		var sort = $(this).attr('data-sort');
		if( sort == 'asc' ) {
			$(this).attr('data-sort', 'desc');
			$(this).toggleClass('arrow-up');
		}else {
			$(this).attr('data-sort', 'asc');
			$(this).toggleClass('arrow-down');
		}
		/*console.log(type);
		console.log(author_id);*/
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_services",
				"author_id": author_id,
				"type": type,
				"sort": sort
			},
			type: 'POST',
			success: function(services_table) {
				$('.services-data').html(services_table);
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
				get_staff_table();
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
				console.log(staffData);
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
				get_services();
				off_preloader_tab();
			},
		});
	});

	jQuery(document).on('click', '.select-service', function(e) {
		e.preventDefault();
		var service_id = $(this).data('service-id');
		var salon_id = $(this).data('salon-id');
		var author_id = $(this).data('author-id');
		localStorage.setItem('link_button', false);
		window.location = '/first-booking?sce='+service_id+'&stf='+salon_id+'&aut='+author_id;
		get_staff_select_option();
	});

	jQuery(document).on('click', '.first-booking-link', function(e) {
		e.preventDefault();
		var author_id = $(this).data('author-id');
		var service_id = $(this).data('service-id');
		var salon_id = $(this).data('salon-id');

		localStorage.setItem('salon_id', salon_id);
		localStorage.setItem('link_button', true);
		
		window.location = '/first-booking?aut='+author_id;
		get_staff_select_option();
		
	});

	$('.service-select').on('change', function(){
		get_staff_select_option();
	});

	function get_staff_select_option() {
		var select_service_id = $('option:selected').val();
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_staff_options_ajax",
				"select_service_id": select_service_id
			},
			type: 'POST',
			success: function( listStaff ) {
				jQuery('select.staff-select').selectpicker('refresh').empty().append(listStaff).selectpicker('refresh').trigger('change');
			},
		});
	}

	$('.search-time-button').on('click', function(e) {
		e.preventDefault();
		var link_button = localStorage.getItem('link_button');
		if(link_button == 'true') {
			var salon_id = localStorage.getItem('salon_id');
			var service_id = $('select.service-select option:selected').val();
			var staff_id = $('select.staff-select').val();
			var staff_name = $('select.staff-select option:selected').text();
			var select_date = $('.select-date-input').val();
		} else {
			var salon_id = $(this).data('salon-id');
			var service_id = $('.service').data('service-id');
			var staff_id = $('select.staff-select').val();
			var staff_name = $('select.staff-select option:selected').text();
			var select_date = $('.select-date-input').val();
		}

		console.log(salon_id);
		console.log(service_id);
		console.log(staff_id);
		console.log(staff_name);
		console.log(select_date);
		if(select_date && service_id && staff_id) {

			$('.service-select').css('border','none');
			$('.service').css('border','none');
			$('.staff-select').css('border','none');
			$('.select-date-input').css('border','none');
			$.ajax({
				url: ajax['ajax_url'],
				data: {
					"action": "get_list_times",
					"salon_id": salon_id,
					"service_id": service_id,
					"staff_id": staff_id,
					"select_date": select_date
				},
				type: 'POST',
				success: function(listTimes) {
					var dataArray = JSON.parse(listTimes);
					if( dataArray.status == 'passed' ) {
						$('.list-times').hide();
						$('.free-times').show('slide');
						$('.staff-name').html('You can not make an order for this day!');
					} else if( dataArray.status == 'closed' ) {
						$('.list-times').hide();
						$('.free-times').show('slide');
						$('.staff-name').html('Salon does not work that day!');
					} else {
						$('.free-times').show('slide');
						$('.list-times').show('slide');
						$('.staff-name').text(staff_name);
						$('.list-times').html(dataArray.times);
					}
					localStorage.setItem('salon_id', salon_id);
					localStorage.setItem('service_id', service_id);
					localStorage.setItem('staff_id', staff_id);
					localStorage.setItem('select_date', select_date);

					localStorage.setItem('start_time', dataArray.start_time);
					localStorage.setItem('end_time', dataArray.end_time);
					localStorage.setItem('interval', dataArray.interval);
					localStorage.setItem('duration', dataArray.duration);

				},
			});
		}else {
			if(!service_id) {
				$('.service-select').css('border','1px solid red');
				$('.service').css('border','1px solid red');
			}
			if(!staff_id) {
				$('.staff-select').css('border','1px solid red');
			}
			if(!select_date) {
				$('.select-date-input').css('border','1px solid red');
			}
		}
	});

	jQuery(document).on('click', '.free-times > ul > li > a', function(e) {
		e.preventDefault();

		var count = $(this).data('count');
		var time = $(this).text();
		localStorage.setItem('select_key', count);
		localStorage.setItem('select_time', time);

		var service_id = localStorage.getItem('service_id');
		var staff_id = localStorage.getItem('staff_id');
		var select_date = localStorage.getItem('select_date');
		var time = time;
		var duration = localStorage.getItem('duration');

		window.location = '/second-booking?sce='+service_id+'&stf='+staff_id+'&drtn='+duration+'&dat='+select_date+'&time='+time;
	});




	jQuery(document).on('click', '.make-order', function(e) {
		e.preventDefault();
		var salon_id = localStorage.getItem('salon_id');
		var service_id = localStorage.getItem('service_id');
		var staff_id = localStorage.getItem('staff_id');
		var select_date = localStorage.getItem('select_date');
		var time = localStorage.getItem('select_time');
		
		var select_key = localStorage.getItem('select_key');
		var start_time = localStorage.getItem('start_time');
		var end_time = localStorage.getItem('end_time');
		var interval = localStorage.getItem('interval');
		var duration = localStorage.getItem('duration');

		var name = $('.name').val();
		var surname = $('.surname').val();
		var email = $('.email').val();
		var phone = $('.phone').val();

		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_array_times",
				"salon_id": salon_id,
				"service_id": service_id,
				"staff_id": staff_id,
				"select_date": select_date,
				"select_key": select_key,
				"start_time": start_time,
				"end_time": end_time,
				"interval": interval,
				"duration": duration,
				"time": time,
				"name": name,
				"surname": surname,
				"email": email,
				"phone": phone
			},
			type: 'POST',
			success: function(arrayTimes) {
				window.location = '/third-booking?sce='+service_id+
				'&stf='+staff_id+
				'&drtn='+duration+
				'&dat='+select_date+
				'&time='+time+
				'&nm='+name+
				'&snm='+surname+
				'&em='+email+
				'&ph='+phone;
			},
		});

	});










	$('.calendar-tab').on('click', function(){
		var salon_id = $('.salon-info-tab').data('post-id');
		$.ajax({
			url: ajax['ajax_url'],
			data: {
				"action": "get_working_time",
				"salon_id": salon_id
			},
			type: 'POST',
			success: function( working_time ) {
				var max_min_time = JSON.parse(working_time);
				calendar_load( max_min_time );
			},
		});
	});




	function calendar_load( max_min_time ) {
		$(document).ready(function(){
			moment.locale('en');
			var now = moment();
			console.log(now.startOf('week').add(9, 'h').format('X'));
			console.log(now.startOf('week').add(10, 'h').format('X'));

			var salon_id = $('.salon-info-tab').data('post-id');
			$.ajax({
				url: ajax['ajax_url'],
				data: {
					"action": "get_events",
					"salon_id": salon_id
				},
				type: 'POST',
				success: function( events ) {
					console.log(events);
				},
			});




			var events = [
			{
				start: now.startOf('week').add(9, 'h').format('X'),
				end: now.startOf('week').add(10, 'h').format('X'),
				title: '1',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Professionnal'
			},
			{
				start: now.startOf('week').add(10, 'h').format('X'),
				end: now.startOf('week').add(11, 'h').format('X'),
				title: '2',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Professionnal'
			},
			{
				start: now.startOf('week').add(11, 'h').format('X'),
				end: now.startOf('week').add(12, 'h').format('X'),
				title: '3',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Personnal'
			},
			{
				start: now.startOf('week').add(1, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(1, 'days').add(10, 'h').format('X'),
				title: '4',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Personnal'
			},
			{
				start: now.startOf('week').add(1, 'days').add(9, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(1, 'days').add(10, 'h').add(30, 'm').format('X'),
				title: '5',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Arrobe'
			},
			{
				start: now.startOf('week').add(1, 'days').add(11, 'h').format('X'),
				end: now.startOf('week').add(1, 'days').add(12, 'h').format('X'),
				title: '6',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Another category'
			},
			{
				start: now.startOf('week').add(2, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(2, 'days').add(10, 'h').format('X'),
				title: '7',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Personnal'
			},
			{
				start: now.startOf('week').add(2, 'days').add(9, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(2, 'days').add(10, 'h').add(30, 'm').format('X'),
				title: '8',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Professionnal'
			},
			{
				start: now.startOf('week').add(2, 'days').add(10, 'h').format('X'),
				end: now.startOf('week').add(2, 'days').add(11, 'h').format('X'),
				title: '9',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Personnal'
			},
			{
				start: now.startOf('week').add(3, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(3, 'days').add(10, 'h').format('X'),
				title: '10',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Professionnal'
			},
			{
				start: now.startOf('week').add(3, 'days').add(9, 'h').add(15, 'm').format('X'),
				end: now.startOf('week').add(3, 'days').add(10, 'h').add(15, 'm').format('X'),
				title: '11',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Personnal'
			},
			{
				start: now.startOf('week').add(3, 'days').add(9, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(3, 'days').add(10, 'h').add(30, 'm').format('X'),
				title: '12',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Anything else'
			},
			{
				start: now.startOf('week').add(4, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(4, 'days').add(12, 'h').format('X'),
				title: '13',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Private'
			},
			{
				start: now.startOf('week').add(4, 'days').add(9, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(4, 'days').add(10, 'h').format('X'),
				title: '14',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'No more creative category name'
			},
			{
				start: now.startOf('week').add(4, 'days').add(11, 'h').format('X'),
				end: now.startOf('week').add(4, 'days').add(11, 'h').add(30, 'm').format('X'),
				title: '15',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Professionnal'
			},
			{
				start: now.startOf('week').add(5, 'days').add(10, 'h').format('X'),
				end: now.startOf('week').add(5, 'days').add(12, 'h').format('X'),
				title: '17',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Private'
			},
			{
				start: now.startOf('week').add(5, 'days').add(9, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(10, 'h').add(30, 'm').format('X'),
				title: '16',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Course'
			},
			{
				start: now.startOf('week').add(5, 'days').add(11, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(12, 'h').add(30, 'm').format('X'),
				title: '18',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'No more creative category name'
			},
			{
				start: now.startOf('week').add(5, 'days').add(12, 'h').format('X'),
				end: now.startOf('week').add(5, 'days').add(13, 'h').format('X'),
				title: '19',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Another one'
			},
			{
				start: now.startOf('week').add(5, 'days').add(12, 'h').add(15, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(13, 'h').format('X'),
				title: '21',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'One again'
			},
			{
				start: now.startOf('week').add(5, 'days').add(12, 'h').add(45, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(13, 'h').add(45, 'm').format('X'),
				title: '22',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Encore'
			},
			{
				start: now.startOf('week').add(5, 'days').add(13, 'h').add(45, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(14, 'h').format('X'),
				title: '23',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Professionnal'
			},
			{
				start: now.startOf('week').add(5, 'days').add(12, 'h').format('X'),
				end: now.startOf('week').add(5, 'days').add(14, 'h').add(30, 'm').format('X'),
				title: '20',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Private'
			},
			{
				start: now.startOf('week').add(5, 'days').add(13, 'h').add(45, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(15, 'h').format('X'),
				title: '27',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Encore'
			},
			{
				start: now.startOf('week').add(5, 'days').add(14, 'h').add(30, 'm').format('X'),
				end: now.startOf('week').add(5, 'days').add(15, 'h').format('X'),
				title: '28',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Private'
			},
			{
				start: now.startOf('week').add(6, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(6, 'days').add(11, 'h').format('X'),
				title: '24',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Foo'
			},
			{
				start: now.startOf('week').add(6, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(6, 'days').add(11, 'h').format('X'),
				title: '25',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Bar'
			},
			{
				start: now.startOf('week').add(6, 'days').add(9, 'h').format('X'),
				end: now.startOf('week').add(6, 'days').add(11, 'h').format('X'),
				title: '26',
				content: 'Hello World! <br> <p>Foo Bar</p>',
				category:'Baz'
			},
			];
			var daynotes = [
			{
				time: now.startOf('week').add(15, 'h').add(30, 'm').format('X'),
				title: 'Leo\'s holiday',
				content: 'yo',
				category: 'holiday'
			}
			];
			var calendar = $('#calendar').Calendar({
				locale: 'en',
				weekday: {
					timeline: {
						intervalMinutes: 30,
						fromHour: max_min_time.min,
						toHour: max_min_time.max,
					}
				},
				events: events,
				daynotes: daynotes
			}).init();
		});
}











});