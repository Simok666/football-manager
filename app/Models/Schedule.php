<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\AttendanceSchedule;
use App\Models\Documentation;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity',
        'date_activity',
        'time_start_activity',
        'time_end_activity',
        'location'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_activity' => 'date',
        'time_start_activity' => 'datetime:H:i',
        'time_end_activity' => 'datetime:H:i'
    ];

    /**
     * The users associated with this schedule.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'schedule_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Add participants to the schedule
     *
     * @param int $scheduleId
     * @param int $userId
     * @param string $role
     * @return void
     */
    public function addParticipants($scheduleId, $userId, $role = 'participant')
    {
        // Find the schedule
        $schedule = self::findOrFail($scheduleId);

        // Attach user with the specified role
        $schedule->users()->syncWithoutDetaching([$userId => ['role' => $role]]);
    }

    /**
     * Remove participants from the schedule
     *
     * @param array|int $userIds
     * @return void
     */
    public function removeParticipants($userIds)
    {
        // Ensure $userIds is an array
        $userIds = is_array($userIds) ? $userIds : [$userIds];

        $this->users()->detach($userIds);
    }

    /**
     * Get all participants for this schedule
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getParticipants($scheduleId = null)
    {
        $schedule = $scheduleId ? self::findOrFail($scheduleId) : $this;
        return $schedule->users()->wherePivot('role', 'participant')->get();
    }

    /**
     * Get all organizers for this schedule
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrganizers()
    {
        return $this->users()->wherePivot('role', 'organizer')->get();
    }
    

    /**
     * Get the attendance records for this schedule.
     */
    public function attendances()
    {
        return $this->hasMany(AttendanceSchedule::class);
    }

    /**
     * Get the attendance status for a specific user.
     *
     * @param int $userId
     * @return bool
     */
    public function getAttendanceForUser($scheduleId ,$userId)
    {
        return AttendanceSchedule::getAttendanceStatus($scheduleId, $userId);
    }

    /**
     * Mark attendance for a user in this schedule.
     *
     * @param int $userId
     * @param bool $status
     * @return AttendanceSchedule
     */
    public function markUserAttendance($scheduleId ,$userId, $status = true, $attendance_status = null)
    {
        return AttendanceSchedule::markAttendance($scheduleId, $userId, $status, $attendance_status);
    }

    /**
     * get Attendacne status for a specific user.
     *
     * @param int $userId
     * @param bool $status
     * @return AttendanceSchedule
     */
    public function getAttendanceStatuses($scheduleId ,$userId)
    {
        return AttendanceSchedule::getAttendanceStatuses($scheduleId, $userId);
    }

    /**
     * Get all users with their attendance status.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUsersWithAttendance()
    {
        return $this->users->map(function ($user) {
            $user->attendance = $this->getAttendanceForUser($user->id);
            return $user;
        });
    }

    /**
     * Get the documentations for the schedule.
     */
    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    /**
     * Upload documentation for a schedule
     *
     * @param int $scheduleId
     * @param array $files
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function uploadDocumentation($scheduleId, $files)
    {
        // Find the schedule
        $schedule = self::findOrFail($scheduleId);
        
        // Ensure $files is an array
        $files = is_array($files) ? $files : [$files];
        
        // Maximum file size (2MB = 2048 KB)
        $maxFileSize = 2 * 1024;
        
        // Store uploaded files
        $uploadedDocumentations = collect();
        
        foreach ($files as $file) {
            // Check file size (in KB)
            $fileSizeKB = $file->getSize() / 1024;
        
            if ($fileSizeKB > $maxFileSize || $fileSizeKB === 0) {
                throw new \Exception("File {$file->getClientOriginalName()} exceeds maximum size of 2MB");
            }

            // Generate a unique filename
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the documentations directory
            $filePath = $file->storeAs('documentations', $fileName, 'public');

            // Create documentation record
            $documentation = $schedule->documentations()->create([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize()
            ]);
            
            $uploadedDocumentations->push($documentation);
        }
        
        return $uploadedDocumentations;
    }

    /**
     * Get documentations for a schedule
     *
     * @param int $scheduleId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDocumentations($scheduleId)
    {
        $schedule = self::findOrFail($scheduleId);
        return $schedule->documentations;
    }

    /**
     * Remove a specific documentation
     *
     * @param int $scheduleId
     * @param int $documentationId
     * @return bool
     */
    public function removeDocumentation($scheduleId, $documentationId)
    {
        $schedule = self::findOrFail($scheduleId);
        
        // Find the specific documentation
        $documentation = $schedule->documentations()->findOrFail($documentationId);

        // Delete the file from storage
        \Storage::disk('public')->delete($documentation->file_path);

        // Delete the database record
        return $documentation->delete();
    }

    /**
     * Remove all documentations for a schedule
     *
     * @param int $scheduleId
     * @return int Number of deleted documentations
     */
    public function removeAllDocumentations($scheduleId)
    {
        $schedule = self::findOrFail($scheduleId);
        
        // Get all documentations
        $documentations = $schedule->documentations;

        // Delete files from storage
        foreach ($documentations as $documentation) {
            \Storage::disk('public')->delete($documentation->file_path);
        }

        // Delete database records
        return $schedule->documentations()->delete();
    }
}
