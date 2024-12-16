<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $request->user()->currentAccessToken()->abilities;
        $role = explode(':', $role[0])[1] ?? "";
        $attendance = $role == "user" ? $this->getAttendanceForUser($this->id, $request->user()->id ) : null;
        $attendanceStatuses = $role == "user" ? $this->getAttendanceStatuses($this->id, $request->user()->id) : null;
        
        return [
            'id' => $this->id,
            'activity' => $this->activity,
            'date_activity' => $this->date_activity,
            'time_start_activity' => $this->time_start_activity,
            'time_end_activity' => $this->time_end_activity,
            'location' => $this->location,
            'user_attendance' => $attendance,
            'attendance_status' => $attendanceStatuses,
            'user_participiants' => $this->attendances,
            'participants_added' => $role == "admin" || $role == "coach" ? $this->getParticipants($this->id) : null,
        ];
    }
}
