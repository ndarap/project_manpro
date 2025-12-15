<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property int $project_id
 * @property string|null $project_name
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $created_by
 * @property float|null $budget
 *
 * @property Budget[] $budgets
 * @property Users $createdBy
 * @property ProjectUser[] $projectUsers
 * @property Task[] $tasks
 * @property Users[] $users
 */
class Project extends \yii\db\ActiveRecord
{
    // 🧩 Properti virtual untuk menampung data dari Select2
    public $users = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_name', 'description', 'start_date', 'end_date', 'created_by', 'budget'], 'default', 'value' => null],
            [['description'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['created_by'], 'integer'],
            [['budget'], 'number'],
            [['project_name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['created_by' => 'user_id']],

            // validasi tambahan untuk properti virtual
            [['users'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'project_name' => 'Project Name',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'created_by' => 'Created By',
            'budget' => 'Budget',
            'users' => 'Users', // label untuk Select2
        ];
    }

    /** 🔗 Relasi ke tabel budgets */
    public function getBudgets()
    {
        return $this->hasMany(Budget::class, ['project_id' => 'project_id']);
    }

    /** 🔗 Relasi ke pembuat proyek */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::class, ['user_id' => 'created_by']);
    }

    /** 🔗 Relasi ke tabel pivot project_user */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'project_id']);
    }

    /** 🔗 Relasi ke tabel task */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'project_id']);
    }

    /** 🔗 Relasi many-to-many ke tabel users */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['user_id' => 'user_id'])
            ->viaTable('project_user', ['project_id' => 'project_id']);
    }

    /** 🧮 Isi $users saat model di-load */
    public function afterFind()
    {
        parent::afterFind();
        $this->users = $this->getUsers()->select('user_id')->column();
    }

    /** 💾 Simpan relasi ke tabel project_user setelah project dibuat/diubah */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Hapus relasi lama
        ProjectUser::deleteAll(['project_id' => $this->project_id]);

        // Tambahkan relasi baru
        if (is_array($this->users)) {
            foreach ($this->users as $userId) {
                $link = new ProjectUser();
                $link->project_id = $this->project_id;
                $link->user_id = $userId;
                $link->save();
            }
        }
    }
}
