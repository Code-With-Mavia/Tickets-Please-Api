<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "discription",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
