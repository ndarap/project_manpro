<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Task;

class CalendarController extends Controller
{
    /**
     * Halaman kalender
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Endpoint event untuk FullCalendar (JSON)
     */
    public function actionEvents()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $tasks = Task::find()->all();
        $events = [];

        foreach ($tasks as $task) {
            $events[] = [
                'id' => $task->task_id,
                'title' => $task->task_name,
                'start' => $task->start_date,
                'end' => $task->end_date,
            ];
        }

        return $events;
    }
}
