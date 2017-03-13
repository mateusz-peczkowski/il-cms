var serializeObject = function(obj) {
    var o = {};
    var a = obj.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

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
    removeAutoHide();
    console.log('%cCreated by: %cJAMPstudio.pl%c -> %chttp://jampstudio.pl','color: #444','background: #2196F3; color: #fff; padding: 4px;','color: #444','color: #009fe3');
});
