$(document).ready(function () {
// MOVIMIENTO POR EL MAIN

let screens = $('.screen');

 $('.nav-items').each(function(index, element) {
    $(element).click(function(e) {
        $('#id_main').scrollLeft(($(screens)[index].offsetWidth * index));
    });
 });
})
