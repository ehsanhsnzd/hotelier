<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Hotel\app\Models\Item;
use Hotel\app\Models\Location;
use Tests\TestCase;

class ItemTest extends TestCase
{
    protected $itemId;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreateItem() {
        $data = [
            'name' => $this->faker->sentence,
            'rating' => $this->faker->numberBetween(0,5),
            'category' => 'hotel',
            'image' => $this->faker->url,
            'reputation' => $this->faker->numberBetween(0,1000),
            'price' => $this->faker->numberBetween(0,500),
            'availability' => $this->faker->numberBetween(0,20),
            'location'=> [
                'city' => $this->faker->city,
                'state' => $this->faker->state,
                'country' => $this->faker->country,
                'zip_code' => '12345',
                'address' => $this->faker->address,
            ]
        ];


       $this->post(route('setItem'), $data,['Accept'=>'application/json'])
            ->assertStatus(200)
            ->assertJson(['data'=>$data]);
    }

    public function testUpdateItem()
    {
        $item = $this->createItem();
        $data = [
            'id'=> $item->id,
            'name' => strtolower($this->faker->name),
            'rating' => $this->faker->numberBetween(0,5),
            'category' => 'hotel',
            'image' => $this->faker->url,
            'reputation' => $this->faker->numberBetween(0,1000),
            'price' => $this->faker->numberBetween(0,500),
            'availability' => $this->faker->numberBetween(1,20),
            'location'=> [
                'city' => $this->faker->city,
                'state' => $this->faker->state,
                'country' => $this->faker->country,
                'zip_code' => '12345',
                'address' => $this->faker->address,
            ]
        ];

        $this->put(route('updateItem'), $data,['Accept'=>'application/json'])
            ->assertStatus(200)
            ->assertJson(['data'=>[$data]]);
    }

    public function testGetItem()
    {
        $item = $this->createItem();
        $this->get(route('getItem',$item->id),['Accept'=>'application/json'])
            ->assertStatus(200)
            ->assertJson(['data'=>$item->toArray()]);
    }

    public function testGetAllItem()
    {
        $this->createItem();
        $this->get(route('allItem'),['Accept'=>'application/json'])
            ->assertStatus(200);
    }

    public function testDeleteItem()
    {
        $item = $this->createItem();
        $this->delete(route('deleteItem',$item->id),['Accept'=>'application/json'])
            ->assertStatus(200)
            ->assertJson([]);

    }

    public function testBookItem()
    {
        $item = $this->createItem();
        $data = [
            'item_id' => $item->id,
            'arrival_date' => Carbon::now()->toDateString(),
            'departure_date' => Carbon::now()->toDateString(),
        ];

        $this->post(route('bookItem'),$data,['Accept'=>'application/json'])
            ->assertStatus(200)
            ->assertJson(['data'=>$data]);
    }

    public function createItem()
    {
        $item = factory(Item::class)->create();
        $location = factory(Location::class)->make();
        $item->location()->create($location->toArray());
        return $item->load('location');
    }
}
