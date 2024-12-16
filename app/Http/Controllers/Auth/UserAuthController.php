<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserRegisterResource;
use App\Http\Resources\UserAccountResource;
use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Models\Admin;
use App\Models\Coach;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;

class UserAuthController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $subject = 'Account New Account';
            $admin = Admin::first();
            $validatedData = $request->validated();
          
            $user = User::create($validatedData);
        
            Mail::to($admin->email)->send(new CustomEmail(
                $subject,
                $user
            ));

            DB::commit();

            return new UserRegisterResource($user);

        } catch(\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while creating account: Email already exists'], 400);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while creating account: ' . $e->getMessage()], 404);
        }
    }

    /**
     * 
     * function get user access
     * 
     * @param Request $request
     * @param User $user
     */
    public function getUserAcc(Request $request) {
        $user = $request->user();
        $role = $request->user()->currentAccessToken()->abilities;
        $role = explode(':', $role[0])[1] ?? "";
        
        $user["role"] = $role;
        return new UserAccountResource($user);
    }

    /**
     * function login
     * 
     * @param UserLoginRequest $request
     * 
     */
    public function login(UserLoginRequest $request) {
        
        $user = User::where('email', $request->email)->first();
        if($user == null) {
            throw ValidationException::withMessages([
                'email' => ['User Email not found'],
            ]);
        }
        if($user->exists() && $user->is_verified == 0) {
            throw ValidationException::withMessages([
                'email' => ['Your account has not been verified please check your email is verified'],
            ]);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }
        $user->role = "user";

        $coachEmails = Coach::pluck('email')->toArray();
        
        if($user->id_positions == null || $user->history == null || $user->strength == null || $user->weakness == null) {
            foreach ($coachEmails as $coachEmail) {
                Mail::to($coachEmail)->send(new CustomEmail(
                    "New User Login with Incomplete Profile",
                    "A user has logged in with an incomplete profile. Please review and assist.\n\n" .
                    "Click here to view user details: " . url('user.html')
                ));
            }
        }
        
        return new AuthResource($user);
    }

    /**
     * function login admin
     * 
     * @param UserLoginRequest $request
     * 
     */
    public function adminLogin(UserLoginRequest $request) {
        
        $admin = Admin::where('email', $request->email)->first();

        if($admin == null) {
            throw ValidationException::withMessages([
                'email' => ['User Email not found'],
            ]);
        }

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }
        $admin->role = "admin";
        
        return new AuthResource($admin);
    }

    /**
     * function login coach
     * 
     * @param UserLoginRequest $request
     * 
     */
    public function coachLogin(UserLoginRequest $request) {
        
        $coach = Coach::where('email', $request->email)->first();

        if($coach == null) {
            throw ValidationException::withMessages([
                'email' => ['User Email not found'],
            ]);
        }

        // Use Hash::check for password verification
        if (!Hash::check($request->password, $coach->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect'],
            ]);
        }

        $coach->role = "coach";
        
        return new AuthResource($coach);
    }
}
