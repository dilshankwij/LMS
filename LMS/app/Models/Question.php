<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $fillable = ['quiz_id', 'question', 'options', 'correct', 'explanation'];
    protected $casts = [
        'options' => 'array',
    ];
}