$(document).ready(function () {
// MOVIMIENTO POR EL MAIN
    let screens = $('.screen');
    $('#selector').css({
        'left' : $('#btn_home')[0].offsetLeft+'px'
    });
    let main = $('#id_main');
    let selector = $("#selector");



    $('.nav-items').each(function(index, element) {

        $(element).click(function(e) {

              anime({
                targets: [main[0], selector[0]],
                scrollLeft: ($(screens)[index].offsetWidth * index),
                left: element.offsetLeft,
                duration: 500,
                easing: 'easeInOutQuad'
              });
        });
    });






})


