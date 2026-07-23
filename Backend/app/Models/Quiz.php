<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model {
    protected $fillable = ['course_id', 'title', 'time_limit', 'passing_score', 'attempts'];

    public function questions() {
        return $this->hasMany(Question::class);
    }
    public function course() {
        return $this->belongsTo(Course::class);
    }
}