<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        Student::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '123-456-7890',
        ]);

        // Add more sample data as needed
    }
}
