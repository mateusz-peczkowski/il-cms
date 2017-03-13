$('[data-ajax-send]').click(function(e) {
    e.preventDefault();
    var $that = $(this);
    var data = {};
    data['_token'] = $that.data('ajax-token');
    data['_method'] = $that.data('ajax-method') ? $that.data('ajax-method') : 'POST';
    $.ajax({
        type: 'POST',
        url: $that.data('ajax-send'),
        data: data,
        success: function (response) {
            if($that.data('ajax-redirect')) {
                window.location = $that.data('ajax-redirect');
            }
        },
        error: function (response) {
            $('#errorModal').find('.response').html(response);
            $('#errorModal').modal();
        }
    });
});

var removeAutoHide = function() {
    setTimeout(function() {
        $('[data-autohide="true"]').slideUp(function() {
            $(this).remove();
        });
    }, 3000);
}


$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    $('.js-data-table').each(function() {
        $(this).DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
    $('.select2').each(function() {
        $(this).select2();
    });
    $('#confirm-delete, #confirm-deactivate, #confirm-revoke, #confirm-destroy').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    removeAutoHide();
    console.log('%cCreated by: %cJAMPstudio.pl%c -> %chttp://jampstudio.pl','color: #444','background: #2196F3; color: #fff; padding: 4px;','color: #444','color: #009fe3');
});
