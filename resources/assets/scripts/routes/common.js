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
      $(".current_option span .input-select").attr("value", choosenValue);
    });

    $('.input-select').change(function() {
      $('.current_option').attr("data-value", $(this).val());
      $(".current_option span .input-select").text($('.select:selected').text());
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
