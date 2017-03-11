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