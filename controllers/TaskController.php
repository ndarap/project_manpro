<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use app\models\ActivityLog;
use app\models\Notification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TaskController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['delete' => ['POST']],
            ],
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($task_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($task_id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // === ACTIVITY LOG ===
            $this->logActivity("Created new task: " . $model->task_name);
            $this->createNotification("Task '{$model->task_name}' has been created.");

            return $this->redirect(['view', 'task_id' => $model->task_id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($task_id)
    {
        $model = $this->findModel($task_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // === ACTIVITY LOG ===
            $this->logActivity("Updated task: " . $model->task_name);
            $this->createNotification("Task '{$model->task_name}' has been updated.");


            return $this->redirect(['view', 'task_id' => $model->task_id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($task_id)
    {
        $model = $this->findModel($task_id);

        // === ACTIVITY LOG ===
        $this->logActivity("Deleted task: " . $model->task_name);
        $this->createNotification("Task '{$model->task_name}' has been deleted.");

        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($task_id)
    {
        if (($model = Task::findOne(['task_id' => $task_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function logActivity($message)
    {
        $userId = $this->safeUserId();
        if ($userId === null) {
            return; // STOP kalau user tidak valid
        }

        $log = new ActivityLog();
        $log->user_id = $userId;
        $log->activity = $message;
        $log->timestamp = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
        $log->save();
    }
    private function createNotification($message)
    {
        $userId = $this->safeUserId();
        if ($userId === null) {
            return;
        }

        $notif = new Notification();
        $notif->user_id = $userId;
        $notif->message = $message;
        $notif->created_at = date('Y-m-d H:i:s');
        $notif->is_read = 0;
        $notif->save();
    }

    private function safeUserId()
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }

        $userId = Yii::$app->user->id;

        $exists = (new \yii\db\Query())
            ->from('users')
            ->where(['user_id' => $userId])
            ->exists();

        return $exists ? $userId : null;
    }


}


