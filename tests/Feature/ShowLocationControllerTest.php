<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShowLocationControllerTest extends TestCase
{
    use DatabaseTransactions;


    public function testGetOverview()
    {
        $response = $this->get('/api/location/1/');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'resource',
                'name',
                'equipment',
                'created_at',
                'updated_at',

            ],
        ]);

        $location = Location::find(1);
        $this->assertEquals($location->equipment()->count(), count($response->json()['data']['equipment']));

        $response->assertStatus(200);
    }

    public function testGetDayViewNoBookings()
    {
        $response = $this->get('/api/location/1/?date=2020-01-12');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'resource',
                'name',
                'availableEquipment',
                'unavailableEquipment',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertEquals(0, count($response->json()['data']['unavailableEquipment']));

        $response->assertStatus(200);
    }

    public function testGetDayViewWithBookings()
    {
        /** @var Location $location */
        $location = Location::find(1);

        $equipment = $location->equipment()->first();

        Booking::create([
            'location_id' => $location->id,
            'equipment_id' => $equipment->id,
            'booked_at' => '2020-01-12',
        ]);

        $response = $this->get('/api/location/1/?date=2020-01-12');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'resource',
                'name',
                'availableEquipment',
                'unavailableEquipment',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertEquals(1, count($response->json()['data']['unavailableEquipment']));

        $response->assertStatus(200);
    }
}
