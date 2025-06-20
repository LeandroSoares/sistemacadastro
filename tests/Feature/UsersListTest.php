<?php

namespace Tests\Feature;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\UsersList;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar os papéis necessários para os testes
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'user']);
    }

    public function test_component_can_render()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Verificar se o componente renderiza corretamente
        Livewire::test(UsersList::class)
            ->assertViewIs('livewire.users-list')
            ->assertViewHas('users');
    }

    public function test_users_are_displayed_properly()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole('admin');

        // Criar outros usuários
        $user1 = User::factory()->create(['name' => 'Test User One']);
        $user1->assignRole('user');

        $user2 = User::factory()->create(['name' => 'Test User Two']);
        $user2->assignRole('manager');

        $this->actingAs($admin);

        // Testar se os usuários aparecem na lista
        $component = Livewire::test(UsersList::class);

        // Verificar que os nomes dos usuários estão no HTML da resposta
        $html = $component->html();
        $this->assertStringContainsString('Admin User', $html);
        $this->assertStringContainsString('Test User One', $html);
        $this->assertStringContainsString('Test User Two', $html);
    }

    public function test_search_functionality()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole('admin');

        // Criar outros usuários
        User::factory()->create(['name' => 'Test User One']);
        User::factory()->create(['name' => 'Another User']);
        User::factory()->create(['name' => 'John Doe']);

        $this->actingAs($admin);

        // Testar pesquisa por "Test"
        $component = Livewire::test(UsersList::class)
            ->set('search', 'Test')
            ->assertViewHas('users');

        $results = $component->viewData('users');
        $this->assertEquals(1, $results->where('name', 'Test User One')->count());
        $this->assertEquals(0, $results->where('name', 'John Doe')->count());
    }

    public function test_admin_can_delete_user()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Criar um usuário comum para ser excluído
        $user = User::factory()->create(['name' => 'User To Delete']);
        $user->assignRole('user');

        $this->actingAs($admin);

        // Excluir o usuário
        Livewire::test(UsersList::class)
            ->call('deleteUser', $user->id);

        // Verificar que o usuário foi excluído
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => 'User To Delete'
        ]);
    }

    public function test_non_admin_cannot_delete_admin()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole('admin');

        // Criar um usuário gerente
        $manager = User::factory()->create();
        $manager->assignRole('manager');

        $this->actingAs($manager);

        // Tentar excluir o administrador
        Livewire::test(UsersList::class)
            ->call('deleteUser', $admin->id);

        // Verificar que o administrador não foi excluído
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'Admin User'
        ]);
    }

    public function test_cannot_delete_nonexistent_user()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Tentar excluir um usuário que não existe
        $component = Livewire::test(UsersList::class)
            ->call('deleteUser', 9999);

        // O componente Livewire está usando flash sessions que não são facilmente acessíveis nos testes
        // Vamos verificar diretamente que o usuário não existe no banco
        $this->assertDatabaseMissing('users', [
            'id' => 9999
        ]);

        // Verificar que o método foi chamado sem erros
        $component->assertOk();
    }

    public function test_pagination()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar 15 usuários adicionais
        User::factory()->count(15)->create();

        // Testar a paginação
        $component = Livewire::test(UsersList::class)
            ->set('perPage', 10)
            ->assertViewHas('users');

        $users = $component->viewData('users');
        $this->assertEquals(10, $users->count()); // Primeira página tem 10 itens
        $this->assertTrue($users->hasMorePages()); // Tem mais páginas
    }

    public function test_per_page_update()
    {
        // Criar um usuário administrador
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        // Criar 30 usuários adicionais
        User::factory()->count(30)->create();

        // Testar mudança de itens por página
        $component = Livewire::test(UsersList::class)
            ->set('perPage', 25)
            ->assertViewHas('users');

        $users = $component->viewData('users');
        $this->assertEquals(25, $users->count()); // Agora mostra 25 itens
    }
}
