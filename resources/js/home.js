var logoutbtn = document.getElementById('logout');
var rate_1 = document.getElementById("rate-1");
var rate_2 = document.getElementById("rate-2");
var rate_3 = document.getElementById("rate-3");
var rate_4 = document.getElementById("rate-4");
var rate_5 = document.getElementById("rate-5");

if (rate_1) {
    rate_1.onclick = rate1;
}

if (rate_2) {
    rate_2.onclick = rate2;
}

if (rate_3) {
    rate_3.onclick = rate3;
}

if (rate_4) {
    rate_4.onclick = rate4;
}

if (rate_5) {
    rate_5.onclick = rate5;
}

function rate1() {
    document.getElementById('rating').value = 1;
}

function rate2() {
    document.getElementById('rating').value = 2;
}

function rate3() {
    document.getElementById('rating').value = 3;
}

function rate4() {
    document.getElementById('rating').value = 4;
}

function rate5() {
    document.getElementById('rating').value = 5;
}

if (logoutbtn) {
    logoutbtn.onclick = logout;
}

function logout(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
}


document.getElementById("en").onclick = function () {
    document.getElementById('locale').value = 'en';
    document.getElementById('language-form').submit();
};
document.getElementById("vi").onclick = function () {
    document.getElementById('locale').value = 'vi';
    document.getElementById('language-form').submit();
};

$(function () {
    $('.toast').toast('show');
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(function () {
    $.each($('.subtotal'), function (index) {
        $('.subtotal')[index].innerText = $('.item-price')[index].innerText.replace(/\D/g, '') * $('.item-quantity')[index].value
    })
})

$(function () {
    $.each($('.book-price'), function (index, value) {
        $('.book-price')[index].innerText = Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format($('.book-price')[index].innerText)
    })
})

$(function () {
    $.each($('.item-quantity'), function (index, value) {
        $('.item-quantity')[index].oninput = function () {
            if (this.value < 1) {
                this.value = 1
            } else if (this.value > 20) {
                this.value = 20
            }
            $('.confirm-update')[index].style.visibility = 'visible'
            var subtotal = this.value * $('.item-price')[index].innerText.replace(/\D/g, '')
            $('.subtotal')[index].innerText = Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(subtotal)
        }

        $('.confirm-update')[index].onclick = function (e) {
            $('.confirm-update')[index].style.visibility = 'hidden'
            e.preventDefault()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            })
            var input = {
                'quantity': $('.item-quantity')[index].value
            }
            $.ajax({
                url: this.dataset.url,
                method: 'PUT',
                data: input,
                success: function success(data) {
                    $('body').append(`
                                <div class="toast noti text-success" data-delay="5000">
                                    <div class="toast-header">
                                        <strong class="mr-auto">${data.title}</strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                    </div>
                                    <div class="toast-body">
                                        ${data.msg}
                                    </div>
                                </div>
                                `)
                    $('.toast').toast('show');
                }
            })
        }
    })
})

$(function () {
    $.each($('.table-row'), function (index) {
        $('.confirm-delete')[index].onclick = function (e) {
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            })

            $.ajax({
                url: this.dataset.url,
                method: 'DELETE',
                success: function success(data) {
                    $('body').append(`
                                <div class="toast noti text-success" data-delay="5000">
                                    <div class="toast-header">
                                        <strong class="mr-auto">${data.title}</strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                    </div>
                                    <div class="toast-body">
                                        ${data.msg}
                                    </div>
                                </div>
                                `)
                    $('.toast').toast('show');

                    $('.table-row')[index].remove()
                }
            })
        }
    })
})

function getItemsAmount() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    })

    $.ajax({
        url: $('#item-amount-url').val(),
        method: 'GET',
        success: function success(data) {
            $('#item-number').html(data);
        }
    })
}

$(getItemsAmount())

$(function () {
    $('#add-to-cart').on('click', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        })

        var input = {
            'user_id': $('input[name="user_id"]').val(),
            'book_id': $('input[name="book_id"]').val(),
            'quantity': 1,
        }

        $.ajax({
            url: $('#add-to-cart-url').val(),
            method: 'POST',
            data: input,
            success: function success(data) {
                $('body').append(`
                            <div class="toast noti text-success" data-delay="5000">
                                <div class="toast-header">
                                    <strong class="mr-auto">${data.title}</strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                                </div>
                                <div class="toast-body">
                                    ${data.msg}
                                </div>
                            </div>
                            `)
                $('.toast').toast('show');
            }
        });

        getItemsAmount()
    })
})
