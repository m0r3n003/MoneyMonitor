$(document).ready(function() {
    $('.show-password').each(function (index, element) {

        $(element).click(function (e) {
            e.preventDefault();
            let clases = $(element).attr('class').split(' ');
            console.log(clases[0]);

            let tipo = $('#'+clases[0]).attr('type');
            if (tipo == 'password') {
                $('#'+clases[0]).attr('type', 'text');

                $(element).addClass("fa-eye-slash");
            } else {
                $('#'+clases[0]).attr('type', 'password');
                $(element).removeClass("fa-eye-slash");
            }
        });

    });

    $('#terminos').change(function (e) {
        $('#register-btn').attr('disabled', ! $('#terminos').prop("checked"));
    });

})
