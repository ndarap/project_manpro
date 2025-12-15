<?php

namespace app\controllers;

use app\models\ActivityLog;
use app\models\ActivityLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityLogController implements the CRUD actions for ActivityLog model.
 */
class ActivityLogController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ActivityLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ActivityLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivityLog model.
     * @param int $log_id Log ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($log_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($log_id),
        ]);
    }

    /**
     * Creates a new ActivityLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ActivityLog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'log_id' => $model->log_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ActivityLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $log_id Log ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($log_id)
    {
        $model = $this->findModel($log_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'log_id' => $model->log_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ActivityLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $log_id Log ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($log_id)
    {
        $this->findModel($log_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ActivityLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $log_id Log ID
     * @return ActivityLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($log_id)
    {
        if (($model = ActivityLog::findOne(['log_id' => $log_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
