<?php

namespace Tests\Feature;

use App\Http\Controllers\MeusDadosController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MeusDadosControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_returns_correct_view()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('meus-dados'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.meus-dados');
        $response->assertViewHas('user', $user);
    }

    #[Test]
    public function unauthenticated_users_are_redirected_to_login()
    {
        $response = $this->get(route('meus-dados'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function meus_dados_page_has_required_livewire_components()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('meus-dados'));

        $response->assertSeeLivewire('personal-data-form');
        $response->assertSeeLivewire('profile-progress-bar');
    }
}
