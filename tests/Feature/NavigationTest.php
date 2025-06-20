<?php

namespace Tests\Feature;

use App\Livewire\Layout\Navigation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class NavigationTest extends TestCase
{
    use RefreshDatabase;    protected function setUp(): void
    {
        parent::setUp();

        // Definir o locale para pt_BR explicitamente
        app()->setLocale('pt_BR');

        // Criar os papéis necessários para os testes
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
    }

    #[Test]
    public function navigation_component_shows_correct_menu_items_for_regular_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(Navigation::class)
            ->assertViewHas('route_list', ['home', 'meus-dados', 'courses.index', 'orishas.index'])
            ->assertSeeHtml('Início')
            ->assertSeeHtml('Meus Dados')
            ->assertSeeHtml('Cursos')
            ->assertSeeHtml('Orixás')
            ->assertDontSeeHtml('Usuários');
    }

    #[Test]
    public function navigation_component_shows_admin_menu_items_for_admin()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        Livewire::test(Navigation::class)
            ->assertViewHas('route_list', ['home', 'meus-dados', 'courses.index', 'orishas.index', 'users.index'])
            ->assertSeeHtml('Início')
            ->assertSeeHtml('Meus Dados')
            ->assertSeeHtml('Cursos')
            ->assertSeeHtml('Orixás')
            ->assertSeeHtml('Usuários');
    }

    #[Test]
    public function navigation_component_shows_manager_menu_items_for_manager()
    {
        $manager = User::factory()->create();
        $manager->assignRole('manager');

        $this->actingAs($manager);

        Livewire::test(Navigation::class)
            ->assertViewHas('route_list', ['home', 'meus-dados', 'courses.index', 'orishas.index', 'users.index'])
            ->assertSeeHtml('Início')
            ->assertSeeHtml('Meus Dados')
            ->assertSeeHtml('Cursos')
            ->assertSeeHtml('Orixás')
            ->assertSeeHtml('Usuários');
    }

    #[Test]
    public function navigation_component_has_logout_functionality()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(Navigation::class)
            ->assertSeeHtml('Sair') // Verificando a tradução correta
            ->call('logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    #[Test]
    public function navigation_shows_translated_menu_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Vamos fazer um teste de integração real para ver se as traduções aparecem no HTML renderizado
        $response = $this->get(route('home'));

        // Este teste vai verificar se o HTML do menu contém as traduções
        $response->assertStatus(200);
        $response->assertSee('Início');
        $response->assertSee('Meus Dados');
        $response->assertSee('Cursos');
        $response->assertSee('Orixás');
    }

    #[Test]
    public function navigation_shows_correct_translations_with_locale_set()
    {
        // Definir o locale para pt_BR explicitamente
        app()->setLocale('pt_BR');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Teste com componente Livewire diretamente
        Livewire::test(Navigation::class)
            ->assertSeeHtml('Início')
            ->assertSeeHtml('Meus Dados')
            ->assertSeeHtml('Cursos')
            ->assertSeeHtml('Orixás');
    }
}
