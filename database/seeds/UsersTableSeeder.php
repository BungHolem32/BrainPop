<?php

use App\Entities\Repositories\UserMetadataRepo;
use App\Entities\Repositories\UserRepo;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_repo          = (new UserRepo());
        $user_metadata_repo = (new UserMetadataRepo());
        $params             = collect([
            [
                'role_id'   => '1',
                'username'  => 'testAdmin',
                'password'  => 'testAdmin',
                "full_name" => 'testAdminFullName'
            ],
            [
                'role_id'   => '2',
                'username'  => 'testTeacher',
                'password'  => 'testTeacher',
                "full_name" => 'testTeacherFullName',
                'metadata'  => ['email' => 'testTeacherEmail@test.com']
            ],
            [
                'role_id'   => '3',
                'username'  => 'testStudent',
                'password'  => 'testStudent',
                "full_name" => 'testStudentFullName',
                'metadata'  => ['grade' => 8]
            ],
            [
                'role_id'   => '2',
                'username'  => 'teacherAdmin3',
                'password'  => 'teacherAdmin3',
                "full_name" => 'teacherAdminFullName3'
            ],
            [
                'role_id'   => '2',
                'username'  => 'testTeacher2',
                'password'  => 'testTeacher2',
                "full_name" => 'testTeacherFullName2',
                'metadata'  => ['email' => 'testTeacherEmail@test.com']
            ],
            [
                'role_id'   => '3',
                'username'  => 'testStudent2',
                'password'  => 'testStudent2',
                "full_name" => 'testStudentFullName2',
                'metadata'  => ['grade' => 10]
            ],
        ]);

        $params->each(function ($records) use ($user_repo, $user_metadata_repo) {
            $user_records = $records;
            if (!empty($user_records['metadata'])) {
                unset($user_records['metadata']);
            }
            $user = $user_repo->store($user_records);

            $user_metadata_repo->storeMetadata($user, $records);
        });

    }
}
