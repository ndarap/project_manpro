<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ActivityLog $model */

$this->title = 'Update Activity Log: ' . $model->log_id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->log_id, 'url' => ['view', 'log_id' => $model->log_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
