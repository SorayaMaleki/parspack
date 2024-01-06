<?php

namespace App\Exceptions;

use App\Traits\Response\ApiResponse;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport
      = [
          //
      ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash
      = [
        'current_password',
        'password',
        'password_confirmation',
      ];

    /* Render an exception into an HTTP response.
    *
    * @param  Request request
    * @param  Throwable  $exception
    * @return Response
    * @throws Throwable
    */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            return match (get_class($exception)) {
                MethodNotAllowedHttpException::class => $this->errorResponse(
                  [__('api.method_not_allowed')],
                  $exception->getStatusCode()
                ),

                NotFoundHttpException::class => $this->errorResponse(
                  [__('api.not_found')],
                  $exception->getStatusCode()
                ),
                ModelNotFoundException ::class => $this->errorResponse(
                  [__('api.record_not_found')],
                  404
                ),

                ValidationException::class => $this->errorResponse(
                  $exception->errors(),
                  $exception->status,
                ),
                AuthenticationException ::class => $this->errorResponse(
                  [__('auth.Unauthenticated'),],
                  401,
                ),
                CommentValidationException ::class => $this->errorResponse(
                  [$exception->getMessage()],
                  403,
                ),

                Exception::class => $this->errorResponse(
                  [$exception->getMessage()],
                  $exception->getCode()
                ),

                default => $this->errorResponse()
            };
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

}
