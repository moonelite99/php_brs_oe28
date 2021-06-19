$(function () {
    var arr = new Array(1000);

    for (var i = 0; i < 1000; i++) {
        arr[i] = i;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    var content = '';
    var count = $('#count').val();
    var review_id = $('#review_id').val();
    var msg_submit = $('#msg_submit').val();
    var msg_delete = $('#msg_delete').val();
    var msg_delete_confirm = $('#msg_delete_confirm').val();
    comment();
    deleteComment();
    updateComment();
    animate();
    like_cmt();
    unlike_cmt();

    function loadComments() {
        $.ajax({
            url: '/brs/public/comments',
            method: 'GET',
            success: function success(response) {
                var time = new Date();
                count++;
                content = "\n                <li class=\"reviews-single-item\" id=\"li".concat(count, "\">\n                    <div class=\"media media-none--xs\" id=\"comment").concat(count, "\">\n                        <button type=\"button\" class=\"btn btn-secondary x-btn\" data-toggle=\"modal\"\n                            data-target=\"#exampleModal").concat(count, "\">\n                            <i class=\"fa fa-times\" aria-hidden=\"true\"></i>\n                        </button>\n                        <div class=\"modal fade\" id=\"exampleModal").concat(count, "\" tabindex=\"-1\" role=\"dialog\"\n                            aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">\n                            <div class=\"modal-dialog\" role=\"document\">\n                                <div class=\"modal-content\">\n                                    <div class=\"modal-header\">\n                                        <h5 class=\"modal-title\" id=\"exampleModalLabel\">\n                                            ").concat(msg_delete, "\n                                        </h5>\n                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\"\n                                            aria-label=\"Close\">\n                                            <span aria-hidden=\"true\">&times;</span>\n                                        </button>\n                                    </div>\n                                    <div class=\"modal-body\">\n                                        ").concat(msg_delete_confirm, "\n                                    </div>\n                                    <div class=\"modal-footer\">\n                                        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\"\n                                            data-id=\"").concat(response.comment.id, " \"\n                                            id=\"delete").concat(count, "\">").concat(msg_delete, "</button>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                        <div class=\"media-body\">\n                            <h4 class=\"comment-title\">").concat(response.username, "  </h4>\n                            <span class=\"post-date\">").concat(time.toISOString().slice(0, 10) + ' ' + time.getHours() + ':' + time.getMinutes() + ':' + time.getSeconds(), "  </span>\n                            <p class=\"break-word\" id=\"p").concat(count, "\">").concat(response.comment.content, "</p>\n                            <span class=\"pull-right\">(<span id=\"cmt_like_num").concat(count, "\">").concat(response.comment.like_num, " </span>)</span>\n                            <a href=\"#\" class=\"like d-none\" id=\"unlike_cmt").concat(count, "\" data-likeable_type=\"App\\Models\\Comment\" data-likeable_id=\"").concat(response.comment.id, " \" data-user_id=\"").concat(response.comment.user_id, " \"><i class=\"fas fa-thumbs-up pull-right\"></i></a>&nbsp;\n                            <a href=\"#\" class=\"like\" id=\"like_cmt").concat(count, "\" data-likeable_type=\"App\\Models\\Comment\" data-likeable_id=\"").concat(response.comment.id, " \" data-user_id=\"").concat(response.comment.user_id, " \"><i class=\"far fa-thumbs-up pull-right\"></i></a>&nbsp;\n                        </div>\n                    </div>\n                    <form class=\"leave-form-box d-none\" id=\"comment_form").concat(count, "\" data-id=").concat(response.comment.id, " \" data-index=").concat(count, ">\n                        <input type=\"hidden\" name=\"review_id\" value=\"").concat(review_id, " \">\n                        <input type=\"hidden\" name=\"user_id\" value=\"").concat(response.comment.user_id, " \">\n                        <div class=\"row\">\n                            <div class=\"col-12 form-group\">\n                                <textarea class=\"textarea form-control comment-form-control\"\n                                    name=\"content\" id=\"content").concat(count, "\" rows=\"4\" cols=\"20\"\n                                    required>").concat(response.comment.content, "</textarea>\n                                <div class=\"help-block with-errors\"></div>\n                            </div>\n                            <div class=\"col-12 form-group mb-0\">\n                                <button type=\"submit\"\n                                    class=\"item-btn comment-button\">").concat(msg_submit, " </button>\n                            </div>\n                        </div>\n                        <div class=\"form-response\"></div>\n                    </form>\n                </li>\n                ");
                $('#ajax-cmt').append(content);
                animate();
                updateComment();
                deleteComment();
                like_cmt();
                unlike_cmt();
            }
        });
    }

    function comment() {
        $('#comment_form').on('submit', function (event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: '/brs/public/comments',
                method: 'POST',
                data: form_data,
                success: function success(data) {
                    $('#comment_form')[0].reset();
                    loadComments();
                }
            });
        });
    }

    function updateComment() {
        $.each(arr, function (index) {
            $('#comment_form' + arr[index]).on('submit', function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                var id = $(this).attr("data-id");
                var idex = $(this).attr("data-index");
                var content = $("#content".concat(idex)).val();
                $.ajax({
                    url: "/brs/public/comments/".concat(id),
                    method: 'PUT',
                    data: form_data,
                    success: function success(data) {
                        $("#p" + arr[index]).html("<p class=\"break-word\">".concat(content, " </p>"));
                        $("#comment" + arr[index]).removeClass("d-none");
                        $("#comment_form" + arr[index]).addClass("d-none");
                    }
                });
            });
        });
    }

    function deleteComment() {
        $.each(arr, function (index) {
            $('#delete' + arr[index]).on('click', function (event) {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "/brs/public/comments/".concat(id),
                    method: 'DELETE',
                    success: function success(data) {
                        $("#li" + arr[index]).addClass("d-none");
                    }
                });
            });
        });
    }

    function animate() {
        $.each(arr, function (index) {
            $("#p" + arr[index]).on('click', function () {
                $("#comment" + arr[index]).addClass("d-none");
                $("#comment_form" + arr[index]).removeClass("d-none");
            });
        });
    }

    function like_cmt() {
        $.each(arr, function (index) {
            $('#like_cmt' + arr[index]).on('click', function (event) {
                event.preventDefault();
                var data = {
                    'user_id': $(this).data("user_id"),
                    'likeable_id': $(this).data("likeable_id"),
                    'likeable_type': $(this).data("likeable_type"),
                    'like': true
                };
                $.ajax({
                    url: '/brs/public/likes',
                    method: 'POST',
                    data: data,
                    success: function success(data) {
                        $('#cmt_like_num' + arr[index]).html(data);
                        $('#like_cmt' + arr[index]).addClass('d-none');
                        $('#unlike_cmt' + arr[index]).removeClass('d-none');
                    }
                });
            });
        });
    }

    function unlike_cmt() {
        $.each(arr, function (index) {
            $('#unlike_cmt' + arr[index]).on('click', function (event) {
                event.preventDefault();
                var data = {
                    'user_id': $(this).data("user_id"),
                    'likeable_id': $(this).data("likeable_id"),
                    'likeable_type': $(this).data("likeable_type")
                };
                $.ajax({
                    url: '/brs/public/likes',
                    method: 'POST',
                    data: data,
                    success: function success(data) {
                        $('#cmt_like_num' + arr[index]).html(data);
                        $('#unlike_cmt' + arr[index]).addClass('d-none');
                        $('#like_cmt' + arr[index]).removeClass('d-none');
                    }
                });
            });
        });
    }
});
