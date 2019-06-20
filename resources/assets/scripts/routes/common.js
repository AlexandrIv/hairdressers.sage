export default {
  init() {
    $('.single-item').slick({
    	arrows: false,
      dots: true,
      responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        },
      },
      ],
    });
    $('.menu-btn').on('click', function(e) {
      e.preventDefault;
      $(this).toggleClass('menu-btn_active');
      $('.header-navbar').slideToggle();
    });
    $(".current_option").click(function() {
      var customOptionsBlock = $("#custom_options");
      if (customOptionsBlock.is(":hidden")) {
        $("#custom_options").show();
      } else {
        $("#custom_options").hide();
      }
    });
    $("#custom_options").click(function() {
      var customOptionsBlock = $("#custom_options");
      if (customOptionsBlock.is(":hidden")) {
        $("#custom_options").show();
      } else {
        $("#custom_options").hide();
      }
    });
    $("#custom_options li").click(function() {
      var choosenValue = $(this).attr("data-value");
      var textName = $(this).text();
      $(".current_option span .input-select").val(choosenValue);
      $(".current_option span .input-select").text(textName);
      $(".current_option").attr("data-value", choosenValue);
      $(".current_option_type").val(choosenValue);
      $(".current_option span .input-select").attr("value", textName);
    });

    $('.input-select').change(function() {
      $('.current_option_type').val($(this).val());
      $(".current_option span .input-select").text($('.select:selected').text());
    });

    

  },
  finalize() {
    $('.buttons a:last').on('click', function(e){
      e.preventDefault();
      $('.form-block').slideToggle(400);
      $(this).parent().fadeToggle();
    });



    $('.input-select-type').toggle(
      function(e){
        $('.link-list').show({"display": "block"}, 700);
        $('.register-partner-form').css('margin-bottom', '')
      },
      function(e){
        $('.link-list').fadeOut( 700, function() {
          $('.register-partner-form').css('')
        });
      }
      );
    $('.link-list li a').on('click', function(e){
      e.preventDefault();
      var selectVal = $(this).data('type');
      var selectText = $(this).text();
      $('.input-select-type').attr('data-value', selectVal);
      $('.input-select-type').val(selectText);
      if( selectVal ){
        $('.link-list').fadeOut( 700);
      }
    });










    $('.open-list-start').on('click', function(){
      var day = $(this).data('day');
      $('#'+day).toggleClass('show');
    });
    $('.time-list-start li').on('click', function(){
      var day = $(this).parent().attr('id');
      var time = $(this).data('value');
      $('#input-'+day).val(time);
      $('#input-'+day).attr('placeholder', time);
    });

    $('.open-list-end').on('click', function(){
      var day = $(this).data('day');
      $('#'+day).toggleClass('show');
    });

    $('.time-list-end li').on('click', function(){
      var day = $(this).parent().attr('id');
      var time = $(this).data('value');
      $('#input-'+day).val(time);
      $('#input-'+day).attr('placeholder', time);
    });





    $('.single-slider').slick({
      infinite: true,
      dots: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      adaptiveHeight: true
    });


    $('.single-content').readmore({
      speed: 350,
      collapsedHeight: 80,
      moreLink: '<a class="loadmore" href="#">LIRE LA SUITE</a>',
      lessLink: true
    });







    $('.category-input').on('click', function(){
      $('.category-list').toggleClass('show');
    });
    $('.category-list li').on('click', function(){
      $('.category-list').removeClass('show');
      var cat_id = $(this).data('category-id');
      var cat_name = $(this).text();
      $('.category-input').val(cat_name);
      $('.category-input').attr('data-category-id', cat_id);
    });


    $('.duration-input').on('click', function(){
      $('.duration-list').toggleClass('show');
    });
    $('.duration-list li').on('click', function(){
      $('.duration-list').removeClass('show');
      var duratino = $(this).data('duration');
      var times = $(this).text();
      $('.duration-input').val(times);
      $('.duration-input').attr('data-duration', duratino);
    });

    jQuery(document).on('click', '.custom-from-list li', function(){
     $("input", this).trigger('click').trigger('change');
   });

    function initMapSingle() {
      var postsArray = JSON.parse(window.postJsonSingle);
      console.log(postsArray);
      if ( postsArray ) {
        var map = new google.maps.Map(
          document.getElementById('map-single'), {
            zoom: 12,
            center: {
              lat: parseFloat(postsArray.lat),
              lng: parseFloat(postsArray.lng),
            },
          });
        var iconDefault = '/wp-content/themes/hairdres/dist/images/marker-icon.png';
        var marker = new google.maps.Marker({
          position: {
            lat: parseFloat(postsArray.lat),
            lng: parseFloat(postsArray.lng),
          },
          icon: iconDefault,
          map: map,
          title: 'Uluru (Ayers Rock)',
        });
        var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '<img src="'+postsArray.image_url+'" alt="" />'+
        '</div>'+
        '<h3 id="firstHeading" class="firstHeading">'+postsArray.post_title+'</h3>'+
        +'<span class="address">'+postsArray.address+'</span>'+
        '<div id="bodyContent">'+
        '<p></p>'+
        '</div>'+
        '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString,
        });
        infowindow.open(map, marker);
      }
    }
    if(window.postJsonSingle != undefined) {
      initMapSingle();
    }






    $('.service-input').on('click', function(){
      $('.service-name-list').toggleClass('show');
      $(this).closest('span').find('i').toggleClass('icon-active');
    });
    $('.service-name-list li').on('click', function(){
      $('.service-name-list').removeClass('show');

      $(this).parent('.service-name-list').closest('span').find('i').removeClass('icon-active');

      var service_id = $(this).data('service_id');
      var service_name = $(this).text();
      $('.service-input').val(service_name);
      $('.service-input').attr('data-select-id', service_id);
    });



    $('select').selectpicker();
    $('.select-date-input').datepicker();























    































$('.staff-input').on('click', function(){
  $('.staff-name-list').toggleClass('show');
  $(this).closest('span').find('i').toggleClass('icon-active');
});
$('.staff-name-list li').on('click', function(){
  $('.staff-name-list').removeClass('show');

  $(this).parent('.staff-name').closest('span').find('i').removeClass('icon-active');

  var staff_id = $(this).data('service_id');
  var staff_name = $(this).text();
  $('.staff-input').val(staff_name);
  $('.staff-input').attr('data-select-id', staff_id);
});







function initMap() {
  var postsArray = JSON.parse(window.postJsonCategory);
  console.log(postsArray);
  if ( postsArray ) {
    var map = new google.maps.Map(
      document.getElementById('mapCategory'), {
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

if(window.postJsonCategory != undefined) {
  initMap();
}
},
};
