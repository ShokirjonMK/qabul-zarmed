<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\StudentSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?php // echo $form->field($model, 'student_phone') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'passport_number') ?>

    <?php // echo $form->field($model, 'passport_serial') ?>

    <?php // echo $form->field($model, 'passport_pin') ?>

    <?php // echo $form->field($model, 'passport_issued_date') ?>

    <?php // echo $form->field($model, 'passport_given_date') ?>

    <?php // echo $form->field($model, 'passport_given_by') ?>

    <?php // echo $form->field($model, 'adress') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'edu_type_id') ?>

    <?php // echo $form->field($model, 'edu_form_id') ?>

    <?php // echo $form->field($model, 'direction_id') ?>

    <?php // echo $form->field($model, 'edu_direction_id') ?>

    <?php // echo $form->field($model, 'lang_id') ?>

    <?php // echo $form->field($model, 'direction_course_id') ?>

    <?php // echo $form->field($model, 'course_id') ?>

    <?php // echo $form->field($model, 'exam_type') ?>

    <?php // echo $form->field($model, 'edu_name') ?>

    <?php // echo $form->field($model, 'edu_direction') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
