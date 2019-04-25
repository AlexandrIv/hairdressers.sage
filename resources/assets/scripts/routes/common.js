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










    $('.open-list').on('click', function(){
      var day = $(this).data('day');
      $('#'+day).toggleClass('show');
    });

    $('.time-list li').on('click', function(){
      var day = $(this).parent().attr('id');
      var time = $(this).data('value');
      $('#input-'+day).val(time);
      $('#input-'+day).attr('placeholder', time);
      $('#'+day).removeClass('show');
    });






  },
};
