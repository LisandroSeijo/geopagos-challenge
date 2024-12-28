<?php

namespace Database\Seeders;

use ATP\Entities\FemalePlayer;
use ATP\Entities\MalePlayer;
use ATP\Repositories\PersistRepository;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
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
            $player = new MalePlayer(
                $faker->name(),
                $faker->numberBetween(1, 100),
                Gender::MALE,
                $faker->email(),
                $faker->numberBetween(1,100),
                $faker->numberBetween(1,100)
            );

            $this->persistRepository->persist($player);

            $player = new FemalePlayer(
                $faker->name(),
                $faker->numberBetween(1, 100),
                Gender::FEMALE,
                $faker->email(),
                $faker->numberBetween(1,100),
            );

            $this->persistRepository->persist($player);
        }
    }
}
