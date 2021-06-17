let logoutbtn = document.getElementById('logout');
let rate_1 = document.getElementById("rate-1");
let rate_2 = document.getElementById("rate-2");
let rate_3 = document.getElementById("rate-3");
let rate_4 = document.getElementById("rate-4");
let rate_5 = document.getElementById("rate-5");

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

function logout() {
    event.preventDefault();
    document.getElementById('logout-form').submit();
}

document.getElementById("en").onclick = en;
document.getElementById("vi").onclick = vi;

function en() {
    document.getElementById('locale').value = 'en';
    document.getElementById('language-form').submit();
}

function vi() {
    document.getElementById('locale').value = 'vi';
    document.getElementById('language-form').submit();
}

$(document).ready(function () {
    $('.toast').toast('show');
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(function () {
    console.log($('.book-price')[0].innerText);
});


