<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'user_id',
        'attendance',
        'attendance_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'attendance' => 'boolean'
    ];

    /**
     * Get the schedule associated with the attendance.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the user associated with the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to find attendance for a specific schedule.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $scheduleId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSchedule($query, $scheduleId)
    {
        return $query->where('schedule_id', $scheduleId);
    }

    /**
     * Scope a query to find attendance for a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Mark attendance for a user in a schedule.
     *
     * @param int $scheduleId
     * @param int $userId
     * @param bool $status
     * @return self
     */
    public static function markAttendance($scheduleId, $userId, $status = true, $attendance_status = null)
    {
        return self::updateOrCreate(
            [
                'schedule_id' => $scheduleId,
                'user_id' => $userId
            ],
            [
                'attendance' => $status,
                'attendance_status' => $attendance_status
            ]
        );
    }

    /**
     * Attendance status for a user in a schedule.
     *
     * @param int $scheduleId
     * @param int $userId
     * @return self
     */
    public static function getAttendanceStatuses($scheduleId, $userId)
    {
        $attendance = self::select('attendance_status')
                          ->where('schedule_id', $scheduleId)
                          ->where('user_id', $userId)
                        //   ->where('attendance_status', true)
                          ->first();
        // dd($attendance->attendance_status);
        return $attendance->attendance_status ?? null;
    }

    /**
     * Get attendance status for a user in a schedule.
     *
     * @param int $scheduleId
     * @param int $userId
     * @return bool
     */
    public static function getAttendanceStatus($scheduleId, $userId)
    {
        $attendance = self::where('schedule_id', $scheduleId)
                          ->where('user_id', $userId)
                          ->first();
       
        return $attendance ? $attendance->attendance : false;
    }
}
