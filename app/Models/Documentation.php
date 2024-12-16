<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documentation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id', 
        'file_path', 
        'file_name', 
        'file_type', 
        'file_size'
    ];

    /**
     * Get the schedule that owns the documentation.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the full URL of the file
     *
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
