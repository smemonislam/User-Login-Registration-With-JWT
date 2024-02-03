<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Helper\JWTHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class userController extends Controller
{
    public function userRegister(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|string|email|max:50|unique:users,email',
                'mobile' => 'required|string|max:15',
                'password' => 'required|string|min:6',
            ]);

            User::create($validated);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'User registration successfully.',
                ],
                Response::HTTP_CREATED,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }


    function userLogin(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = JWTHelper::CreateToken($request->input('email'), $user->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful.'
                ])->cookie('token_message', $token, time() + 60 * 60);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Invalid credentials.'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
