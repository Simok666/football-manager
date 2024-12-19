<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use App\Models\Coach;
use App\Models\Contribution;
use App\Models\Schedule;
use App\Models\Scoring;
use App\Models\Payment;
use App\Models\Admin;
use App\Models\AttendanceSchedule;
use App\Models\Status;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CoachResource;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\StatusResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\ContributionResource;
use DB;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * index of items
     * 
     * @param $paginate
     * 
     * @return JsonResponse
     * 
     */
    public function getUserAccount(Request $request)
    {
        return UserResource::collection(
            User::with('position', 'contribution', 'status')->when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
    }   

    /**
     * get list position
     * 
     * 
     * @return collection
     * 
     */
    public function getPosition(Position $position) {
        return PositionResource::collection(
            $position::when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
    }

    /**
     * get list contribution
     * 
     * 
     * @return collection
     * 
     */
    public function getContribution(Contribution $contribution) {
        return ContributionResource::collection(
            $contribution::when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
    }

    /**
     * Count users who have participated in matches
     * 
     * @param Schedule $schedule
     * @return JsonResponse
     */
    public function countUserParticipation(Schedule $schedule)
    {
        // Count users who have attended schedules
        $participationCount = AttendanceSchedule::where('attendance', true)
            ->whereHas('schedule', function ($query) {
                // Optional: Add any additional schedule filtering if needed
                // For example, filter by date range or specific schedule type
                // $query->whereBetween('date', [now()->subMonths(3), now()]);
            })
            ->distinct('user_id')
            ->count('user_id');

        // Optional: Get detailed participation breakdown
        $participationBreakdown = AttendanceSchedule::where('attendance', true)
            ->with('user', 'schedule')
            ->whereHas('schedule', function ($query) {
                // Same optional filtering as above
            })
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(*) as total_participation')
            ->orderByDesc('total_participation')
            ->get();
      
        return response()->json([
            'total_participants' => $participationCount,
            'participation_breakdown' => $participationBreakdown
        ]);
    }

    /**
     * Get participation statistics for a specific user
     * 
     * @param User $user
     * @return JsonResponse
     */
    public function getUserParticipationStats($userId)
    {
        $totalSchedules = Schedule::count();
        
        $userParticipation = AttendanceSchedule::where('user_id', $userId)
            ->where('attendance', true)
            ->count();

        $participationPercentage = $totalSchedules > 0 
            ? round(($userParticipation / $totalSchedules) * 100, 2) 
            : 0;
        

        return $userParticipation;

        // return response()->json([
        //     'user_id' => $userId,
        //     'total_schedules' => $totalSchedules,
        //     'user_participation' => $userParticipation,
        //     'participation_percentage' => $participationPercentage
        // ]);
    }

    /**
     * get list Status
     * 
     * 
     * @return collection
     * 
     */
    public function getStatus(Request $request, Status $status, Schedule $schedule, User $user) {
        $userId = $request->id;
        $valueContribution = $request->selectedContribution;
        $userParticipation = $this->getUserParticipationStats($userId);
        // dd($status::where('id', 2)->first());
        $status = null;
        if (($valueContribution == 1 || $valueContribution == 2) && $userParticipation == 0) {
            $status = Status::where('id', 1)->first();
        } else if (($valueContribution == 1 || $valueContribution == 2) &&  $userParticipation > 0) {
            $status = Status::where('id', 2)->first();
        } else if ($valueContribution == 3 && ($userParticipation > 0 || $userParticipation == 0) ) {
            $status = Status::where('id', 3)->first();
        }
        
        return new StatusResource($status);
    }

    /**
     * Get users who have played more than once with detailed evaluation
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getEvaluation()
    {
        try {
            // Get users with more than one participation
            $activeUsers = AttendanceSchedule::where('attendance', true)
                ->groupBy('user_id')
                ->havingRaw('COUNT(DISTINCT schedule_id) > 0')
                ->with(['user' => function($query) {
                    $query->with(['position', 'contribution']);
                }])
                ->select('user_id')
                ->selectRaw('COUNT(DISTINCT schedule_id) as total_schedules')
                ->get();
            

            // Prepare detailed evaluation for each user
            $evaluationResults = $activeUsers->map(function($attendance) {
                $user = $attendance->user;
                // Calculate overall performance metrics
                $scorings = Scoring::where('user_id', $user->id)->get();
                
                // Get all schedule activities for this user
                $scheduleActivities = AttendanceSchedule::where('user_id', $user->id)
                ->where('attendance', true)
                ->with('schedule')
                ->get()
                ->map(function($scheduleAttendance) {
                    $schedule = $scheduleAttendance->schedule;
                    
                    // Get scoring for this specific schedule
                    $scoring = Scoring::where('user_id', $scheduleAttendance->user_id)
                    ->where('schedule_id', $schedule->id)
                    ->first();
                    
                    
                        return [
                            'schedule_id' => $schedule->id,
                            'schedule_name' => $schedule->activity,
                            'schedule_date' => $schedule->date_activity,
                            'schedule_location' => $schedule->location,
                            'scoring' => $scoring ? [
                                'goals' => $scoring->goals,
                                'assists' => $scoring->assists,
                                'discipline' => $scoring->discipline,
                                'attitude' => $scoring->attitude,
                                'tackles' => $scoring->tackles,
                                'interceptions' => $scoring->interceptions,
                                'clean_sheets' => $scoring->clean_sheets,
                                'saved' => $scoring->saved,
                                'offsides' => $scoring->offsides,
                                'foul' => $scoring->foul,
                                'improvement' => $scoring->improvement,
                            ] : null
                        ];
                    });
            
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'position' => $user->position ? $user->position->description : 'N/A',
                    'contribution' => $user->contribution ? $user->contribution->name : 'N/A',
                    'total_schedules' => $attendance->total_schedules,
                    'schedule_activities' => $scheduleActivities
                ];
            });
           
            return response()->json([
                // 'total_evaluated_users' => $evaluationResults->count(),
                'data' => $evaluationResults
            ]);
        } catch (\Exception $e) {
            \Log::error('Evaluation retrieval failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to retrieve evaluations',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed evaluation for a specific schedule and user
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getDetailedEvaluation(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            // Fetch the user with related information
            $user = User::with(['position', 'contribution'])
                ->findOrFail($request->user_id);

            // Fetch the schedule
            $schedule = Schedule::findOrFail($request->schedule_id);

            // Fetch attendance information
            $attendance = AttendanceSchedule::where('user_id', $user->id)
                ->where('schedule_id', $schedule->id)
                ->first();

            // Fetch scoring information
            $scoring = Scoring::where('user_id', $user->id)
                ->where('schedule_id', $schedule->id)
                ->first();

            // Prepare detailed evaluation response
            $detailedEvaluation = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'position' => $user->position ? $user->position->description : 'N/A',
                    'contribution' => $user->contribution ? $user->contribution->name : 'N/A',
                ],
                'schedule' => [
                    'id' => $schedule->id,
                    'activity' => $schedule->activity,
                    'date' => $schedule->date_activity,
                    'location' => $schedule->location,
                ],
                'attendance' => $attendance ? [
                    'status' => $attendance->attendance ? 'Present' : 'Absent',
                    'attendance_status' => $attendance->attendance_status,
                ] : null,
                'scoring' => $scoring ? [
                    // General Performance
                    'discipline' => $scoring->discipline,
                    'attitude' => $scoring->attitude,
                    'stamina' => $scoring->stamina,
                    'injury' => $scoring->injury,

                    // Offensive Stats
                    'goals' => $scoring->goals,
                    'assists' => $scoring->assists,
                    'chances_created' => $scoring->chances_created,
                    'shots_on_target' => $scoring->shots_on_target,
                    'successful_passes' => $scoring->successful_passes,

                    // Defensive Stats
                    'tackles' => $scoring->tackles,
                    'interceptions' => $scoring->interceptions,
                    'clean_sheets' => $scoring->clean_sheets,
                    'saved' => $scoring->saved,

                    // Rule-based Stats
                    'offsides' => $scoring->offsides,
                    'foul' => $scoring->foul,
                    'improvement' => $scoring->improvement,
                ] : null
            ];

            return response()->json($detailedEvaluation);
        } catch (\Exception $e) {
            \Log::error('Detailed evaluation retrieval failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to retrieve detailed evaluation',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * update data user management
     * 
     * @param Request $request
     * @param User $user
     */
    public function userManagement(Request $request, User $user) {
        try {
          DB::beginTransaction();   
          $data = collect($request->repeater)->map(function ($item) use ($user) {
              $userEmail = $user::where('id', $item['id'])->first()->email; 
            
              $user = $user::updateOrCreate(
                  [
                      'id' => $item['id'] ?? null,
                  ],
                  [
                      'email' => $item['email'],
                      'name' => $item['name'],
                      'nik' => $item['nik'],
                      'place_of_birth' => $item['place_of_birth'],
                      'birth_of_date' => $item['birth_of_date'],
                      'address' => $item['address'],
                      'school' => $item['school'],
                      'class' => $item['class'],
                      'father_name' => $item['father_name'],
                      'mother_name' => $item['mother_name'],
                      'parents_contact' => $item['parents_contact'],
                      'weight' => $item['weight'] ?? null,
                      'height' => $item['height'] ?? null,
                      'id_positions' => $item['id_positions'] ?? null,
                      'history' => $item['history'] ?? null,
                      'id_contributions' => $item['id_contributions'] ?? null,
                      'id_statuses' => $item['id_statuses'] ?? null,
                      'strength' => $item['strength'] ?? null,
                      'weakness' => $item['weakness'] ?? null,
                      'is_verified' => true
                  ],
              );
       
        //   $token = Password::createToken($user);
        //   Mail::to($userEmail)->send(new CustomEmail(
        //     "Account Created Now you can login",
        //     "Click the link to reset your password: " . url('password/reset', $token)
        //   ));

          DB::commit();
          });
          return response()->json(['message' => 'Data updated successfully'], 201);
        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred updated data: ' . $ex->getMessage()], 400);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updated data: ' . $e->getMessage()], 400);
        }
    }

    /**
     * get list of coach
     * 
     * @param $paginate
     * 
     * @return JsonResponse
     * 
     */
    public function getCoachAccount(Request $request)
    {
        return CoachResource::collection(
            Coach::when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
    }   


    /**
     * add or edit data coach
     * 
     * @param Request $request
     * @param Coach $coach
     */
    public function addUpdateCoach(Request $request, Coach $coach) {
        try {
            DB::beginTransaction();   
            $data = collect($request->repeater)->map(function ($item) use ($coach) {
              
                $coach = $coach::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                    ],
                    [
                        'email' => $item['email'],
                        'name' => $item['name'],
                        'password' => Hash::make($item['password']) ?? null,
                        'phone' => $item['phone'],
                        'nik' => $item['nik'],
                        'place_of_birth' => $item['place_of_birth'],
                        'date_of_birth' => $item['date_of_birth'],
                        'address' => $item['address'],
                        'emergeny_contact' => $item['emergeny_contact'],
                        'weight' => $item['weight'] ,
                        'height' => $item['height'] ,
                        'history' => $item['history'] ,
                        'status' => $item['status'] 
                    ],
                );
                 
                 if ($item['new_id'] == "null") {
                     Mail::to($item['email'])->send(new CustomEmail(
                        "Coach Account Created Now you can login",
                        "Email : " . $item['email'] . " <br/> Password : " .$item['password']
                    ));
                 } 
  
            DB::commit();
            });
            return response()->json(['message' => 'Data updated successfully'], 201);
          } catch(\Illuminate\Database\QueryException $ex) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred updated data: ' . $ex->getMessage()], 400);
          } catch(\Exception $e) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred while updated data: ' . $e->getMessage()], 400);
          }
    }

    /**
     * add or edit data schedule
     * 
     * @param Request $request
     * @param Schedule $schedule
     */
    public function addSchedule(Request $request, Schedule $schedule) {
        try {
            DB::beginTransaction(); 
            $usersEmails = User::pluck('email')->toArray();
            $data = collect($request->repeater)->map(function ($item) use ($schedule, $usersEmails) {

                if ($item['event_name'] == 'edit_event' || $item['event_name'] == 'add_event' ) {
                    $schedule = $schedule::updateOrCreate(
                        [
                            // 'id' => $item['id'] ?? null,
                            'date_activity' => $item['date_activity'],
                            // 'activity' => $item['activity'],
                        ],
                        [
                            'activity' => $item['activity'],
                            'date_activity' => $item['date_activity'],
                            'time_start_activity' => $item['time_start_activity'],
                            'time_end_activity' => $item['time_end_activity'],
                            'location' => $item['location'],
                        ],
                    );
                     
                     if ($item['new_id'] == "null") {
                        foreach ($usersEmails as $userEmail) {
                            Mail::to($userEmail)->send(new CustomEmail(
                                "New Schedule Created mark your attendance",
                                "Please mark your attendance for the activity : " . $item['activity']
                            ));
                        }
                     } 
                } else if ($item['event_name'] == 'add_participants') {
                    
                    $schedule->addParticipants($item['id'] ,$item['user_id'], 'participant');
                } else if ($item['event_name'] == 'add_documentation') {
                    
                    $schedule->uploadDocumentation($item['id'] ,$item['example']);
                    foreach ($usersEmails as $userEmail) {
                        Mail::to($userEmail)->send(new CustomEmail(
                            "New decumentation added at : ". $item['activity'],
                            "check User Attendance menu if you want to download the documentation"
                        ));
                    }
                }
  
            DB::commit();
            });
            return response()->json(['message' => 'Data created successfully'], 201);
          } catch(\Illuminate\Database\QueryException $ex) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred created data: ' . $ex->getMessage()], 400);
          } catch(\Exception $e) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred while created data: ' . $e->getMessage()], 400);
          }
    }

    /**
     * get list of schedule
     * 
     * @param $paginate
     * 
     * @return JsonResponse
     * 
     */
    public function getSchedule(Request $request)
    {
        return ScheduleResource::collection(
            Schedule::with('attendances.user')
            ->when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
    }

    /**
     * mark attendance
     * 
     * @param Request $request
     * @param Schedule $schedule
     * 
     * @return JsonResponse
     * 
     */
    public function markAttendance(Request $request, Schedule $schedule)
    {
        try {
            
            DB::beginTransaction();   
            $scheduleId = $request->id;
            $userId = $request->user()->id;
            $markAttendance = $request->attendance == "true" ? true : false;
            $attendance_status = $markAttendance == true ? "Hadir" : "Tidak Hadir";
            $schedule = $schedule->markUserAttendance($scheduleId, $userId, $markAttendance, $attendance_status);
            
            DB::commit();
            return response()->json(['message' => 'Data updated successfully'], 201);
          } catch(\Illuminate\Database\QueryException $ex) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred updated data: ' . $ex->getMessage()], 400);
          } catch(\Exception $e) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred while updated data: ' . $e->getMessage()], 400);
          }        
    }

    /**
     * get Image Documentation
     * 
     * @param int $scheduleId
     * @param Schedule $schedule
     * 
     * @return JsonResponse
     * 
     */
    public function getImageDocumentation($scheduleId, Schedule $schedule) {
        try {
            $documentations = $schedule->getDocumentations($scheduleId);
            
            return response()->json([
                'status' => 'success',
                'data' => $documentations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve documentation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * get Image Documentation
     * 
     * @param Request $request
     * @param Schedule $schedule
     * 
     * @return JsonResponse
     * 
     */
    public function removeImageDocumentation(Request $request, Schedule $schedule) {
        try {
           
            $remove = $schedule->removeDocumentation($request->schedule_id, $request->doc_id);
            
            return response()->json([
                'status' => 'remove success',
                'data' => $remove
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove documentation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * add scoring
     * 
     * @param Request $request
     * @param Scoring $scoring
     * 
     * @return JsonResponse
     * 
     */
    public function addUpdateScoring (Request $request, Scoring $scoring) {
        try {
            DB::beginTransaction(); 
         
            $data = collect($request->repeater)->map(function ($item) use ($scoring) {
                
                $scoring = $scoring::updateOrCreate(
                    [
                        // 'id' => $item['id'] ?? null,
                        'schedule_id' => $item['schedule_id'],
                        'user_id'   => $item['user_id'],
                    ],
                    [
                        'schedule_id' => $item['schedule_id'],
                        'user_id'   => $item['user_id'],
                        'discipline' => $item['discipline'],
                        'attitude' => $item['attitude'],
                        'stamina' => $item['stamina'],
                        'injury' => $item['injury'],
                        'goals' => $item['goals'],
                        'assists' => $item['assists'],
                        'shots_on_target' => $item['shots_on_target'],
                        'successful_passes' => $item['successful_passes'],
                        'chances_created' => $item['chances_created'],
                        'tackles' => $item['tackles'],
                        'interceptions' => $item['interceptions'],
                        'clean_sheets' => $item['clean_sheets'],
                        'saved' => $item['saved'] ?? 0,
                        'offsides' => $item['offside'] ?? 0,
                        'foul' => $item['foul'],
                        'improvement' => $item['improvement'],
                    ],
                );
                 
            DB::commit();
            });
            return response()->json(['message' => 'Data created successfully'], 201);
          } catch(\Illuminate\Database\QueryException $ex) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred created data: ' . $ex->getMessage()], 400);
          } catch(\Exception $e) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred while created data: ' . $e->getMessage()], 400);
          }
    }

    /**
     * Get Scoring Data for a User
     * 
     * @param int $userId
     * @param Scoring $scoring
     * 
     * @return JsonResponse
     */
    public function getScoring($userId, Scoring $scoring, Request $request)
    {
        try {
            $scheduleId = $request->schedule_id;
            // Get all scoring records for the user
            $scoringRecords = $scoring::getScoringByUserId($userId, $scheduleId);
            
            // Get performance metrics
            $performanceMetrics = $scoring::getUserPerformanceMetrics($userId);

            return response()->json([
                'status' => 'success',
                'data' =>  $scoringRecords,
                // 'data' => [
                //     'scoring_records' => $scoringRecords,
                //     'performance_metrics' => $performanceMetrics
                // ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve scoring data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * add Proof Payment
     * 
     * @param Request $request
     * @param Scoring $scoring
     * 
     * @return JsonResponse
     * 
     */
    public function addUpdatePayment (Request $request, Payment $payment) {
        try {
            DB::beginTransaction(); 
            $maxFileSize = 2 * 1024;
            $userId = $request->user()->id;
            $data = collect($request->repeater)->map(function ($item) use ($payment, $userId, $maxFileSize) {
                $filePath = null;
                
                if ($item['proof_payment'] != "null") {
                    $fileSizeKB = $item['proof_payment']->getSize() / 1024;

                    if ($fileSizeKB > $maxFileSize || $fileSizeKB === 0) {
                        throw new \Exception("File {$item['proof_payment']->getClientOriginalName()} exceeds maximum size of 2MB");
                    }
    
                    $fileName = time() . '_' . $item['proof_payment']->getClientOriginalName();
    
                    $filePath = $item['proof_payment']->storeAs('payments', $fileName, 'public');
                }

                if ($item['event_name'] === 'payment_paid_off') {
                
                    $payment = $payment::updateOrCreate(
                        [
                            'user_id'   => $item['user_id'] ?? null,
                        ],
                        [
                            // 'user_id'   => $userId ?? null,
                            'id_statuses' => $item['id_statuses'] ?? null,
                            'payment_confirmation' => $item['payment_confirmation'] ?? null,
                            // 'date_payment' => date("Y-m-d"),
                            // 'proof_payment' => $filePath,
                        ],
                    );    
                } else if ($item['event_name'] === 'proof_payment') {
                    $payment = $payment::updateOrCreate(
                        [
                            // 'id' => $item['id'] ?? null,
                            'user_id'   => $userId ?? null,
                        ],
                        [
                            'id_statuses' => $item['id_statuses'] ?? null,
                            // 'payment_confirmation' => $item['payment_confirmation'] ?? null,
                            'date_payment' => now(),
                            'proof_payment' => $filePath,
                        ],
                    );
                    $adminEmail = Admin::first()->email;
                    $userName = User::where('id', $userId)->first()->name;
                    Mail::to($adminEmail)->send(new CustomEmail(
                        "Payment Confirmation from " . $userName,
                        "Check Payment confirmation for " . $userName
                    ));
                }
                 
            DB::commit();
            });
            return response()->json(['message' => 'Data created successfully'], 201);
          } catch(\Illuminate\Database\QueryException $ex) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred created data: ' . $ex->getMessage()], 400);
          } catch(\Exception $e) {
              DB::rollBack();
              return response()->json(['error' => 'An error occurred while created data: ' . $e->getMessage()], 400);
          }
    }

    /**
     * get list of schedule
     * 
     * @param $paginate
     * 
     * @return JsonResponse
     * 
     */
    public function getPayment(Request $request)
    {
        return PaymentResource::collection(
            Payment::with(['user', 'status'])
            ->when(request()->filled("id"), function ($query){
                $query->where('id', request("id"));
            })->paginate($request->limit ?? "10")
        );
    }

}
