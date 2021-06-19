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

$(function (){
  $('.toast').toast('show');
});

$(function (){
  $('[data-toggle="tooltip"]').tooltip();
});

$(function (){
    $.each($('.book-price'), function (index, value){
        $('.book-price')[index].innerText = Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format($('.book-price')[index].innerText)
    })
});

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
    $('#add-to-cart').on('click', function (){
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
          });

        getItemsAmount()
    })
})
