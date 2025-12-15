<?php

namespace app\controllers;

use Yii;
use app\models\Comments;
use app\models\CommentsSearch;
use app\models\ActivityLog;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CommentsController extends Controller
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
        $searchModel = new CommentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($comment_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($comment_id),
        ]);
    }

    public function actionCreate($task_id)
    {
        $model = new Comments();
        $model->task_id = $task_id;
        $model->user_id = Yii::$app->user->id;
        $model->created_at = gmdate('Y-m-d H:i:s', time() + 7 * 3600);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->logActivity("Added comment on task ID: $task_id");
            return $this->redirect(['task/view', 'task_id' => $task_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'task_id' => $task_id,
        ]);
    }

    public function actionUpdate($comment_id)
    {
        $model = $this->findModel($comment_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->logActivity("Updated comment ID: " . $model->comment_id);
            return $this->redirect(['view', 'comment_id' => $model->comment_id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($comment_id)
    {
        $model = $this->findModel($comment_id);
        $this->logActivity("Deleted comment ID: " . $model->comment_id);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($comment_id)
    {
        if (($model = Comments::findOne(['comment_id' => $comment_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function logActivity($message)
    {
        $log = new ActivityLog();
        $log->user_id = Yii::$app->user->id;
        $log->activity = $message;
        $log->timestamp = gmdate('Y-m-d H:i:s', time() + 7 * 3600); // WIB
        $log->save(false);
    }
}
