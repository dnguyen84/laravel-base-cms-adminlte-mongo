<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

/**
 * Refine user field with fillable format
 * @example php artisan update:user
 */
class UpdateUserField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user field with fillable format';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all user
        $users = User::all();

        // Remove all documents
        $ok = User::truncate();

        // Cast field arrat
        $casts = [
            'avatar' => 'object',
            'cover' => 'object',
            'roles' => 'array',
            'groups' => 'array',
            'accounts' => 'array',
            'profile' => 'object',
            'settings' => 'object',
            'payment' => 'array',
            'location' => 'object',
            'locales' => 'object',
            'filters' => 'array',
            'stats' => 'object',
        ];

        foreach($users as $item) {
            // Get user fillable field
            $fields = $item->getFillable();

            $user = new User();
            $user->_id = $item->id;

            foreach($fields as $field) {
                $user->{$field} = $item->{$field} ?? null;
            }

            foreach($casts as $key => $format) {
                if (empty($user->{$key})) {
                    $user->{$key} = ($format == 'object' ? object() : []);
                }
            }

            // Process user {pid}
            if ($item->pid) {
                $user->groups = [
                    [
                        'id' => $item->pid,
                        'kind' => 'publisher',
                        'role' => 'admin'
                    ]
                ];
            }

            // Process avatar, cover
            if ($item->avatar) {
                $user->avatar = (object) $item->avatar->getEmbedded2();
            }

            if ($item->cover) {
                $user->cover = (object) $item->cover->getEmbedded2();
            }

            $user->save();
        }
    }
}
