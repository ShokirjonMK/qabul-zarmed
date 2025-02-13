<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Student;
use common\models\StudentPerevot;
use common\models\StudentOferta;
use common\models\StudentDtm;
use common\models\StudentMaster;

/** @var Student $student */

$lang = Yii::$app->language;
$this->title = Yii::t("app", "a44");
$eduDirection = $student->eduDirection;

$documents = [];

if ($student->edu_type_id == 2) {
    $documents[] = [
        'model' => StudentPerevot::findOne([ 'edu_direction_id' => $eduDirection->id, 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0 ]),
        'title' => Yii::t("app", "a86"),
        'button' => Yii::t("app", "a88"),
        'upload_url' => 'file/create-tr',
        'delete_url' => 'file/del-tr'
    ];
} elseif ($student->edu_type_id == 3) {
    $documents[] = [
        'model' => StudentDtm::findOne([ 'edu_direction_id' => $eduDirection->id, 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0 ]),
        'title' => Yii::t("app", "a148"),
        'button' => Yii::t("app", "a150"),
        'upload_url' => 'file/create-dtm',
        'delete_url' => 'file/del-dtm'
    ];
} elseif ($student->edu_type_id == 4) {
    $documents[] = [
        'model' => StudentMaster::findOne([ 'edu_direction_id' => $eduDirection->id, 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0 ]),
        'title' => Yii::t("app", "a148"),
        'button' => Yii::t("app", "a150"),
        'upload_url' => 'file/create-dtm',
        'delete_url' => 'file/del-dtm'
    ];
}

if ($eduDirection->is_oferta == 1) {
    $documents[] = [
        'model' => StudentOferta::findOne([ 'edu_direction_id' => $eduDirection->id, 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0 ]),
        'title' => Yii::t("app", "a127"),
        'button' => Yii::t("app", "a128"),
        'upload_url' => 'file/create-oferta',
        'delete_url' => 'file/del-oferta'
    ];
}

function renderDocumentBox($document) {
    if (!$document['model']) return;
    ?>
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="cfile_box">
            <div class="cfile_box_head_right <?= ($document['model']->file_status == 0 || $document['model']->file_status == 3) ? 'danger' : (($document['model']->file_status == 2) ? 'active' : '') ?>">
                <p><?= Yii::t("app", "a" . (82 + $document['model']->file_status)) ?></p>
            </div>
            <div class="cfile_box_head">
                <div class="cfile_box_head_left">
                    <h5><span></span> <?= $document['title'] ?></h5>
                </div>
            </div>
            <?php if ($document['model']->file_status == 0) : ?>
                <div class="cfile_box_content_upload">
                    <?= Html::a($document['button'], Url::to([$document['upload_url'], 'id' => $document['model']->id]), [
                        "data-bs-toggle" => "modal",
                        "data-bs-target" => "#studentModalUpload"
                    ]) ?>
                </div>
            <?php else: ?>
                <div class="cfile_box_content">
                    <div class="cfile_box_content_file">
                        <div class="cfile_box_content_file_left">
                            <a href="/frontend/web/uploads/<?= $document['model']->student_id ?>/<?= $document['model']->file ?>" target="_blank">
                                <span><i class="fa-solid fa-file-export"></i></span> <?= Yii::t("app", "a89") ?>
                            </a>
                        </div>
                        <?php if ($document['model']->file_status != 2) : ?>
                            <div class="cfile_box_content_file_right">
                                <?= Html::a('<i class="fa-solid fa-trash"></i>', Url::to([$document['delete_url'], 'id' => $document['model']->id]), [
                                    "data-bs-toggle" => "modal",
                                    "data-bs-target" => "#studentModalDelete"
                                ]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
?>

<div class="ika_page_box">
    <div class="ika_page_box_item">
        <div class="ikpage">
            <div class="htitle">
                <h6><?= Yii::t("app", "a44") ?></h6>
                <span></span>
            </div>
            <div class="row top40">
                <?php foreach ($documents as $document) renderDocumentBox($document); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="studentModalUpload" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" id="modalUploadBody"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="studentModalDelete" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" id="modalDeleteBody"></div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
    $('#studentModalUpload, #studentModalDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('.modal-body').load(url);
    });
});
JS;
$this->registerJs($js);
?>
