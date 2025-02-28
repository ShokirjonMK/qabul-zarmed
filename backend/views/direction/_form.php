<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Status;

/** @var yii\web\View $this */
/** @var common\models\Direction $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="direction-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class='col-6 col-md-4'>
            <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-6 col-md-4'>
            <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-6 col-md-4'>
            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-6 col-md-4'>
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class='col-6 col-md-4'>
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Status::accessStatus(),
                'options' => ['placeholder' => 'Status tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group d-flex justify-content-end mt-4 mb-2">
        <?= Html::submitButton('Saqlash', ['class' => 'b-btn b-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
