<?php

use App\User;
use App\Role;
use App\Perm;
use App\Guid;

use App\Publisher;

use Faker\Generator as Faker;
use Faker\Provider as FakerProvider;

use Illuminate\Database\Seeder;

/**
 * Command to generate seed data
 * -----------------------------
 *  composer dump-autoload
 *  php artisan db:seed --class=RoleSeeder
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /**
         * Generate system roles
         */
        $roles = $this->roles();

        foreach ($roles as $item) {
            Role::firstOrCreate(['_id' => $item['_id']], $item);
        }

        /**
         * Generate system admin
         */
        $users = $this->users($faker);

        foreach ($users as $item) {
            if (User::where('email', $item['email'])->first() == false) {
                User::create($item);
            }
        }
    }

    public function roles()
    {
        return [
            [
                '_id' => 'admin',
                'name' => 'Admin',
                'level' => '1',
                'description' => 'Admin has all permission',
                'perms' => Perm::all(),
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ],
            [
                '_id' => 'manager',
                'name' => 'Manager',
                'level' => '2',
                'description' => 'System management',
                'perms' => [],
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ],
            [
                '_id' => 'marketer',
                'name' => 'marketer',
                'level' => '3',
                'description' => 'marketer',
                'perms' => [],
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ],
            [
                '_id' => 'reviewer',
                'name' => 'reviewer',
                'level' => '4',
                'description' => 'reviewer',
                'perms' => [],
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ],
            [
                '_id' => 'accountant',
                'name' => 'Accountant',
                'level' => '5',
                'description' => 'Accountant',
                'perms' => [],
                'status' => '1',
                'created' => now(),
                'updated' => now(),
            ]
        ];
    }

    public function users($faker)
    {
        $faker->addProvider(new FakerPerson($faker));
        $faker->addProvider(new FakerProvider\vi_VN\Address($faker));
        $faker->addProvider(new FakerProvider\vi_VN\PhoneNumber($faker));

        return [
            [
                'pid' => '',
                'name' => 'Super Admin',
                'email' => 'admin@sagebook.vn',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember' => Str::random(10),
                'avatar' => null,
                'cover' => null,
                'gender' => $faker->randomElement(['male', 'female']),
                'mobile' => $faker->e164PhoneNumber,
                'location' => null,
                'birthday' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'about' => $faker->text,
                'roles' => [
                    'admin',
                ],
                'status' => 1,
                'verified' => now()->format('Y-m-d H:i:s'),
                'updated' => now(),
                'created' => now(),
            ],
            [
                'pid' => '',
                'name' => 'manager',
                'email' => 'manager@sagebook.vn',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember' => Str::random(10),
                'avatar' => null,
                'cover' => null,
                'gender' => $faker->randomElement(['male', 'female']),
                'mobile' => $faker->e164PhoneNumber,
                'location' => null,
                'birthday' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'about' => $faker->text,
                'roles' => [
                    'manager',
                ],
                'status' => 1,
                'verified' => now()->format('Y-m-d H:i:s'),
                'updated' => now(),
                'created' => now(),
            ],
            // marketer
            [
                'pid' => '',
                'name' => 'marketer',
                'email' => 'marketer@sagebook.vn',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember' => Str::random(10),
                'avatar' => null,
                'cover' => null,
                'gender' => $faker->randomElement(['male', 'female']),
                'mobile' => $faker->e164PhoneNumber,
                'location' => null,
                'birthday' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'about' => $faker->text,
                'roles' => [
                    'marketer',
                ],
                'status' => 1,
                'verified' => now()->format('Y-m-d H:i:s'),
                'updated' => now(),
                'created' => now(),
            ],
            // reviewer
            [
                'pid' => '',
                'name' => 'reviewer',
                'email' => 'reviewer@sagebook.vn',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember' => Str::random(10),
                'avatar' => null,
                'cover' => null,
                'gender' => $faker->randomElement(['male', 'female']),
                'mobile' => $faker->e164PhoneNumber,
                'location' => null,
                'birthday' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'about' => $faker->text,
                'roles' => [
                    'sponsor',
                ],
                'status' => 1,
                'verified' => now()->format('Y-m-d H:i:s'),
                'updated' => now(),
                'created' => now(),
            ],
            [
                'pid' => '',
                'name' => 'Accountant Demo',
                'email' => 'accountant@sagebook.vn',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember' => Str::random(10),
                'avatar' => null,
                'cover' => null,
                'gender' => $faker->randomElement(['male', 'female']),
                'mobile' => $faker->e164PhoneNumber,
                'location' => null,
                'birthday' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'about' => $faker->text,
                'roles' => [
                    'accountant',
                ],
                'status' => 1,
                'verified' => now()->format('Y-m-d H:i:s'),
                'updated' => now(),
                'created' => now(),
            ]
        ];
    }
}
