<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class result extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'notes',
        'presence_recipients'
    ];

    protected $casts = [
        'presence_recipients' => 'array',
    ];
    
    public function LetterResult(){
        return $this->belongsTo(letter::class,'letter_id','id');
    }
}
