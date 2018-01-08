$(document).ready(function () {
    // Отправка формы со страницы контактов
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

    // Обработка лайков
    $('[data-toy-like]').on('click', function (event) {
        event.preventDefault();
        var current = $(event.currentTarget);
        var currentId = current.attr('data-toy-like');
        var href = current.find('a').attr('href');
        $.get(href, function (result) {
            current.html($(result).find('[data-toy-like='+currentId+']'));
        });
    });

    initComments();
    initSubmitComment();
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

// Functions
function initComments() {
    $('[data-comment-reply-all]').on('click', function (event) {
        $(event.currentTarget).closest('li').find('ul').toggle(300);
    });

    $('[data-comment-reply]').on('click', function (event) {
        var currentCommentId = $(event.currentTarget).attr('data-comment-reply');

        $('[data-comment-reply-form]').each(function (i, current) {
            if ($(current).attr('data-comment-reply-form') === currentCommentId) {
                $(current).toggle(300);
            }
        });
    });

    $('[data-comment-update]').on('click', function (event) {
        var current = $(event.currentTarget);
        var commentId = current.attr('data-comment-update');
        var contentConteiner = current.closest('li').find('[data-comment-body]:first');

        $.post('/comment/edit/'+commentId, function (data) {
            current.remove();
            contentConteiner.html(data);
            initSubmitComment();
        });
    });

    $('[data-comment-delete]').on('click', function (event) {
        var current = $(event.currentTarget);
        var commentId = current.attr('data-comment-delete');

        $.post('/comment/delete/'+commentId, function (data) {
            $('.blog-recent-comments').html($(data).find('.blog-recent-comments'));
            $('[data-toy-comments-count]').html($(data).find('[data-toy-comments-count]'));
            initComments();
            initSubmitComment();
        });
    });

    $('.blog-recent-comments .pagination li').on('click', function (event) {
        event.preventDefault();
        var current = $(event.currentTarget);
        var href;
        if (href = current.find('a').attr('href')) {
            $.get(href, function (result) {
                current.closest('.blog-recent-comments').html($(result).find('.blog-recent-comments').html());
                initComments();
                initSubmitComment();
            });
        }
    });
}

function initSubmitComment() {
    $('.blog-recent-comments [type=submit]').on('click', function (event) {
        event.preventDefault();
        var current = $(event.currentTarget);
        var form = current.closest('form');
        var action = form.attr('action');
        var commentId = current.closest('li').attr('data-comment-id');

        $.ajax({
            url: action,
            method: 'POST',
            data: form.serialize(),
            success: function (data) {
                $('.blog-recent-comments').html($(data).find('.blog-recent-comments'));
                $('[data-toy-comments-count]').html($(data).find('[data-toy-comments-count]'));
                initComments();
                initSubmitComment();
                if (current.attr('data-coments') === 'toogle') {
                    $('[data-comment-reply-form='+commentId+']').closest('li').find('ul').toggle(300);
                }
            }
        });
    });

    $('.blog-recent-comments textarea').on('keydown', function (event) {
        if (event.ctrlKey && event.keyCode == 13) {
            event.preventDefault();
            var current = $(event.currentTarget);
            var button = current.closest('li').find('[type=submit]');
            var form = current.closest('form');
            var action = form.attr('action');
            var commentId = current.closest('li').attr('data-comment-id');

            $.ajax({
                url: action,
                method: 'POST',
                data: form.serialize(),
                success: function (data) {
                    $('.blog-recent-comments').html($(data).find('.blog-recent-comments'));
                    $('[data-toy-comments-count]').html($(data).find('[data-toy-comments-count]'));
                    initComments();
                    initSubmitComment();
                    if (button.attr('data-coments') === 'toogle') {
                        $('[data-comment-reply-form=' + commentId + ']').closest('li').find('ul').toggle(300);
                    }
                }
            });
        }
    });
}
