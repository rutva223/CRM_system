$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var title = $(this).data('title');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');
    $("#commonModal .modal-title").html(title);
    $("#commonModal .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        beforeSend: function () {
            $(".loader-wrapper").removeClass('d-none');
        },
        success: function (data) {
            $(".loader-wrapper").addClass('d-none');
            $('#commonModal .body').html(data);
            $("#commonModal").modal('show');
        },
        error: function (data) {
            $(".loader-wrapper").addClass('d-none');
            data = data.responseJSON;
            toastrs('Error', data.error, 'error')
        }
    });
});



/*  Window Resize END */
