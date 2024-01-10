<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class letter_type extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestaps = true;

    protected $fillable = [
        'letter_code',
        'name_type',
    ];

    public function letterType(){
        return $this->hasMany(letter::class);
    }
}
