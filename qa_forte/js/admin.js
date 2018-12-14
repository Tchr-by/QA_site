(function($) {
    //$('.row-actions .edit').hide();
    $('.row-actions .trash').hide();
})( jQuery );

function checkParams() {
    var name = $('#name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
     
    if( name.length !== '' && email.length !== '' && phone.length !== '') {
        $('#submit').removeAttr('disabled');
    } else {
        $('#submit').attr('disabled', 'disabled');
    }
}