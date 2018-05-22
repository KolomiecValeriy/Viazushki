$(document).ready(function () {

    addImagesPreview('mainImage');
    initImageClick('mainImage');

    addImagesPreview('images');
    initImageClick('images', true);
});

function addImagesPreview(blockId) {
    $("div[id^='field_container_'][id$='" + blockId + "']").hide();
    var container = $("div[id^='sonata-ba-field-container-'][id$='" + blockId + "']");
    var checkedBlocks = container.find('div.checked');
    var imagePreviewBlock = $('[data-' + blockId + '-preview-block]').clone().removeClass('cloned-block');

    $("ul[id$='" + blockId + "'] li").each(function (i, element) {
        var fileName = $.trim($(element).find('.control-label__text').html());
        if (fileName === 'None') {
            fileName = 'no-image.png';
        }
        var imageBlock = $('#image-' + blockId + '-block').clone().removeClass('cloned-block');
        imageBlock.attr('data-' + blockId + '-block', i + 1);

        imageBlock.find('img').attr('src', '/assets/images/'+fileName);

        $(checkedBlocks).each(function (i, element) {
            var checkedName = $.trim($(element).next().html());
            if (fileName === checkedName) {
                imageBlock.find('img').addClass('active');
            }
        });

        imagePreviewBlock.find('.row').append(imageBlock);
    });
    container.append(imagePreviewBlock.show());
    container.append('<div class="clearfix"></div>');
}

function initImageClick(blockId, multiply) {
    $('[data-' + blockId + '-block]').on('click', function (event) {
        var current = $(event.currentTarget);
        var currentNumber = current.attr('data-' + blockId + '-block');
        var img = current.find('img');

        if (!multiply) {
            $('[data-' + blockId + '-preview-block]').find('.active').removeClass('active');
        }
        if (img.hasClass('active')) {
            img.removeClass('active');
        } else {
            img.addClass('active');
        }
        $("ul[id$='" + blockId + "'] li:nth-child(" + currentNumber + ") div label").click()
    });
}