<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model {
    protected $fillable = ['section_id', 'title', 'type', 'video_url', 'attachment', 'content', 'duration', 'order'];

    public function section() {
        return $this->belongsTo(Section::class);
    }
}