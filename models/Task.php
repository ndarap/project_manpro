<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $task_id
 * @property int|null $project_id
 * @property string|null $task_name
 * @property string|null $description
 * @property int|null $assigned_to
 * @property string|null $status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property float|null $budget
 */
class Task extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tasks';
    }

    public function rules()
    {
        return [
            [['project_id', 'assigned_to'], 'integer'],
            [['description', 'status'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['budget'], 'number'],
            [['task_name'], 'string', 'max' => 100],
            [['task_name', 'status'], 'required'], // tambahkan ini biar field tidak kosong
            [['status'], 'string', 'max' => 20],

        ];
    }

    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'project_id' => 'Project ID',
            'task_name' => 'Task Name',
            'description' => 'Description',
            'assigned_to' => 'Assigned To',
            'status' => 'Status',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'budget' => 'Budget',
        ];
    }
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['task_id' => 'task_id']);
    }
}
