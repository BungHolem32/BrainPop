<?php

use App\Entities\Repositories\PeriodsRepo;
use App\Entities\Repositories\UserRepo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data        = [];
        $teacher_ids = (new UserRepo())
            ->query()
            ->where('role_id', '2')
            ->pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $data[$i] = [
                'name'       => Str::random(20),
                'teacher_id' => $teacher_ids->random(1)->first(),
                'created_at' => now()
            ];
        }

        (new PeriodsRepo())->model()->insert($data);
    }
}
