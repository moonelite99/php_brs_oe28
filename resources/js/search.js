$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val(),
        }
    });

    $('#search-on').on('click', function(event){
        event.preventDefault();
        document.getElementById('search-box').style.visibility = 'visible';
        $('#search-on').addClass('d-none');
        $('#search-off').removeClass('d-none');
    })

    $('#search-off').on('click', function(event){
        event.preventDefault();
        document.getElementById('search-box').style.visibility = 'hidden';
        $('#search-off').addClass('d-none');
        $('#search-on').removeClass('d-none');
    })

    $('#search-box').on('keyup', function (event) {
        event.preventDefault();
        var input = {
            'data': $('#search-box').val(),
        }
        if (input != '') {
            $.ajax({
                url: '/brs/public/search',
                method: 'POST',
                data: input,
                success: function (data) {
                    $('#result').html(data);
                }
            })
        }
    });
})
