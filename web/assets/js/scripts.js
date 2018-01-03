$(document).ready(function () {
    //Отправка формы со страницы контактов
    $('#contact_form').on('submit', function (event) {
        event.preventDefault();

        var form = $("#contact_form");
        $.ajax({
            url: form.attr('action'),
            method: "POST",
            data: form.serialize(),
            success: function (result) {
                $('.success-msg').fadeIn();
                form[0].reset();
                setTimeout(function () {
                    $('.success-msg').fadeOut();
                }, 3000);
            },
            error: function (error) {
                alert('Сообщение не отправлено.');
            }
        })
    });

    $('[data-comment-reply]').on('click', function (event) {
       var currentCommentId = $(event.currentTarget).attr('data-comment-reply');

        $('[data-comment-reply-form]').each(function (i, current) {
            if ($(current).attr('data-comment-reply-form') === currentCommentId) {
                $(current).toggle(300);
            }
        });
    });

    $('[data-comment-reply-all]').on('click', function (event) {
        $(event.currentTarget).closest('li').find('ul').toggle(300);
    });
});

// Portfolio
$(window).load(function () {
    var $cont = $('.portfolio-group');


    $cont.isotope({
        itemSelector: '.portfolio-group .portfolio-item',
        masonry: {columnWidth: $('.isotope-item:first').width(), gutterWidth: 20, isFitWidth: true},
        filter: '*',
    });

    $('.portfolio-filter-container a').click(function () {
        $cont.isotope({
            filter: this.getAttribute('data-filter')
        });

        return false;
    });

    var lastClickFilter = null;
    $('.portfolio-filter a').click(function () {

        //first clicked we don't know which element is selected last time
        if (lastClickFilter === null) {
            $('.portfolio-filter a').removeClass('portfolio-selected');
        }
        else {
            $(lastClickFilter).removeClass('portfolio-selected');
        }

        lastClickFilter = this;
        $(this).addClass('portfolio-selected');
    });


});

// Mobile Menu
$(function () {
    $('#hornavmenu').slicknav();
});
