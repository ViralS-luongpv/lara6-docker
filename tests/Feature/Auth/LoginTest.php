<?php


namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(\App\Models\ViralsUser::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(\App\Models\ViralsUser::class)->create([
            'password' => bcrypt($password = '123456789'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(\App\Models\ViralsUser::class)->create([
        'password' => bcrypt('123456789'),
    ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => '11111111',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_user_can_logout() {
        $user = factory(\App\Models\ViralsUser::class)->create([
            'password' => bcrypt($password = '123456789'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');

        $response = $this->actingAs($user)->post('/logout');
        $response->assertRedirect('/');
    }

    public function test_user_can_not_access_to_uri()
    {
        $user = factory(\App\Models\ViralsUser::class)->create([
            'password' => bcrypt($password = '123456789'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');

        $response = $this->actingAs($user)->get('/admin/permission');
        $response->assertNotFound();
    }

    public function test_user_has_permission_can_access_to_uri()
    {
        $user = \App\Models\ViralsUser::first();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '123456789',
        ]);
        $response->assertRedirect('/home');

        $response = $this->actingAs($user)->get('/admin/permission');
        $response->assertViewIs('virals-permission::admin.permissions.index');
    }

    public function test_user_can_access_to_uri_is_not_permission()
    {
        $user = factory(\App\Models\ViralsUser::class)->create([
            'password' => bcrypt($password = '123456789'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');

        $response = $this->actingAs($user)->get('/home');
        $response->assertViewIs('home');
    }

    public function test_user_can_access_to_uri_if_not_credentials()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }
}