<?php

use App\Entities\Repositories\RoleRepo;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new RoleRepo())->model()->insert([
            ['name' => 'admin'],
            ['name' => 'teacher'],
            ['name' => 'student']
        ]);

    }

}
