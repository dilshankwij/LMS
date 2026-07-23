<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    protected $fillable = ['title', 'category', 'level', 'teacher_id', 'thumb', 'description', 'status', 'rating'];
    
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function sections() {
        return $this->hasMany(Section::class)->orderBy('order');
    }
    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }
    public function assignments() {
        return $this->hasMany(Assignment::class);
    }
    public function quizzes() {
        return $this->hasMany(Quiz::class);
    }
}