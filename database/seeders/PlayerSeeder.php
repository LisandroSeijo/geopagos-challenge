<?php

namespace Database\Seeders;

use ATP\Repositories\PersistRepository;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use ATP\Entities\Player;
use ATP\Entities\Gender;

class PlayerSeeder extends Seeder
{
    private PersistRepository $persistRepository;
    public function __construct(PersistRepository $persistRepository) {
        $this->persistRepository = $persistRepository;
    }

    public function run(): void
    {
        $faker = Faker::create(); 
        
        foreach(range(1, 100) as $index) {
            $player = new Player(
                $faker->name(),
                $faker->numberBetween(1, 100),
                $faker->randomElement([Gender::MALE, Gender::FEMALE]),
            );

            $this->persistRepository->persist($player);
        }
    }
}
