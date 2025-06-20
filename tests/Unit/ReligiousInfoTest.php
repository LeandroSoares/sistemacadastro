<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\ReligiousInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReligiousInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_religious_info()
    {
        $user = User::factory()->create();

        $religiousInfo = ReligiousInfo::factory()->create([
            'user_id' => $user->id,
            'start_date' => '2015-01-15',
            'start_location' => 'São Paulo',
            'charity_house_start' => '2015-03-01',
            'charity_house_end' => '2020-12-31',
            'charity_house_observations' => 'Participação ativa em trabalhos espirituais',
            'development_start' => '2016-05-10',
            'development_end' => '2018-06-20',
            'service_start' => '2018-07-01',
            'umbanda_baptism' => '2016-06-15',
            'cambone_experience' => true,
            'cambone_start_date' => '2015-04-01',
            'cambone_end_date' => '2017-10-31'
        ]);

        $this->assertDatabaseHas('religious_infos', [
            'user_id' => $user->id,
            'start_date' => '2015-01-15',
            'start_location' => 'São Paulo',
            'charity_house_start' => '2015-03-01',
            'charity_house_end' => '2020-12-31',
            'charity_house_observations' => 'Participação ativa em trabalhos espirituais',
            'development_start' => '2016-05-10',
            'development_end' => '2018-06-20',
            'service_start' => '2018-07-01',
            'umbanda_baptism' => '2016-06-15',
            'cambone_experience' => true,
            'cambone_start_date' => '2015-04-01',
            'cambone_end_date' => '2017-10-31'
        ]);

        $this->assertEquals($user->id, $religiousInfo->user_id);
        $this->assertEquals('2015-01-15', $religiousInfo->start_date);
        $this->assertEquals('São Paulo', $religiousInfo->start_location);
        $this->assertEquals('2015-03-01', $religiousInfo->charity_house_start);
        $this->assertEquals('2020-12-31', $religiousInfo->charity_house_end);
        $this->assertEquals('Participação ativa em trabalhos espirituais', $religiousInfo->charity_house_observations);
        $this->assertEquals('2016-05-10', $religiousInfo->development_start);
        $this->assertEquals('2018-06-20', $religiousInfo->development_end);
        $this->assertEquals('2018-07-01', $religiousInfo->service_start);
        $this->assertEquals('2016-06-15', $religiousInfo->umbanda_baptism);
        $this->assertTrue($religiousInfo->cambone_experience);
        $this->assertEquals('2015-04-01', $religiousInfo->cambone_start_date);
        $this->assertEquals('2017-10-31', $religiousInfo->cambone_end_date);
    }

    public function test_can_update_religious_info()
    {
        $religiousInfo = ReligiousInfo::factory()->create();

        $religiousInfo->update([
            'start_location' => 'Rio de Janeiro',
            'development_start' => '2017-06-15'
        ]);

        $this->assertDatabaseHas('religious_infos', [
            'id' => $religiousInfo->id,
            'start_location' => 'Rio de Janeiro',
            'development_start' => '2017-06-15'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $religiousInfo = ReligiousInfo::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $religiousInfo->user);
        $this->assertEquals($user->id, $religiousInfo->user->id);
    }

    public function test_completion_rate_calculation()
    {
        // Cria informações religiosas completas
        $completeInfo = ReligiousInfo::factory()->create([
            'start_date' => '2015-01-15',
            'start_location' => 'São Paulo',
            'development_start' => '2016-05-10'
        ]);

        $this->assertEquals(100, $completeInfo->getCompletionRate());

        // Cria informações religiosas parciais
        $partialInfo = ReligiousInfo::factory()->create([
            'start_date' => '2015-01-15',
            'start_location' => null,
            'development_start' => null
        ]);

        $this->assertEquals(35, $partialInfo->getCompletionRate());
    }

    public function test_factory_with_cambone_experience_state()
    {
        $religiousInfo = ReligiousInfo::factory()->withCamboneExperience()->create();

        $this->assertTrue($religiousInfo->cambone_experience);
        $this->assertNotNull($religiousInfo->cambone_start_date);
    }

    public function test_factory_without_cambone_experience_state()
    {
        $religiousInfo = ReligiousInfo::factory()->withoutCamboneExperience()->create();

        $this->assertFalse($religiousInfo->cambone_experience);
        $this->assertNull($religiousInfo->cambone_start_date);
        $this->assertNull($religiousInfo->cambone_end_date);
    }

    public function test_factory_minimal_state()
    {
        $religiousInfo = ReligiousInfo::factory()->minimal()->create();

        $this->assertNotNull($religiousInfo->start_date);
        $this->assertNotNull($religiousInfo->start_location);
        $this->assertNotNull($religiousInfo->development_start);
    }
}
