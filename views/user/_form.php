<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Project;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
        font-family: 'Poppins', sans-serif;
    }

    .users-form {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        padding: 40px;
        max-width: 800px;
        margin: 40px auto;
        animation: fadeIn 0.6s ease;
    }

    h1 {
        font-weight: 600;
        color: #007c91;
        text-align: center;
        margin-bottom: 25px;
    }

    label {
        font-weight: 500;
        color: #000000ff;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #000000ff;
        box-shadow: none;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #0097a7;
        box-shadow: 0 0 6px rgba(0, 151, 167, 0.3);
    }

    .btn-success {
        background-color: #0097a7;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 10px 30px;
        transition: 0.3s;
        letter-spacing: 0.5px;
        color: white;
    }

    .btn-success:hover {
        background-color: #00acc1;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 151, 167, 0.4);
        color: white;
    }

    .form-group {
        text-align: center;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Breadcrumb modern */
    .breadcrumb {
        background-color: rgba(255, 255, 255, 0.85);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        padding: 10px 15px;
        margin-bottom: 25px;
    }

    /* Styling untuk Select2 */
    .select2-container--krajee .select2-selection--multiple {
        border-radius: 10px;
        border: 1px solid #000000ff;
        transition: 0.3s;
    }

    .select2-container--krajee .select2-selection--multiple:focus {
        border-color: #0097a7;
        box-shadow: 0 0 6px rgba(0, 151, 167, 0.3);
    }

    .select2-container--krajee .select2-selection--multiple .select2-selection__choice {
        background-color: #0097a7;
        border-color: #007c91;
        color: white;
        border-radius: 6px;
    }

    .select2-container--krajee .select2-dropdown {
        border-radius: 10px;
        border: 1px solid #000000ff;
    }
</style>

<div class="users-form shadow-lg">
    <h1>👤 User Form</h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter Username',
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Enter Password',
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter Email Address',
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'role')->dropDownList([
                'admin' => '👑 Admin',
                'project_manager' => '📊 Project Manager',
                'team_member' => '👥 Team Member',
            ], [
                'prompt' => '🔧 Select Role',
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>

    <!-- Dropdown multi-select untuk memilih project -->
    <?= $form->field($model, 'projects')->widget(Select2::class, [
        'data' => ArrayHelper::map(Project::find()->all(), 'project_id', 'project_name'),
        'options' => [
            'multiple' => true,
            'placeholder' => '📁 Select Projects',
            'class' => 'form-control'
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('📋 Assigned Projects') ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('💾 Save User', ['class' => 'btn btn-success shadow']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>