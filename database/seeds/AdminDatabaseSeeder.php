<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Admin::create([
              'name'  => 'Admin',
              'email'  => 'admin@app.com',
              'role_id'  => null,
              'password'  => bcrypt('12345678'),
         ]);
    }
}
