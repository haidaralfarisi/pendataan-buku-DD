<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function yearBook()
    {
        return $this->belongsTo(YearBook::class, 'year_book_id');
    }

    public function books()
    {
        return $this->hasMany(Classroom::class,'classRoom_id');
    }
}
