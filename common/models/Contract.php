<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string $full_name
 * @property string $adress
 * @property string $phone
 * @property string $brithday
 * @property string $course
 * @property string $group
 * @property int $status
 */
class Contract extends \yii\db\ActiveRecord
{

    public $price;

    public function rules()
    {
        return [
            [['price'], 'required'],
            [['price'], 'number'],
        ];
    }
}
