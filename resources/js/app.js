require('./bootstrap');

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#shortener_url").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: '/',
            method: 'post',
            dataType: 'text',
            data: {
                'url' : $('#url').val()
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.error) {
                    $('#error').html(data.error);
                    $('.container').css("display", "none");
                } else {
                    $('#error').html('');
                    $('.container').css("display", "block");
                    $('#long_url').html(data.long_url);
                    $('#shorten_url').html(window.location.href + data.token);
                }
            }
        });
    });

    $("#to_url").click(function (e) {
        e.preventDefault();
        window.open($("#shorten_url").text(), '_blank');
    })
});
