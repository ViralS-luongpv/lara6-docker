<?php

namespace Tests\Feature\Auth;

use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithFaker;
use Notification;
use Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use WithFaker;

    const ROUTE_PASSWORD_EMAIL = 'password.email';
    const ROUTE_PASSWORD_REQUEST = 'password.request';
    const ROUTE_PASSWORD_RESET = 'password.reset';
    const ROUTE_PASSWORD_RESET_SUBMIT = 'password.reset.submit';

    const USER_ORIGINAL_PASSWORD = 'secret';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /**
     * Testing showing the password reset request page.
     */
    public function test_user_can_view_a_reset_password_form()
    {
        $this
            ->get(route(self::ROUTE_PASSWORD_REQUEST))
            ->assertSuccessful()
            ->assertViewIs('auth.passwords.email');
    }

    public function test_submit_password_reset_request_invalid_email()
    {
        $response = $this->from(route(self::ROUTE_PASSWORD_REQUEST))->post(route(self::ROUTE_PASSWORD_EMAIL), [
            'email' => $this->faker->email,
        ]);

        $response->assertRedirect('/password/reset');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertGuest();
    }

    public function testSubmitPasswordResetRequest()
    {
        $user = factory(\App\Models\ViralsUser::class)->create();

        $response = $this->from(route(self::ROUTE_PASSWORD_REQUEST))->post(route(self::ROUTE_PASSWORD_EMAIL), [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * Testing showing the reset password page.
     */
    public function testShowPasswordResetPage()
    {
        $user = factory(\App\Models\ViralsUser::class)->create();

        $token = Password::broker()->createToken($user);

        $response = $this
            ->get(route(self::ROUTE_PASSWORD_RESET, [
                'token' => $token,
            ]));
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.reset');
    }
}
