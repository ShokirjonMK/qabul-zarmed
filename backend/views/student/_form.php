<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Student $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class='col-6'>    <?= $form->field($model, 'user_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'student_phone')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'gender')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'birthday')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'passport_serial')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'passport_pin')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'passport_issued_date')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'passport_given_date')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'passport_given_by')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'adress')->textarea(['rows' => 6]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'status')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'created_at')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'updated_at')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'created_by')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'updated_by')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'is_deleted')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'edu_type_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'edu_form_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'direction_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'edu_direction_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'lang_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'direction_course_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'course_id')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'exam_type')->textInput() ?>

</div><div class='col-6'>    <?= $form->field($model, 'edu_name')->textInput(['maxlength' => true]) ?>

</div><div class='col-6'>    <?= $form->field($model, 'edu_direction')->textInput(['maxlength' => true]) ?>

</div>    </div>

    <div class="form-group d-flex justify-content-end mt-4 mb-3">
        <?= Html::submitButton('Saqlash', ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
