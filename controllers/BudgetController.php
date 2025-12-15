<?php

namespace app\controllers;

use app\models\Budget;
use app\models\BudgetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BudgetController implements the CRUD actions for Budget model.
 */
class BudgetController extends Controller
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
     * Lists all Budget models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BudgetSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Budget model.
     * @param int $budget_id Budget ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($budget_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($budget_id),
        ]);
    }

    /**
     * Creates a new Budget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Budget();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'budget_id' => $model->budget_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Budget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $budget_id Budget ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($budget_id)
    {
        $model = $this->findModel($budget_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'budget_id' => $model->budget_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Budget model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $budget_id Budget ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($budget_id)
    {
        $this->findModel($budget_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Budget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $budget_id Budget ID
     * @return Budget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($budget_id)
    {
        if (($model = Budget::findOne(['budget_id' => $budget_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
