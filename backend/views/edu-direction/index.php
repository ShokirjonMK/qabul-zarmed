<?php

use common\models\EduDirection;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Direction;
use common\models\Lang;
use common\models\EduType;
use common\models\EduForm;

/** @var yii\web\View $this */
/** @var common\models\EduDirectionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'E\'lon qilingan yo\'nalishlar';
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$directions = Direction::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
$langs = Lang::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
$eduTypes = EduType::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
$eduForms = EduForm::find()
    ->where(['is_deleted' => 0 , 'status' => 1])->all();
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

    <p class="mb-3 mt-4">
        <?= Html::a('Q\'shish', ['create'], ['class' => 'b-btn b-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute' => 'direction_id',
               'contentOptions' => ['date-label' => 'direction_id'],
               'format' => 'raw',
               'value' => function($model) {
                    $direction = $model->direction;
                   return $direction->code." - ".$direction->name_uz;
               },
               'filter' => Html::activeDropDownList($searchModel, 'direction_id',
                   ArrayHelper::map($directions, 'id', 'name'),
                   ['class'=>'form-control','prompt' => 'Yo\'nalish tanlang ...']),
            ],
            [
               'attribute' => 'lang_id',
               'contentOptions' => ['date-label' => 'lang_id'],
               'format' => 'raw',
               'value' => function($model) {
                   return $model->lang->name_uz;
               },
               'filter' => Html::activeDropDownList($searchModel, 'lang_id',
                    ArrayHelper::map($langs, 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Til tanlang ...']),
            ],
            [
                'attribute' => 'edu_type_id',
                'contentOptions' => ['date-label' => 'edu_type_id'],
                'format' => 'raw',
                'value' => function($model) {
                    return $model->eduType->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_type_id',
                    ArrayHelper::map($eduTypes, 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Ta\'lim turini tanlang ...']),
            ],
            [
                'attribute' => 'edu_form_id',
                'contentOptions' => ['date-label' => 'edu_form_id'],
                'format' => 'raw',
                'value' => function($model) {
                    return $model->eduForm->name_uz;
                },
                'filter' => Html::activeDropDownList($searchModel, 'edu_form_id',
                    ArrayHelper::map($eduForms, 'id', 'name_uz'),
                    ['class'=>'form-control','prompt' => 'Ta\'lim shaklini tanlang ...']),
            ],
            [
               'attribute' => 'duration',
               'contentOptions' => ['date-label' => 'duration'],
               'format' => 'raw',
               'value' => function($model) {
                   return $model->duration;
               },
            ],
            [
               'attribute' => 'price',
               'contentOptions' => ['date-label' => 'price'],
               'format' => 'raw',
               'value' => function($model) {
                   return $model->price;
               },
            ],
            [
                'attribute' => 'Item',
                'contentOptions' => ['data-label' => 'Item'],
                'format' => 'raw',
                'value' => function ($model) {
                    $labels = [
                        1 => ['url' => 'direction-subject/index', 'text' => 'Fanlar'],
                        2 => ['url' => 'direction-course/index', 'text' => 'Bosqichlar'],
                    ];

                    if (isset($labels[$model->edu_type_id])) {
                        $url = Url::to([$labels[$model->edu_type_id]['url'], 'id' => $model->id]);
                        $text = $labels[$model->edu_type_id]['text'];
                        return "<a href='{$url}' class='badge-table-div active'><span>{$text}</span></a>";
                    }

                    return null;
                },
            ],

            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'view',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->id]);
                        return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                            'title' => 'update',
                            'class' => 'tableIcon',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => 'delete',
                            'class' => 'tableIcon',
                            'data-confirm' => Yii::t('yii', 'Ma\'lumotni o\'chirishni xoxlaysizmi?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
