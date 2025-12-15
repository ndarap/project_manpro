<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Comments".
 *
 * @property int $comment_id
 * @property int|null $task_id
 * @property int|null $user_id
 * @property string|null $comment_text
 * @property string $created_at
 */
class Comments extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'comment_text'], 'default', 'value' => null],
            [['task_id', 'user_id'], 'integer'],
            [['comment_text'], 'string'],
            [['created_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'task_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'comment_text' => 'Comment Text',
            'created_at' => 'Created At',
        ];
    }
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'task_id']);
    }
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }


}
