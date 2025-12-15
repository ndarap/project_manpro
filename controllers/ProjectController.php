<?php

namespace app\controllers;

use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\ActivityLog;
use app\models\Notification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProjectController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($project_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($project_id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->logActivity("Created new project: " . $model->project_name);
            $this->createNotification("Project '{$model->project_name}' has been created.");

            return $this->redirect(['view', 'project_id' => $model->project_id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($project_id)
    {
        $model = $this->findModel($project_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->logActivity("Updated project: " . $model->project_name);
            $this->createNotification("Project '{$model->project_name}' has been updated.");

            return $this->redirect(['view', 'project_id' => $model->project_id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($project_id)
    {
        $model = $this->findModel($project_id);
        $this->logActivity("Deleted project: " . $model->project_name);
        $this->createNotification("Project '{$model->project_name}' has been deleted.");

        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($project_id)
    {
        if (($model = Project::findOne(['project_id' => $project_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function logActivity($message)
    {
        $userId = $this->safeUserId();
        if ($userId === null) {
            return;
        }

        $log = new ActivityLog();
        $log->user_id = $userId;
        $log->activity = $message;
        $log->timestamp = gmdate('Y-m-d H:i:s', time() + 7 * 3600); // WIB
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
