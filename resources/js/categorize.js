$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val(),
        }
    });

    var count = 0;

    $('#category').hover(function () {
        if (count == 0) {
            $.ajax({
                url: '/brs/public/category',
                method: 'GET',
                success: function (data) {
                    $('#categorize').html(data);
                    count++;
                }
            })
        }
    })

})
