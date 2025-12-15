<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "budget".
 *
 * @property int $budget_id
 * @property int|null $project_id
 * @property int|null $task_id
 * @property float|null $amount
 * @property string|null $description
 * @property float|null $spent
 * @property float|null $remaining
 */
class Budget extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'budget';
    }

    public function rules()
    {
        return [
            [['project_id', 'task_id'], 'integer'],
            [['amount', 'spent', 'remaining'], 'number'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'budget_id' => 'Budget ID',
            'project_id' => 'Project ID',
            'task_id' => 'Task ID',
            'amount' => 'Amount',
            'description' => 'Description',
            'spent' => 'Spent',
            'remaining' => 'Remaining',
        ];
    }
      // 🧩 Tambahkan relasi di sini
    public function getProject()
    {
        return $this->hasOne(Project::class, ['project_id' => 'project_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['task_id' => 'task_id']);
    }
}

