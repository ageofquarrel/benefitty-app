<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\JsonResponse;

class AuthorizationController extends Controller
{
    /**
     * Регистрация
     * 
     * @param Request
     * @return array
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        $user = User::create([
            'email'     => $request->email,
            'name'      => $request->name,
            'password'  => Hash::make($request->password)
        ]);

        return response()->json($this->createTokens($user));
    }

    /**
    * Авторизация
    *
    * @param Request $request
    * @return array
    */
    public function auth(AuthorizationRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
     
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'Вы ввели неверные данные'
            ]);
        }
     
        return response()->json($this->createTokens($user));
    }

    /**
     * @param User $user
     * @return array
     */
    private function createTokens(User $user): array
    {
        $accessToken = $user->createToken(
            'access_token', 
            ['*'], 
            Carbon::now()->addMinutes(config('sanctum.ac_expiration'))
        );
        
        $refreshToken = $user->createToken(
            'refresh_token', 
            ['*'], 
            Carbon::now()->addMinutes(config('sanctum.rt_expiration'))
        );
        
        return [
            'token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken
        ];
    }
}