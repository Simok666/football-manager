<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scoring extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'schedule_id',
        'user_id', 
        'discipline', 
        'attitude', 
        'stamina', 
        'injury', 
        'goals', 
        'assists', 
        'shots_on_target', 
        'successful_passes', 
        'chances_created', 
        'tackles', 
        'interceptions', 
        'clean_sheets', 
        'saved', 
        'offsides', 
        'foul', 
        'improvement'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Schedule
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get scoring data for a specific user
     * 
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getScoringByUserId($userId, $scheduleId)
    {
        return self::where('user_id', $userId)
            ->where('schedule_id', $scheduleId)
            ->with('schedule')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get the latest scoring record for a user
     * 
     * @param int $userId
     * @return self|null
     */
    public static function getLatestScoringByUserId($userId)
    {
        return self::where('user_id', $userId)
            ->with('schedule')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Calculate performance metrics for a user
     * 
     * @param int $userId
     * @return array
     */
    public static function getUserPerformanceMetrics($userId)
    {
        $scorings = self::where('user_id', $userId)->get();

        if ($scorings->isEmpty()) {
            return null;
        }

        return [
            'total_goals' => $scorings->sum('goals'),
            'total_assists' => $scorings->sum('assists'),
            'average_successful_passes' => $scorings->avg('successful_passes'),
            'total_clean_sheets' => $scorings->sum('clean_sheets'),
            'discipline_distribution' => $scorings->groupBy('discipline')->map->count(),
            'attitude_distribution' => $scorings->groupBy('attitude')->map->count(),
            'stamina_distribution' => $scorings->groupBy('stamina')->map->count(),
            'injury_distribution' => $scorings->groupBy('injury')->map->count(),
        ];
    }
}
