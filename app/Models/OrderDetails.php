<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{

    use HasFactory;

    protected $guarded = [
        'id',
    ];
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function book()
    {
        return $this->belongsTo(Books::class);
    }
}
