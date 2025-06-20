<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\HeadOrisha;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HeadOrishaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_head_orisha()
    {
        $user = User::factory()->create();

        $headOrisha = HeadOrisha::factory()->create([
            'user_id' => $user->id,
            'ancestor' => 'Oxalá',
            'front' => 'Oxum',
            'front_together' => true,
            'adjunct' => 'Ogum',
            'adjunct_together' => false,
            'left_side' => 'Exu Guardião',
            'left_side_together' => false,
            'right_side' => 'Oxóssi',
            'right_side_together' => true
        ]);

        $this->assertDatabaseHas('head_orishas', [
            'user_id' => $user->id,
            'ancestor' => 'Oxalá',
            'front' => 'Oxum',
            'front_together' => true,
            'adjunct' => 'Ogum',
            'adjunct_together' => false,
            'left_side' => 'Exu Guardião',
            'left_side_together' => false,
            'right_side' => 'Oxóssi',
            'right_side_together' => true
        ]);

        $this->assertEquals($user->id, $headOrisha->user_id);
        $this->assertEquals('Oxalá', $headOrisha->ancestor);
        $this->assertEquals('Oxum', $headOrisha->front);
        $this->assertTrue($headOrisha->front_together);
        $this->assertEquals('Ogum', $headOrisha->adjunct);
        $this->assertFalse($headOrisha->adjunct_together);
        $this->assertEquals('Exu Guardião', $headOrisha->left_side);
        $this->assertFalse($headOrisha->left_side_together);
        $this->assertEquals('Oxóssi', $headOrisha->right_side);
        $this->assertTrue($headOrisha->right_side_together);
    }

    public function test_can_update_head_orisha()
    {
        $headOrisha = HeadOrisha::factory()->create();

        $headOrisha->update([
            'ancestor' => 'Iemanjá',
            'front' => 'Xangô'
        ]);

        $this->assertDatabaseHas('head_orishas', [
            'id' => $headOrisha->id,
            'ancestor' => 'Iemanjá',
            'front' => 'Xangô'
        ]);
    }

    public function test_belongs_to_user_relationship()
    {
        $user = User::factory()->create();
        $headOrisha = HeadOrisha::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $headOrisha->user);
        $this->assertEquals($user->id, $headOrisha->user->id);
    }

    public function test_head_orisha_completion_rate()
    {
        $headOrisha = HeadOrisha::factory()->create([
            'ancestor' => 'Oxalá',
            'front' => 'Oxum',
            'adjunct' => 'Ogum',
            'left_side' => 'Exu Guardião',
            'right_side' => 'Oxóssi'
        ]);

        $this->assertEquals(100, $headOrisha->getCompletionRate());

        $incompleteHeadOrisha = HeadOrisha::factory()->create([
            'ancestor' => 'Oxalá',
            'front' => null,
            'adjunct' => null,
            'left_side' => null,
            'right_side' => null
        ]);

        $this->assertEquals(30, $incompleteHeadOrisha->getCompletionRate());
    }
}
