<?php

namespace Spa\Exceptions;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Watson\Validating\ValidationException as SelfValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /** @var Response $response */
        $response = app(Response::class);

        if ($exception instanceof SelfValidationException) {
            return $response->errorWrongArgs($exception->getMessageBag());
        }
        if ($exception instanceof AuthorizationException) {
            return $response->errorForbidden($exception->getMessage());
        }

        if ($exception instanceof NotFoundHttpException) {
            return $response->errorNotFound(trans('exceptions.route_not_found'));
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $response->errorMethodNotAllowed(trans('exceptions.method_not_allowed', ['method' => $request->getMethod()]));
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = last(explode("\\", $exception->getModel()));

            return $response->errorNotFound(trans('exceptions.no_query_result_for_model', ['model' => $model]));
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  AuthenticationException  $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
