<?php
use yii\helpers\Url;
use common\models\EduType;

$user = Yii::$app->user->identity;
$role = $user->authItem;
$logo = "/frontend/web/images/logo_blue.svg";

function getActive($cont, $act)
{
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if ($controller == $cont && $action == $act) {
        return [
            'style' => 'display: block;',
            'class' => 'menu_active',
        ];
    } else {
        return [
            'style' => '',
            'class' => '',
        ];
    }
}

function getActiveSubMenu($cont, $act)
{
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if ($controller == $cont && $action == $act) {
        return "sub_menu_active";
    } else {
        return false;
    }
}

function getActiveTwo($cont, $act)
{
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if ($controller == $cont && $action == $act) {
        return "active_menu";
    } else {
        return false;
    }
}

$eduTypes = EduType::find()
    ->where(['is_deleted' => 0])
    ->all();
?>

<div id="sidebar" class="root_left">
    <div class="sidebar-item">
        <div class="close_button">
            <span></span>
            <span></span>
        </div>
        <div class="sidebar-logo">
            <a href="<?= Url::to(['/site/index']) ?>">
                <img src="<?= $logo ?>" alt="">
            </a>
        </div>

        <div class="sidebar_menu">
            <ul class="sidebar_ul">
                <li class="sidebar_li">
                    <a href="<?= Url::to(['/']) ?>" class="sidebar_li_link <?= getActiveTwo( 'site', ''); ?>">
                        <i class="i-n fa-solid fa-house"></i>
                        <span>Bosh sahifa</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['consulting/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Hamkorlar</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['employee/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Xodimlar</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['branch/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Filiallar</span>
                    </a>
                </li>


                <li class="sidebar_li sidebar_drop">
                    <a href="javascript: void(0);" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-graduation-cap"></i>
                        <span>
                            Ta'lim jarayoni
                        </span>
                        <i class="icon-n fa-solid fa-chevron-right"></i>
                    </a>
                    <div class="menu_drop">
                        <ul class="sub_menu_ul">
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['subjects/index']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                    Fanlar
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['lang/index']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                    Ta'lim tili
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['edu-type/index']) ?>">
                                    Ta'lim turi
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['edu-form/index']) ?>">
                                    Ta'lim shakli
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['direction/index']) ?>">
                                    Yo'nalishlar
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['edu-direction/index']) ?>">
                                    Qabul
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar_li sidebar_drop">
                    <a href="javascript: void(0);" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-graduation-cap"></i>
                        <span>
                            Qabul 2025
                        </span>
                        <i class="icon-n fa-solid fa-chevron-right"></i>
                    </a>
                    <div class="menu_drop">
                        <ul class="sub_menu_ul">
                            <?php foreach ($eduTypes as $eduType) : ?>
                                <li class="sub_menu_li">
                                    <a href="<?= Url::to(['student/index' , 'id' => $eduType->id]) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                        <?= $eduType->name_uz ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['student/chala']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Chala arizalar</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['student/bot']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Telegram bot</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['student/contract']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Barcha shartnomalar</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['branch/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Umumiy arizalar</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['branch/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-user-group"></i>
                        <span>Arxiv</span>
                    </a>
                </li>



                <li class="sidebar_li sidebar_drop">
                    <a href="javascript: void(0);" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-graduation-cap"></i>
                        <span>
                            Tizim sozlamari
                        </span>
                        <i class="icon-n fa-solid fa-chevron-right"></i>
                    </a>
                    <div class="menu_drop">
                        <ul class="sub_menu_ul">
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['employee/all']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                    Foydalanuvchilar
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['auth-item/index']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                    Ro'llar
                                </a>
                            </li>
                            <li class="sub_menu_li">
                                <a href="<?= Url::to(['languages/index']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                    Til
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</div>