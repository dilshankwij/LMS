<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model {
    protected $fillable = ['assignment_id', 'student_id', 'submitted_at', 'file_path', 'score', 'feedback', 'status'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }
}