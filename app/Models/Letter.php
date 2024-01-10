<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class letter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'letter_type_id',
        'letter_perihal',
        'recipients',
        'content',
        'attachment',
        'notulis'
    ];

    protected $casts = [
        'recipients' => 'array',
    ];

    public function User(){
        return $this->belongsTo(user::class,'notulis','id');
    }

    public function Letter(){
        return $this->belongsTo(letter_type::class,'letter_type_id','id');
    }

    public function Result(){
        return $this->hasOne(result::class,'letter_id','id');
    }
}
