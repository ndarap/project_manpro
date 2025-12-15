<?php

use app\models\Budget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BudgetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Budgets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Budget', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'budget_id',
            'project_id',
            'task_id',
            'amount',
            'description:ntext',
            //'spent',
            //'remaining',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Budget $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'budget_id' => $model->budget_id]);
                 }
            ],
        ],
    ]); ?>


</div>
