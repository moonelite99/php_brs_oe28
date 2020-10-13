$(document).ready(function () {
    var arr = new Array(1000);
    for (var i = 0; i < 1000; i++) {
        arr[i] = i;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val(),
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
            success: function (response) {
                var time = new Date();
                count++;
                content = `
                <li class="reviews-single-item" id="li${count}">
                    <div class="media media-none--xs" id="comment${count}">
                        <button type="button" class="btn btn-secondary x-btn" data-toggle="modal"
                            data-target="#exampleModal${count}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <div class="modal fade" id="exampleModal${count}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            ${msg_delete}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ${msg_delete_confirm}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                                            data-id=" ${response.comment.id} "
                                            id="delete${count}">  ${msg_delete} </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="media-body">
                            <h4 class="comment-title"> ${response.username}  </h4>
                            <span class="post-date"> ${time.toISOString().slice(0, 10) + ' ' + time.getHours() + ':' + time.getMinutes() + ':' + time.getSeconds()}  </span>
                            <p class="break-word" id="p${count}">  ${response.comment.content}  </p>
                            <span class="pull-right">(<span id="cmt_like_num${count}"> ${response.comment.like_num} </span>)</span>
                            <a href="#" class="like d-none" id="unlike_cmt${count}" data-likeable_type="App\\Models\\Comment" data-likeable_id=" ${response.comment.id} " data-user_id=" ${response.comment.user_id} "><i class="fas fa-thumbs-up pull-right"></i></a>&nbsp;
                            <a href="#" class="like" id="like_cmt${count}" data-likeable_type="App\\Models\\Comment" data-likeable_id=" ${response.comment.id} " data-user_id=" ${response.comment.user_id} "><i class="far fa-thumbs-up pull-right"></i></a>&nbsp;
                        </div>
                    </div>
                    <form class="leave-form-box d-none" id="comment_form${count}" data-id= ${response.comment.id} " data-index=${count}>
                        <input type="hidden" name="review_id" value=" ${review_id} ">
                        <input type="hidden" name="user_id" value=" ${response.comment.user_id} ">
                        <div class="row">
                            <div class="col-12 form-group">
                                <textarea class="textarea form-control comment-form-control"
                                    name="content" id="content${count}" rows="4" cols="20"
                                    required> ${response.comment.content} </textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-12 form-group mb-0">
                                <button type="submit"
                                    class="item-btn comment-button"> ${msg_submit} </button>
                            </div>
                        </div>
                        <div class="form-response"></div>
                    </form>
                </li>
                `;
                $('#ajax-cmt').append(content);
                animate();
                updateComment();
                deleteComment();
                like_cmt();
                unlike_cmt();
            }
        })
    }

    function comment() {
        $('#comment_form').on('submit', function (event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: '/brs/public/comments',
                method: 'POST',
                data: form_data,
                success: function (data) {
                    $('#comment_form')[0].reset();
                    loadComments();
                }
            })
        });
    }

    function updateComment() {
        $.each(arr, function (index) {
            $('#comment_form' + arr[index]).on('submit', function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                var id = $(this).attr("data-id");
                var idex = $(this).attr("data-index");
                var content = $(`#content${idex}`).val();
                $.ajax({
                    url: `/brs/public/comments/${id}`,
                    method: 'PUT',
                    data: form_data,
                    success: function (data) {
                        $("#p" + arr[index]).html(`<p class="break-word"> ${content} </p>`)
                        $("#comment" + arr[index]).removeClass("d-none");
                        $("#comment_form" + arr[index]).addClass("d-none");
                    }
                })
            });
        });
    }

    function deleteComment() {
        $.each(arr, function (index) {
            $('#delete' + arr[index]).on('click', function (event) {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: `/brs/public/comments/${id}`,
                    method: 'DELETE',
                    success: function (data) {
                        $("#li" + arr[index]).addClass("d-none");
                    }
                })
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
                    'like': true,
                }
                $.ajax({
                    url: '/brs/public/likes',
                    method: 'POST',
                    data: data,
                    success: function (data) {
                        $('#cmt_like_num' + arr[index]).html(data);
                        $('#like_cmt' + arr[index]).addClass('d-none');
                        $('#unlike_cmt' + arr[index]).removeClass('d-none');
                    }
                })
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
                    'likeable_type': $(this).data("likeable_type"),
                }
                $.ajax({
                    url: '/brs/public/likes',
                    method: 'POST',
                    data: data,
                    success: function (data) {
                        $('#cmt_like_num' + arr[index]).html(data);
                        $('#unlike_cmt' + arr[index]).addClass('d-none');
                        $('#like_cmt' + arr[index]).removeClass('d-none');
                    }
                })
            });
        });
    }
});


