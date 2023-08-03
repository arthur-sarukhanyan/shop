<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken;

abstract class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $device_name = $request->header('User-Agent');
        $authEntity = $this->getAuthEntity($request->email);
        $isAjaxRequest = $request->expectsJson();

        if (!$authEntity || ! Hash::check($request->password, $authEntity->password)) {
            if ($isAjaxRequest) {
                return response()->json([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            } else {
                return redirect('/admin/login');
            }
        }

        $entityType = get_class($authEntity);

        if ($isAjaxRequest) {
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
        } else {
            $data = $request->except(['_token']);
            Auth::guard('web')->attempt($data, true);
            return redirect('/admin');
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $currentToken = auth()->user()->currentAccessToken();
        $authEntityId = $currentToken->tokenable_id;
        $authEntityType = $currentToken->tokenable_type;
        PersonalAccessToken::where([
                'tokenable_id' => $authEntityId,
                'tokenable_type' => $authEntityType
            ])->delete();


        return response()->json([
            'success' => 'Logout success',
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validated();
        $credentials['password'] = Hash::make($credentials['password']);
        $authenticateModel = $this->getAuthenticateModel();
        $authEntity = $authenticateModel::create($credentials);
        $isAjaxRequest = $request->expectsJson();

        if ($isAjaxRequest) {
            $device_name = $request->header('User-Agent');
            $token = $authEntity->createToken($device_name)->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
            ]);
        } else {
            $data = $request->except(['name']);
            Auth::guard('web')->attempt($data, true);
            return redirect('/admin');
        }
    }

    /**
     * @param string $email
     * @return Authenticatable|null
     */
    abstract public function getAuthEntity(string $email): Authenticatable|null;

    /**
     * @return string
     */
    abstract public function getAuthenticateModel(): string;
}
