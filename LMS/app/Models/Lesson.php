<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model {
    protected $fillable = ['section_id', 'title', 'video_url', 'content', 'duration', 'order'];

    public function section() {
        return $this->belongsTo(Section::class);
    }
}