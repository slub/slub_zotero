function toggleAbstract(nr) {
    $("div#"+nr).toggle();
}

$(document).ready(function()
{
    $('.openitems').click(function()
    {
        var ajaxURL = $(this).data('ajaxurl');
        var target = 'div#' + $(this).data('target');
        //~ showing loading animation from jQuery LoadingOverlay
        $.LoadingOverlay("show");

        $(target).load(ajaxURL, function()
        {
            $.LoadingOverlay("hide");
        });
        return false;
    });
});
