<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return ErrorResource|\Illuminate\Http\Response|JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): ErrorResource|\Illuminate\Http\Response|JsonResponse|Response
    {
        if ($e instanceof ModelNotFoundException) {
            return new ErrorResource([
                'message' => 'Requested entity not found',
                'code' => 404,
            ]);
        }

        return parent::render($request, $e);
    }
}
