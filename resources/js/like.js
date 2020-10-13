$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val(),
        }
    });

    like();
    unlike();

    function like() {
        $('#like').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $(this).data("user_id"),
                'likeable_id': $(this).data("likeable_id"),
                'likeable_type': $(this).data("likeable_type"),
                'like': true,
            }
            $.ajax({
                url: '/brs/public/likes',
                method: 'POST',
                data: data,
                success: function (data) {
                    $('#like_num').html(data);
                    $('#like').addClass('d-none');
                    $('#unlike').removeClass('d-none');
                }
            })
        });
    }

    function unlike() {
        $('#unlike').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $(this).data("user_id"),
                'likeable_id': $(this).data("likeable_id"),
                'likeable_type': $(this).data("likeable_type"),
            }
            $.ajax({
                url: '/brs/public/likes',
                method: 'DELETE',
                data: data,
                success: function (data) {
                    $('#like_num').html(data);
                    $('#unlike').addClass('d-none');
                    $('#like').removeClass('d-none');
                }
            })
        });
    }
});
