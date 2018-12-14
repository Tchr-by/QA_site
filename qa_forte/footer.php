<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
(function($) {
    $('.map').on('click', function() {
        $(this).addClass('error');
    });
    $('.literature-dl-fake-btn').on('click', function() {
        alert("У вас нет прав администратора!");
    });
    $('.literature-dl-admin-btn').on('click', function() {
        setTimeout(function(){
            alert("Ошибка!");
        }, 1000);
    });
    $('.order-btn').on('click', function() {
        $('.registration-form').hide();
        $(this).closest('.courses-item').next().toggle();
    });
    $('.registration-form form input').keyup(function() {
        if ($(this).parent().find('.inp_name').val().length > 2 && $(this).parent().find('.inp_email').val().length > 2 && $(this).parent().find('.inp_phone').val().length > 2 && $(this).parent().find('.inp_phone').val().length > 2) {
            if ($(this).parent().find('.radio_1').is(':checked') || $(this).parent().find('.radio_2').is(':checked')) {
                $(this).parent().find('.form-btn').prop("disabled", false);
            }
        }
    });
    $('.registration-form .radio').on('click', function() {
        if ($(this).parent().find('.inp_name').val().length > 2 && $(this).parent().find('.inp_email').val().length > 2 && $(this).parent().find('.inp_phone').val().length > 2 && $(this).parent().find('.inp_phone').val().length > 2) {
            if ($(this).parent().find('.radio_1').is(':checked') || $(this).parent().find('.radio_2').is(':checked')) {
                $(this).parent().find('.form-btn').prop("disabled", false);
            }
        }
    });
    $('.radio_1').on('click', function() {
        $('.ri-type').text('дневную группу');
        $('.alert-success').show();
    });
    $(document).keypress(function(e) {
        if(e.which == 13) {
            if($('.alert-success').is(':visible')){
                 window.location.href = "/about";
            }
            $('.alert-success').hide();
        }
   });
   $('.form-btn').on('click', function() {
        if ($('.radio_2').is(':checked')) {
            $('.register-info').text('');
        }
        $('.register-info').show();
   });
   $('.alert-btn').on('click', function() {
       $(this).parent('.register-info').hide();
   });
   $('.register').submit(function () {
       sendContactForm();
       return false;
   });
})( jQuery );
</script>


<?php wp_footer(); // необходимо для работы плагинов и функционала  ?>
</body>
</html>