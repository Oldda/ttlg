<?php

namespace App\Exceptions;

use App\Facades\ApiReturn;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        //接口返回格式
        switch ($exception){
            case $exception instanceof MethodNotAllowedHttpException:
                return ApiReturn::handle('METHOD_NOT_ALLOWED');
                break;
            case $exception instanceof NotFoundHttpException:
                return ApiReturn::handle('API_URL_NOT_FOUND');
                break;
        }
        return parent::render($request, $exception);
    }

    //重写表单验证失败返回格式
    protected function invalid($request, ValidationException $exception)
    {
        return response()->json([
            'status'=>false,
            'response_code' => 302,
            'response_time'=> date('Y-m-d H:i:s'),
            'msg' => $exception->getMessage(),
            'errors' => $exception->errors(),
        ], 302); //$exception->status
    }
}
