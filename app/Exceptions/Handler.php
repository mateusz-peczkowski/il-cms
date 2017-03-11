<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->is('cmsbackend/*')) {
            if($exception instanceof BadRequestHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 400], 400);
            }
            if($exception instanceof UnauthorizedHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 401], 401);
            }
            if($exception instanceof AccessDeniedHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 403], 403);
            }
            if($exception instanceof NotFoundHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 404], 404);
            }
            if($exception instanceof MethodNotAllowedHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 405], 405);
            }
            if($exception instanceof NotAcceptableHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 406], 406);
            }
            if($exception instanceof ConflictHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 409], 409);
            }
            if($exception instanceof GoneHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 410], 410);
            }
            if($exception instanceof LengthRequiredHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 411], 411);
            }
            if($exception instanceof PreconditionFailedHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 412], 412);
            }
            if($exception instanceof UnsupportedMediaTypeHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 415], 415);
            }
            if($exception instanceof UnprocessableEntityHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 422], 422);
            }
            if($exception instanceof PreconditionRequiredHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 428], 428);
            }
            if($exception instanceof TooManyRequestsHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 429], 429);
            }
            if($exception instanceof ServiceUnavailableHttpException) {
                return response()->view('cmsbackend.errors', ['exception' => 503], 503);
            }
        } else if ($exception instanceof NotFoundHttpException) {
            return redirect()->route('home');
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
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
