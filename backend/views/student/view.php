<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Student $model */

$this->title = 'Ko\'rish';
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="page">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs['item'] as $item) : ?>
            <li class='breadcrumb-item'>
                <?= Html::a($item['label'], $item['url'], ['class' => '']) ?>
            </li>
            <?php endforeach; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <p class="mb-3">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'b-btn b-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Ma\'lumotni o\'chirishni xoxlaysizmi?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="grid-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
            'user_id',
            'first_name',
            'last_name',
            'middle_name',
            'student_phone',
            'username',
            'password',
            'gender',
            'birthday',
            'passport_number',
            'passport_serial',
            'passport_pin',
            'passport_issued_date',
            'passport_given_date',
            'passport_given_by',
            'adress:ntext',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'is_deleted',
            'edu_type_id',
            'edu_form_id',
            'direction_id',
            'edu_direction_id',
            'lang_id',
            'direction_course_id',
            'course_id',
            'exam_type',
            'edu_name',
            'edu_direction',
            ],
        ]) ?>
    </div>

</div>
