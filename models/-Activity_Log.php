<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Activity_Log".
 *
 * @property int $log_id
 * @property int|null $user_id
 * @property string|null $activity
 * @property string $timestamp
 */
class Activity_Log extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Activity_Log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'activity'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['activity'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'user_id' => 'User ID',
            'activity' => 'Activity',
            'timestamp' => 'Timestamp',
        ];
    }

}
