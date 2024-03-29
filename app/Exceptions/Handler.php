<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        
        return parent::render($request, $exception);

        //log the exception

        //error_reporting(0);
        //return view('errors.404');
    }

    // public function render($request, Exception $exception)
    // {
    //     if ($exception instanceof ErrorException) {
    //         error_reporting(0);

    //         $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    //         $response = $kernel->handle($request)->send();
    //         return $kernel->terminate($request, $response);
    //     }

    //     return parent::render($request, $exception);
    // }
}
