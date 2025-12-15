<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Task $model */

$this->title = $model->task_name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tasks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Task', ['update', 'task_id' => $model->task_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete Task', ['delete', 'task_id' => $model->task_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this task?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'task_id',
            'project_id',
            'task_name',
            'description:ntext',
            'assigned_to',
            'status',
            'start_date',
            'end_date',
            'budget',
        ],
    ]) ?>

    <hr>
    <h3>Comments</h3>

    <!-- Tombol untuk menambah komentar -->
    <?= Html::a('Add Comment', ['comments/create', 'task_id' => $model->task_id], ['class' => 'btn btn-success mb-3']) ?>

    <!-- Daftar komentar -->
    <ul style="list-style-type:none; padding-left:0;">
        <?php foreach ($model->comments as $comment): ?>
            <li style="margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:10px;">
                <strong>
                    <?= Html::encode($comment->user->username ?? 'Unknown User') ?>:
                </strong>
                <?= Html::encode($comment->comment_text) ?>
                <br>
                <small class="text-muted">
                    <?= Yii::$app->formatter->asDatetime($comment->created_at) ?>
                </small>

                <!-- Tombol Edit & Delete untuk komentar -->
                <div style="margin-top:5px;">
                    <?= Html::a('Edit', ['comments/update', 'comment_id' => $comment->comment_id], ['class' => 'btn btn-sm btn-warning']) ?>
                    <?= Html::a('Delete', ['comments/delete', 'comment_id' => $comment->comment_id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this comment?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
