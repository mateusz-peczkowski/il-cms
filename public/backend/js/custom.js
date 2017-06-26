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

function SendAjax(url, method, data, callback)
{
    var ret = true;
    $.ajax({
        type: method,
        url: url,
        data: data
    })
        .done(function( msg ) {
            if (msg.status == 'OK')
            {
                if (msg.redirect)
                {
                    window.location.href = msg.redirect;
                }
                else if (msg.reload)
                {
                    window.location.reload();
                }
                else
                {
                    if (msg.message)
                    {
                        Display(msg);
                    }

                    if (typeof callback === "function")
                    {
                        callback();
                    }
                }
            }
            else
            {
                // status = fail
                Display(msg);
                ret = false;
                // alert('error');
            }
        })
        .fail(function() {
            Display({status:'ERROR', message:'Server Error'});
            ret = false;
            // alert('fail');
        });

    return ret;
}


function Display(msg)
{
    // msg.status
    // msg.message
    if (msg instanceof Object)
    {
        if (msg.status == 'OK')
        {
            $('#form-messages').empty();
            $('#form-messages').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4 class="mb-0"><i class="icon fa fa-check"></i> ' + msg.message + '</h4></div>');
            // scroll to message
            $('html, body').animate({
                scrollTop: 0
            }, 1000);

            $('#form-messages').slideDown();

            setTimeout(function() {
                $('#form-messages').slideUp();
            }, 1500);
        }
        else
        {
            $.each(msg.message, function( index, values ) {

                var control = $('[name=' + index + ']');
                var control_group = control.parent('.form-group');

                control_group.addClass('has-error');
                // <div id="val-username-error" class="help-block animation-pullUp">Please enter a username</div>
                var message = '';
                $.each(values, function (k, v) {
                    message += '<li>' + v + '</li>';
                });
                // aria-describedby="val-username-error" aria-invalid="true"
                control.after('<div class="help-block animation-pullUp">' + message + '</div>');


            });
            // scroll to first error
            $('html, body').animate({
                scrollTop: $('.has-error:first').offset().top -40
            }, 1000);
        }
    }
    else
    {
        alert(msg);
    }

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
});
