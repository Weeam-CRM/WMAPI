<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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

    public function render($request, Throwable $e)
    {
<<<<<<< Updated upstream
        // Check if the request is an API request
        if ($request->is('api/*') || $request->wantsJson() || $request->expectsJson()) {
            // Handle authentication errors for API requests
            if ($e instanceof AuthenticationException || $e instanceof UnauthorizedHttpException) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            // Handle token mismatch errors for API requests
            if ($e instanceof TokenMismatchException) {
                return response()->json(['error' => 'Token mismatch.'], 403);
            }

            // Handle other error responses for API requests
            $response = parent::render($request, $e);

            if ($response->isServerError() || $response->isClientError()) {
                return response()->json(['error' => 'Server Error.'], $response->status());
            }

            return $response;
        }

        // For non-API (web) requests, handle errors differently
        $response = parent::render($request, $e);

        if (!app()->environment(['local', 'testing', 'development']) && in_array($response->status(), [500, 503, 404, 403])) {
=======
        if ($e instanceof AuthenticationException || $e instanceof UnauthorizedHttpException) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $response = parent::render($request, $e);

        if (! app()->environment(['local', 'testing', 'development']) && in_array($response->status(), [500, 503, 404, 403])) {
>>>>>>> Stashed changes
            return Inertia::render('Core/Error', ['status' => $response->status()])
                ->toResponse($request)
                ->setStatusCode($response->status());
        } elseif ($response->status() === 419) {
            return back()->with([
                'message' => 'The page expired, please try again.',
            ]);
        }

        return $response;
    }
}
