<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role', 'avatar', 'title', 'batch'];
    protected $hidden = ['password', 'remember_token'];

    public function courses() {
        return $this->hasMany(Course::class, 'teacher_id');
    }
    public function enrollments() {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
    public function submissions() {
        return $this->hasMany(Submission::class, 'student_id');
    }
}