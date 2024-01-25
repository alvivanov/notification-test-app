<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Notification\Notification;
use app\services\NotificationManager\NotificationManagerInterface;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\rest\Serializer;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class NotificationsController extends Controller
{
    public $serializer = Serializer::class;

    public function __construct(
        $id,
        $module,
        $config,
        private readonly NotificationManagerInterface $notificationManager,
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            [
                'class'   => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionCreate(Request $request): array
    {
        $this->notificationManager->create($request->post());
        \Yii::$app->response->setStatusCode(201);

        return [
            'status_code' => 201,
            'message'     => 'Notification created',
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate(Request $request, int $id): array
    {
        $this->notificationManager->update($this->findNotification($id), $request->post());

        return [
            'status_code' => 200,
            'message'     => 'Notification updated',
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findNotification(int $id): Notification
    {
        return Notification::findOne(['id' => $id]) ?? throw new NotFoundHttpException('Notification not found');
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): array
    {
        $this->notificationManager->delete($this->findNotification($id));

        return [
            'status_code' => 200,
            'message'     => 'Notification deleted',
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): array
    {
        return [
            'status_code' => 200,
            'message'     => 'Success',
            'data'        => $this->findNotification($id),
        ];
    }

    public function actionIndex(): array
    {
        return [
            'status_code' => 200,
            'message'     => 'Success',
            'data'        => new ActiveDataProvider(['query' => Notification::find()]),
        ];
    }

    protected function verbs(): array
    {
        return [
            'index'  => ['GET', 'HEAD'],
            'view'   => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
}
