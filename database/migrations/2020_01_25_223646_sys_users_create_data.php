<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Faker\Provider as FakerProvider;

use App\Guid;
use App\User;
use App\School;
use App\Teacher;
use App\Student;
use App\Parents;
use App\Classroom;

/**
 * Run this migration command
 * @example php artisan migrate --path=/database/migrations/2020_01_25_223646_sys_users_create_data.php
 */
class SysUsersCreateData extends Migration
{
    /**
     * Initialize migration collection
     *
     * @return void
     */
    public function __construct()
    {
        $this->collection = (new User)->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::collection($this->collection, function (Blueprint $collection) {
            foreach($this->users() as $item) {
                if (User::where('email', $item['email'])->first() == false) {
                    $model = new User();
                    $fillable = $model->getFillable();
                    $bucket = array_fill_keys($fillable, null);
                    $bucket = array_merge($bucket, $item);
                    $model->fill($bucket);
                    $model->save();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::collection($this->collection, function (Blueprint $collection) {
            foreach($this->users() as $item) {
                if ($user = User::where('email', $item['email'])->first()) {
                    $user->forceDelete();
                }
            }
        });
    }

    public function users()
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new FakerProvider\vi_VN\Address($faker));
        $faker->addProvider(new FakerProvider\vi_VN\PhoneNumber($faker));

        return [
            [
                'name' => 'Admin',
                'email' => 'admin@theepochtimes.kr',
                'password' => '$2y$10$/gFxlBmOcoOPLIayDDNDbu78HY6PN0r1XAcrd.wKiVoDbYf/cr1Ly', // Admin@kr!20
                'mobile' => $faker->e164PhoneNumber,
                'roles' => [
                    'admin',
                ],
                'status' => 1,
                'updated' => now(),
                'created' => now(),
            ],
            [
                'name' => 'Marketing',
                'email' => 'marketing@theepochtimes.kr',
                'password' => '$2y$10$/gFxlBmOcoOPLIayDDNDbu78HY6PN0r1XAcrd.wKiVoDbYf/cr1Ly', // Admin@kr!20
                'mobile' => $faker->e164PhoneNumber,
                'roles' => [
                    'manager',
                ],
                'status' => 1,
                'updated' => now(),
                'created' => now(),
            ]
        ];
    }
}
