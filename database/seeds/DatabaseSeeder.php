<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TaskGroupSeeder::class);
		$this->call(TaskSeeder::class);
		$this->call(TaskMailSeeder::class);
		$this->call(TaskPhoneSeeder::class);
		$this->call(TaskServerSeeder::class);
		$this->call(TaskUserSeeder::class);
    }
}
