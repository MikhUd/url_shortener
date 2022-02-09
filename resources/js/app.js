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
            success: function (data) {
                shortenUrl = JSON.parse(data);
                $('#error').html('');
                $('.container').css("display", "block");
                $('#long_url').html(shortenUrl.long_url);
                $('#shorten_url').html(window.location.href + shortenUrl.token);
            },
            error: function (data) {
                errors = JSON.parse(data.responseText);
                $('#error').html(errors.errors.url);
                $('.container').css("display", "none");
            }
        });
    });

    $("#to_url").click(function (e) {
        e.preventDefault();
        window.open($("#shorten_url").text(), '_blank');
    })
});
