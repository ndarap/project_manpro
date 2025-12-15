<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Project;
use app\models\Users;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
/** @var yii\widgets\ActiveForm $form */

$projects = ArrayHelper::map(Project::find()->all(), 'project_id', 'project_name');
$users = ArrayHelper::map(Users::find()->all(), 'user_id', 'username');
?>

<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
        font-family: 'Poppins', sans-serif;
    }

    .task-form {
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
    }

    .btn-success:hover {
        background-color: #00acc1;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 151, 167, 0.4);
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
</style>

<div class="task-form shadow-lg">
    <h1></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'project_id')->dropDownList($projects, ['prompt' => '📁 Select Project']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'task_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Task Name']) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 5, 'placeholder' => 'Describe the task details...']) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'assigned_to')->dropDownList($users, ['prompt' => '👤 Assign to User']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList([
                'not_started' => '⏳ Not Started',
                'in_progress' => '🚧 In Progress',
                'completed' => '✅ Completed',
            ], ['prompt' => 'Select Status']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'start_date')->input('date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'end_date')->input('date') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?= $form->field($model, 'budget')->textInput(['maxlength' => true, 'placeholder' => 'Enter Budget Amount (Rp)']) ?>
        </div>
    </div>

    <div class="form-group mt-4">
        <?= Html::submitButton('💾 Save Task', ['class' => 'btn btn-success shadow']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
