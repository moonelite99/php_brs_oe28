var suffix = $('#suffix').attr('value');
var pusher = new Pusher('a3af80b3348a3d7cc8bf', {
    encrypted: true,
    cluster: "ap1"
});

var channel = pusher.subscribe('ReviewNotificationEvent');
channel.bind('review-channel', function (data) {
    var newNotificationHtml = `

        <div class="notifi__item">
            <div class="bg-c3 img-cir img-40">
                <i class="zmdi zmdi-file-text"></i>
            </div>
            <div class="content">
                <a href="${data.link}">
                    <p>${data.name}` + suffix + `</p>
                    <span class="date">${data.time}</span>
                </a>
            </div>
        </div>

    `;

    var toast = `
    <div class="toast noti-bottom text-success" data-delay="10000">
        <div class="toast-body">
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            <a href="${data.link}">
                <p>${data.name}` + suffix + `</p>
                <span class="date">${data.time}</span>
            </a>
        </div>
    </div>
    `;

    $('#noti-dropdown').prepend(newNotificationHtml);
    $('body').prepend(toast);

    $(document).ready(function () {
        $('.toast').toast('show');
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
