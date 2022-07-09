<?php

namespace Tests\Feature;

use App\Language;


use App\Content;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class WebappTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseMigrations;
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function testWelcomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testAdminLogin()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('test')
        ]);
        $this->assertFalse(Auth::check());
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'test',
            'admin_bool'=>1
        ]);
        $this->assertTrue(Auth::check());
        $response->assertRedirect('home');
    }
    public function testUserLogin(){
        $user = factory(User::class)->create([
            'password' => bcrypt('test')
        ]);
        $this->assertFalse(Auth::check());
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'test',
            'admin_bool'=>0
        ]);
        $this->assertTrue(Auth::check());
        session(['user'=>$response]);
        redirect()->action('WebappController@index');
        $response->assertRedirect('webapp');
    }
    public function testContent()
    {
        $id=1;
        $content='content';
        $color_code='#000000';
        $data= [
            'id'=>$id,
            'content'=>$content,
            'color_code'=>$color_code,
        ];
        factory(Content::class)->create();
        $this->assertDatabaseHas('contents', $data);
    }
    public function testLanguage()
    {
        $id = 1;
        $language = 'language';
        $color_code = '#000000';
        $data=[
            'id' => $id,
            'language' => $language,
            'color_code' => $color_code,
        ];
        factory(Language::class,1)->create();
        $this->assertDatabaseHas('languages', $data);
    }
}
