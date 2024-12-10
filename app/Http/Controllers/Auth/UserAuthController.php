<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserRegisterResource;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Mail;

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
}
