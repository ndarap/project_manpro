<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $email
 * @property string|null $role
 *
 * @property ActivityLog[] $activityLogs
 * @property Comments[] $comments
 * @property ProjectUser[] $projectUsers
 * @property Project[] $projects
 * @property Task[] $tasks
 */
class Users extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_PROJECT_MANAGER = 'project_manager';
    const ROLE_TEAM_MEMBER = 'team_member';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'role'], 'default', 'value' => null],
            [['role'], 'string'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[ActivityLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityLogs()
    {
        return $this->hasMany(ActivityLog::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[ProjectUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['created_by' => 'user_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['assigned_to' => 'user_id']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_ADMIN => 'admin',
            self::ROLE_PROJECT_MANAGER => 'project_manager',
            self::ROLE_TEAM_MEMBER => 'team_member',
        ];
    }

    /**
     * @return string
     */
    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    /**
     * @return bool
     */
    public function isRoleAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setRoleToAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRoleProjectmanager()
    {
        return $this->role === self::ROLE_PROJECT_MANAGER;
    }

    public function setRoleToProjectmanager()
    {
        $this->role = self::ROLE_PROJECT_MANAGER;
    }

    /**
     * @return bool
     */
    public function isRoleTeammember()
    {
        return $this->role === self::ROLE_TEAM_MEMBER;
    }

    public function setRoleToTeammember()
    {
        $this->role = self::ROLE_TEAM_MEMBER;
    }
}
