<?php

namespace Database\Seeders;

use App\Models\Books;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Matematika Dasar',
                'price' => 50000,
                'image' => null,
                'classroom_id' => 1,
            ],
            [
                'title' => 'Bahasa Indonesia',
                'price' => 45000,
                'image' => null,
                'classroom_id' => 1,
            ],
            [
                'title' => 'IPA Terpadu',
                'price' => 60000,
                'image' => null,
                'classroom_id' => 2,
            ],
            [
                'title' => 'IPS',
                'price' => 55000,
                'image' => null,
                'classroom_id' => 2,
            ],
        ];

        foreach ($books as $book) {
            Books::create($book);
        }
    }
}
