<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request)
    {
       $input = $request->all();
       Auth::attempt($input);
       $user = Auth::user();
       $token = $user->createToken('token')->accessToken;

        return Response(['status' => 200, 'token' => $token], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getUserDetail()
    {
        $user = Auth::guard('api')->user();
        return Response(['Data' => $user],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
