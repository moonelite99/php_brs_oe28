<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_change_language_en()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->mouseover('#language-link')
                ->click('#en')
                ->assertPathIs(env('APP_PREFIX_URL') . '/login')
                ->assertSeeIn('.card-header', 'Login')
                ->assertSeeIn('#login-form', 'Username')
                ->assertSeeIn('#login-form', 'Password')
                ->assertSeeIn('#login-form', 'Remember me');
        });
    }

    public function test_change_language_vi()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->mouseover('#language-link')
                ->click('#vi')
                ->assertPathIs(env('APP_PREFIX_URL') . '/login')
                ->assertSeeIn('.card-header', 'Đăng nhập')
                ->assertSeeIn('#login-form', 'Tên đăng nhập')
                ->assertSeeIn('#login-form', 'Mật khẩu')
                ->assertSeeIn('#login-form', 'Ghi nhớ đăng nhập');
        });
    }

    public function test_click_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->click('#register-btn')
                ->assertPathIs(env('APP_PREFIX_URL') . '/register');
        });
    }

    public function test_login_fail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->type('username', 'moon')
                ->type('password', '1235')
                ->press('#login-btn')
                ->assertPathIs(env('APP_PREFIX_URL') . '/login');
        });
    }

    public function test_login_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->type('username', 'moon')
                ->type('password', '123')
                ->press('#login-btn')
                ->assertPathIs(env('APP_PREFIX_URL') . '/home');
        });
    }
}
