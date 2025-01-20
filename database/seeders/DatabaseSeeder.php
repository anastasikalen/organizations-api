<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $building1 = Building::create([
            'address' => 'г. Москва, ул. Ленина 1, офис 3',
            'latitude' => 55.7558,
            'longitude' => 37.6173
        ]);

        $building2 = Building::create([
            'address' => 'г. Санкт-Петербург, Невский пр., 10',
            'latitude' => 59.9343,
            'longitude' => 30.3351
        ]);

        $activityFood = Activity::create(['name' => 'Еда']);
        $activityMeat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $activityFood->id]);
        $activityMilk = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $activityFood->id]);
        $activityAuto = Activity::create(['name' => 'Автомобили']);
        $activityTrucks = Activity::create(['name' => 'Грузовые', 'parent_id' => $activityAuto->id]);
        $activityCars = Activity::create(['name' => 'Легковые', 'parent_id' => $activityAuto->id]);
        $activityParts = Activity::create(['name' => 'Запчасти', 'parent_id' => $activityCars->id]);
        $activityAccessories = Activity::create(['name' => 'Аксессуары', 'parent_id' => $activityCars->id]);

        $organization1 = Organization::create([
            'name' => 'ООО “Рога и Копыта”',
            'building_id' => $building1->id
        ]);
        
        $organization2 = Organization::create([
            'name' => 'ЗАО “АвтоМир”',
            'building_id' => $building2->id
        ]);
        
        $organization3 = Organization::create([
            'name' => 'ИП “Фермерские продукты”',
            'building_id' => $building1->id
        ]);
        
        $organization1->activities()->attach([$activityFood->id, $activityMeat->id]);
        $organization2->activities()->attach([$activityAuto->id, $activityCars->id, $activityParts->id]);
        $organization3->activities()->attach([$activityFood->id, $activityMilk->id]);

        $organization1->phones()->createMany([
            ['phone' => '2-222-222'],
            ['phone' => '3-333-333'],
            ['phone' => '8-923-666-13-13'],
        ]);

        $organization2->phones()->createMany([
            ['phone' => '4-444-444'],
            ['phone' => '5-555-555'],
        ]);

        $organization3->phones()->createMany([
            ['phone' => '6-666-666'],
            ['phone' => '7-777-777'],
        ]);
    }
}
