<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use App\Models\Contribution;
use App\Http\Resources\UserResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\ContributionResource;
use DB;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

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
            User::when(request()->filled("id"), function ($query){
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
            //   dd($user::where('id', $item['id'])->first()->password);
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
                  ],
              );
       
          $token = Password::createToken($user);
          Mail::to($userEmail)->send(new CustomEmail(
            "Account Created Now you can login",
            "Click the link to reset your password: " . url('password/reset', $token)
          ));

          DB::commit();
          });
          return response()->json(['message' => 'Data updated successfully'], 201);
        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred creating data: ' . $ex->getMessage()], 400);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating data: ' . $e->getMessage()], 400);
        }
    }
}
