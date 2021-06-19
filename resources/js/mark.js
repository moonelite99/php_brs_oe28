$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    reading();
    unreading();
    read();
    unread();
    fav();
    unfav();

    function reading() {
        $('#unreading').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $('#user_id').val(),
                'book_id': $('#book_id').val(),
                'status': $(this).data("status")
            };
            $.ajax({
                url: '/brs/public/marks',
                method: 'POST',
                data: data,
                success: function success(data) {
                    $('#unreading').addClass('d-none');
                    $('#reading').removeClass('d-none');
                    $('#unread').removeClass('d-none');
                    $('#read').addClass('d-none');
                }
            });
        });
    }

    function unreading() {
        $('#reading').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $('#user_id').val(),
                'book_id': $('#book_id').val(),
                'status': $(this).data("status")
            };
            $.ajax({
                url: '/brs/public/marks',
                method: 'POST',
                data: data,
                success: function success(data) {
                    $('#unreading').removeClass('d-none');
                    $('#reading').addClass('d-none');
                }
            });
        });
    }

    function read() {
        $('#unread').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $('#user_id').val(),
                'book_id': $('#book_id').val(),
                'status': $(this).data("status")
            };
            $.ajax({
                url: '/brs/public/marks',
                method: 'POST',
                data: data,
                success: function success(data) {
                    $('#unread').addClass('d-none');
                    $('#read').removeClass('d-none');
                    $('#unreading').removeClass('d-none');
                    $('#reading').addClass('d-none');
                }
            });
        });
    }

    function unread() {
        $('#read').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $('#user_id').val(),
                'book_id': $('#book_id').val(),
                'status': $(this).data("status")
            };
            $.ajax({
                url: '/brs/public/marks',
                method: 'POST',
                data: data,
                success: function success(data) {
                    $('#unread').removeClass('d-none');
                    $('#read').addClass('d-none');
                }
            });
        });
    }

    function fav() {
        $('#unfav').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $('#user_id').val(),
                'book_id': $('#book_id').val(),
                'favorite': $(this).data("favorite")
            };
            $.ajax({
                url: '/brs/public/marks',
                method: 'POST',
                data: data,
                success: function success(data) {
                    $('#unfav').addClass('d-none');
                    $('#fav').removeClass('d-none');
                }
            });
        });
    }

    function unfav() {
        $('#fav').on('click', function (event) {
            event.preventDefault();
            var data = {
                'user_id': $('#user_id').val(),
                'book_id': $('#book_id').val(),
                'favorite': $(this).data("favorite")
            };
            $.ajax({
                url: '/brs/public/marks',
                method: 'POST',
                data: data,
                success: function success(data) {
                    $('#unfav').removeClass('d-none');
                    $('#fav').addClass('d-none');
                }
            });
        });
    }
});
