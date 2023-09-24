<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Candidate;

class TestCandidate extends TestCase
{
    public function testGetAllCandidates()
    {
        $user = User::find(1);

        $token = $this->post('/api/auth', ['username' => $user->username, 'password' => '1234']); 

        $candidates = Candidate::factory(3)->create();

        $response = $this->get('/api/leads', ['Authorization' => 'Bearer ' . $token['data']['token']]);

        $response->assertStatus(200);

        foreach ($candidates as $candidate) {
            $response->assertJsonFragment([
                'id' => $candidate->id,
                'name' => $candidate->name,
                
            ]);
        }
    }

    public function testGetDetailCandidates()
    {
        $user = User::find(1);

        $token = $this->post('/api/auth', ['username' => $user->username, 'password' => '1234']); 

        $candidate = Candidate::factory()->create();

        $response = $this->get('/api/lead/' . $candidate->id, ['Authorization' => 'Bearer ' . $token['data']['token']]);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'source' => $candidate->source,
            ],
        ]);
    }
}
