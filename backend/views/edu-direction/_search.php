<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EduDirectionSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="edu-direction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'direction_id') ?>

    <?= $form->field($model, 'lang_id') ?>

    <?= $form->field($model, 'duration') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'edu_type_id') ?>

    <?php // echo $form->field($model, 'edu_form_id') ?>

    <?php // echo $form->field($model, 'is_oferta') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
