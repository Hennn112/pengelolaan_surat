<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class letter_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_code',
        'name_type',
    ];

    public function letterType(){
        return $this->hasMany(letter::class);
    }
}
