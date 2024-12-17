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
use App\Http\Resources\UserResource;
use App\Http\Resources\CoachResource;
use App\Http\Resources\ScheduleResource;
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
            // dd($request->repeater);
            $data = collect($request->repeater)->map(function ($item) use ($scoring) {
                
                $scoring = $scoring::updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                    ],
                    [
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
                        'saved' => $item['saved'] ?? null,
                        'offside' => $item['offside'] ?? null,
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
    public function getScoring($userId, Scoring $scoring)
    {
        try {
            // Get all scoring records for the user
            $scoringRecords = $scoring::getScoringByUserId($userId);
            
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
}
