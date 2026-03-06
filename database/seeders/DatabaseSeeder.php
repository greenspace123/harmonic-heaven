<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Genre::count() == 0) {
            Genre::create(['name' => 'Jazz', 'slug' => 'jazz']);
            Genre::create(['name' => 'Lo-Fi', 'slug' => 'lo-fi']);
            Genre::create(['name' => 'Rock', 'slug' => 'rock']);
            Genre::create(['name' => 'Ambient', 'slug' => 'ambient']);
            Genre::create(['name' => 'Classical', 'slug' => 'classical']);
            Genre::create(['name' => 'Hip Hop', 'slug' => 'hip-hop']);
            Genre::create(['name' => 'Electronic', 'slug' => 'electronic']);
            Genre::create(['name' => 'Pop', 'slug' => 'pop']);
            Genre::create(['name' => 'Blues', 'slug' => 'blues']);
            Genre::create(['name' => 'Folk', 'slug' => 'folk']);
            $this->command->info('Жанры созданы!');
        }

        if (!User::where('email', 'admin@hh.com')->exists()) {
            User::create([
                'name' => 'Администратор',
                'email' => 'admin@hh.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]);
            $this->command->info('Администратор создан (admin@hh.com / admin123)');
        }
    }
}
