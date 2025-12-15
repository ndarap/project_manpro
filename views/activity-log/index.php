<?php

use app\models\ActivityLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ActivityLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Activity Logs';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
        font-family: 'Poppins', sans-serif;
    }

    .activity-log-index {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
        animation: fadeIn 0.5s ease-in-out;
    }

    h1 {
        text-align: center;
        color: #000000ff;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .btn-success {
        background-color: #0097a7;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
        transition: 0.3s;
    }


    .btn-success:hover {
        background-color: #2bb0c2ff;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 151, 167, 0.4);
    }

    .grid-view {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .grid-view table {
        border: none !important;
    }

    .grid-view th {
        background: #028694ff;
        color: white;
        text-align: center;
        font-weight: 500;
    }

    .grid-view td {
        text-align: center;
        vertical-align: middle !important;
    }

    .breadcrumb {
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 12px;
        padding: 10px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table thead th a {
        color: white !important;
    }

    .table thead th {
        color: white !important;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        /* jarak antar tombol */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="activity-log-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-end mb-4">
        <?= Html::a('📝 Create Activity Log', ['create'], ['class' => 'btn btn-success shadow-sm', 'style' => 'color: black;']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-hover table-bordered align-middle'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '#',
                'headerOptions' => ['style' => 'background-color:#007c91;color:white;text-align:center'],
            ],
            [
                'attribute' => 'log_id',
                'contentOptions' => ['style' => 'width:5%;text-align:center;']
            ],
            [
                'attribute' => 'user_id',
                'label' => 'User ID',
                'contentOptions' => ['style' => 'text-align:center;']
            ],
            [
                'attribute' => 'activity',
                'contentOptions' => ['style' => 'text-align:center;'],
            ],
            [
                'attribute' => 'timestamp',
                'contentOptions' => ['style' => 'text-align:center;'],
                'format' => 'datetime'
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Actions',
                'headerOptions' => ['style' => 'background-color:#007c91;color:white;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'template' => '<div class="action-buttons">{view} {update} {delete}</div>',
                'buttons' => [
                    'view' => fn($url) => Html::a('👁', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'View Activity']),
                    'update' => fn($url) => Html::a('✏️', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit Activity']),
                    'delete' => fn($url) => Html::a('🗑', $url, [
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this activity log?',
                            'method' => 'post',
                        ],
                    ]),
                ],
                'urlCreator' => function ($action, ActivityLog $model) {
                        return Url::toRoute([$action, 'log_id' => $model->log_id]);
                    },
            ],
        ],
    ]); ?>
</div>