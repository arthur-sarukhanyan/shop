<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken;

abstract class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $device_name = $request->header('User-Agent');
        $authEntity = $this->getAuthEntity($request->email);

        if (! $authEntity || ! Hash::check($request->password, $authEntity->password)) {
            return response()->json([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $entityType = get_class($authEntity);

        PersonalAccessToken::where([
            'tokenable_id' => $authEntity->id,
            'tokenable_type' => $entityType,
            'name' => $device_name,
        ])->delete();

        $token = $authEntity->createToken($device_name)->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $currentToken = auth()->user()->currentAccessToken();
        $authEntityId = $currentToken->tokenable_id;
        $authEntityType = $currentToken->tokenable_type;
        PersonalAccessToken::where(['tokenable_id' => $authEntityId, 'tokenable_type' => $authEntityType])
            ->delete();

        return response()->json([
            'success' => 'Logout success',
        ]);
    }

    abstract function getAuthEntity(string $email): Authenticatable|null;
}
