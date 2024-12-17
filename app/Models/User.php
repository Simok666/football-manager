<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Schedule;
use App\Models\Scoring;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'place_of_birth',
        'birth_of_date',
        'address',
        'school',
        'class',
        'father_name',
        'mother_name',
        'parents_contact',
        'weight',
        'height',
        'id_positions',
        'history',
        'id_contributions',
        'id_statuses',
        'strength',
        'weakness',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'id_positions');
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'id_contributions');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_statuses');
    }

    /**
     * The schedules that the user is associated with.
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Check if user is part of a specific schedule.
     *
     * @param int $scheduleId
     * @return bool
     */
    public function isInSchedule($scheduleId)
    {
        return $this->schedules()->where('schedules.id', $scheduleId)->exists();
    }

    /**
     * Get user's role in a specific schedule.
     *
     * @param int $scheduleId
     * @return string|null
     */
    public function getScheduleRole($scheduleId)
    {
        $schedule = $this->schedules()->where('schedules.id', $scheduleId)->first();
        return $schedule ? $schedule->pivot->role : null;
    }

    /**
     * The scorings that belong to the user.
     */
    public function scorings()
    {
        return $this->hasMany(Scoring::class);
    }

    /**
     * Get the latest scoring record for the user.
     */
    public function latestScoring()
    {
        return $this->hasOne(Scoring::class)->latestOfMany();
    }
}
