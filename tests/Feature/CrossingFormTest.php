<?php

namespace Tests\Feature;

use App\Livewire\CrossingForm;
use App\Models\Crossing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CrossingFormTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function component_can_render()
    {
        $user = User::factory()->create();

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->assertViewIs('livewire.crossing-form');
    }

    /** @test */
    public function can_add_new_crossing()
    {
        $user = User::factory()->create();

        $crossingData = [
            'entity' => 'Entidade de Teste',
            'date' => now()->format('Y-m-d'),
            'purpose' => 'Propósito de teste',
        ];

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->set('entity', $crossingData['entity'])
            ->set('date', $crossingData['date'])
            ->set('purpose', $crossingData['purpose'])
            ->call('save')
            ->assertDispatched('profile-updated');

        $this->assertDatabaseHas('crossings', [
            'user_id' => $user->id,
            'entity' => $crossingData['entity'],
            'purpose' => $crossingData['purpose'],
        ]);
    }

    /** @test */
    public function can_delete_crossing()
    {
        $user = User::factory()->create();
        $crossing = Crossing::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Entidade Teste',
            'date' => now(),
            'purpose' => 'Propósito Teste',
        ]);

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->call('deleteCrossing', $crossing->id);

        $this->assertModelMissing($crossing);
    }

    /** @test */
    public function cannot_delete_crossing_of_different_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $crossing = Crossing::factory()->create([
            'user_id' => $user2->id,
            'entity' => 'Entidade Teste',
            'date' => now(),
            'purpose' => 'Propósito Teste',
        ]);

        Livewire::test(CrossingForm::class, ['user' => $user1])
            ->call('deleteCrossing', $crossing->id);

        $this->assertModelExists($crossing);
    }

    /** @test */
    public function fields_are_reset_after_saving()
    {
        $user = User::factory()->create();

        $crossingData = [
            'entity' => 'Entidade de Teste',
            'date' => now()->format('Y-m-d'),
            'purpose' => 'Propósito de teste',
        ];

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->set('entity', $crossingData['entity'])
            ->set('date', $crossingData['date'])
            ->set('purpose', $crossingData['purpose'])
            ->call('save')
            ->assertSet('entity', '')
            ->assertSet('date', '')
            ->assertSet('purpose', '');
    }

    /** @test */
    public function validates_required_fields()
    {
        $user = User::factory()->create();

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->set('entity', '')
            ->set('date', '')
            ->set('purpose', '')
            ->call('save')
            ->assertHasErrors(['entity', 'date', 'purpose']);
    }

    /** @test */
    public function can_view_existing_crossings()
    {
        $user = User::factory()->create();

        $crossing1 = Crossing::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Entidade 1',
            'date' => now()->subDays(5),
            'purpose' => 'Propósito 1',
        ]);

        $crossing2 = Crossing::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Entidade 2',
            'date' => now()->subDays(10),
            'purpose' => 'Propósito 2',
        ]);

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->assertViewHas('crossings', function ($crossings) use ($user) {
                return $crossings->count() === 2 &&
                    $crossings->contains('id', $user->crossings->first()->id) &&
                    $crossings->contains('id', $user->crossings->last()->id);
            });
    }

    /** @test */
    public function crossings_are_ordered_by_date_desc()
    {
        $user = User::factory()->create();

        $oldCrossing = Crossing::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Entidade 1',
            'date' => now()->subDays(10),
            'purpose' => 'Propósito 1',
        ]);

        $newCrossing = Crossing::factory()->create([
            'user_id' => $user->id,
            'entity' => 'Entidade 2',
            'date' => now()->subDays(5),
            'purpose' => 'Propósito 2',
        ]);

        Livewire::test(CrossingForm::class, ['user' => $user])
            ->assertViewHas('crossings', function ($crossings) use ($newCrossing) {
                return $crossings->first()->id === $newCrossing->id;
            });
    }
}
