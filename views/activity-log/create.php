<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ActivityLog $model */

$this->title = 'Create Activity Log';
$this->params['breadcrumbs'][] = ['label' => 'Activity Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
