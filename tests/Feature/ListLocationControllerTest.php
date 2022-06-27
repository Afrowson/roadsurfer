<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ListLocationControllerTest extends TestCase
{
    use DatabaseTransactions;


    public function testGetOverviewList()
    {
        $response = $this->get('/api/location');

        $this->assertEquals(Location::all()->count(), count($response->json()['data']));

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'resource',
                    'name',
                    'equipmentOne',
                    'equipmentTwo',
                    'equipmentThree',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);

        $response->assertStatus(200);
    }
}
