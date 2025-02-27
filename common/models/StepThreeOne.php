<?php

namespace common\models;

use Yii;
use yii\base\Model;

class StepThreeOne extends Model
{
    const STEP = 4;

    public $filial_id;
    public $lang_id;
    public $edu_form_id;
    public $edu_type_id;
    public $edu_direction_id;
    public $exam_type;

    public function rules()
    {
        return [
            [['filial_id', 'lang_id', 'edu_form_id', 'edu_direction_id', 'edu_type_id', 'exam_type'], 'required'],
            [['filial_id', 'lang_id', 'edu_form_id', 'edu_direction_id', 'edu_type_id', 'exam_type'], 'integer'],

            [['filial_id'], function ($attribute) {
                if (!Branch::find()->where(['id' => $this->$attribute, 'status' => 1, 'is_deleted' => 0])->exists()) {
                    $this->addError($attribute, 'Tanlangan filial mavjud emas.');
                }
            }],
            [['lang_id'], function ($attribute) {
                if (!Lang::find()->where(['id' => $this->$attribute, 'status' => 1, 'is_deleted' => 0])->exists()) {
                    $this->addError($attribute, 'Tanlangan til mavjud emas.');
                }
            }],
            [['edu_form_id'], function ($attribute) {
                if (!EduForm::find()->where(['id' => $this->$attribute, 'status' => 1, 'is_deleted' => 0])->exists()) {
                    $this->addError($attribute, 'Tanlangan taʼlim shakli mavjud emas.');
                }
            }],
            [['edu_direction_id'], function ($attribute) {
                if (!EduDirection::find()->where([
                    'id' => $this->$attribute,
                    'edu_form_id' => $this->edu_form_id,
                    'edu_type_id' => $this->edu_type_id,
                    'lang_id' => $this->lang_id,
                    'status' => 1,
                    'is_deleted' => 0
                ])->exists()) {
                    $this->addError($attribute, 'Tanlangan taʼlim yo‘nalishi mavjud emas.');
                }
            }],
            [['edu_type_id'], function ($attribute) {
                if (!EduType::find()->where(['id' => $this->$attribute, 'status' => 1, 'is_deleted' => 0])->exists()) {
                    $this->addError($attribute, 'Tanlangan taʼlim turi mavjud emas.');
                }
            }],
        ];
    }

    public function getEduDirection()
    {
        return $this->hasOne(EduDirection::class, ['id' => 'edu_direction_id']);
    }

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
            foreach ($lev1 as $key => $error) {
                $result[] = $error;
            }
        }
        return array_unique($result);
    }

    public function ikStep($user, $student)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if (!$this->validate()) {
            return ['is_ok' => false, 'errors' => $this->simple_errors($this->errors)];
        }

        $student->setAttributes([
            'branch_id' => $this->filial_id,
            'exam_type' => $this->exam_type,
        ]);

        if ($student->edu_direction_id != $this->edu_direction_id) {
            $eduDirection = EduDirection::findOne($this->edu_direction_id);
            $student->setAttributes([
                'lang_id' => $this->lang_id,
                'edu_form_id' => $this->edu_form_id,
                'edu_direction_id' => $this->edu_direction_id,
                'edu_type_id' => $this->edu_type_id,
                'direction_id' => $eduDirection->direction_id,
            ]);

            $result = StepThree::createEduType($student);
            if (!$result['is_ok']) {
                $transaction->rollBack();
                return ['is_ok' => false , 'errors' => $result['errors']];
            }
        }

        if (!$student->save(false)) {
            $errors[] = ['Student maʼlumotlarini yangilashda xatolik yuz berdi.'];
        }

        $user->step = self::STEP;
        if (!$user->save(false)) {
            $errors[] = ['Foydalanuvchi maʼlumotlarini yangilashda xatolik yuz berdi.'];
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }
        $transaction->rollBack();
        return ['is_ok' => false , 'errors' => $errors];
    }
}
