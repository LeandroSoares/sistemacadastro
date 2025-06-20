<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\PriestlyFormation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PriestlyFormationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_priestly_formation()
    {
        $user = User::factory()->create();

        $priestlyFormation = PriestlyFormation::factory()->create([
            'user_id' => $user->id,
            'theology_start' => '2015-01-15',
            'theology_end' => '2018-12-20',
            'priesthood_start' => '2019-02-10',
            'priesthood_end' => '2022-06-30'
        ]);

        $this->assertDatabaseHas('priestly_formations', [
            'user_id' => $user->id,
            'theology_start' => '2015-01-15',
            'theology_end' => '2018-12-20',
            'priesthood_start' => '2019-02-10',
            'priesthood_end' => '2022-06-30'
        ]);

        $this->assertEquals($user->id, $priestlyFormation->user_id);
        $this->assertEquals('2015-01-15', $priestlyFormation->theology_start);
        $this->assertEquals('2018-12-20', $priestlyFormation->theology_end);
        $this->assertEquals('2019-02-10', $priestlyFormation->priesthood_start);
        $this->assertEquals('2022-06-30', $priestlyFormation->priesthood_end);
    }

    public function test_can_update_priestly_formation()
    {
        $priestlyFormation = PriestlyFormation::factory()->create();

        $priestlyFormation->update([
            'theology_end' => '2020-01-15',
            'priesthood_end' => '2023-06-20'
        ]);

        $this->assertDatabaseHas('priestly_formations', [
            'id' => $priestlyFormation->id,
            'theology_end' => '2020-01-15',
            'priesthood_end' => '2023-06-20'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $priestlyFormation = PriestlyFormation::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $priestlyFormation->user);
        $this->assertEquals($user->id, $priestlyFormation->user->id);
    }

    public function test_completion_rate_calculation()
    {
        // Formação completa
        $completeFormation = PriestlyFormation::factory()->create([
            'theology_start' => '2015-01-15',
            'theology_end' => '2018-12-20',
            'priesthood_start' => '2019-02-10',
            'priesthood_end' => '2022-06-30'
        ]);

        $this->assertEquals(100, $completeFormation->getCompletionRate());

        // Formação parcial
        $partialFormation = PriestlyFormation::factory()->create([
            'theology_start' => '2015-01-15',
            'theology_end' => null,
            'priesthood_start' => '2019-02-10',
            'priesthood_end' => null
        ]);

        $this->assertEquals(70, $partialFormation->getCompletionRate());
    }

    public function test_factory_minimal_state()
    {
        $priestlyFormation = PriestlyFormation::factory()->minimal()->create();

        $this->assertNotNull($priestlyFormation->theology_start);
        $this->assertNull($priestlyFormation->theology_end);
        $this->assertNotNull($priestlyFormation->priesthood_start);
        $this->assertNull($priestlyFormation->priesthood_end);
    }

    public function test_factory_ongoing_priesthood_state()
    {
        $priestlyFormation = PriestlyFormation::factory()->ongoingPriesthood()->create();

        $this->assertNotNull($priestlyFormation->priesthood_start);
        $this->assertNull($priestlyFormation->priesthood_end);
    }

    public function test_factory_complete_state()
    {
        $priestlyFormation = PriestlyFormation::factory()->complete()->create();

        $this->assertNotNull($priestlyFormation->theology_start);
        $this->assertNotNull($priestlyFormation->theology_end);
        $this->assertNotNull($priestlyFormation->priesthood_start);
        $this->assertNotNull($priestlyFormation->priesthood_end);
    }
}
