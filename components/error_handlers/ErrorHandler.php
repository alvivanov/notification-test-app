<?php

declare(strict_types=1);

namespace app\components\error_handlers;

use app\components\exceptions\ModelValidationException;
use yii\base\ErrorHandler as BaseErrorHandler;
use yii\web\HttpException;
use yii\web\Response;

final class ErrorHandler extends BaseErrorHandler
{
    protected function renderException($exception): void
    {
        if (\Yii::$app->has('response')) {
            $response          = \Yii::$app->getResponse();
            $response->isSent  = false;
            $response->stream  = null;
            $response->data    = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $response->format = Response::FORMAT_JSON;
        $response->setStatusCode(500);
        $message   = YII_DEBUG ? $exception->getMessage() : 'Error';
        $extraData = [];

        if ($exception instanceof HttpException) {
            $response->setStatusCode($exception->statusCode);
            $message = $exception->getMessage();
        }

        if ($exception instanceof \DomainException) {
            $response->setStatusCode(400);
            $message = $exception->getMessage();
        }

        if ($exception instanceof ModelValidationException) {
            $message = $exception->getMessage();
            $response->setStatusCode(422);
            $extraData = ['errors' => $exception->errors];
        }

        $response->data = [
            'status_code' => $response->statusCode,
            'message'     => $message,
            ...$extraData,
        ];

        $response->send();
    }
}
