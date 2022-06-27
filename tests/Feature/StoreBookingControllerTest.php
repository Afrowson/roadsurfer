<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StoreBookingControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreBooking()
    {
        $response = $this->post('/api/booking/', [
            'equipmentId' => 1,
            'bookedFrom'  => '2022-01-05',
            'bookedTo'    => '2022-01-07',
        ]);

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'resource',
                    'bookedAt',
                    'equipment' => [
                        'id',
                        'resource',
                        'type',
                        'valueOne',
                        'valueTwo',
                        'created_at',
                        'updated_at',
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]
        ]);
        $this->assertEquals(3, count($response->json()['data']));

        $locationId = Equipment::find(1)->location_id;
        $this->assertDatabaseHas('bookings', [
            'equipment_id' => 1,
            'location_id'  => $locationId,
            'booked_at'    => '2022-01-05'
        ]);
        $this->assertDatabaseHas('bookings', [
            'equipment_id' => 1,
            'location_id'  => $locationId,
            'booked_at'    => '2022-01-06'
        ]);
        $this->assertDatabaseHas('bookings', [
            'equipment_id' => 1,
            'location_id'  => $locationId,
            'booked_at'    => '2022-01-07'
        ]);

        $response->assertStatus(200);
    }

    public function testValidationFailed()
    {
        $response = $this->post('/api/booking/', [
            'equipmentId' => 1,
            'bookedFrom'  => '2022-101-04',
            'bookedTo'    => '2022-01-07',
        ]);

        $response->assertJson([
            "errors" => [
                "bookedFrom" => ["The booked from is not a valid date."],
            ]
        ]);

        $response = $this->post('/api/booking/', [
            'equipmentId' => 1,
            'bookedFrom'  => '2022-01-04',
            'bookedTo'    => '2022-01-03',
        ]);

        $response->assertJson([
            "errors" => [
                "bookedTo" => ["The booked to must be a date after booked from."]
            ]
        ]);


        $response->assertStatus(422);
    }

    public function testDoubleBookingFailed()
    {
        /** @var Location $location */
        $location = Location::find(1);

        $equipment = $location->equipment()->first();

        Booking::create([
            'location_id'  => $location->id,
            'equipment_id' => $equipment->id,
            'booked_at'    => '2022-01-06',
        ]);


        $response = $this->post('/api/booking/', [
            'equipmentId' => 1,
            'bookedFrom'  => '2022-01-04',
            'bookedTo'    => '2022-01-07',
        ]);

        $response->assertJson([
            'error' => 'This Equipment has already been booked for this day'
        ]);
    }
}
