<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Status;
use kartik\select2\Select2;
use common\models\Direction;
use common\models\EduType;
use common\models\EduForm;
use common\models\Lang;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\EduDirection $model */
/** @var yii\widgets\ActiveForm $form */
$directions = Direction::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
$langs = Lang::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
$eduTypes = EduType::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
$eduForms = EduForm::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
?>

<div class="edu-direction-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'direction_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($directions, 'id', 'name'),
                'options' => ['placeholder' => 'Yo\'nalishlar'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Yo\'nalishlar'); ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'edu_type_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($eduTypes, 'id', 'name_uz'),
                'options' => ['placeholder' => 'Ta\'lim turi'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Ta\'lim turi'); ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'edu_form_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($eduForms, 'id', 'name_uz'),
                'options' => ['placeholder' => 'Ta\'lim shakli'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Ta\'lim shakli'); ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'lang_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($langs, 'id', 'name_uz'),
                'options' => ['placeholder' => 'Ta\'lim tili'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Ta\'lim tili'); ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'is_oferta')->widget(Select2::classname(), [
                'data' => Status::ofertaStatus(),
                'options' => ['placeholder' => 'Oferta status tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class='col-12 col-md-6 col-lg-4'>
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Status::accessStatus(),
                'options' => ['placeholder' => 'Status tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group d-flex justify-content-end mt-4 mb-3">
        <?= Html::submitButton('Saqlash', ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
