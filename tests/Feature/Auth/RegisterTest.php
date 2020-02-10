<?php


namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    public function test_user_can_view_a_register_form()
    {
        $response = $this->get('/register');

        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    public function test_user_cannot_view_a_register_form_when_authenticated()
    {
        $user = factory(\App\Models\ViralsUser::class)->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/home');
    }

    public function test_user_can_register_with_correct_form()
    {
        $user = [
            'name' => 'Joe',
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ];

        $response = $this->post('/register', $user);
        $response
            ->assertRedirect('/home');

        //Remove password and password_confirmation from array
        array_splice($user,2, 2);

        $this->assertDatabaseHas('users', $user);
    }
//
//    public function test_user_cannot_login_with_incorrect_password()
//    {
//        $user = factory(\App\Models\ViralsUser::class)->create([
//            'password' => bcrypt('123456789'),
//        ]);
//
//        $response = $this->from('/login')->post('/login', [
//            'email' => $user->email,
//            'password' => '11111111',
//        ]);
//
//        $response->assertRedirect('/login');
//        $response->assertSessionHasErrors('email');
//        $this->assertTrue(session()->hasOldInput('email'));
//        $this->assertFalse(session()->hasOldInput('password'));
//        $this->assertGuest();
//    }
//
//    public function test_user_can_logout() {
//        $user = factory(\App\Models\ViralsUser::class)->create([
//            'password' => bcrypt($password = '123456789'),
//        ]);
//        $response = $this->post('/login', [
//            'email' => $user->email,
//            'password' => $password,
//        ]);
//        $response->assertRedirect('/home');
//
//        $response = $this->actingAs($user)->post('/logout');
//        $response->assertRedirect('/');
//    }
}