<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_log".
 *
 * @property int $log_id
 * @property int|null $user_id
 * @property string|null $activity
 * @property string $timestamp
 *
 * @property Users $user
 */
class ActivityLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_log';
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['user_id' => 'user_id']);
    }

    /**
     * Set timestamp otomatis sebelum menyimpan data
     */
    public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        // Set zona waktu ke WIB (Asia/Jakarta)
        date_default_timezone_set('Asia/Jakarta');

        // Jika ini data baru dan timestamp belum diisi, isi otomatis dengan waktu sekarang
        if ($insert && empty($this->timestamp)) {
            $this->timestamp = date('Y-m-d H:i:s');
        }
        return true;
    }
    return false;
}

}
