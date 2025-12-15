<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Budget $model */

$this->title = $model->budget_id;
$this->params['breadcrumbs'][] = ['label' => 'Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="budget-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'budget_id' => $model->budget_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'budget_id' => $model->budget_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'budget_id',
            'project_id',
            'task_id',
            'amount',
            'description:ntext',
            'spent',
            'remaining',
        ],
    ]) ?>

</div>
