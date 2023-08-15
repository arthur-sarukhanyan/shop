<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken;

abstract class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return SuccessResource|RedirectResponse|ErrorResource
     */
    public function login(LoginRequest $request): SuccessResource|RedirectResponse|ErrorResource
    {
        $device_name = $request->header('User-Agent');
        $authEntity = $this->getAuthEntity($request->email);
        $isAjaxRequest = $request->expectsJson();

        if (!$authEntity || ! Hash::check($request->password, $authEntity->password)) {
            if ($isAjaxRequest) {
                return new ErrorResource(['message' => 'The provided credentials are incorrect.']);
            } else {
                return redirect('/admin/login');
            }
        }

        $entityType = get_class($authEntity);

        if ($isAjaxRequest) {
            return $this->ajaxLogin($authEntity, $entityType, $device_name);
        }

        $data = $request->except(['_token']);
        Auth::guard('web')->attempt($data, true);
        return redirect('/admin');
    }

    /**
     * @param Model $authEntity
     * @param string $entityType
     * @param string $device_name
     * @return SuccessResource
     */
    private function ajaxLogin(Model $authEntity, string $entityType, string $device_name): SuccessResource
    {
        PersonalAccessToken::where([
            'tokenable_id' => $authEntity->id,
            'tokenable_type' => $entityType,
            'name' => $device_name,
        ])->delete();

        $token = $authEntity->createToken($device_name)->plainTextToken;

        return new SuccessResource([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * @param Request $request
     * @return SuccessResource|RedirectResponse
     */
    public function logout(Request $request): SuccessResource|RedirectResponse
    {
        if ($request->expectsJson()) {
            return $this->ajaxLogout();
        }

        auth()->guard('web')->logout();
        return redirect('/admin/login');
    }

    /**
     * @return SuccessResource
     */
    private function ajaxLogout(): SuccessResource
    {
        $currentToken = auth()->user()->currentAccessToken();
        $authEntityId = $currentToken->tokenable_id;
        $authEntityType = $currentToken->tokenable_type;
        PersonalAccessToken::where([
            'tokenable_id' => $authEntityId,
            'tokenable_type' => $authEntityType
        ])->delete();

        return new SuccessResource([
            'success' => 'Logout success',
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return SuccessResource|RedirectResponse
     */
    public function register(RegisterRequest $request): SuccessResource|RedirectResponse
    {
        $credentials = $request->validated();
        $credentials['password'] = Hash::make($credentials['password']);
        $authenticateModel = $this->getAuthenticateModel();
        $authEntity = $authenticateModel::create($credentials);

        $device_name = $request->header('User-Agent');
        $token = $authEntity->createToken($device_name)->plainTextToken;

        return new SuccessResource([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
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
